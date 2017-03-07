<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use backend\models\Project;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ประเภทโครงการ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">
  <p class="text-right">
      <?= Html::a('สร้างประเภทโครงการ', ['create'], ['class' => 'btn btn-success']) ?>
  </p>
  <div class="box box-solid">
		<div class="box-header with-border">
			<?php $form = ActiveForm::begin(); ?>
				<div class="row">
					<div class="col-md-6">
						<table width="100%" style="border: 1px solid #e0dede; background-color: #f4f4f4;">
							<tr>
								<td width="130px" style="text-align: center;"><span>ชื่อประเภทโครงการ</span></td>
								<td><?php echo Html::textInput('name', '', ['id'=> 'project_name', 'class'=> 'form-control', 'placeholder'=> 'ชื่อโครงการ', 'onchange'=>'this.form.submit()']);?></td>
							</tr>
						</table>
					</div>
					
					<div class="col-md-6">
						<table width="100%" style="border: 1px solid #e0dede; background-color: #f4f4f4;">
							<tr>
								<td width="130px" style="text-align: center;"><span>สถานะ</span></td>
								<td><?php echo Html::dropDownList('status', '', [0=>'ทั้งหมด']+ Project::$arrSendStatus , ['id'=> 'status', 'class'=> 'form-control','onchange'=>'this.form.submit()'])?></td>
							</tr>
						</table>
					</div>
				</div>
			<?php ActiveForm::end(); ?>
		</div>
	</div>
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
                     	<?= Html::a('', ['view', 'id' => (string)$field->_id], ['class' => 'btn btn-info fa fa-eye']) ?>
                        <?= Html::a('', ['update', 'id' => (string)$field->_id], ['class' => 'btn btn-warning fa fa-edit']) ?>
                        <?= Html::a('', ['delete', 'id' => (string)$field->_id], [
                            'class' => 'btn btn-danger  fa fa-archive',
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
