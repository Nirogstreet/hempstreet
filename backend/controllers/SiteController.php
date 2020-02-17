<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use backend\models\BackendUser;


/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
//    public function behaviors()
//    {
//        return [
//            'access' => [
//                'class' => AccessControl::className(),
//                'rules' => [
//                    [
//                        'actions' => ['login', 'error'],
//                        'allow' => true,
//                    ],
//                    [
//                        'actions' => ['logout', 'index'],
//                        'allow' => true,
//                        'roles' => ['@'],
//                    ],
//                ],
//            ],
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'logout' => ['post'],
//                ],
//            ],
//        ];
//    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

   
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
 
        $model = new \backend\models\LoginForm(['scenario' => \backend\models\LoginForm::SCENARIO_LOGIN]);
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            
            return $this->goBack();
        } else {
            
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }
     public function actionSignup()
    {
        $model = new BackendUser();
        $model->scenario = BackendUser::SCENARIO_SIGNUP;
        if ($model->load(Yii::$app->request->post())) {
            $model->scenario = BackendUser::SCENARIO_SIGNUP;
            $model->create_time = new \yii\db\Expression('NOW()');
            $model->status = 1;
            $model->setPassword1($model->password);
            $model->generateAuthKey1();
            if ($model->validate()) {
                $model->save();
                Yii::$app->session->setFlash('success', 'Admin Created Successfully!');
                    return $this->goHome();
                
            }else{
                //echo '<pre>';print_r($model->getErrors());die;
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }
     public function actionChangepassword(){
       $model_changepass = new LoginForm(['scenario' => LoginForm::SCENARIO_CHANGEPSW]);
       $user_changepass = new BackendUser(['scenario' => BackendUser::SCENARIO_CHANGEPSW]);
       if($model_changepass->load(Yii::$app->request->post())){
            if($model_changepass->validate() && $user_changepass->resetPassword($model_changepass->newPassword)){
                Yii::$app->session->setFlash('success', 'Password changed succesfully.');
                return $this->render('change_password',[
                  'model_changepass'=>$model_changepass]);
            }else{
                Yii::$app->session->setFlash('error', 'Password cant be changed');
                return $this->render('change_password',[
                  'model_changepass'=>$model_changepass]);
             }
            }return $this->render('change_password',['model_changepass'=>$model_changepass]);
       }
        public function actionDeleteAdmin($id){
         
         $model = BackendUser::find()->where(['id'=>$id])->one();
         $model->scenario = BackendUser::SCENARIO_SIGNUP; 
         $model->status = 2;
         $model->save();
         
        $admin = BackendUser::find()->where(['<>','id',yii::$app->user->id])->andWhere(['<>','status',2])->all();
        return $this->render('other-admin',['admin'=>$admin]);
    }
    
     public function actionUpdateBack($id){
        $model = BackendUser::find()->where(['id'=> $id])->one();
        $pass = $model->password;
         if($model->load(Yii::$app->request->post())){            
            $model->scenario = BackendUser::SCENARIO_SIGNUP; 
            $model->update_time = new \yii\db\Expression('NOW()');
            $model->type = $_POST['BackendUser']['type'];
            $model->username = $_POST['BackendUser']['username'];
            $model->email = $_POST['BackendUser']['email'];
            $model->phone = $_POST['BackendUser']['phone'];
             if($_POST['BackendUser']['password'] != $model->oldAttributes['password'] ){
              $model->setPassword1($_POST['BackendUser']['password']);   
              $model->generateAuthKey1();                
            }
            if ($model->validate()) {
                $model->save();
                Yii::$app->session->setFlash('success', 'Admin Updated Successfully!');
                    return $this->goHome();
                
            }else{
                echo '<pre>';print_r($model->getErrors());die;
            }
         }
        
        
        return $this->render('signup',['model'=>$model]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
