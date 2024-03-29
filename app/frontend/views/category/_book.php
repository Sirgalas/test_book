<?php

declare(strict_types=1);

use common\Modules\Book\Entities\Book;
use common\Modules\Image\Entities\Image;
use yii\helpers\Html;
use yii\helpers\Url;
/**
 * @var Book $book
 */



?>
<div class="col-5" >
    <div class="card" style="width: 18rem;">
        <?php if($book->image instanceof Image):  ?>
            <?= Html::img($book->getImageUrl(),['class' =>"card-img-top", 'alt' => $book->title ])?>
        <?php endif;?>
        <div class="card-body">
            <h5 class="card-title"><?= $book->title ?></h5>
            <p class="card-text"><?= $book->shortDescription ?></p>
            <?= Html::a('Перейти', Url::to(['/book/one', 'id' => $book->id]), ['class' => "btn btn-primary"])?>
        </div>
    </div>
</div>

