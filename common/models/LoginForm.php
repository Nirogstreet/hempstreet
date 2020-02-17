<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use backend\models\BackendUser;

/**
 * Login form
 */
 
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;
    private $_user;
    public $oldPassword;
    public $repeatPassword;
    public $newPassword;
    const SCENARIO_LOGIN='login';
    const SCENARIO_CHANGEPSW='changepsw';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            [['newPassword','oldPassword','repeatPassword'], 'required','on' => self::SCENARIO_CHANGEPSW],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
            ['oldPassword','passwordValidation'],
            ['repeatPassword','compare','compareAttribute'=>'newPassword'],
        ];
    }
    public function scenarios() {
        parent::scenarios();
        $_scenarios[self::SCENARIO_LOGIN]=['username','password'];
        $_scenarios[self::SCENARIO_CHANGEPSW]=['oldPassword','newPassword','repeatPassword'];
        return $_scenarios;
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect usernsaame or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login() {
       
        if ($this->validate()) {
           
            $user = $this->getUser();
            
            //$user->regenerateValidationKey();
            // echo print_r($user);die;
            return Yii::$app->user->login($user, (3600*24*30));
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = \backend\models\BackendUser::find()->where(['username'=>$this->username])->andWhere(['status'=>1])->one();
        }

        return $this->_user;
    }
    
    public function validatePasswordCustom() {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            //print_r($this->password." ". $user->salt);exit;
           // print_r($user);exit;
            if (!$user || !$user->validatePasswordCustom($this->password, $user->salt, $user->password)) {
                return $this->addError("username", 'Incorrect username or password.');
            }
        }
    }
    public function passwordValidation($attribute, $params){
            $user = BackendUser::find()->where(['username'=>Yii::$app->user->identity->username])->one();
            if (!Yii::$app->getSecurity()->validatePassword($this->oldPassword, $user->password)) {
                $this->addError($attribute,'Old password is incorrect');
               }
        }
}
