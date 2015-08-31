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
    /**
     * @param $message
     * @param string $type string $type 信息显示类型, ['info', 'success', 'error', 'warning']
     * @param null $url
     * @throws \yii\base\ExitException
     */
    public function flash($message, $type = 'info', $url = null)
    {
        \Yii::$app->getSession()->setFlash($type, $message);
        if ($url !== null ){
            \Yii::$app->end(0, $this->redirect($url));
        }
    }
}