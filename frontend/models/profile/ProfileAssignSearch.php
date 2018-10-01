<?php

namespace frontend\models\profile;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\ProfileAssign;

/**
 * ProfileAssignSearch represents the model behind the search form about `frontend\models\ProfileAssign`.
 */
class ProfileAssignSearch extends ProfileAssign
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'gender_id', 'image_id'], 'integer'],
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
        $query = ProfileAssign::find();

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
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'gender_id' => $this->gender_id,
            'image_id' => $this->image_id,
        ]);

        return $dataProvider;
    }
}
