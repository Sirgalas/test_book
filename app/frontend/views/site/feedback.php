<?php

declare(strict_types=1);


/**
 * @var \common\Modules\Feedback\Forms\FeedbackForm $model
 */
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use yii\helpers\Html;

?>
<div class="category-form">
    <h1> Feedback </h1>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'email')->textInput() ?>
    <?= $form->field($model, 'name')->textInput() ?>
    <?= $form->field($model, 'message')->textarea() ?>

    <?= $form->field($model, 'phone')->widget(MaskedInput::class,['mask' => '+7(999)-999-99-99']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
