<?php

namespace app\models;

use dektrium\user\models\User as BaseUser;

class User extends BaseUser
{
    protected $_role;

    public function roles()
    {
        return [
            'admin' => 'Administrator',
            'manager' => 'Manager',
            'user' => 'User',
        ];
    }

    public function rules()
    {
        $rules = parent::rules();
        $rules[] = [['role'], 'safe'];
        $rules[] = [['role'], 'default', 'value' => 'user'];
        return $rules;
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

    public function afterSave($insert, $changedAttributes)
    {
        if($this->_role) {
            $auth = \Yii::$app->authManager;
            $role = $auth->getRole($this->_role);
            $auth->revokeAll($this->id);
            $auth->assign($role, $this->id);
        }
        parent::afterSave($insert, $changedAttributes);
    }

}
