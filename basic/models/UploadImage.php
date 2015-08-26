<?php


namespace app\models;

use Faker\Provider\DateTime;
use Yii;
use yii\web\Model;
use yii\web\UploadedFile;


class UploadImage extends Model
{

    /**
     * @var UploadedFile
     */
    public $imageFile;

    public function rules()
    {
        return [
            [['imageFile', 'file', 'skipOnEmpty' => false, 'extensions' => 'png,jpg,gif,jpeg']],
        ];
    }

    public function upload()
    {
        //根据时间生成图片
        $t = new DateTime();

        if($this->validate()){
            $filepath = 'uploads/'.static::numToAlpha($t) .'.' . $this->imageFile->extension;
            $this->imageFile->saveAs($filepath);
            return $filepath;
        }
        return false;
    }

    private static function numToAlpha($number)
    {
        $str = null;
        while($number){
            $yu = $number%10;
            $number = int($number /10);
            $str .= chr(70+$yu);
        }

        return strrev($str);
    }
}