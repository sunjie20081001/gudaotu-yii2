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
 */
class Comment extends \yii\db\ActiveRecord
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
            [['created_at', 'updated_at'], 'required'],
            [['created_at', 'updated_at', 'user_id', 'parent_id'], 'integer'],
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
            'content' => 'Content',
            'user_id' => 'User ID',
            'ip' => 'Ip',
            'parent_id' => 'Parent ID',
            'agent' => 'Agent',
            'status' => 'Status',
        ];
    }
}
