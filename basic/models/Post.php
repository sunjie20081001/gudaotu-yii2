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
 *
 * @property User $user
 * @property Term $term
 * @property UserMeta[] $userMetas
 */
class Post extends \yii\db\ActiveRecord
{
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
            [['created_at', 'updated_at', 'user_id', 'term_id', 'title', 'content', 'excerpt', 'comment_count'], 'required'],
            [['created_at', 'updated_at', 'user_id', 'term_id', 'status', 'comment_status', 'view_count', 'good'], 'integer'],
            [['title', 'content', 'excerpt'], 'string'],
            [['keyword'], 'string', 'max' => 45],
            [['comment_count'], 'string', 'max' => 255]
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
            'user_id' => 'User ID',
            'term_id' => 'Term ID',
            'title' => 'Title',
            'keyword' => 'Keyword',
            'content' => 'Content',
            'excerpt' => 'Excerpt',
            'status' => 'Status',
            'comment_status' => 'Comment Status',
            'comment_count' => 'Comment Count',
            'view_count' => 'View Count',
            'good' => 'Good',
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
}
