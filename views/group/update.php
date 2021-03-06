<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Group */

$this->title = 'Update Group: ' . ' ' . $model->group_id;
$this->params['breadcrumbs'][] = ['label' => 'Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->group_id, 'url' => ['view', 'id' => $model->group_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="group-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
