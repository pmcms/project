<?php

use yii\helpers\Html;
use backend\assets\CreateAsset;
use yii\web\View;
use richardfan\widget\JSRegister;
/* @var $this yii\web\View */
/* @var $model backend\models\Project */
CreateAsset::register ( $this );

$this->title = 'สร้างโครงการ';
$this->params['breadcrumbs'][] = ['label' => 'โครงการ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php JSRegister::begin(); ?>
<script>

$("#projectname").change(function(){
	var projectname = $("#projectname").val();

		if(projectname != ""){
			$.ajax({
			       url: '<?php echo Yii::$app->request->baseUrl. '/project/duplicate' ?>',
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
</script>
<?php JSRegister::end(); ?>
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
                                                                <select class="form-control">
                                                                    <option class="form-control">โครงการ</option>
                                                                    <option class="form-control">อีเว้นท์</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">แผนก
                                                            </label>
                                                            <div class="col-md-4">
                                                                <select class="form-control">
                                                                    <option class="form-control">วิจัยและพัฒนาเทคโนโลยี</option>
                                                                    <option class="form-control">บุคคล</option>
                                                                    <option class="form-control">บัญชี</option>
                                                                </select>
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
											                                             <input id="mepEmnNo" name="mepEmnNo" type="text" placeholder="ชื่อทีม" class="form-control input-circle">
											                                       	</div>
											                                 	</div>
											                              	</div>
											                               	<br>
											                                <div class="col-md-8">
											                                    <table  width="100%" >
											                                        <thead>
											                                            <tr>
											                                                <th width="30%">ชื่อทีม</th>
											                                                <th width="5%"></th>
											                                            </tr>
											                                        </thead>
											                                        <tbody>
											                                            <tr>
											                                             	<td>ทีมการจัดการโปรเจค</td>
											                                              	<td>
											                                              		<p align="center">
											                                              			<a href="javascript:;" class="btn btn-circle btn-icon-only red">
											                                                        	<i class="fa fa-minus" style="font-size:20px"></i>
											                                                  		</a>
											                                                  	</p>
											                                              	</td>
											                                            </tr>
											                                            <tr>
											                                                <td>ทีมปฏิทิน</td>
											                                                <td>
											                                              		<p align="center">
											                                              			<a href="javascript:;" class="btn btn-circle btn-icon-only green">
											                                                      		<i class="fa fa-plus" style="font-size:20px"></i>
																									</a>
																								</p>
																							</td>
											                                            </tr>
											                                            <tr>
											                                                <td>ทีมออกแบบ</td>
											                                           		<td>
											                                              		<p align="center">
											                                              			<a href="javascript:;" class="btn btn-circle btn-icon-only green">
																										<i class="fa fa-plus" style="font-size:20px"></i>
											                                                     	</a>
											                                                   	</p>
																							</td>
											                                            </tr>
											                                   		</tbody>
											                             		</table>
											                             	</div>
											                           	</div>
											        					<div id="tab_1" class="tab-pane">
											                              	<div class="row">
											                                  	<div class="col-md-8">
											                                       	<div class="col-md-8">
											                                             <input id="mepEmnNo" name="mepEmnNo" type="text" placeholder="ชื่อ-สกุล" class="form-control input-circle">
											                                       	</div>
																				</div>
											                             	</div>
											                               	<br>
											                                <div class="col-md-8">
											                                	<table  width="100%" >
											                                        <thead>
											                                            <tr>
											                                                <th width="30%">ชื่อ-นามสกุล</th>
											                                                <th width="5%"></th>
											                                            </tr>
											                                        </thead>
											                                        <tbody>
											                                            <tr>
											                                             	<td>เจนสันต์ ริยาพันธ์</td>
											                                              	<td>
											                                              		<p align="center">
											                                              			<a href="javascript:;" class="btn btn-circle btn-icon-only red">
											                                                        	<i class="fa fa-minus" style="font-size:20px"></i>
											                                                  		</a>
											                                                  	</p>
											                                              	</td>
											                                            </tr>
											                                            <tr>
											                                                <td>กฤษต เหนือคลอง</td>
											                                                <td>
											                                              		<p align="center">
											                                              			<a href="javascript:;" class="btn btn-circle btn-icon-only green">
											                                                      		<i class="fa fa-plus" style="font-size:20px"></i>
																									</a>
																								</p>
																							</td>
											                                            </tr>
											                                            <tr>
											                                                <td>ชัยสิทธิ์ ลิ่มสกุล</td>
											                                           		<td>
											                                              		<p align="center">
											                                              			<a href="javascript:;" class="btn btn-circle btn-icon-only green">
																										<i class="fa fa-plus" style="font-size:20px"></i>
											                                                     	</a>
											                                                   	</p>
																							</td>
											                                            </tr>
											                                   		</tbody>
											                             		</table>
											                          		</div>
											                        	</div>
											                    	</div>
											                    </div>
											                    <div class="col-md-4">
											                     	<div class="portlet light portlet-fit portlet-form bordered">
											                        <center><h5>พนักงานภายในโครงการ</h5></center>
											                        <table  width="100%">
											                        	<thead>
											                              	<tr>
											                               		<th ></th>
											                                	<th ></th>
											                             	</tr>
											                           	</thead>
											                           	<tbody>
											                            	<tr  height=20>
											                                	<td style="text-align:center">
											                                		<input type="checkbox" name="checkbox-1" id="checkbox-1" checked/>
											                                	</td>
																				<td>
																					ทีมการจัดการโครงการ 
																					<i class="fa fa-users" style="color:green"></i>
																				</td>
																			</tr>
											                              	<tr>
											                                  	<td >
											                                  	</td>
											                                    <td>
											                                   		<input type="checkbox" name="checkbox-1" id="checkbox-1" checked/>ประทีป คงกล้า 
											                                       		<i class="fa fa-user" style="color:#32c5d2"></i><br>
											                                       	<input type="checkbox" name="checkbox-1" id="checkbox-1" checked/>กฤษฎา หมัดอะดัม
											                                            <i class="fa fa-user" style="color:#32c5d2"></i><br>
											                                       	<input type="checkbox" name="checkbox-1" id="checkbox-1" checked/>สากีริน ขามิ๊
											                                           	<i class="fa fa-user" style="color:#32c5d2"></i><br>
											                                        <input type="checkbox" name="checkbox-1" id="checkbox-1" checked/>อัศม์เดช โส้สมัน
											                                           	<i class="fa fa-user" style="color:#32c5d2"></i><br>
											                                        <input type="checkbox" name="checkbox-1" id="checkbox-1" checked/>นัทธพงศ์ ซุ่นสั้น
											                                            <i class="fa fa-user" style="color:#32c5d2"></i><br>
											                                   	</td>
											                           		</tr>
											                                <tr height=50>
											                                    <td style="text-align:center">
											                                    	<input type="checkbox" name="checkbox-1" id="checkbox-1" checked/>
											                                    </td>
											                                    <td>
											                                    	เจนสันต์ ริยาพันธ์ 
											                                    	<i class="fa fa-user" style="color:#32c5d2"></i>
											                                    </td>
											                               	</tr>
											                                <tr height=50>
											                                	<td style="text-align:center">
											                                		<input type="checkbox" name="checkbox-1" id="checkbox-1" checked/>
											                                	</td>
											                                   	<td>
											                                   		ชัยสิทธิ์ ลิ่มสกุล
											                                   		<i class="fa fa-user" style="color:#32c5d2"></i>
											                                   	</td>                
											                              	</tr>
											                          	</tbody>
											                     	</table>
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
