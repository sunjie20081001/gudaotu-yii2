<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%post}}".
 *
 * @property string $id
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $user_id
 * @property string $term_id
 * @property string $title
 * @property string $keyword
 * @property string $content
 * @property string $excerpt
 * @property integer $status
 * @property integer $comment_status
 * @property string $comment_count
 * @property string $view_count
 * @property integer $good
 * @property string $slug
 *
 * @property User $user
 * @property Term $term
 * @property UserMeta[] $userMetas
 */
class Post extends ActiveRecord
{

    const STATUS_DRAFT = 0; //草稿
    const STATUS_PUBLISH = 1; //发布

    const COMMENT_STATUS_NO = 0; //可评论
    const COMMENT_STATUS_OK = 1; //不可评论

    /**
     * 文章状态标签
     * @return array
     */
    public static function statusLabels()
    {
        return [
            0 => '草稿',
            1 => '发布',
        ];
    }

    /**
     *  评论状态标签
     * @return array
     */
    public static function commentStatusLabels()
    {
        return [
            0 => '不可评论',
            1 => '可评论',
        ];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'user_id', 'term_id', 'title', 'content', 'excerpt'], 'required'],
            [['created_at', 'updated_at', 'user_id', 'term_id', 'status', 'comment_status', 'view_count', 'good'], 'integer'],
            [['title', 'content', 'excerpt','img'], 'string'],
            [['keyword'], 'string', 'max' => 45],
            [['comment_count'], 'string', 'max' => 255],
            ['status','default', 'value' => self::STATUS_DRAFT],
            ['status', 'in', 'range' => array_keys(static::statusLabels())],
            ['comment_status', 'default', 'value' => self::COMMENT_STATUS_OK],
            ['comment_status', 'in', 'range' => array_keys(static::commentStatusLabels())],
            ['slug', 'match', 'pattern' => '/^[a-z][\w-]*$/i', 'message' =>"必须为字符数字或者下划线"],
            ['slug', 'required'],

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
            'user_id' => '作者',
            'term_id' => '分类',
            'title' => '标题',
            'keyword' => '关键字',
            'content' => '内容',
            'excerpt' => '简介',
            'status' => '状态',
            'comment_status' => '评论状态',
            'comment_count' => '评论数',
            'view_count' => '查看数',
            'good' => '赞',
            'slug' => '标签',
            'img'  => '特殊图片'

        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTerm()
    {
        return $this->hasOne(Term::className(), ['id' => 'term_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserMetas()
    {
        return $this->hasMany(UserMeta::className(), ['post_id' => 'id']);
    }

    public static function getPostBySlug($slug){
        return static::findOne(['slug' => $slug]);
    }
}
