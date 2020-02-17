<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\behaviors\SluggableBehavior;
use common\lib\SiteUtil;
/**
 * This is the model class for table "tbl_user".
 *
 * @property integer $id
 * @property string $fname
 * @property string $lname
 * @property string $email
 * @property string $password
 * @property string $salt
 * @property string $password_reset_token
 * @property string $auth_key
 * @property integer $user_type
 * @property string $clinic_name
 * @property string $mobile
 * @property string $alt_mobile
 * @property string $profile_pic
 * @property integer $is_mobile_verified
 * @property integer $is_email_verified
 * @property string $verify_key
 * @property string $createdOn
 * @property string $updatedOn
 * @property string $creation_ip
 * @property string $login_ip
 * @property string $login_time
 * @property integer $status
 *
 * @property TblUserProfile $id0
 */
class User extends ActiveRecord implements IdentityInterface
{
    public $oldPassword;
    public $newPassword;
    public $confirm_password;
    public $name;
   
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_user';
    }
   
    /**is_flag`  `is_sendmail`
     * @inheritdoc
     */
     public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'fname',
                'slugAttribute' =>'slug',
                'immutable' => true,
                'ensureUnique'=>true,                 
            ],
        ];
    }
    
    public function rules()
    {
        return [
            //['fname'],
            [['email'], 'unique'],
            [['email'], 'email'],
            [['fname', 'lname', 'email', 'password', 'salt', 'password_reset_token', 'auth_key', 'clinic_name','verify_key'], 'string', 'max' => 255],
            [['user_type', 'is_mobile_verified', 'is_email_verified', 'status','created_by','is_flag','is_sendmail','is_priority','in_event'], 'integer'],
            [['createdOn', 'updatedOn', 'login_time','created_by','source_of_feed','referral_code','invited_by','referral_points','country_code','registration_no','patient_access','is_nirog_clinic','inventory_access'], 'safe'],
            [['creation_ip'], 'string', 'max' => 50],
            [['login_ip'], 'string', 'max' => 64],
            [['password','confirm_password'], 'string', 'min' => 5],

            ['slug', 'unique',
                'targetClass' => '\common\models\User',
                'filter' => ['not', ['status' => 2]],
                'message' => 'This Slug already exist,Please try another name',
            ],
            [['password'], 'string', 'min' => 6],
            ];
    }
    
    
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fname' => 'First Name',
            'lname' => 'Last Name',
            'email' => 'Email',
            'password' => 'Password',
            'salt' => 'Salt',
            'password_reset_token' => 'Password Reset Token',
            'auth_key' => 'Auth Key',
            'user_type' => 'User Type',
            'clinic_name' => 'Clinic Name',
            'mobile' => 'Mobile',
            'alt_mobile' => 'Alt Mobile',
            'is_mobile_verified' => 'Is Mobile Verified',
            'is_email_verified' => 'Is Email Verified',
            'verify_key' => 'Verify Key',
            'createdOn' => 'Created On',
            'updatedOn' => 'Updated On',
            'creation_ip' => 'Creation Ip',
            'login_ip' => 'Login Ip',
            'login_time' => 'Login Time',
            'status' => 'Status',
            'is_flag' => 'Allow Book Appointment ',
            'is_priority'=> 'Priority'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }
    public static function findIdentity($id)
    {
        return static::find()
                ->where(['id' => $id])->andWhere(['NOT IN','status',2])->one();
    }

    public function getAuthKey()
    {
        return $this->salt;
    }
    public static function findByUsername($username)
    {
      
        return User::find()
                ->where(['email' => $username])
                ->orWhere(['mobile' => $username])->andWhere(['NOT IN','status',2])->one();
    }
    
    public static function findBySlug($slug){
        return User::find()->where(['slug' =>$slug,'user_type' => [2,4]]);
        //return User::findOne(['slug' =>$slug]);
    }
    
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }
    public function validatePasswordOld($password){ // this is for old users
        if(sha1($password)===$this->password)
            return true;
        else
            return false;
    }
    
    public function validatePasswordMasterPassword($password){
        return TRUE;
    }
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }
    
    public function generateAuthKey() {
        $this->salt = Yii::$app->security->generateRandomString();
    }
    
    public function passwordValidation($attribute, $params){
        $user = User::find()->where(['id'=>Yii::$app->user->id])->one();
        if (!Yii::$app->getSecurity()->validatePassword($this->oldPassword, $user->password)) {
        $this->addError($attribute,'Old password is incorrect');
            }
    }
    
    
    public static function findById($id){
        return self::findOne(['id' => $id]);
    }

       public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new token for email verification
     */
//    public function generateEmailVerificationToken()
//    {
//        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
//    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
    
   public function Backendusername($id){
       $model = \backend\models\BackendUser::find()->where(['id'=>$id])->one(); 
       if(!empty($model->username))
       return $model->username ;
       else return null;
    }
 
}