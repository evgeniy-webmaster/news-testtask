<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

/**
 * NewsSearch represents the model behind the search form about `app\models\News`.
 */
class UserSearch extends User
{

    public $minCreatedAt;
    public $maxCreatedAt;
    public $minLastLoginAt;
    public $maxLastLoginAt;

    public function rules()
    {
        return [
            [['minCreatedAt', 'maxCreatedAt', 'username', 'id', 'email',
              'minLastLoginAt', 'maxLastLoginAt'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        $a = [
            'minCreatedAt' => 'From Created Date and Time',
            'maxCreatedAt' => 'To Created Date and Time',
            'minLastLoginAt' => 'From Date and Time of Last Login',
            'maxLastLoginAt' => 'To Date and Time of Last Login',
        ];
        return array_merge(parent::attributeLabels(), $a);
    }

    public function search($params)
    {
        $q = User::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $q,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $mincat = $this->minCreatedAt ? strtotime($this->minCreatedAt) : null;
        $maxcat = $this->maxCreatedAt ? strtotime($this->maxCreatedAt) : null;
        $minllat = $this->minLastLoginAt ? strtotime($this->minLastLoginAt) : null;
        $maxllat = $this->maxLastLoginAt ? strtotime($this->maxLastLoginAt) : null;

        $q->andFilterWhere(['id' => $this->id])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['>', 'created_at', $mincat])
            ->andFilterWhere(['<', 'created_at', $maxcat])
            ->andFilterWhere(['>', 'last_login_at', $minllat])
            ->andFilterWhere(['<', 'last_login_at', $maxllat]);

        return $dataProvider;
    }
}
