<?php

namespace backend\SearchForms;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\Modules\Parser\Entities\Parser;

/**
 * ParserSearch represents the model behind the search form of `common\Modules\Parser\Entities\Parser`.
 */
class ParserSearch extends Parser
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'url'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
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
        $query = Parser::find();


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['ilike', 'name', $this->name])
            ->andFilterWhere(['ilike', 'url', $this->url]);

        return $dataProvider;
    }
}
