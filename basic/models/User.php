<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property string $id
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $username
 * @property string $password_hash
 * @property string $email
 * @property string $display_name
 * @property string $avatar
 * @property integer $status
 * @property integer $role
 * @property integer $notification_count
 * @property string $auth_key
 
 *
 * @property Comment[] $comments
 * @property Post[] $posts
 * @property UserMeta[] $userMetas
 */
class User extends ActiveRecord implements \yii\web\IdentityInterface
{
    
    	//状态 
	const STATUS_DELETED = 0; //未激活
	const STATUS_ACTIVE = 1;  //激活
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password_hash'], 'required'],
            [['created_at', 'updated_at', 'status', 'role', 'notification_count'], 'integer'],
            [['username', 'passwor_hash', 'email', 'display_name', 'auth_key'], 'string', 'max' => 255],
            [['avatar'], 'string', 'max' => 45],
            [['username'], 'unique'],
            ['status', 'defautl', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_DELETED, sefl::STATUS_ACTIVE]],
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
            'username' => '用户名',
            'password_hash' => '密码',
            'email' => '邮箱',
            'display_name' => '显示名',
            'avatar' => '头像',
            'status' => '状态',
            'role' => '角色',
            'notification_count' => '通知',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserMetas()
    {
        return $this->hasMany(UserMeta::className(), ['user_id' => 'id']);
    }
    
    public static function findIdentity($id){
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }
    
    public static function findIdentityByAccessToken($token, $type = null){
        return static::findOne(['access_token' => $token]);
    }
    
    public static function findByEmail($email){
        
    }
    
    public static function findByUsername($username){
        
    }
    
    public function getId(){
        return $this->id;
    }
    
    public function getAuthKey(){
        return $this->auth_key;
    }
    
    public function validateAuthKey($authKey){
        return $this->auth_key === $authKey;
    }
    
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
             if ($this->isNewRecord) {
                 $this->auth_key = \Yii::$app->security->generateRandomString();
             }        
             return true;
        }
        return false;
    }
    
    /**
    * generates password hash from password and sets it to the model
    * @param string $password
    */
    public function setPassword($password)
    {
        $this->password_hash = \Yii::$app->security->generatePasswordHash($password);
    }
    
    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password, $this->password_hash);
    }
}
