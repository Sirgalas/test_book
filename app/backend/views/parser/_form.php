<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\Modules\Parser\Entities\Parser $model */
/** @var yii\widgets\ActiveForm $form
 * @var array $type
 * @var array $encode
 */

?>

<div class="parser-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model,'type')->dropDownList($type) ?>

    <?= $form->field($model,'encode')->dropDownList($encode) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
