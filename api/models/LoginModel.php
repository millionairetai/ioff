<?php
namespace api\models;

use yii\base\Model;
use common\models\User;

class LoginModel extends Model{
  public $username;
  public $password; 
  
  /**
   * @inheritdoc
   */
  public function rules() {
    return [
        // email and password are both required
        [['username', 'password'], 'required'],                        
        ['password', 'validatePassword'],
    ];
  }
  
  /**
   * Validates the password.
   * This method serves as the inline validation for password.
   */
  public function validatePassword() {
    if (!$this->hasErrors()) {
      $user = User::findOne(['username' => $this->username]);
      
      if ($user) {
        if($user->status !== User::STATUS_ACTIVE){
          $this->addError('email', 'This email isn\'t active yet');                
        }else{
          if(!$user->validatePassword($this->password)){
            $this->addError('password', 'Password is incorrect');                
          }
        }
      }else{
        $this->addError('email', 'This email doesn\'t exist');
      }
    }
  }    
}
