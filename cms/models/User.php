<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\web\IdentityInterface;

/**
 * User
 *
 * @property integer $id
 * @property string $name
 * @property string $username
 * @property string $email
 * @property string $phone
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $auth_key
 * @property integer $state
 * @property integer $created_at
 * @property integer $updated_at
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATE_TRASHED = 100;
    const STATE_ACTIVE = 1;
    const STATE_INACTIVE = 2;

    /**
     * @var string used in forms for collecting user entered password
     */
    public $password;


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
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('cms', 'Name'),
            'username' => Yii::t('cms', 'Username'),
            'email' => Yii::t('cms', 'Email'),
            'phone' => Yii::t('cms', 'Phone'),
            'state' => Yii::t('cms', 'State'),
            'created_at' => Yii::t('cms', 'Created at'),
            'updated_at' => Yii::t('cms', 'Updated at'),
            'password' => Yii::t('cms', 'Password'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (!empty($this->password)) {
            $this->setPassword($this->password);
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // multiple
            [['name', 'username', 'email'], 'required'],
            [['username', 'email'], 'filter', 'filter' => 'trim'],
            
            // username
            ['username', 'unique', 'targetClass' => 'bigbrush\cms\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 3, 'max' => 255],

            // name
            ['name', 'string', 'min' => 0, 'max' => 255],

            // phone
            ['phone', 'string', 'min' => 0, 'max' => 255],

            // email
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => 'bigbrush\cms\models\User', 'message' => 'This email address has already been taken.'],

            // password
            ['password', 'required', 'when' => function ($model) {
                return $model->getIsNewRecord();
            }, 'whenClient' => 'function(attribute, value) {
                return '.$this->getIsNewRecord().';
            }'],
            ['password', 'string', 'min' => 6, 'skipOnEmpty' => false, 'when' => function ($model) {
                return $model->getIsNewRecord();
            }, 'whenClient' => 'function(attribute, value) {
                return value.length > 0;
            }'],

            // state
            ['state', 'default', 'value' => self::STATE_ACTIVE],
            ['state', 'in', 'range' => array_keys($this->getStateOptions())],
        ];
    }

    /**
     * Returns an array used in dropdown lists for field [[state]]
     *
     * @return array
     */
    public function getStateOptions()
    {
        return [
            self::STATE_ACTIVE => Yii::t('cms', 'Active'),
            self::STATE_INACTIVE => Yii::t('cms', 'Inactive'),
            self::STATE_TRASHED => Yii::t('cms', 'Trashed'),
        ];
    }

    /**
     * Returns the text value of the provided state. If state is not provided the value of [[state]] is returned as text.
     *
     * @param int $state an optional state id to get the value from.
     * @return string the text value.
     */
    public function getStateText($state = null)
    {
        if ($state === null) {
            $state = $this->state;
        }
        $options = $this->getStateOptions();
        return $options[$state];
    }

    /**
     * Finds user by username. Only active users is searched.
     *
     * @param string $username the username to search for.
     * @return static|null a [[User]] model if found otherwise null.
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'state' => self::STATE_ACTIVE]);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Validates the provided password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     *******************************************************
     * Methods below are required by [[IdentityInterface]]
     *******************************************************
     */

    /**
     * Finds an identity by the given ID.
     * 
     * @param string|integer $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     * 
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return boolean if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
}