<?php

namespace backend\controllers;

use Yii;
use common\models\Author;
use common\models\AuthorSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AuthorController implements the CRUD actions for Author model.
 */
class AuthorController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Author models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AuthorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Author model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Author model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Author();

        if ($model->load(Yii::$app->request->post())) {
            
              $authimage =  \yii\web\UploadedFile::getInstance($model, 'author_pic');                   
            if(isset($authimage)){
                if(strpos(Yii::$app->basePath, 'backend') !== false){
                $rootPath = str_replace(DIRECTORY_SEPARATOR . 'backend', "", Yii::$app->basePath);
                }else{
                $rootPath = str_replace(DIRECTORY_SEPARATOR . 'frontend', "", Yii::$app->basePath);
                }
                 $jpg_image = imagecreatefromjpeg($authimage->tempName);
                    if (($authimage->size) > 2097152) {
                        $size = 42;
                    }
                    else if (($authimage->size) > 1048576 && ($authimage->size) < 1572864) {
                        $size = 55;
                    }   
                    else if (($authimage->size) > 1572864 && ($authimage->size) < 2097152) {
                        $size = 60;
                    }
                    else {
                        $size = 65;
                    }  
                $filepath = $rootPath . '/frontend/web/images/blogs/';
                $exp_var =      explode('.',$authimage->name) ;
                $ext = end($exp_var);
                $randomstring=time() ."-auth.".$ext;
                $model->author_pic = $randomstring;  
                
               $new = imagejpeg($jpg_image, $filepath . $randomstring, $size);   
           
          if(\common\lib\SiteUtil::UploadS3('images/blogs/'.$randomstring, $filepath . $randomstring,\yii::$app->params['s3.bucketname'])){
                          unlink($filepath . $randomstring);
                    }                
                 }                    
                $model->status =1; 
                $model->save();    
               
            
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Author model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model1 = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()))
            {
                                
            $proimage=  \yii\web\UploadedFile::getInstance($model, 'author_pic'); // echo '<pre>'; print_r($proimage->error); print_r($_POST); print_r($_FILES); die;                 
            if(isset($_FILES['Author']['error']['author_pic']) && $_FILES['Author']['error']['author_pic'] == 0){ 
            if(isset($proimage)){      
                if(strpos(Yii::$app->basePath, 'backend') !== false){
                $rootPath = str_replace(DIRECTORY_SEPARATOR . 'backend', "", Yii::$app->basePath);
                }else{
                $rootPath = str_replace(DIRECTORY_SEPARATOR . 'frontend', "", Yii::$app->basePath);
                }
            
            $filepath = $rootPath . '/frontend/web/images/blogs/';
                $exp_var =      explode('.',$proimage->name) ;
                $ext = end($exp_var);
                $randomstring=time() ."-auth.".$ext;
                $model->author_pic = $randomstring;   //echo '<pre>'; print_r($model); print_r($_POST); print_r($_FILES); die;                    
                $proimage->saveAs($filepath.$randomstring); 
              if(\common\lib\SiteUtil::UploadS3('images/blogs/'.$randomstring, $filepath . $randomstring,\yii::$app->params['s3.bucketname'])){
                              unlink($filepath . $randomstring);
                }
             }
            }else{
                $model->author_pic = $model1->author_pic;   
            }                  
                $model->status =1; 
                $model->save();    
               
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Author model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
       $model = $this->findModel($id);
            $model->status = 2;
            $model->update(false);

        return $this->redirect(['index']);
    }

    /**
     * Finds the Author model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Author the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Author::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
