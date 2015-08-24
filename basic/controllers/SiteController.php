<?php

namespace app\controllers;

use app\models\CommentSearch;
use app\models\PostSearch;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Post;
use app\models\Term;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * 网站首页
     * 无限加载
     * @return string
     */
    public function actionIndex()
    {
        //翻页 分类  标签(暂时不做标签)
        $params = \Yii::$app->request->queryParams;

        //分类
        $condition = array();
        if ( isset( $params['term'] ) ) {
            $term = Term::findOne(['slug' => $params['term']]);
            $term ? $params['PostSearch']['term_id'] = $term->id : '';
        }

        $postSearch = new PostSearch();
        $dataProvider = $postSearch->search($params, $condition);


        return $this->render('index',[
            'postSearch' => $postSearch,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * 文章页面
     * @param $slug
     * @return string
     */
    public function actionView($slug)
    {
        $model = Post::getPostBySlug($slug);


        $commentSearch = new CommentSearch();
        if(!$model){

        }
        $dataProvider = $commentSearch->search(['post_id' => $model->id]);
        return $this->render('view',[
            'model' => $model,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    
    

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
    
    /**
    * 注册控制器
    */
    public function actionRegister()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        
        $model = new \app\models\RegisterForm();

        if($model->load(\Yii::$app->request->post()) ){
            if ( $user = $model->save() ){
                if ( \Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
            
        }
        return $this->render('register',[
            'model' => $model
        ]);
    }
}
