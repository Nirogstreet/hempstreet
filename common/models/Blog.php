<?php

namespace common\models;
use yii\behaviors\TimestampBehavior;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "tbl_blog".
 *
 * @property integer $id
 * @property string $title
 * @property string $blog_description
 * @property string $author_name
 * @property string $banner_image
 * @property string $published_date
 * @property integer $status
 */
class Blog extends \yii\db\ActiveRecord
{
    const lang = 0;
    public $crop;
    public $imageFile;
     const SCENARIO_blog = 'blog';
     const SCENARIO_video = 'video_blog';
     const SCENARIO_photo = 'photo'; 

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_blog';
    }
 public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
                'slugAttribute' =>'slug',
                'immutable' => true,
                'ensureUnique'=>true,               
            ],
              TimestampBehavior::className(),
        ];
    }
    
//     public function scenarios() {
//        parent::scenarios();
//        $scenarios[self::SCENARIO_blog] = ['title','blog_description','slug','published_date','crop','category','tag_id','slug','alt_tag','img_description','is_nirog_blog','doctor_id','clinic_id'];
//        $scenarios[self::SCENARIO_video] = ['video_url','title','blog_description','slug','published_date','crop','category','tag_id','slug','alt_tag','img_description','is_nirog_blog','doctor_id','clinic_id'];
//         return $scenarios;
//    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title','blog_description','slug','published_date','category'],'required'],
            [['video_url'], 'required', 'on' => self::SCENARIO_video],
           //  [['sub_category'], 'required', 'on' => self::SCENARIO_photo],
            [['published_date','crop','category','tag_id','slug','alt_tag','img_description','is_nirog_blog','doctor_id','clinic_id','blog_type'], 'safe'],
            [['status','author_name','must_read','created_at', 'updated_at','language'], 'integer'],
            [['title', 'banner_image'], 'string', 'max' => 255],
            [['blog_description'], 'string', 'min' => 280, 'on' => self::SCENARIO_blog],
            [['blog_description','meta_title','meta_description'],'string'],
           ['slug', 'unique',
                'targetClass' => '\common\models\Blog',
                'filter' => ['not', ['status' => 2]],
                'message' => 'This Slug already exist,Please try another name',
            ],      
            ['language', 'default', 'value' => self::lang],
            [['banner_image'], 'file', 'extensions' => 'jpg, jpeg'],
          
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'blog_description' => 'Blog Description',
            'author_name' => 'Author Name',
            'banner_image' => 'Banner Image',
            'published_date' => 'Published Date',
            'status' => 'Status',
        ];
    }
    
    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
        
    }
      
    
    
     public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'doctor_id']);
    }
    
     public function getAuthorr()
    {
        return $this->hasOne(Author::className(), ['id' => 'author_name']);
    }
    
     public function getCategoryy()
    {
        return $this->hasOne(BlogCategory::className(), ['id' => 'category']);
    }
    public function getSubcategory()
    {
        return $this->hasOne(BlogCategory::className(), ['id' => 'sub_category']);
    }
     public static function findBySlug($slug){
        return Blog::find()->where(['slug' =>$slug]);
        //return User::findOne(['slug' =>$slug]);
    }
    public static function userList()
    {
        $userList  = [];
        $users = User::find()->where(['user_type'=>2,'status'=>[1,4]])->orderBy('fname')->all();

        $userList = ArrayHelper::map($users, 'id', function ($user) {
           return 'Dr '. $user->fname.' '.$user->lname.' ('.$user->mobile.')';
        });

        return $userList;
    }
   
    
    public function getPhotos()
    {   
        return $this->hasMany(BlogPhotos::className(), ['blog_id' => 'id'])->where(['tbl_blog_photos.status'=>1]);
    }
}
