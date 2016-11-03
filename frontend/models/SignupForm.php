<?php
namespace frontend\models;

use common\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $companyName;
    public $firstname;
    public $lastname;
    public $email;
    public $password;
//    public $repassword;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['companyName', 'required'],
            ['companyName', 'filter', 'filter' => 'trim'],
            ['firstname', 'required'],
            ['firstname', 'filter', 'filter' => 'trim'],
            ['lastname', 'required'],
            ['lastname', 'filter', 'filter' => 'trim'],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\Employee', 'message' => 'This email address has already been taken.'],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
//            ['repassword', 'required'],
//            ['repassword', 'string', 'min' => 6, 'compare', 'compareAttribute'=>'password', 'message'=>"Passwords don't match" ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'companyName' => Yii::t('common', 'Company name'),
            'firstname' => Yii::t('common', 'First name'),
            'lastname' => Yii::t('common', 'Last name'),
            'email' => Yii::t('common', 'Email'),
            'password' => Yii::t('common', 'Password'),
        ];
    }
    
    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;
    }
}
