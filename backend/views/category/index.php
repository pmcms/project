<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ประเภทโครงการ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">
  <p class="text-right">
      <?= Html::a('สร้างประเภทโครงการ', ['create'], ['class' => 'btn btn-success']) ?>
  </p>
  <div class="row">
    <div class="col-md-6">
      <div class="input-group">
        <span class="input-group-addon label-gray">ประเภทโครงการ</span>
        <input type="text" id="category" class="form-control" name="name" placeholder="ประเภทโครงการ" onchange="this.form.submit()">
      </div>
    </div>
    <div class="col-md-6">
      <div class="input-group">
        <span class="input-group-addon label-gray">สถานะ</span>
        <input type="text" id="status_cat" class="form-control" name="name" placeholder="สถานะ" onchange="this.form.submit()">
      </div>
    </div>
  </div><br>
  <div class="panel">
              <div class="panel-heading">

              </div>
              <!-- /.box-header -->
              <div class="panel panel-body">
                <table class="table">
                  <tr>
                    <!-- <th style="width: 10px">#</th> -->
                    <th>ประเภทโครงการ</th>
                    <th>รายละเอียด</th>
                    <!-- <th style="width: 40px">Label</th> -->
                  </tr>

                  <?php foreach ($query as $field): ?>
                  <tr>

                    <td><?= $field->category_name; ?></td>
                    <td><?= $field->description; ?></td>
                    <!-- <td>
                       $field->activeFlag;?>
                  </td> -->
                  <td>
                     <p>
                        <?= Html::a('แก้ไข', ['update', 'id' => (string)$field->_id], ['class' => 'btn fa fa-edit']) ?>
                        <?= Html::a('ลบ', ['delete', 'id' => (string)$field->_id], [
                            'class' => 'btn  fa fa-archive',
                            'data' => [
                                'confirm' => 'ต้องการลบประเภทโครงการใช่หรือไม่?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </p>
                  </td>
                  </tr>
              <?php endforeach; ?>

                </table>
              </div>
            


</div>
