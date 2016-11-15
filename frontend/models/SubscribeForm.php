<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Subscriber;

/**
 * ContactForm is the model behind the contact form.
 */
class SubscribeForm extends Model
{
    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email' => 'Email',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param  string  $email the target email address
     * @return boolean whether the email was sent
     */
    public function sendEmail($email)
    {
        return Yii::$app->mailer->compose()
            ->setTo($email)
            ->setFrom([$this->email => $this->name])
            ->setSubject($this->subject)
            ->setTextBody($this->body)
            ->send();
    }
    
    /**
     * Add one subscribe to our system.
     *
     * @return boolean
     */
    public function add()
    {      
        $subscriber = new Subscriber();
        $subscriber->email = $this->email;
        if (!$subscriber->save(false)) {
            //Send an email thankful.
            return false;
        }
        
        return true;
    }
}
