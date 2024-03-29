<?php

use kartik\datetime\DateTimePicker;
use kartik\select2\Select2;use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\Modules\Book\Entities\Book $model */
/** @var yii\widgets\ActiveForm $form
 * @var array $categories
 * @var array $authors
 * */
?>

<div class="book-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'isbn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pageCount')->textInput() ?>

    <?= $form->field($model, 'publishedDate')->widget(DateTimePicker::class, [
        'options' => ['placeholder' => 'Enter published date'],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd hh:ii:ss'
        ]
    ]); ?>

    <?= $form->field($model, 'shortDescription')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'longDescription')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'imageFile')->fileInput() ?>

    <?= $form->field($model, 'authors_id')->widget(Select2::class,
     [
        'data' => $authors,
        'options' => ['placeholder' => 'Select a authors', 'multiple' => true],
        'pluginOptions' => [
            'tags' => true,
            'tokenSeparators' => [',', ' '],
            'maximumInputLength' => 10
        ],
    ]) ?>

    <?= $form->field($model, 'categories_id')->widget(Select2::class,
     [
        'data' => $categories,
        'options' => ['placeholder' => 'Select a category', 'multiple' => true],
        'pluginOptions' => [
            'tags' => true,
            'tokenSeparators' => [',', ' '],
            'maximumInputLength' => 10
        ],
    ]) ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
