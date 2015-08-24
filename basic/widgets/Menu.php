<?php
/**
 * widgets
 */

namespace app\widgets;

class Menu extends \yii\base\Widget
{
    public function init(){
        parent::init();
    }

    public function run(){
        return $this->render('view');
    }
}
