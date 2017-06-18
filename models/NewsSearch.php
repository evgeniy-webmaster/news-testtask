<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\News;

/**
 * NewsSearch represents the model behind the search form about `app\models\News`.
 */
class NewsSearch extends News
{

    public $minCreatedAt;
    public $maxCreatedAt;

    function init()
    {
        $this->status = null;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'boolean'],
            [['minCreatedAt', 'maxCreatedAt', 'title', 'shortText'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'minCreatedAt' => 'From Created Date and Time',
            'maxCreatedAt' => 'To Created Date and Time',
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = News::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere(['status' => $this->status]);

        //var_dump(date('Y m d H:i', strtotime($this->minCreatedAt)));
        $mincat = $this->minCreatedAt ? strtotime($this->minCreatedAt) : null;
        $maxcat = $this->maxCreatedAt ? strtotime($this->maxCreatedAt) : null;
        
        $query->andFilterWhere(['>', 'created_at', $mincat])
            ->andFilterWhere(['<', 'created_at', $maxcat])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'shortText', $this->shortText]);

        return $dataProvider;
    }
}
