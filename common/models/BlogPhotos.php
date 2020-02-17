<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_blog_photos".
 *
 * @property integer $id
 * @property integer $blog_id
 * @property string $photo
 * @property integer $status
 * @property string $title
 */
class BlogPhotos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_blog_photos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['blog_id', 'status'], 'integer'],
            [['photo', 'title'], 'string', 'max' => 255],
            [['photo'], 'file', 'extensions' => 'jpg, jpeg'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'blog_id' => 'Blog ID',
            'photo' => 'Photo',
            'status' => 'Status',
            'title' => 'Title',
        ];
    }
}
