<?php

declare(strict_types=1);
/**
 * @var \frontend\SearchForms\BookSearch $model
 * @var array $authors
 */

use common\Helpers\EnumHelpers;
use common\Modules\Book\Enums\EnumStatus;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>
<div class="category-form">
    <h1> Feedback </h1>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput() ?>
    <?= $form->field($model, 'status')->dropDownList(EnumHelpers::enumsToArr(EnumStatus::cases())) ?>

    <?= $form->field($model, 'author_id')->widget(Select2::class,
        [
            'data' => $authors,
            'options' => ['placeholder' => 'Select a authors'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>