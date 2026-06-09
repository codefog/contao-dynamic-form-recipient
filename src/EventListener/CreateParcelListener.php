<?php

namespace Codefog\DynamicFormRecipientBundle\EventListener;

use Contao\StringUtil;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Terminal42\NotificationCenterBundle\Event\CreateParcelEvent;
use Terminal42\NotificationCenterBundle\Parcel\Stamp\FormConfigStamp;
use Terminal42\NotificationCenterBundle\Parcel\Stamp\TokenCollectionStamp;
use Terminal42\NotificationCenterBundle\Token\Token;

#[AsEventListener(CreateParcelEvent::class)]
class CreateParcelListener
{
    public function __invoke(CreateParcelEvent $event): void
    {
        $parcel = $event->getParcel();

        if (!$parcel->hasStamps([FormConfigStamp::class, TokenCollectionStamp::class])) {
            return;
        }

        $formConfig = $parcel->getStamp(FormConfigStamp::class)->formConfig;

        if (!$formConfig->getString('dynamicRecipientField')) {
            return;
        }

        $tokenCollection = $parcel->getStamp(TokenCollectionStamp::class)->tokenCollection;
        $fieldValue = $tokenCollection->getByName($formConfig->getString('dynamicRecipientField'))?->getValue();

        if (!$fieldValue) {
            return;
        }

        $recipients = StringUtil::deserialize($formConfig->getString('dynamicRecipientList'));

        if (!\is_array($recipients) || [] === $recipients) {
            return;
        }

        $recipientFound = null;

        foreach ($recipients as $recipient) {
            if ($recipient['key'] === $fieldValue) {
                $recipientFound = $recipient['value'];
                break;
            }
        }

        if ($recipientFound === null) {
            return;
        }

        $tokenCollection->addToken(Token::fromValue('form_recipient', $recipientFound));
    }
}
