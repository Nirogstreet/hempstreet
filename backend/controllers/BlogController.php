<?php

namespace backend\controllers;

use Yii;
use common\models\Blog;
use common\models\BlogSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
/**
 * BlogController implements the CRUD actions for Blog model.
 */
class BlogController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {

        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * Lists all Blog models.
     * @return mixed
     */
    public function actionIndex() {

        $searchModel = new BlogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Blog model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Blog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {

        ini_set('memory_limit', '512M');
        $model = new Blog();
        $model->scenario = 'blog';
//        $uploadform = new upload
        if (!file_exists(Yii::getAlias('@frontend/web/images/blogs/'))) {
            mkdir(Yii::getAlias('@frontend/web/images/blogs/'), 0777, true);
        }
      
          
         if ($model->load(Yii::$app->request->post()) && $model->validate()) { //echo '<pre>'; print_r($_POST); die;
            //    echo '<pre>'; print_r($_POST); print_r($_FILES); die;
            
             $model->published_date = date($model->published_date);
            
            $proimage = \yii\web\UploadedFile::getInstance($model, 'banner_image');
            if (isset($proimage)) {
                if (strpos(Yii::$app->basePath, 'backend') !== false) {
                    $rootPath = str_replace(DIRECTORY_SEPARATOR . 'backend', "", Yii::$app->basePath);
                } else {
                    $rootPath = str_replace(DIRECTORY_SEPARATOR . 'frontend', "", Yii::$app->basePath);
                }
                $jpg_image = imagecreatefromjpeg($proimage->tempName);
                if (($proimage->size) > 2097152) {
                    $size = 42;
                } else if (($proimage->size) > 1048576 && ($proimage->size) < 1572864) {
                    $size = 50;
                } else if (($proimage->size) > 1572864 && ($proimage->size) < 2097152) {
                    $size = 52;
                } else {
                    $size = 65;
                }

                $filepath = $rootPath . '/frontend/web/images/blogs/';
                $exp_var = explode('.', $proimage->name);
                $ext = end($exp_var);
                $randomstring = time() . "-blog." . $ext;
                $model->banner_image = $randomstring;

                $new = imagejpeg($jpg_image, $filepath . $randomstring, $size);

                if (\common\lib\SiteUtil::UploadS3('images/blogs/' . $randomstring, $filepath . $randomstring, \yii::$app->params['s3.bucketname'])) {
                    unlink($filepath . $randomstring);
                }
            }

            if (!empty($_POST['Blog']['tag_id'])) {
                $blogArr = $_POST['Blog']['tag_id'];
                foreach ($blogArr as $id) {
                    $serv = \common\models\BlogTags::find()->where(['name' => $id])->one();
                    if (empty($serv)) {
                        $se = new \common\models\BlogTags();
                        $se->name = strtolower($id);
                        $se->status = 1;
                        $se->save();
                    }
                }
                $model->tag_id = strtolower(implode(',', $blogArr));
            }
            if (!empty($model->doctor_id)) {
                $aryTagDcotor = [];
                foreach ($model->doctor_id as $did) {
                    $docs = \common\models\User::find()->where(['id' => $did])->one();
                    if ($docs) {
                        array_push($aryTagDcotor, $did);
                    }
                }
                $model->doctor_id = implode(',', $aryTagDcotor);
            }
            if (!empty($model->clinic_id)) {
                $aryTagclinic = [];
                foreach ($model->clinic_id as $cid) {
                    $cl = \common\models\ClinicProfile::find()->where(['id' => $cid])->one();
                    if ($cl) {
                        array_push($aryTagclinic, $cid);
                    }
                }
                $model->clinic_id = implode(',', $aryTagclinic);
            }
            $model->slug = str_replace(' ', '-', strtolower($model->slug));
            $model->blog_type = 1;
            $model->save();
            
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,                       
            ]);
        }
    }

