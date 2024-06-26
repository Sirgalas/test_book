<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\Modules\Book\Entities\Book $model
 * @var array $categories
 * @var array $authors
 */

$this->title = 'Create Book';
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'categories' => $categories,
        'authors' => $authors
    ]) ?>

</div>
