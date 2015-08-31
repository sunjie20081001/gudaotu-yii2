<?php
namespace app\controllers;

use app\models\CommentSearch;
use app\models\Post;
use app\models\PostSearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\User;

class AccountController extends Controller
{
	public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['logout', 'setting', 'comments'],
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
	
	public function actionIndex()
	{
		return $this->render('index');
	}

    /**
     * 账号设置
     * @return string
     */
    public function actionSetting()
    {
        $model = \Yii::$app->user->identity;

        if($model->load(\Yii::$app->request->post()) && $model->save()){
            $this->flash('用户信息更新成功!','success');
        }
        return $this->render('setting',[
            'model' => $model
        ]);
    }

    public function actionFavorates()
    {

    }

    /**
     * 我的评论
     * @return string
     */
    public function actionComments()
    {
        $currentUser = \Yii::$app->user->identity;

        $params = \Yii::$app->request->queryParams;
        if( !$currentUser ){
            $this->goHome();
        }
        $params['CommentSearch']['user_id'] = $currentUser->id;

        $commentSearch = new CommentSearch();
        $dataProvider = $commentSearch->search($params);

        return $this->render('comments',[
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPosts()
    {
        $currentUser = \Yii::$app->user->identity;
        //当前用户是否是 author
        if($currentUser->isAuthor()){
            return $this->goHome();
        }

        $params = \Yii::$app->request->queryParams;
        $params['PostSearch']['user_id'] = $currentUser->id;

        $postSearch = new PostSearch();
        $dataProvider = $postSearch->search($params);
    }

}