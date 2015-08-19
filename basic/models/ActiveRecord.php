<?php 

namespace app\models;

use Yii;

class ActiveRecord extends \yii\db\ActiveRecord
{

	
	
	/**
	* 自动更新 created_at, updated_at
	* @return array
	*/
	public function behaviors(){
		return [
			'timestamp' => [
				'class' => 'yii\behaviors\TimestampBehavior'
			]
		];
	}
}