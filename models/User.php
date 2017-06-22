<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $password_hash
 * @property integer $created_at
 * @property integer $confirmed
 * @property integer $last_login_at
 *
 * @property News[] $news
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    const SCENARIO_LOGIN = 'login';
    const SCENARIO_REGISTER = 'register';
    const SCENARIO_CONFIRM = 'confirm';
    const SCENARIO_CREATE = 'create';

    protected $_role;
    public $password;

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['username', 'email'];
        $scenarios[self::SCENARIO_REGISTER] = ['username', 'email', 'password'];
        $scenarios[self::SCENARIO_CONFIRM] = ['password'];
        return $scenarios;
    }

    public function behaviors()
    {
        return [
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'updatedAtAttribute' => false,
            ],
        ];
    }

    public function roles()
    {
        return [
            'admin' => 'Administrator',
            'manager' => 'Manager',
            'user' => 'User',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email'], 'required'],
            [['username', 'email'], 'string', 'max' => 255],
            [['username'], 'unique'],
            [['created_at', 'last_login_at'], 'integer'],
            [['email'], 'email'],
            [['email'], 'unique'],
            [['password_hash'], 'string', 'max' => 60],
            [['password'], 'string'],
            [['confirmed'], 'boolean'],
            [['confirmed'], 'default', 'value' => false, 'on' => [self::SCENARIO_REGISTER, self::SCENARIO_CREATE]],
            [['role'], 'safe'],
            [['role'], 'default', 'value' => 'user', 'on' => self::SCENARIO_REGISTER],
            [['get_emails', 'get_browser_notify'], 'boolean'],
            [['get_emails'], 'default', 'value' => true, 'on' => self::SCENARIO_REGISTER],
            [['get_browser_notify'], 'default', 'value' => true, 'on' => self::SCENARIO_REGISTER],
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return null;
    }

    public function validateAuthKey($authKey)
    {
        return false;
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function getRole()
    {
        $roles = \Yii::$app->authManager->getRolesByUser($this->id);
        $roleNames = array_keys($roles);
        if(isset($roleNames[0]))
            return array_keys($roles)[0];
        else return 'user';
    }

    public function setRole($name)
    {
        if($this->isNewRecord) {
            $this->_role = $name;
        } else {
            $auth = \Yii::$app->authManager;
            $role = $auth->getRole($name);
            $auth->revokeAll($this->id);
            $auth->assign($role, $this->id);
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'email' => 'Email',
            'password_hash' => 'Password Hash',
            'created_at' => 'Created At',
            'confirmed' => 'Confirmed',
            'last_login_at' => 'Last Login At',
        ];
    }

    public function beforeSave($insert)
    {
        if(!parent::beforeSave($insert)) return false;

        if($this->password)
            $this->password_hash = Yii::$app->security->generatePasswordHash($this->password);

        if($this->password && self::SCENARIO_DEFAULT) {
            Yii::$app->mailer->compose('user/password-changed', ['username' => $this->username])
                ->setFrom('noreply@' . Yii::$app->request->serverName)
                ->setTo($this->email)
                ->setSubject('Your password has been changed on ' . Yii::$app->request->serverName)
                ->send();
        }

        return true;
    }

    public function afterSave($insert, $changedAttributes)
    {
        if($insert && ( $this->scenario == self::SCENARIO_REGISTER ||
                        $this->scenario == self::SCENARIO_CREATE )) {
            $key = Yii::$app->security->encryptByKey($this->id, Yii::$app->params['confirmAccountKey']);

            Yii::$app->mailer->compose('user/confirm-account', ['key' => $key, 'username' => $this->username])
                ->setFrom('noreply@' . Yii::$app->request->serverName)
                ->setTo($this->email)
                ->setSubject('Confirm registration on ' . Yii::$app->request->serverName)
                ->send();
        }
        if($this->_role) {
            $auth = \Yii::$app->authManager;
            $role = $auth->getRole($this->_role);
            $auth->revokeAll($this->id);
            $auth->assign($role, $this->id);
        }
        parent::afterSave($insert, $changedAttributes);
    }

    public static function confirm($key)
    {
        $id = Yii::$app->security->decryptByKey($key, Yii::$app->params['confirmAccountKey']);

        if($id === false) return false;

        $model = self::findOne($id);
        $model->confirmed = true;
        $model->save();

        return true;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNews()
    {
        return $this->hasMany(News::className(), ['authorId' => 'id']);
    }
}
