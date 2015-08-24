<?php
/**
 * Created by PhpStorm.
 * User: sun
 * Date: 8/21/15
 * Time: 4:35 PM
 */
namespace app\controllers;

class Controller extends \yii\web\Controller
{
    public function flash($message, $type = 'info', $url = null)
    {
        \Yii::$app->getSession()->setFlash($type, $message);
        if ($url !== null ){
            \Yii::$app->end(0, $this->redirect($url));
        }
    }
}