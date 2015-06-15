<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm
 */
class LoginForm extends Model
{
    public $username;
    public $password;

    private $_user;


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('cms', 'Username'),
            'password' => Yii::t('cms', 'Password'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Find a user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUserName($this->username);
        }
        return $this->_user;
    }

    /**
     * Logs in a user using the provided username and password
     *
     * @return boolean whether the user was logged in succesfully
     */
    public function login()
    {
        if($this->validate()) {
            return Yii::$app->getUser()->login($this->getUser(), 0);
        }
        return false;
    }
}