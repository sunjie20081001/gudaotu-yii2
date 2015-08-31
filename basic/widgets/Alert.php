<?php
/**
 * widgets
 */

namespace app\widgets;

class Alert extends \yii\base\Widget
{
    public $alertTypes = [
        'error'   => 'alert-error',
        'danger'  => 'alert-danger',
        'success' => 'alert-success',
        'info'    => 'alert-info',
        'warning' => 'alert-warning'
    ];

    public function init(){
        parent::init();
        $session = \Yii::$app->getSession();
        $flashes = $session->getAllFlashes();

        foreach($flashes as $type => $data){
            if(isset($this->alertTypes[$type])) {
                $data = (array)$data;
                foreach($data as $message){
                    echo $message;
                }
                $session->remove($type);
            }
        }
    }


}
