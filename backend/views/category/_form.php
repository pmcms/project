<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="box border:5px">


  <div class="category-form ">

      <?php $form = ActiveForm::begin(); ?>

      <?= $form->field($model, 'category_name') ?>

      <?= $form->field($model, 'description') ?>


      <div class="form-group" align="right">
          <?= Html::submitButton($model->isNewRecord ? 'สร้าง' : 'บันทึก', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
      </div>

      <?php ActiveForm::end(); ?>

</div>
</div>