//    public function actionUploadBlogs() {
//        ini_set('memory_limit', '512M');
//        $model = new Blog();
//
//        if (!file_exists(Yii::getAlias('@frontend/web/images/blogs/'))) {
//            mkdir(Yii::getAlias('@frontend/web/images/blogs/'), 0777, true);
//        }
//
//        if ($model->load(Yii::$app->request->post())) {
//            $proimage = \yii\web\UploadedFile::getInstance($model, 'imageFile');
//
//            $model->published_date = date($model->published_date);
//            if (isset($proimage)) {
//                if (strpos(Yii::$app->basePath, 'backend') !== false) {
//                    $rootPath = str_replace(DIRECTORY_SEPARATOR . 'backend', "", Yii::$app->basePath);
//                } else {
//                    $rootPath = str_replace(DIRECTORY_SEPARATOR . 'frontend', "", Yii::$app->basePath);
//                }
//                $filepath = $rootPath . '/frontend/web/images/blogs/';
//                $exp_var = explode('.', $proimage->name);
//                $ext = end($exp_var);
//                $randomstring = time() . "-blog." . $ext;
//                $model->imageFile = $randomstring;
//                $proimage->saveAs($filepath . $randomstring);
//                if (\common\lib\SiteUtil::UploadS3('images/blogs/' . $randomstring, $filepath . $randomstring, \yii::$app->params['s3.bucketname'])) {
//                    unlink($filepath . $randomstring);
//                }
//            }
//            $dat = file_get_contents($filepath . $randomstring);
//            $xml = simplexml_load_string($dat);
//            $blog = $xml->children();
//
//
//            foreach ($blog as $all) {
//
//                $blogdata = New Blog();
//                $blogdata->title = $all->title;
//
//                $blogdata->published_date = date($all->post_date);
//                $blogdata->status = 0;
//                $blogdata->save();
//            }
//            echo 'done';
//        } else {
//            return $this->render('createnew', [
//                        'model' => $model,
//            ]);
//        }
//    }

    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $model->scenario = 'blog';
        $old_banner = $model->banner_image;
        ini_set('memory_limit', '512M');
       
        
        if ($model->load(Yii::$app->request->post())) {
            $proimage = \yii\web\UploadedFile::getInstance($model, 'banner_image'); // echo '<pre>'; print_r($proimage->error); print_r($_POST); print_r($_FILES); die;                 

            if (isset($_FILES['Blog']['error']['banner_image']) && $_FILES['Blog']['error']['banner_image'] == 0) {
                if (isset($proimage)) {
                    if (strpos(Yii::$app->basePath, 'backend') !== false) {
                        $rootPath = str_replace(DIRECTORY_SEPARATOR . 'backend', "", Yii::$app->basePath);
                    } else {
                        $rootPath = str_replace(DIRECTORY_SEPARATOR . 'frontend', "", Yii::$app->basePath);
                    }

                    $jpg_image = imagecreatefromjpeg($proimage->tempName);
                    if (($proimage->size) > 2097152) {
                        $size = 42;
                    } else if (($proimage->size) > 1048576 && ($proimage->size) < 1572864) {
                        $size = 50;
                    } else if (($proimage->size) > 1572864 && ($proimage->size) < 2097152) {
                        $size = 55;
                    } else {
                        $size = 65;
                    }

                    $filepath = $rootPath . '/frontend/web/images/blogs/';
                    $exp_var = explode('.', $proimage->name);
                    $ext = end($exp_var);
                    $randomstring = time() . "-blog." . $ext;

                    $model->banner_image = $randomstring;   //echo '<pre>'; print_r($model); print_r($_POST); print_r($_FILES); die;
                    $new = imagejpeg($jpg_image, $filepath . $randomstring, $size);
                    //  $proimage->saveAs($filepath . $randomstring);
                    if (\common\lib\SiteUtil::UploadS3('images/blogs/' . $randomstring, $filepath . $randomstring, \yii::$app->params['s3.bucketname'])) {
                        unlink($filepath . $randomstring);
                    }
                }
            } else {
                $model->banner_image = $old_banner;
            }

            if (!empty($_POST['Blog']['tag_id'])) {

                $blogArr = $_POST['Blog']['tag_id'];
                foreach ($blogArr as $id) {                  
                    $serv = \common\models\BlogTags::find()->where(['name' => $id])->one();
                    if (empty($serv)) {
                        $se = new \common\models\BlogTags();
                        $se->name = strtolower($id);
                        $se->status = 1;
                        $se->save();
                    }
                    $model->tag_id =strtolower(implode(',', $blogArr));
                }
            }

            if (!empty($model->doctor_id)) {
                $aryTagDcotor = [];
                foreach ($model->doctor_id as $did) {
                    $docs = \common\models\User::find()->where(['id' => $did])->one();
                    if ($docs) {
                        array_push($aryTagDcotor, $did);
                    }
                }
                $model->doctor_id = implode(',', $aryTagDcotor);
            }
            if (!empty($model->clinic_id)) {
                $aryTagclinic = [];
                foreach ($model->clinic_id as $cid) {
                    $cl = \common\models\ClinicProfile::find()->where(['id' => $cid])->one();
                    if ($cl) {
                        array_push($aryTagclinic, $cid);
                    }
                }
                $model->clinic_id = implode(',', $aryTagclinic);
            }
            $model->slug = str_replace(' ', '-', strtolower($model->slug));
            $model->blog_type = 1;
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            if ($model->category == 20) {
                return $this->redirect(['create-video-blog', 'id' => $model->id]);
            }
           else if ($model->blog_type == 3) {
                return $this->redirect(['create-photo-blog', 'id' => $model->id]);
            }else {
                return $this->render('update', [
                            'model' => $model,
                          
                ]);
            }
        }
    }

    public function actionUploadFile() {

        $this->enableCsrfValidation = false;
        $upload = $_FILES['upload'];
        $funcNum = $_REQUEST['CKEditorFuncNum'];
        if (strpos(Yii::$app->basePath, 'backend') !== false) {
            $rootPath = str_replace(DIRECTORY_SEPARATOR . 'backend', "", Yii::$app->basePath);
        } else {
            $rootPath = str_replace(DIRECTORY_SEPARATOR . 'frontend', "", Yii::$app->basePath);
        }

        $filepath = $rootPath . '/frontend/web/images/blogs/';
        $file_extension = pathinfo($upload['name'], PATHINFO_EXTENSION);
        $message = 'success';
        //  if ($file_extension != 'jpeg' && $file_extension != 'jpg' && $file_extension != 'png' && $file_extension != 'pdf' && $file_extension != 'mp4')
        //  die("Wrong file extension.");
        $filename = 'file-' . md5(microtime(true)) . '.' . $file_extension;
        if (move_uploaded_file($upload['tmp_name'], $filepath . $filename)) {
            if (\common\lib\SiteUtil::UploadS3('images/blogs/' . $filename, $filepath . $filename, \yii::$app->params['s3.bucketname']))
                $path = 'https://s3-' . yii::$app->params['s3.region'] . '.amazonaws.com/' . yii::$app->params['s3.bucketname'] . '/images/blogs/' . $filename;

            echo '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction("' .$funcNum.'", "'.$path.'" );</script>';
//            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
//            return [
//                'filelink' => $path,
//                'filename' => $filename,
//            ];
        }
    }

    public function actionDelete($id) {

        $model = $this->findModel($id);
        $model->slug = $id.'-deleted';
        $model->status = 2;
        $model->update(false);

        return $this->redirect(['index', 'key' => $model->language]);
    }

    public function actionGetcategory() {
        $option = "<option value=''>--Select category--</option>";
        $id = $_POST['id'];
        $cities = \common\models\BlogCategory::find()
                ->where(['language' => $id,'status'=>1])
                ->orderBy('id ASC')
                ->all();

        echo $option;
        if ($cities) {
            foreach ($cities as $city) {
                echo "<option value='" . $city->id . "'>" . $city->category_name . "</option>";
            }
        }
    }

    private function addBlogTags($services) {
        $servicesIDs = '';
        if (!empty($services)) {
            if (is_array($services)) {
                foreach ($services as $service) {
                    $check = \common\models\BlogTags::find()->where(['status' => 1, 'name' => $service])->one();
                    if ($check != null) {
                        $check->status = 1;
                        $check->save();
                        $servicesIDs .= ',' . $check->id;
                    } else {
                        $model_service = new \common\models\BlogTags();
                        $model_service->name = $service;
                        $model_service->status = 1;
                        $model_service->save();
                        $servicesIDs .= ',' . $model_service->id;
                    }
                }
            } else {
                $services = explode(',', $services);
                foreach ($services as $ser) {
                    $check = \common\models\BlogTags::find()->where(['status' => 1, 'name' => $ser])->one();
                    if ($check) {

                        $check->status = 1;
                        $check->save();
                        $servicesIDs .= ',' . $check->id;
                    } else {
                        $model_service = new \common\models\BlogTags();
                        $model_service->name = $ser;
                        $model_service->status = 1;
                        $model_service->save();
                        $servicesIDs .= ',' . $model_service->id;
                    }
                }
            }
            return $servicesIDs;
        } else {
            return FALSE;
        }
    }

    /**
     * Finds the Blog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Blog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Blog::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionUpdateSlug() {
        $model = Blog::find()->where(['IN', 'blog_type', [2,3]])->all();
        //  echo"<pre>";print_r($model);die;
        $ary = [];
        foreach ($model as $mod) {
            $mod->slug = str_replace(' ', '-', strtolower($mod->slug));
            if ($mod->save(false)) {
                
            } else {
                array_push($ary, $mod->id);
            }
        } echo"<pre>";
        print_r($ary);
        die;
    }
    public function actionUpdateTag() {
         ini_set('memory_limit', '512M');
        $model = Blog::find()->where(['IN', 'status', [1,2]])->all();
          echo"<pre>";print_r($model);die;
       // $inIdess = [];
        foreach ($model as $mod) {
//          if (!empty($mod->tag_id)) {
//              $blog= Blog::findOne($mod->id);
//                    $s_id = explode(',', $mod->tag_id);
//                    $newArr=[];
//                    foreach ($s_id as $_sid) {
//                        $ser = \common\models\BlogTags::find()->select('name')->where(['id' => $_sid])->one();
//                       
//                        array_push($newArr, $ser['name']);
//                       $tag= implode(',', $newArr);
//                    } 
//                    $blog->tag_id=$tag;
//                  //  print_r($blog->tag_id);
//                    $blog->save();
//                   
//                }
           
        }
    
        echo"<pre>";
        //print_r($inIdess);
       
        die;
    }
    
    public function actionCreateVideoBlog($id=null){
       
        if(!empty($id)){
         $model = $this->findModel($id);   
        }else{
         $model = new Blog();    
        }
        $model->scenario = 'video_blog';
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if (!empty($_POST['Blog']['tag_id'])) {
                $blogArr = $_POST['Blog']['tag_id'];
                foreach ($blogArr as $idsub) {
                    $serv = \common\models\BlogTags::find()->where(['name' => $idsub])->one();
                    if (empty($serv)) {
                        $se = new \common\models\BlogTags();
                        $se->name = strtolower($idsub);
                        $se->status = 1;
                        $se->save();
                    }
                }
                $model->tag_id = strtolower(implode(',', $blogArr));
            }
            $model->slug = str_replace(' ', '-', strtolower($model->slug));
            $model->blog_type = 2;
            $model->save();
           
           return $this->redirect(['view', 'id' => $model->id]);
        } else {            
            return $this->render('video_form', [
                'model' => $model
            ]);
        }
    }
    
    public function actionCreatePhotoBlog($id=null){
      // echo"<pre>";print_r($_POST);die;
        if(!empty($id)){
         $model = $this->findModel($id);
       }else{
         $model = new Blog();    
     
        }
        $modelsphoto = [new \common\models\BlogPhotos];
        $model->scenario = 'photo';
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
           
            if (!empty($_POST['Blog']['tag_id'])) {
                $blogArr = $_POST['Blog']['tag_id'];
                foreach ($blogArr as $idsub) {
                    $serv = \common\models\BlogTags::find()->where(['name' => $idsub])->one();
                    if (empty($serv)) {
                        $se = new \common\models\BlogTags();
                        $se->name = strtolower($idsub);
                        $se->status = 1;
                        $se->save();
                    }
                }
                $model->tag_id = strtolower(implode(',', $blogArr));
            }
            $model->slug = str_replace(' ', '-', strtolower($model->slug));
            $model->blog_type = 3;
            $model->save();
            $img_move_to = Yii::getAlias('@frontend/web/images/blogs/');
            $connection = \Yii::$app->db;
            if(!empty($_POST['BlogPhotosedit'])){
            foreach ($_POST['BlogPhotosedit'] as $index => $titles) {
            $blogphotoId=$_POST['BlogPhotosedit'][$index]['id'];
            $connection->createCommand()
              ->update('tbl_blog_photos', ['title' =>$_POST['BlogPhotosedit'][$index]['title']], ['id'=>$blogphotoId])
              ->execute();
              $connection->close();
            }}
            
            
            
    foreach ($_FILES['BlogPhotos']["tmp_name"] as $gi => $files) {
              
    if (!empty($_FILES['BlogPhotos']["tmp_name"][$gi]["photo"])) {
       // var_dump($_POST['BlogPhotos'][$gi]['id']); die;
                if (($_FILES['BlogPhotos']["size"][$gi]["photo"]) > 2097152) {
                    $size = 42;
                } else if (($_FILES['BlogPhotos']["size"][$gi]["photo"]) > 1048576 && ($_FILES['BlogPhotos']["size"][$gi]["photo"]) < 1572864) {
                    $size = 50;
                } else if (($_FILES['BlogPhotos']["size"][$gi]["photo"]) > 1572864 && ($_FILES['BlogPhotos']["size"][$gi]["photo"]) < 2097152) {
                    $size = 52;
                } else {
                    $size = 65;
                }
                        $jpg_image = imagecreatefromjpeg($_FILES['BlogPhotos']["tmp_name"][$gi]['photo']);
                        $tmp = explode('.', $_FILES['BlogPhotos']["name"][$gi]["photo"]);
                        $ext = end($tmp);
                        $rndstrnghotelimg = $randomstring = time() . "-blog." . $ext;
                        if (imagejpeg($jpg_image, $img_move_to . $rndstrnghotelimg, $size)) {
                        
                              $connection->createCommand()
                              ->insert('tbl_blog_photos', ['blog_id' => $model->id, 'photo' => $rndstrnghotelimg, 'title' =>$_POST['BlogPhotos'][$gi]['title'], 'status' => 1])
                                    ->execute();
                            $connection->close();
                        }
                        if(\common\lib\SiteUtil::UploadS3('images/blogs/'.$rndstrnghotelimg, $img_move_to . $rndstrnghotelimg,\yii::$app->params['s3.bucketname'])){
                          //  unlink($img_move_to . $image);
                        }

                        }
                                }
           return $this->redirect(['view', 'id' => $model->id]);
        } else {            
            return $this->render('photo_form', [
                'model' => $model, 'modelsphoto'=>$modelsphoto
            ]);
        }
    }
      public function actionDeleteimg(){
        $id = $_POST['id'];
        $model = \common\models\BlogPhotos::findOne($id);
        $model->status = 2;
        $model->save(false);
       
        return "Deleted Successfully";
    }

}
