<?php

use common\Modules\Parser\Enums\EncodesEnum;
use common\Modules\Parser\Enums\TypeEnum;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\Modules\Parser\Entities\Parser $model
 * @var array $type
 * @var array $encode
 */

$this->title = 'Update Parser: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Parsers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="parser-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'type' => $type,
        'encode' => $encode
    ]) ?>

</div>
