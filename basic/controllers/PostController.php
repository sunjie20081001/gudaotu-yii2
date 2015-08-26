<?php

namespace app\controllers;

use Yii;
use app\models\Post;
use app\models\PostSearch;
use yii\web\Response;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;


/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    ['allow' => true, 'actions' => ['index', 'create', 'update', 'delete', 'upload'], 'roles' => ['@']]
                ],
            ],
        ];
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, null);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Post model.
     * @param string $id
     * @return mixed
     */
//    public function actionView($id)
//    {
//        return $this->render('view', [
//            'model' => $this->findModel($id),
//        ]);
//    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Post();
        $currentUser = \Yii::$app->user->identity;
        if ( !$currentUser->isAuthor() ) {
            //不是 作者 无权操作
            return $this->goHome();
        }

        if ($model->load(Yii::$app->request->post())) {

            if ( isset($model->user_id) || ($currentUser->id != $model->user_id && !$currentUser->isAdmin()) ){
                $model->user_id = $currentUser->id;
            }
            if ( $model->save() ) {
                return $this->redirect(['update', 'id' => $model->id]);
            }
        }

        $model->comment_status = Post::COMMENT_STATUS_OK;
        $model->user_id = $currentUser->id;
        return $this->render('create', [
            'model' => $model,
            'isAdmin' => $currentUser ->isAdmin(),
        ]);

    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $currentUser = \Yii::$app->user->identity;
        if ( !$currentUser->isAuthor() ) {
            return $this->goHome();
        }

        if( !$currentUser->isAdmin() && $model->user_id != $currentUser->id){
            //不是 管理员 不能 进行 操作 其它人的文章
            return $this->goHome();
        }

        if ($model->load(Yii::$app->request->post()) ) {
            if( !$currentUser->isAdmin() && $model->user_id != $currentUser->id ){
                //无权修改 用户
                return;
            }
            if( $model->save() ){
                return $this->redirect(['update', 'id' => $model->id]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'isAdmin' => $currentUser->isAdmin(),
            ]);
        }
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionUpload()
    {
        $response = \Yii::$app->response;
        $response->format = Response::FORMAT_JSON;



        $currentUser = \Yii::$app->user->identity;
        if( !$currentUser->isAuthor() ){
            return [
                'status' => 1,
                'msg' => '您没权限上传图片!',
                'data' => '',
            ];
        }

        if ( Yii::$app->request->isPost)
        {
            $model = new UploadImage();
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($filePath = $model->upload())
            {
                //上传成功,上传到 又拍云上.
                
            }
        }


    }
}
