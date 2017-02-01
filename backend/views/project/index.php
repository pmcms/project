<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;
use backend\models\Project;

$baseUrl = \Yii::getAlias('@web');

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'โครงการ';
$this->params['breadcrumbs'][] = $this->title;

include 'extend.php';

$str = <<<EOT
	$('.project-detail').click(function(){
		var name = $(this).attr('project-name');
		var description = $(this).attr('project-description');
		var startDate = $(this).attr('project-start-date');
		var endDate = $(this).attr('project-end-date');
		var projectType = $(this).attr('project-project-type');
		var status = $(this).attr('project-status');
		var createDate = $(this).attr('project-create-date');
		var createBy = $(this).attr('project-create-by');
		var project = $(this).attr('project');
		$('.modal-title').text(name);
		$('#modal-description').text(description);
		$('#modal-start-date').text(startDate);
		$('#modal-end-date').text(endDate);
		$('#modal-project-type').text(projectType);
		$('#modal-status').text(status);
		$('#modal-create-date').text(createDate);
		$('#modal-create-by').text(createBy);
		$('.modal').modal('show');
	})
EOT;

$this->registerJs($str, View::POS_LOAD, 'form-js');

?>
<div class="project-index">
    <p align="right">
        <?= Html::a('<i class="fa fa-plus"></i> สร้างโครงการ', ['create'], ['class' => 'btn btn-success','style'=>'text-align: right;']) ?>
    </p>
   	<div class="site-index">
	<div class="box box-solid">
		<div class="box-header with-border">
		<?php $form = ActiveForm::begin(); ?>
			<div class="row">
				<div class="col-md-4">
					<div class="input-group">
						<span class="input-group-addon label-gray">ชื่อโครงการ</span>
						<?php echo Html::textInput('name', $name, ['id'=> 'project_name', 'class'=> 'form-control', 'placeholder'=> 'ชื่อโครงการ', 'onchange'=>'this.form.submit()']);?>
					</div>
				</div>
				
				<div class="col-md-4">
					<div class="input-group">
						<span class="input-group-addon label-gray">สถานะ</span>
							<?php echo Html::dropDownList('status', $status, [0=>'ทั้งหมด']+ Project::$arrSendStatus , ['id'=> 'status', 'class'=> 'form-control','onchange'=>'this.form.submit()'])?>
					</div>
				</div>
				<div class="col-md-4">
					<div class="input-group">
						<span class="input-group-addon label-gray">จัดเรียง</span>
						<?php echo Html::dropDownList('sort', $sort,  Project::$arrSort , ['id'=> 'sort', 'class'=> 'form-control' ,'onchange'=>'this.form.submit()'])?>
					</div>
				</div>
			</div>
		<?php ActiveForm::end(); ?>
		</div>
	</div>
	<?php $count = 0; ?>
	<?php foreach ($value as $field): ?>
	<?php $count++; ?>
	<?php if($count == 1){?>
		<div class="row">
		<?php } ?>
			<div class="col-md-4">
				<div class="box box-solid">
				<a href="<?php echo $baseUrl."/index.php?r=task"?>" title="เข้าสู่งานในโครงการ">  
					<div class="box-header with-border box-height">
						<div class="text-right">
							<?php echo $lebel[$field->status]; ?>
						</div>
						<div class="text-left">
							<?php echo $field->project_name; ?>
						</div>
						<div class="pull-right text-muted">
							<small>
								<?php echo "วันที่สิ้นสุด"." : ".$field->end_date; ?>
							</small>
						</div>
					</div></a>
					<div class="box-body-height">
						<div class="">
							<div class="text-right">
								<a href="javascript:;" class="project-detail" 
									project-name="<?=$field->project_name?>"
									project-description="<?=$field->description?>"
									project-start-date="<?=$field->start_date?>"
									project-end-date="<?=$field->end_date?>"
									project-project-type="<?php echo $arrCategory[(string)$field->project_type];?>"
									project-status="<?php echo Project::$arrSendStatus[$field->status]; ?>"
									project-create-date="<?=$field->create_date?>"
									project-create-by="<?php echo $arrUser[(string)$field->create_by];?>"
									title="ดูรายละเอียดโครงการ">
									<span>รายละเอียด</span>
									<i class="fa fa-angle-right"></i>&nbsp;
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php if($count == 3 ){ $count = 0;?>
		</div>
		<?php } ?>
	<?php endforeach; ?>
	</div>
	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="ปิด"><span aria-hidden="true">&times;</span></button>
	        <div>
	        	<span class="modal-title" id="myModalLabel"></span>
	        	<a class="btn-sm" href="javascript:;" title="เข้าสู่งานในโครงการ">
					<i class="fa fa-folder-open-o"></i>
				</a>
				<a class="btn-sm" href="<?php echo $baseUrl."/project/update";?>" title="แก้ไขโครงการ">
					<i class="fa fa-edit"></i>
				</a>
				<a class="btn-sm" href="javascript:;" title="ลบโครงการ">
					<i class="fa fa-archive"></i>
				</a>
				<a class="btn-sm" href="javascript:;" title="ยกเลิกโครงการ">
					<i class="fa fa-ban"></i>
				</a>
				<a class="btn-sm" href="<?php echo $baseUrl."/project/setting";?>" title="ตั้งค่าโครงการ">
					<i class="fa fa-cogs"></i>
				</a>
	        </div>
	      </div>
	     <!-- ********** BODY MODAL ********** -->
	      <div class="modal-body">
	        <section class="content-modal">
		          <div class="nav-tabs-custom">
		            <ul class="nav nav-tabs">
		              <li class="active"><a href="#fa-icons" data-toggle="tab">รายละเอียดโครงการ</a></li>
		              <li><a href="#comment" data-toggle="tab">Comment</a></li>
		              <li><a href="#log" data-toggle="tab">Log</a></li>
		            </ul>
		            <!-- ********** TAB DETAIL ********** -->
		            <div class="tab-content">
		              <!-- Font Awesome Icons -->
		              <div class="tab-pane active" id="fa-icons">
							<div class="row">
								<div class="col-md-3 text-right">
									<label class="control-label">รายละเอียด : </label>
								</div>
								<div class="col-md-9">
									<span id="modal-description"></span>
								</div>
							</div>
							<div class="row">
								<div class="col-md-3 text-right">
									<label class="control-label">วันที่เริ่มต้น : </label>
								</div>
								<div class="col-md-9">
									<span id="modal-start-date"></span>
								</div>
							</div>
							<div class="row">
								<div class="col-md-3 text-right">
									<label class="control-label">วันที่สิ้นสุด : </label>
								</div>
								<div class="col-md-9">
									<span id="modal-end-date"></span>
								</div>
							</div>
							<div class="row">
								<div class="col-md-3 text-right">
									<label class="control-label">ประเภทโครงการ : </label>
								</div>
								<div class="col-md-9">
									<span id="modal-project-type"></span>
								</div>
							</div>
							<div class="row">
								<div class="col-md-3 text-right">
									<label class="control-label">ผู้สร้าง : </label>
								</div>
								<div class="col-md-9">
									<span id="modal-create-by"></span>
								</div>
							</div>
							<div class="row">
								<div class="col-md-3 text-right">
									<label class="control-label">วันที่สร้าง : </label>
								</div>
								<div class="col-md-9">
									<span id="modal-create-date"></span>
								</div>
							</div>
							<div class="row">
								<div class="col-md-3 text-right">
									<label class="control-label">สถานะ : </label>
								</div>
								<div class="col-md-9">
									<span id="modal-status"></span>
								</div>
							</div>
		              </div>
		              <!-- /#fa-icons -->
						
					  <!-- ********** TAB LOG ********** -->
		              <!-- glyphicons-->
		              <div class="tab-pane" id="log">
						<!-- DIRECT CHAT SUCCESS -->
				          <div class="box box-success direct-chat direct-chat-success">
				            <!-- /.box-header -->
				            <div class="box-body">
				              <!-- Conversations are loaded here -->
				              <div class="direct-chat-messages">
				                <!-- Message. Default to the left -->
				                <div class="direct-chat-msg">
				                  <!-- /.direct-chat-info -->
				                  <div class="col-md-12">
				                    Is this template really for free? That's unbelievable!
				                    <span class="direct-chat-timestamp pull-right">23 Jan 2:00 pm</span>
				                  </div>
				                  <!-- /.direct-chat-text -->
				                </div>
				                <div class="direct-chat-msg">
				                  <!-- /.direct-chat-info -->
				                  <div class="col-md-12">
				                    Is this template really for free? That's unbelievable!
				                    <span class="direct-chat-timestamp pull-right">23 Jan 2:00 pm</span>
				                  </div>
				                  <!-- /.direct-chat-text -->
				                </div>
				                <div class="direct-chat-msg">
				                  <!-- /.direct-chat-info -->
				                  <div class="col-md-12">
				                    Is this template really for free? That's unbelievable!
				                    <span class="direct-chat-timestamp pull-right">23 Jan 2:00 pm</span>
				                  </div>
				                  <!-- /.direct-chat-text -->
				                </div>
				                <!-- /.direct-chat-msg -->
				              </div>
				              <!--/.direct-chat-messages-->
				            </div>
				            <!-- /.box-body -->
				          </div>
				          <!--/.direct-chat -->
		              </div>
		              <!-- /#ion-icons -->
		              
		              <!-- ********** TAB COMMENT ********** -->
		              <!-- glyphicons-->
		              <div class="tab-pane" id="comment">
		
				          <!-- DIRECT CHAT SUCCESS -->
				          <div class="box box-success direct-chat direct-chat-success">
				            <!-- /.box-header -->
				            <div class="box-body">
				              <!-- Conversations are loaded here -->
				              <div class="direct-chat-messages">
				                <!-- Message. Default to the left -->
				                <div class="direct-chat-msg">
				                  <div class="direct-chat-info clearfix">
				                    <span class="direct-chat-name pull-left">Alexander Pierce</span>
				                    <span class="direct-chat-timestamp pull-right">23 Jan 2:00 pm</span>
				                  </div>
				                  <!-- /.direct-chat-info -->
				                  <img class="direct-chat-img" src="<?= $baseUrl; ?>/img/user2-160x160.jpg" alt="Message User Image"><!-- /.direct-chat-img -->
				                  <div class="direct-chat-text">
				                    Is this template really for free? That's unbelievable!
				                  </div>
				                  <!-- /.direct-chat-text -->
				                </div>
				                <div class="direct-chat-msg">
				                  <div class="direct-chat-info clearfix">
				                    <span class="direct-chat-name pull-left">Alexander Pierce</span>
				                    <span class="direct-chat-timestamp pull-right">23 Jan 2:00 pm</span>
				                  </div>
				                  <!-- /.direct-chat-info -->
				                  <img class="direct-chat-img" src="<?= $baseUrl; ?>/img/user2-160x160.jpg" alt="Message User Image"><!-- /.direct-chat-img -->
				                  <div class="direct-chat-text">
				                    Is this template really for free? That's unbelievable!
				                  </div>
				                  <!-- /.direct-chat-text -->
				                </div>
				                <div class="direct-chat-msg">
				                  <div class="direct-chat-info clearfix">
				                    <span class="direct-chat-name pull-left">Alexander Pierce</span>
				                    <span class="direct-chat-timestamp pull-right">23 Jan 2:00 pm</span>
				                  </div>
				                  <!-- /.direct-chat-info -->
				                  <img class="direct-chat-img" src="<?= $baseUrl; ?>/img/user2-160x160.jpg" alt="Message User Image"><!-- /.direct-chat-img -->
				                  <div class="direct-chat-text">
				                    Is this template really for free? That's unbelievable!
				                  </div>
				                  <!-- /.direct-chat-text -->
				                </div>
				                <div class="direct-chat-msg">
				                  <div class="direct-chat-info clearfix">
				                    <span class="direct-chat-name pull-left">Alexander Pierce</span>
				                    <span class="direct-chat-timestamp pull-right">23 Jan 2:00 pm</span>
				                  </div>
				                  <!-- /.direct-chat-info -->
				                  <img class="direct-chat-img" src="<?= $baseUrl; ?>/img/user2-160x160.jpg" alt="Message User Image"><!-- /.direct-chat-img -->
				                  <div class="direct-chat-text">
				                    Is this template really for free? That's unbelievable!
				                  </div>
				                  <!-- /.direct-chat-text -->
				                </div>
				                <!-- /.direct-chat-msg -->
				
				                <!-- Message to the right -->
				                <div class="direct-chat-msg right">
				                  <div class="direct-chat-info clearfix">
				                    <span class="direct-chat-name pull-right">Sarah Bullock</span>
				                    <span class="direct-chat-timestamp pull-left">23 Jan 2:05 pm</span>
				                  </div>
				                  <!-- /.direct-chat-info -->
				                  <img class="direct-chat-img" src="<?= $baseUrl; ?>/img/user2-160x160.jpg" alt="Message User Image"><!-- /.direct-chat-img -->
				                  <div class="direct-chat-text">
				                    You better believe it!
				                  </div>
				                  <!-- /.direct-chat-text -->
				                </div>
				                <!-- /.direct-chat-msg -->
				              </div>
				              <!--/.direct-chat-messages-->
				
				              <!-- Contacts are loaded here -->
				              <div class="direct-chat-contacts">
				                <ul class="contacts-list">
				                  <li>
				                    <a href="#">
				                      <img class="contacts-list-img" src="<?= $baseUrl; ?>/img/user2-160x160.jpg" alt="User Image">
				
				                      <div class="contacts-list-info">
				                            <span class="contacts-list-name">
				                              Count Dracula
				                              <small class="contacts-list-date pull-right">2/28/2015</small>
				                            </span>
				                        <span class="contacts-list-msg">How have you been? I was...</span>
				                      </div>
				                      <!-- /.contacts-list-info -->
				                    </a>
				                  </li>
				                  <!-- End Contact Item -->
				                </ul>
				                <!-- /.contatcts-list -->
				              </div>
				              <!-- /.direct-chat-pane -->
				            </div>
				            <!-- /.box-body -->
				            <div class="box-footer">
				              <form action="#" method="post">
				                <div class="input-group">
				                  <input type="text" name="message" placeholder="comment..." class="form-control">
				                      <span class="input-group-btn">
				                        <button type="submit" class="btn btn-success btn-flat">ส่ง</button>
				                      </span>
				                </div>
				              </form>
				            </div>
				            <!-- /.box-footer-->
				          </div>
				          <!--/.direct-chat -->
				          
		              </div>
		              <!-- /#ion-icons -->
		
		            </div>
		            <!-- /.tab-content -->
		          </div>
		        <!-- /.col -->
		      <!-- /.row -->
		    </section>
	      </div>
	    </div>
	  </div>
	</div>
</div>
