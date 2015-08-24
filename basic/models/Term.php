<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%term}}".
 *
 * @property string $id
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property string $keyword
 *
 * @property Post[] $posts
 */
class Term extends \app\models\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%term}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'integer'],
            [['title','keyword', 'description'], 'string'],
            [['slug'], 'required'],
            [['slug'], 'string', 'max' => 255],
            [['slug'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'title' => '标题',
            'slug' => '标签',
            'keyword'=> '关键字',
            'description' => '描述',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['term_id' => 'id']);
    }
    
    
    public static function allTermsArray()
    {
        return ArrayHelper::map(static::find()->all(),'id','title');
    }
}
