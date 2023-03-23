<?php

declare(strict_types=1);

/*
 * This file is part of DynamicFormRecipientBundle.
 *
 * @author Codefog <https://codefog.pl>
 *
 * @license MIT
 */

namespace Codefog\DynamicFormRecipientBundle\EventListener;

use Contao\Config;
use Contao\StringUtil;
use NotificationCenter\Model\Notification;
use NotificationCenter\tl_form;

class ProcessFormDataListener extends tl_form
{
    /**
     * On process form data.
     */
    public function onProcessFormData(array $data, array $form, $files, $labels): void
    {
        // Send the notification
        if ($form['nc_notification'] && ($notification = Notification::findByPk($form['nc_notification'])) !== null) {
            $this->sendNotification($notification, $data, $form, $files, $labels);
        }
    }

    /**
     * Send the notification.
     */
    private function sendNotification(Notification $notification, array $data, array $form, $files, $labels): void
    {
        if (!isset($data['recipient'])) {
            $data['recipient'] = $GLOBALS['TL_ADMIN_EMAIL'] ?: Config::get('adminEmail');
        }

        // Get the recipient
        if ($form['dynamicRecipientField'] && isset($data[$form['dynamicRecipientField']]) && $data[$form['dynamicRecipientField']]) {
            $recipients = StringUtil::deserialize($form['dynamicRecipientList'], true);

            if (\is_array($recipients) && \count($recipients) > 0) {
                foreach ($recipients as $recipient) {
                    if ($recipient['key'] === $data[$form['dynamicRecipientField']]) {
                        $data['recipient'] = $recipient['value'];
                        break;
                    }
                }
            }
        }

        $notification->send($this->generateTokens($data, $form, (array) $files, (array) $labels, $notification->flatten_delimiter ?: ','), $GLOBALS['TL_LANGUAGE']);
    }
}
