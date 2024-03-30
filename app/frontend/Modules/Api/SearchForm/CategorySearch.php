<?php

declare(strict_types=1);

namespace frontend\Modules\Api\SearchForm;

use common\Modules\Category\Entities\Category;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;

/**
 * CategorySearch represents the model behind the search form of `common\Modules\Category\Entities\Category`.
 */
class CategorySearch extends Category
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'parent_id'], 'integer'],
            [['title'], 'safe'],
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

    public function search($params): ArrayHelper
    {
        $query = Category::find();


        $this->load($params,'');

        if (!$this->validate()) {
            return [];
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'parent_id' => $this->parent_id,
        ]);

        $query->andFilterWhere(['ilike', 'title', $this->title]);
        $countQuery = clone $query;
        $pagination = new Pagination(['totalCount' => $countQuery->count()]);
        return [$query->offset($pagination->offset)->limit($pagination->limit)->all()->all(), $pagination];
    }
}
