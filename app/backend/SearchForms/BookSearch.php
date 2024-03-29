<?php

namespace backend\SearchForms;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\Modules\Book\Entities\Book;

/**
 * BookSearch represents the model behind the search form of `common\Modules\Book\Entities\Book`.
 */
class BookSearch extends Book
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'pageCount', 'image_id'], 'integer'],
            [['title', 'isbn', 'publishedDate', 'shortDescription', 'longDescription', 'status'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Book::find();

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
            'pageCount' => $this->pageCount,
            'publishedDate' => $this->publishedDate,
            'image_id' => $this->image_id,
        ]);

        $query->andFilterWhere(['ilike', 'title', $this->title])
            ->andFilterWhere(['ilike', 'isbn', $this->isbn])
            ->andFilterWhere(['ilike', 'shortDescription', $this->shortDescription])
            ->andFilterWhere(['ilike', 'longDescription', $this->longDescription])
            ->andFilterWhere(['ilike', 'status', $this->status]);

        return $dataProvider;
    }
}
