<?php

declare(strict_types=1);

use common\Modules\Category\Entities\Category;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var Category $category */
?>
<div class="col-3 mt-lg-5">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title"><?= $category->title ?></h5>
            <?= Html::a('Перейти', Url::to(['/category/one', 'id' => $category->id]), ['class' => "btn btn-primary"]) ?>
        </div>
    </div>
</div>
