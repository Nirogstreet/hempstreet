<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_author".
 *
 * @property integer $id
 * @property string $name
 * @property string $organization
 * @property string $author_desc
 * @property string $author_pic
 */
class Author extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_author';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['author_desc'], 'string'],
            [['name'], 'string', 'max' => 50],
            [['organization', 'author_pic'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'organization' => 'Organization',
            'author_desc' => 'Author Desc',
            'author_pic' => 'Author Pic',
        ];
    }
}
