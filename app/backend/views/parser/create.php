<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\Modules\Parser\Entities\Parser $model */

$this->title = 'Create Parser';
$this->params['breadcrumbs'][] = ['label' => 'Parsers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parser-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
