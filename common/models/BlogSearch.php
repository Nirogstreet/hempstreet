<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Blog;

/**
 * BlogSearch represents the model behind the search form about `common\models\Blog`.
 */
class BlogSearch extends Blog
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status','language'], 'integer'],
            [['title', 'blog_description', 'author_name','tag_id','blog_type'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Blog::find()->where(['not',['tbl_blog.status'=>2]])->orderBy(['id' => SORT_DESC]);
         $query->joinWith(['authorr']);
        // $query->joinWith(['categoryy']);
                //->orderBy(['id' => SORT_DESC]);
       
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
      // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
          //  'category' => $this->category,
            'language' => $this->language,
            'blog_type' => $this->blog_type,
            'status' => $this->status,            
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'blog_description', $this->blog_description])
            ->andFilterWhere(['like', 'tag_id', $this->tag_id])
          //  ->andFilterWhere(['like', 'tbl_blog_category.category_name', $this->category])
            
            ->andFilterWhere(['like', 'tbl_author.name', $this->author_name]);
          // ->andFilterWhere(['like', 'tbl_blog_category.id', $this->category]);
               
          //  ->andFilterWhere(['like', 'banner_image', $this->banner_image]);

        return $dataProvider;
    }
}
