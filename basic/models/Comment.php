<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%comment}}".
 *
 * @property string $id
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $content
 * @property string $user_id
 * @property string $ip
 * @property string $parent_id
 * @property string $agent
 * @property string $status
 * @property string $post_id
 *
 * @property User $user
 * @property Post $post
 */
class Comment extends \app\models\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%comment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['created_at', 'updated_at', 'user_id', 'parent_id', 'post_id'], 'integer'],
            [['content'], 'string'],
            [['ip', 'agent'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 45]
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
            'content' => '评论内容',
            'user_id' => '评论者',
            'ip' => 'Ip',
            'parent_id' => '父评论',
            'agent' => 'Agent',
            'status' => 'Status',
            'post_id' => '文章',
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
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id']);
    }
}
