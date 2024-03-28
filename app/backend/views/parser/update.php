<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\Modules\Parser\Entities\Parser $model */

$this->title = 'Update Parser: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Parsers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="parser-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
