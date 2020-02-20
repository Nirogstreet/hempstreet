<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tbl_backend_user".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $username
 * @property string $password
 * @property string $salt
 * @property string $password_strategy
 * @property string $email
 * @property string $phone
 * @property integer $login_attempts
 * @property integer $login_time
 * @property string $login_ip
 * @property string $validation_key
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $status
 */
class BackendUser extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    const STATUS_ACTIVE = 1;
    const SCENARIO_CHANGEPSW='changepsw';
    const SCENARIO_SIGNUP='signup';
    const SCENARIO_LOGIN='login';
    public $oldPassword;
    public $repeatPassword;
    public $newPassword;
    public $password_repeat;
    public $workFactor=14;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_backend_user';
    }
    
    public function scenarios() {
        parent::scenarios();
        $_scenario[self::SCENARIO_SIGNUP] =['username','password','email','create_time','type','phone','status','validation_key'];
        $_scenario[self::SCENARIO_LOGIN] =['username','password'];
        $_scenario[self::SCENARIO_CHANGEPSW] =['password', 'oldPassword', 'repeatPassword', 'newPassword', 'update_time'];
        return $_scenario;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['password', 'email','status','username','password_repeat'], 'required'],
            [['user_id', 'login_attempts', 'login_time', 'status','type'], 'integer'],
            [['create_time', 'update_time'],'safe'],
            [['username'], 'string', 'max' => 45],
            [['password', 'salt', 'email', 'validation_key','password_strategy'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 50],
            [['login_ip'], 'string', 'max' => 32],
            [['email','username'], 'unique'],
            ['password', 'string', 'min' => 6],
            //['password_repeat', 'compare', 'compareAttribute'=>'password', 'message'=>"Passwords don't match" ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'username' => 'Username',
            'password' => 'Password',
            'salt' => 'Salt',
            'password_strategy' => 'Password Strategy',
            'email' => 'Email',
            'phone' => 'Phone',
            'login_attempts' => 'Login Attempts',
            'login_time' => 'Login Time',
            'login_ip' => 'Login Ip',
            'validation_key' => 'Validation Key',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'status' => 'Status',
        ];
    }


    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token) {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
                    'password_reset_token' => $token,
                    'status' => self::STATUS_ACTIVE,
                ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token) {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId() {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey() {
        return $this->validation_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    public function regenerateValidationKey() {
        $this->updateAttributes([
            'validation_key' => Yii::$app->security->generateRandomString(),
        ]);
    }

    public function validatePasswordCustom($password, $salt, $currentpassword) {
        $valpass = crypt($password, $salt);
        if ($currentpassword === $valpass) {
            return true;
        } else {
            return false;
        }
    }

    public function logout($destroySession = true) {
        $identity = $this->getIdentity();
        if ($identity !== null && $this->beforeLogout($identity)) {
            $this->switchIdentity(null);
            $id = $identity->getId();
            $ip = Yii::$app->getRequest()->getUserIP();
            Yii::info("BackendUser '$id' logged out from $ip.", __METHOD__);
            if ($destroySession && $this->enableSession) {
                Yii::$app->getSession()->destroy();
            }
            $this->afterLogout($identity);
        }

        return $this->getIsGuest();
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBuyingRequests()
    {
        return $this->hasMany(BuyingRequest::className(), ['posted_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuotations()
    {
        return $this->hasMany(Quotations::className(), ['seller_id' => 'id']);
    }


    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        if(filter_var($username, FILTER_VALIDATE_EMAIL)) {
        return BackendUser::findOne(['email' => $username, 'status' => self::STATUS_ACTIVE]);
         }
        else {
        return BackendUser::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
         }
        //return Userform::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }


    

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
//    public function setPassword($password)
//    {
//        $this->password = Yii::$app->security->generatePasswordHash($password);
//    }

    public function setPasswordreturn($password)
    {
        return Yii::$app->security->generatePasswordHash($password);
    }
    
    public function generateSaltkeyCustomFunction()
    {
      return Yii::$app->security->generateRandomString();
    }
    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
    
   public function backvalidatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
       
    }
    
    public function setPassword($password) {
        $this->password = crypt($password,$this->salt);
    }
    public function setPassword1($password) {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey() {
        $salt = '$2a$' . str_pad($this->workFactor, 2, '0', STR_PAD_LEFT) . '$';
        $salt .= substr(strtr(base64_encode($this->getRandomBytes(16)), '+', '.'), 0, 22);
        $this->salt =$salt;
        $this->password_strategy='bcrypt';
    }
    public function generateAuthKey1()
    {
        $this->salt = Yii::$app->security->generateRandomString();
    }
    public function getRandomBytes($count = 16) {
        $bytes = "";
        if (function_exists("openssl_random_pseudo_bytes") && strtoupper(substr(PHP_OS, 0, 3)) !== "WIN") {
            $bytes = openssl_random_pseudo_bytes($count);
        } else if ($bytes == "" && is_readable("/dev/urandom") && ($handle = fopen("/dev/urandom", "rb")) !== false) {
            $bytes = fread($handle, $count);
            fclose($handle);
        }

        if (strlen($bytes) < $count) {
            $key = uniqid(Yii::$app->name, true);

            // we need to pad with some pseudo random bytes
            while (strlen($bytes) < $count) {
                $value = $bytes;
                for ($i = 0; $i < 12; $i++) {
                    if (version_compare(PHP_VERSION, '5.4.0') >= 0) {
                        $value = hash_hmac('sha1', microtime() . $value, $key, true);
                    } else {
                        $value = hash_hmac('salsa20', microtime() . $value, $key, true);
                    }
                    usleep(10); // make sure microtime() returns a new value
                }
                $bytes = substr($value, 0, $count);
            }
        }
        return $bytes;
    }
    public function resetPassword($password)
    {
        $user = BackendUser::find()->where(['id'=>  \yii::$app->user->id])->one();
        $user->scenario=  BackendUser::SCENARIO_CHANGEPSW;
        $user->update_time = new \yii\db\Expression('NOW()');
        $user->setPassword1($password);
        $user->generateAuthKey1();
        if($user->validate() && $user->save(false)){
            return true;
        }else{
            return false;
        }
    }
    
}
