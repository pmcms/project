<?php

use yii\helpers\Html;
use backend\assets\CreateAsset;
use yii\web\View;
use richardfan\widget\JSRegister;
use app\Entity;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model backend\models\Project */
CreateAsset::register ( $this );
$baseUrl = \Yii::getAlias('@web');
$this->title = 'สร้างโครงการ';
$this->params['breadcrumbs'][] = ['label' => 'โครงการ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$userId = Yii::$app->user->identity->_id;

$str2 = <<<EOT

var data = [];

function getData(){
	return data;
}

function addUserMenber(value, child) {
	data.push(value);
	child.removeClass('fa fa-plus').addClass('fa fa-minus');
	console.log(data);
	lenderMember();
}

function removeUserMember(id, child){
	child.removeClass('fa fa-minus').addClass('fa fa-plus');
	$.each(data, function( index, value ) {
		if(id === value.userId){
			data.splice(index,1);
			return false;
		}
	});
	console.log(data);
	lenderMember();
}

function lenderMember(){
	var lender = "";
	$.each(data, function(index, value) {
		lender = lender.concat('<tr height=20><td style=\"text-align:center\"><input type=\"checkbox\" name=\"checkbox-1\" checked/></td><td>'+value.name+'<i class=\"fa fa-user\" style=\"color:#32c5d2\"></i></td></tr>');
	});
	$('#memberOfProject').html(lender);
}

$('a.btn-icon-only ').click(function(){
	var id = $(this).attr('arr-id');
	var name = $(this).attr('arr-name');
	var temp = {
		userId : id,
		name : name,
	};
	var child = $(this).children();
	var strClass = $(this).attr('class');;
	if(strClass.includes("user selected")){
		$(this).removeClass('btn btn-circle btn-icon-only red user selected').addClass('btn btn-circle btn-icon-only green user');
		removeUserMember(id, child);
	}else if(strClass.includes("user")){
		$(this).removeClass('btn btn-circle btn-icon-only green user').addClass('btn btn-circle btn-icon-only red user selected');
		addUserMenber(temp,child);
	}
	
});

$('#teamName').keyup(function(){
	var value = $(this).val();
	var row = "";
	$("table[id=team] tr").each(function(index) {
		if (index !== 0) {
// 		debugger;
			row = $(this);
			var id = row.find("td:first").text();
			if (id.includes(value) == true) {
                row.show();
            }
            else {
                row.hide();
            }
		}
	});
});

$('#nameUser').keyup(function(){
	var value = $(this).val();
	var row = "";
	$("table[id=user] tr").each(function(index) {
		if (index !== 0) {
// 		debugger;
			row = $(this);
			var id = row.find("td:first").text();
			if (id.includes(value) == true) {
                row.show();
            }
            else {
                row.hide();
            }
		}
	});
});

$('#submit').click(function(){
	
		var formData = new FormData();
		formData.append('name', $('input[name=projectname]').val());
		formData.append('startdate', $('input[id=from]').val()+" "+$('input[id=fromTime]').val());
		formData.append('enddate', $('input[id=to]').val()+" "+$('input[id=toTime]').val());
		formData.append('description', $('textarea[name=description]').val());
		formData.append('member', JSON.stringify(data));
		formData.append('category', $('select[name=category]').val());
		formData.append('department', $('select[name=department]').val());
		
		var request = new XMLHttpRequest();
		request.open("POST", "$baseUrl/project/save", true);
		request.onreadystatechange = function () {
	        if(request.readyState === XMLHttpRequest.DONE && request.status === 200) {
				debugger;
	       	    var response = request.responseText;
	            if(typeof(response) == "string"){
	            	response = JSON.parse(request.responseText);
					console.log(response);
	            }
	        }
	    };
		request.send(formData);
});

$("#projectname").change(function(){
	var projectname = $("#projectname").val();

		if(projectname != ""){
			$.ajax({
			       url: '$baseUrl/project/duplicate',
			       type: 'post',
			       data: {searchname: projectname},
			       dataType: "json",
			       success: function (data) {
			          console.log(data.isDuplicate);
			          if(data.isDuplicate){
			        	  $("#error-name").html("ชื่อโครงการซ้ำ");
		                  $("#error-name").show();
		                  $("#next").hide();
			          }else{
			        	  $("#error-name").hide();
			        	  $("#next").show();
			          }
			       }
			  });
		}else{
			$("#error-name").hide();
			$("#next").show();
		}
});

EOT;

$this->registerJs($str2, View::POS_END);
?>
<div class="project-create">
 <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE BASE CONTENT -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet light bordered" id="form_wizard_1">
                                <div class="portlet-body form">
                                    <form action="#" class="form-horizontal" id="submit_form" method="POST" name="registration">
                                        <div class="form-wizard">
                                            <div class="form-body">
                                                <ul class="nav nav-pills nav-justified steps">
                                                    <li class="active">
                                                        <a href="#tab1" data-toggle="tab" class="step" aria-expanded="true">
                                                            <span class="number"> 1 </span>
                                                            <span class="desc">
                                                                <i class="fa fa-check"></i> ข้อมูลพื้นฐานโครงการ </span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#tab2" data-toggle="tab" class="step">
                                                            <span class="number"> 2 </span>
                                                            <span class="desc">
                                                                <i class="fa fa-check"></i> สมาชิกในโครงการ </span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#tab3" data-toggle="tab" class="step active">
                                                            <span class="number"> 3 </span>
                                                            <span class="desc">
                                                                <i class="fa fa-check"></i> สร้างทีมในโครงการ </span>
                                                        </a>
                                                    </li>
                                                </ul>
                                                <div id="bar" class="progress progress-striped" role="progressbar">
                                                    <div class="progress-bar progress-bar-success"> </div>
                                                </div>
                                                <div class="tab-content">
                                                    <div class="tab-pane active" id="tab1">
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">ชื่อโครงการ
                                                                <span class="required"> * </span>
                                                            </label>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" name="projectname" placeholder="ชื่อโครงการ" id="projectname" maxlength="30"/>
                                                            	<span id="error-name" class="error-date"></span>
                                                            </div>
                                                        </div>
                                                        
                                                         <div class="form-group">
                                                            <label class="control-label col-md-3">วันที่เริ่มต้น
                                                                <span class="required"> * </span>
                                                            </label>
                                                            <div class="col-md-2">
                                                                <input type="text" class="form-control date-picker" name="startdate" placeholder="วันที่เริ่มต้น" id="from" />
                                                            </div>
                                                            <div class="col-md-2">
                                                                <input type="text" id="fromTime" class="form-control date-picker" name="starttime" placeholder="เวลาเริ่มต้น" />
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">วันที่สิ้นสุด
                                                                <span class="required"> * </span>
                                                            </label>
                                                            <div class="col-md-2">
                                                                <input type="text" class="form-control date-picker" name="stopdate" placeholder="วันที่สิ้นสุด" id="to"/>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <input type="text" id="toTime" class="form-control date-picker" name="stoptime" placeholder="เวลาสิ้นสุด" />
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3"></div>
                                                            <div class="col-md-4"><span id="requireDate" class="error-date"></span></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">คำอธิบาย</label>
                                                            <div class="col-md-4">
                                                                <textarea class="form-control" name="description" rows="3" placeholder="คำอธิบาย" id="description"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">ประเภทโครงการ
                                                            </label>
                                                            <div class="col-md-4">
	                                                            <?php 
																    echo  Html::dropDownList( 'category',
																      'selected option',  
																       $arrCategory, 
																       ['class' => 'form-control', 'id' => 'category']
																    )
																?>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">แผนก</label>
                                                            <div class="col-md-4">
                                                                <?php 
																    echo  Html::dropDownList( 'department',
																      'selected option',  
																       $arrDepartment, 
																       ['class' => 'form-control', 'id' => 'department']
																    )
																?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- ***********TAB2*************** -->
                                                    <div class="tab-pane" id="tab2">
											        	<div class="row">
											              	<div class="col-md-12" >
											                   	<div class="col-md-8" >
											                        <ul class="nav nav-tabs">
												                        <li class="active">
												                        	<a href="#tab_0" data-toggle="tab" aria-expanded="true"> ทีม </a>
												                        </li>
												                        <li>
												                        	<a href="#tab_1" data-toggle="tab" > สมาชิก </a>
												                        </li>
											                        </ul>
											                        <div class="tab-content">
											                        	<div id="tab_0" class="tab-pane active">
											                              	<div class="row">
											                               		<div class="col-md-8">
											                                       	<div class="col-md-8">
											                                             <input id="teamName" name="teamName" type="text" placeholder="ชื่อทีม" class="form-control input-circle">
											                                       	</div>
											                                 	</div>
											                              	</div>
											                               	<br>
											                                <div class="col-md-8">
											                                    <table  width="100%" id="team">
											                                        <thead>
											                                            <tr>
											                                                <th width="30%">ชื่อทีม</th>
											                                                <th width="5%"></th>
											                                            </tr>
											                                        </thead>
											                                        <tbody>
											                                        <?php foreach ($listTeam as $fieldTeam): ?>
											                                            <tr>
											                                             	<td><?=$fieldTeam->team_name ?></td>
											                                              	<td>
											                                              		<p align="center">
											                                              			<a href="javascript:;" class="btn btn-circle btn-icon-only green"
											                                              				arr-id="<?php echo (string)$fieldTeam->_id;?>"
											                                              				arr-name="<?php echo $fieldTeam->team_name;?>"
											                                              			>
											                                                        	<i class="fa fa-plus" style="font-size:20px"></i>
											                                                  		</a>
											                                                  	</p>
											                                              	</td>
											                                            </tr>
											                                        <?php endforeach; ?>
											                                   		</tbody>
											                             		</table>
											                             	</div>
											                           	</div>
											        					<div id="tab_1" class="tab-pane">
											                              	<div class="row">
											                                  	<div class="col-md-8">
											                                       	<div class="col-md-8">
											                                             <input id="nameUser" name="m" type="nameUser" placeholder="ชื่อ-สกุล" class="form-control input-circle">
											                                       	</div>
																				</div>
											                             	</div>
											                               	<br>
											                                <div class="col-md-8">
											                                	<table  width="100%" id="user">
											                                        <thead>
											                                            <tr>
											                                                <th width="30%">ชื่อ-นามสกุล</th>
											                                                <th width="5%"></th>
											                                            </tr>
											                                        </thead>
											                                        <tbody>
											                                        	<?php foreach ($listUser as $fieldUser): ?>
											                                            <tr>
											                                             	<td><?php echo $fieldUser->firstname." ".$fieldUser->lastname;?></td>
											                                              	<td>
											                                              		<p align="center">
											                                              			<a href="javascript:;" class="btn btn-circle btn-icon-only green user"
											                                              				arr-id="<?php echo (string)$fieldUser->_id;?>"
											                                              				arr-name="<?php echo $fieldUser->firstname." ".$fieldUser->lastname;?>"
											                                              			>
											                                                        	<i class="fa fa-plus" style="font-size:20px"></i>
											                                                  		</a>
											                                                  	</p>
											                                              	</td>
											                                            </tr>
											                                            <?php endforeach; ?>
											                                   		</tbody>
											                             		</table>
											                          		</div>
											                        	</div>
											                    	</div>
											                    </div>
											                    <div class="col-md-4">
											                     	<div class="portlet light portlet-fit portlet-form bordered">
											                        <center><h5>พนักงานภายในโครงการ</h5></center>
											                        <table  width="100%" id="memberOfProject">
											                     	</table>
											                     	</br>
											               			</div>
											           			</div>
											           		</div>
											           </div>
                                                   </div>
                                                   <!-- **********TAB3*********** -->
                                                    <div class="tab-pane" id="tab3">
                                                        <div class="col-md-12" >
                                                            <div class="row">
                                                               	<label class="col-md-3 control-label" style="align:right;">
                                                               		ต้องการสร้างทีมใหม่หรือไม่
                                                               	</label>
                                                                <div class="col-md-3" >
                                                                	<input type="radio" name="want" id="want" checked/>    
                                                                    <span>ต้องการสร้างทีมใหม่</span><br/>
                                                                    <input type="radio" name="want" id="nowant" />
                                                                    <span>ไม่ต้องการสร้างทีมใหม่</span>
                                                                </div>
                                                            </div><br>
                                                        </div>
                                                        <div class="col-md-12" >
                                                            <div class="row">
                                                                <label class="col-md-3 control-label" style="align:right;">
                                                                    <span>ชื่อทีม</span>
                                                                    <span class="required"> * </span>
                                                                </label>
                                                                <div class="col-md-3" >
                                                                    <input class="form-control" type="text"  name="teamname" id="teamname" placeholder="ชื่อทีม" />
                                                                    <span id="teamrequire" class="error-date"><span>
                                                                </div>
                                                            </div><br> <br> <br>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-actions">
                                                <div class="row">
                                                    <div class="col-md-offset-3 col-md-9">
                                                        <a href="javascript:;" class="btn default button-previous disabled" style="display: ">
                                                            <i class="fa fa-angle-left"></i> กลับ </a>
                                                        <a href="javascript:;" class="btn btn-outline green button-next" id="next"> ถัดไป
                                                            <i class="fa fa-angle-right"></i>
                                                        </a>
                                                        <a href="javascript:;" class="btn green button-submit" style="display: none;" id="submit"> สร้าง
                                                            <i class="fa fa-check"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END PAGE BASE CONTENT -->
                </div>
                <!-- END CONTENT BODY -->
            </div>
	<!-- END CONTENT -->
</div>
