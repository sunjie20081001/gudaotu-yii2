<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

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
 * @property string description
 *
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
    
    //角色
    const ROLE_USER = 10; //一般用户
    const ROLE_AUTHOR = 20; //作者/编辑
    const ROLE_ADMIN  = 30; //管理员 
    const ROLE_SUPER  = 40; //超级管理员
    

    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }
    
    public static function roleArray()
    {
        return [
            10 => '一般用户',
            20 => '编辑',
            30 => '管理员',
            40 => '超级管理员'
        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password_hash'], 'required'],
            [['created_at', 'updated_at', 'status', 'role', 'notification_count'], 'integer'],
            [['username', 'password_hash', 'email', 'display_name', 'auth_key', 'description'], 'string', 'max' => 255],
            [['avatar'], 'string', 'max' => 45],
            [['username'], 'unique'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_DELETED, self::STATUS_ACTIVE]],
            ['role', 'default', 'value' => self::ROLE_USER],
            ['role', 'in', 'range' => array_keys(static::roleArray())],

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
            'display_name' => '昵称',
            'avatar' => '头像',
            'status' => '状态',
            'role' => '角色',
            'notification_count' => '通知',
            'description' => '一句话描述',
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
        return static::findOne(['username' => $username]);
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
    
    
    /**
    * 是否是 编辑
    * @return boolean
    */
    public function isAuthor(){
        if($this->role == self::ROLE_AUTHOR || $this->role == self::ROLE_ADMIN || $this->role == self::ROLE_SUPER ){
            return true;
        }
        return false;
    }
    
    public function isAdmin(){
        if($this->role == self::ROLE_ADMIN || $this->role == self::ROLE_SUPER ){
            return true;
        }
        return false;
    }
    
    public function isSuperAdmin(){
        if($this->role == self::ROLE_SUPER ){
            return true;
        }
        return false;
    }

    /**
     * 返回作者数组 id=>display_name
     * @return array
     */
    public static function getAuthors()
    {
        return ArrayHelper::map(static::find()->where(['role' => self::ROLE_AUTHOR,'status' => self::STATUS_ACTIVE])->all(),'id','label');
    }

    /**
     * 用户标签/display_name or username
     * @return string
     */
    public function getLabel()
    {
        return $this->display_name?$this->display_name:$this->username;
    }
}
