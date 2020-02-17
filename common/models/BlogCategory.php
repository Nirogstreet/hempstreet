<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_blog_category".
 *
 * @property integer $id
 * @property string $category_name
 * @property integer $status
 */
class BlogCategory extends \yii\db\ActiveRecord
{
    const lang = 0;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_blog_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
             [['category_name'],'required'],
            [['language','status'], 'integer'],
            [['category_name'], 'string', 'max' => 50],
            ['category_name', 'unique',
                'targetClass' => '\common\models\BlogCategory',
                'filter' => ['not', ['status' => 2]],
                'message' => 'This Name. has already been taken.',
            ],
            ['language', 'default', 'value' => self::lang],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_name' => 'Category Name',
            'status' => 'Status',
        ];
    }
}
