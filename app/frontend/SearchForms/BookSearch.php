<?php

namespace frontend\SearchForms;

use common\Modules\Book\Entities\Book;
use common\Modules\Book\Entities\BooksToAuthors;
use common\Modules\Book\Entities\BooksToCategories;
use common\Modules\Category\Entities\Category;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;

class BookSearch extends Book
{

    public ?string $title = null;
    public ?int $author_id = null;
    public ?int $category_id = null;
    public ?string $status = null;

    public function rules()
    {
        return [
            [['author_id','category_id'], 'integer'],
            [['title', 'status'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        return Model::scenarios();
    }
    public function search($params): array
    {
        $query = Book::find();
        if(array_key_exists('author_id',$params['BookSearch']) && $params['BookSearch']['author_id'] === "") {
            unset($params['BookSearch']['author_id']);
        }
        $this->load($params);

        if (!$this->validate()) {
            return [];
        }

        if($this->author_id) {
            $bookIds = BooksToAuthors::find()->select('book_id')->where(['author_id' => $this->author_id]);
            $query->andFilterWhere(['in','id', $bookIds]);
        } else {
            $childId = Category::find()->select('id')->where(['parent_id' => $this->category_id]);
            $bookIds = BooksToCategories::find()
                ->select('book_id')
                ->where(['in','category_id',  $childId ])
                ->orWhere(['category_id' => $this->category_id]);
            $query->andFilterWhere(['in','id',$bookIds]);
        }
        if(!empty($this->title) && $this->title !== ""){
            $query->andFilterWhere(['ilike', 'title', $this->title]);
        }

        if(!empty($this->status)) {
            $query->andFilterWhere(['ilike', 'status', $this->status]);
        }
        $page = clone $query;
        $pagination = new Pagination(['totalCount' => $page->count()]);
        return [$query->offset($pagination->offset)->limit($pagination->limit)->all(), $pagination];
    }
}
