<?php


namespace app\models;

use Faker\Provider\DateTime;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;


class UploadImage extends Model
{

    /**
     * @var UploadedFile[]
     */
    public $imageFiles;

    public function rules()
    {
        return [
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png,jpg,gif,jpeg' , 'maxFiles'=> 5],
        ];
    }

    public function upload()
    {
        //根据时间生成图片
        $t = time();
        if($this->validate()){
            $filepaths = array();
            $appPath = Yii::getAlias('@app');
            foreach($this->imageFiles as $file){
                $t++;
                $filepath = $appPath.'/uploads/'.static::numToAlpha($t) .'.' . $file->extension;
                $file->saveAs($filepath);
                $filepaths[] = $filepath;
            }
            return $filepaths;
        }

        return false;
    }

    private static function numToAlpha($number)
    {
        $str = null;
        while($number){
            $yu = $number%10;
            $number = (int)($number /10);
            $str .= chr(70+$yu);
        }

        return strrev($str);
    }
}