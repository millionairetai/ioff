<?php

namespace common\helpers;

class EmailHelper 
{

    /**
     * send email
     * 
     * @param string $subject
     * @param string $body
     * @param string $receiver
     * @param string $sender
     */
    public static function send($subject, $body, $receiver, $sender = '') 
    {
        $email = new Email();

        $email->addTo($receiver)
                ->setFrom($sender)
                ->setSubject($subject)
                ->setHtml($body);
    }

    public static function sendActiveKey($user) 
    {
    }

    public static function sendNewPassword($user, $newPassword) 
    {
    }

    public static function getEmailTemplate($templateId) 
    {
        $template = \Yii::$app->db->createCommand('SELECT * FROM `email_templates` WHERE id=' . $templateId)->queryOne();
        return $template;
    }

}
