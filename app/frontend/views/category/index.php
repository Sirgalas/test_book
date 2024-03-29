<?php

declare(strict_types=1);

use common\Modules\Category\Entities\Category;
use yii\bootstrap4\LinkPager;
use yii\web\View;

/**
 * @var View $this
 * @var Category $categories
 * @var Pagination $page
 **/

$this->title = 'Category';
?>
<div class="container">
    <div class="row">
        <div class="col mb-5">
            <div class="container">
                <div class="row">
                    <?php foreach ($categories as $category) {
                        echo  $this->render('_category',[
                            'category' => $category
                        ]);
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="col-12">
            <?= LinkPager::widget([
                'pagination' => $page,
            ]);
            ?>
        </div>
    </div>
</div>


