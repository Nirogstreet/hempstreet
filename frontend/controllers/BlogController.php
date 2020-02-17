<?php

namespace frontend\controllers;

use yii\web\Controller;
use common\models\Blog;
use Yii;


class BlogController extends Controller
{
    
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

   
    public function actionIndex()
    {
        $blog = Blog::find()->where(['status' => 1, 'must_read' => 1, 'language' => 0,'blog_type'=>1])->orderBy(['published_date' => SORT_DESC])->limit(5)->all();
        $cat = \common\models\BlogCategory::find()->where(['status' => 1])->all();
        $video = Blog::find()->where(['status' => 1, 'blog_type' => 2, 'language' => 0])->orderBy(['id' => SORT_DESC])->limit(3)->all();
        $all = Blog::find()->where(['status' => 1,'language' => 0,'blog_type'=>1])->andWhere([ 'must_read'=> 0])->orderBy(['id' => SORT_DESC])->limit(6)->all();
        
        return $this->render('index', ['all' => $all, 'topBlog' => $blog, 'video' => $video, 'cat' => $cat, 'language' => 0]);
    }
     public function actionAllBlogs()
    {   $lang =  $_GET['lang'];
        $language=($lang == 'blog')? 0:1;
        $all = Blog::find()->where(['status' => 1,'language' => $language,'blog_type'=>1])->andWhere([ 'must_read'=> 0]);
        $count = $all->count(); 
        $pagination = new \yii\data\Pagination(['totalCount' => $count, 'defaultPageSize' => 6]);
        $all = $all->offset($pagination->offset)->orderBy(['id' => SORT_DESC])->limit($pagination->limit)->all();
        return $this->render('all-blogs', ['all' => $all, 'language' => $language,'pagination' => $pagination]);
    }
    public function actionBlogSearch()
    { 
        // echo "<pre>"; print_r($_GET); die;
        $key = isset($_GET['blog_search'])?$_GET['blog_search']:'';
        $lang = isset($_GET['lang'])?$_GET['lang']:0;
        $slug= isset($_GET['slug'])?str_replace('-',' ', $_GET['slug']):'';
        $blog_type= isset($_GET['blog_type'])?$_GET['blog_type']:'';
        $language=($lang == 'blog')? 0:1;
        $all = Blog::find()->where(['status' => 1])->andWhere([ 'must_read'=> 0]);
      if (isset($key) && !empty($key)) { 
        if($blog_type==3){
             $all->andWhere(['blog_type'=>3]);
             $all->andWhere("MATCH(title,tag_id,blog_description) AGAINST 
               ('$key' IN NATURAL LANGUAGE MODE)");
             $cat = \common\models\BlogCategory::find()->where(['status' => 6])->all();
             $latest =$all->limit(5)->orderBy(['id' => SORT_DESC])->all(); 
             return $this->render('photo_list',['cat' => $cat,'latest'=>$latest, 'language' => 0]);       
        }elseif($blog_type==2){
            $all->andWhere(['blog_type'=>2]);
            $all->andWhere("MATCH(title,tag_id,blog_description) AGAINST 
               ('$key' IN NATURAL LANGUAGE MODE)");
            $cat = \common\models\BlogCategory::find()->where(['status' => 5])->all();
            $latest = $all->limit(3)->orderBy(['id' => SORT_DESC])->all();       
            return $this->render('video_blog_list', ['cat' => $cat,'latest'=>$latest, 'language' => 0]); 
        }else{
            if(!empty($slug)){
            $cat_id = \common\models\BlogCategory::find()->select(['id'])->where(['like','category_name',$slug])->one();
            $all->andWhere(['category'=>$cat_id]);
            $all->andWhere("MATCH(title,tag_id,blog_description) AGAINST 
               ('$key' IN NATURAL LANGUAGE MODE)");
            }else{
            $all->andWhere(['language'=>$language]);
            $all->andWhere("MATCH(title,tag_id,blog_description) AGAINST 
               ('$key' IN NATURAL LANGUAGE MODE)");
            }
            $count = $all->count(); 
            $pagination = new \yii\data\Pagination(['totalCount' => $count, 'defaultPageSize' => 6]);
            $all = $all->offset($pagination->offset)->orderBy(['id' => SORT_DESC])->limit($pagination->limit)->all();
            return $this->render('all-blogs', ['all' => $all, 'language' => $language,'pagination' => $pagination]);
        }
        
            
         }
        
    } 
     public function actionHindi()
    {
        $blog = Blog::find()->where(['status' => 1, 'must_read' => 1, 'language' => 1,'blog_type'=>1])->orderBy(['published_date' => SORT_DESC])->limit(5)->all();
        $cat = \common\models\BlogCategory::find()->where(['status' => 1])->all();
        $video = Blog::find()->where(['status' => 1, 'blog_type' => 2, 'language' => 1])->orderBy(['id' => SORT_DESC])->limit(3)->all();
        $all = Blog::find()->where(['status' => 1,'language' => 1,'blog_type'=>1])->andWhere([ 'must_read'=> 0])->orderBy(['id' => SORT_DESC])->limit(6)->all();
        return $this->render('index', ['all' => $all, 'topBlog' => $blog, 'video' => $video, 'cat' => $cat, 'language' => 1]);
    } 
     public function actionCategory()
    {
        $catname = str_replace('-', ' ', $_GET['slug']);
        $cat_id = \common\models\BlogCategory::find()->select(['id'])->where(['category_name' => $catname])->one(); 
        $all = \common\models\Blog::find()->where(['status' => 1,'category'=>$cat_id]);      
        $count = $all->count(); 
        $pagination = new \yii\data\Pagination(['totalCount' => $count, 'defaultPageSize' => 6]);
        $all = $all->offset($pagination->offset)->orderBy(['id' => SORT_DESC])->limit($pagination->limit)->all();
        return $this->render('text_blog_list', ['all' => $all,'cat_id' => isset($cat_id->id)?$cat_id->id:'', 'language' => 0,'show_button'=>1,'pagination' => $pagination]);
    }    
    public function actionHindiCategory()
    {
        $catname = str_replace('-', ' ', $_GET['slug']);
        $cat_id = \common\models\BlogCategory::find()->select(['id'])->where(['category_name' => $catname])->one(); 
        $all = \common\models\Blog::find()->where(['status' => 1,'category'=>$cat_id]);    
        $count = $all->count(); 
        $pagination = new \yii\data\Pagination(['totalCount' => $count, 'defaultPageSize' => 6]);
        $all = $all->offset($pagination->offset)->orderBy(['id' => SORT_DESC])->limit($pagination->limit)->all();
        return $this->render('text_blog_list', ['all' => $all,'cat_id' => isset($cat_id->id)?$cat_id->id:'', 'language' => 1,'show_button'=>1,'pagination' => $pagination]);
    }    
    
    public function actionVideoList(){
       $cat = \common\models\BlogCategory::find()->where(['status' => 5])->all();
       $latest = Blog::find()->where(['status' => 1,'blog_type'=>2])->limit(3)->orderBy(['id' => SORT_DESC])->all();       
       return $this->render('video_blog_list', ['cat' => $cat,'latest'=>$latest, 'language' => 0]);    
    }
    public function actionCategoryList($slug=null){        
          $model = Blog::find()->where(['status' => 1,'blog_type'=>2]);
         
          if(isset($slug) && !empty($slug)) {
            $catname = str_replace('-', ' ', $slug);   
          $cat = \common\models\BlogCategory::find()->where(['category_name' => $catname,'status' => 5])->one();             
          $model = $model->andWhere(['sub_category' => $cat->id]);    
         }
          $model = $model->orderBy(['id' => SORT_DESC])->all();
 
      return $this->render('video_category_list', ['model' => $model, 'language' => 0,'slug'=>$slug]);
    
    }
    public function actionVideoDetail($slug){
       // 2->video 3->photo
    $model = Blog::findOne(['slug' => $slug]);
    if(empty($model)){
   return $this->redirect(['blog/index']);
    }   
    $similar = Blog::find()->where(['status' => 1])->andWhere(['sub_category' => $model->sub_category])->andWhere(['NOT IN','id',$model->id])->limit(5)->orderBy(['id' => SORT_DESC])->all();
    $latest = Blog::find()->where(['status' => 1,'blog_type'=>2])->limit(3)->orderBy(['id' => SORT_DESC])->all();
    return $this->render('video_detail', ['model' => $model,'similar'=> $similar,'latest'=>$latest, 'language' => $model->language]);
    
    }
    
    public function actionPhotoList(){
       $cat = \common\models\BlogCategory::find()->where(['status' => 6])->all();
       $latest = Blog::find()->where(['status' => 1,'blog_type'=>3])->limit(5)->orderBy(['id' => SORT_DESC])->all(); 
       return $this->render('photo_list',['cat' => $cat,'latest'=>$latest, 'language' => 0]);       
    }
     public function actionPhotoCategoryList($slug){     
          $catname = str_replace('-', ' ', $slug);
       $cat = \common\models\BlogCategory::find()->where(['category_name' => $catname,'status' => 6])->one();             
      $model = Blog::find()->where(['status' => 1])->andWhere(['sub_category' => $cat->id])->orderBy(['id' => SORT_DESC])->all();
       return $this->render('photo_category_list', ['model' => $model,'language'=>1]);
       
    }
    
     public function actionPhotoDetail($slug){
    $model  = Blog::findOne(['slug' => $slug]);
    if(empty($model)){
    return $this->redirect(['blog/index']);
    } 
    $similar= Blog::find()->where(['status' => 1])->andWhere(['sub_category' => $model->sub_category])->andWhere(['NOT IN','id',$model->id])->limit(10)->orderBy(['id' => SORT_DESC])->all();
    
    return $this->render('photo_blog_detail', ['model' => $model,'similar'=> $similar, 'language' => $model->language]);
    
    }
    
     public function actionBlogView($slug) {
        $model = \common\models\Blog::findOne(['slug' => $slug]);
      if(empty($model)){
      return $this->redirect(['blog/index']);
     } 
        $blog = \common\models\Blog::find()->where(['status' => 1, 'language' => $model->language])->andWhere(['NOT IN', 'id', $model->id])->orderBy(['id' => SORT_DESC])->limit(4)->all();
        $cate = str_replace(' ', '-', strtolower($model->categoryy->category_name));
        $this->view->registerLinkTag(['rel' => 'canonical', 'href' => yii::$app->urlManager->createAbsoluteUrl("blog/$cate/$model->slug")]);
        return $this->render('blog_detail', ['model' => $model, 'blog' => $blog, 'language' => $model->language]);
    }
    
    public function actionHindiBlogView($slug) {
        $model = \common\models\Blog::findOne(['slug' => $slug]);
        if(empty($model)){
        return $this->redirect(['blog/index']);
       } 
        $blog = \common\models\Blog::find()->where(['status' => 1, 'language' => $model->language])->andWhere(['NOT IN', 'id', $model->id])->orderBy(['id' => SORT_DESC])->limit(4)->all();
        $cate = str_replace(' ', '-', strtolower($model->categoryy->category_name));
        $this->view->registerLinkTag(['rel' => 'canonical', 'href' => yii::$app->urlManager->createAbsoluteUrl(["hindi/$cate/$model->slug"])]);
        return $this->render('blog_detail', ['model' => $model, 'blog' => $blog, 'language' => $model->language]);
    }
    
    public function actionMoreBlog() {
        if (isset($_POST['c_id'])) {            
            $new = str_replace('-', ' ', $_POST['c_id']);
            $id = \common\models\BlogCategory::find()->select(['id'])->where(['category_name' => $new])->one();
        }
        if (isset($_POST['a_id'])) {           
            $auth = str_replace('-', ' ', $_POST['a_id']);
            $aid = \common\models\Author::find()->select(['id'])->where(['name' => $auth])->one();
        }

        $language = $_POST['language'];       
        $page = $_POST['page'];
        $off = 6 * ($page);

        $all = Blog::find()->where(['status' => 1, 'language' => $language]);
        if (isset($_POST['valu']) && !empty($_POST['valu'])) {
            $all->andWhere('title LIKE :query')->orWhere('blog_description LIKE :query')->addParams([':query' => $_POST['valu'] . '%']);
        }
//        if (!empty($id)) {
//            $all->andWhere(['category' => $id]);
//        }
//        if (!empty($aid)) {
//            $all->andWhere(['author_name' => $aid]);
//        }
        $count = $all->orderBy(['id' => SORT_DESC])->count();
        $all = $all->orderBy(['id' => SORT_DESC])->limit(6)->offset($off)->all();
      //  echo "<pre>";print_r($all);die;
        $data = Yii::$app->controller->renderPartial('/blog/text_blog_list', ['all' => $all, 'language' => $language]);
        if ($off < $count) {
            $loadmore = 1;
        } else {
            $loadmore = 0;
        }
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'status' => 1,
            'content' => $data,
            'load_more' => $loadmore,
            'page' => $page + 1,
        ];
    }
    
    
      
}
