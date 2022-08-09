<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Uploads */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="uploads-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php if(!$model->isNewRecord): ?>
        <div style="margin-bottom: 15px">
            <?php foreach ($model->uploadedImages as $image): ?>
                <img class='modal-target' width='45' style='cursor:pointer;margin-right: 10px'  src='/<?= $image['image'] ?>' />
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?= $form->field($model, 'images[]')->fileInput(['multiple' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
