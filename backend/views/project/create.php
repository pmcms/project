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
$user = Yii::$app->user->identity;
$userID = $user->_id;
$userName = $user->firstname." ".$user->lastname;
$this->title = 'สร้างโครงการ';
$this->params['breadcrumbs'][] = ['label' => 'โครงการ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$userId = Yii::$app->user->identity->_id;

$str2 = <<<EOT

var dataUser = [
    {
        name : "$userName",
        userId : "$userId"
    }
];
var dataTeam = [];

function addUserMenber(newUser) {
    dataUser.push(newUser);
//  child.removeClass('fa fa-plus').addClass('fa fa-minus');
    console.log(dataUser);
    lenderMember();
    hideColumnUser(newUser.name);
}

function removeUserMember(id){
//  child.removeClass('fa fa-minus').addClass('fa fa-plus');
    $.each(dataUser, function( index, value ) {
        if(id === value.userId){
            dataUser.splice(index,1);
            return false;
        }
    });
    console.log(dataUser);
    lenderMember();
}

function lenderMember(){
    var lender = "";
    $.each(dataUser, function(index, value) {
        if(value.userId == "$userId"){
            lender = lender.concat('<tr height=33><td style=\"text-align:center\"></td>'+
            '<td>'+value.name+'</td><td width="50%"><div class="text-right">'+
            '</div>'+
            '</td></tr>');
        }else{
            lender = lender.concat('<tr height=20><td style=\"text-align:center\"></td>'+
            '<td>'+value.name+'</td><td width="50%"><div class="text-right">'+
            '<a href="javascript:;" type="button" class="right-user btn red btn-outline" style="padding:6px 10px 6px !important; font-size:15px;"'+
            'arr-id=\"'+value.userId+'\" '+
            'arr-name=\"'+value.name+'\">'+
            '<i class=\"fa fa-minus\"></i></a>'+
            '</div>'+
            '</td></tr>');
        }
    });
    $('#memberOfProject').html(lender);
}

function addTeamMenber(newTeam) {
    var isNewTeam = true;
    $.each(dataTeam, function( index, value ) {
        if(newTeam.teamId === value.teamId){
            isNewTeam = false;
            value.member = [];
            value.member = newTeam.member;
            return false;
        }
    });
    if(isNewTeam){
        dataTeam.push(newTeam);
    }
    console.log(dataTeam);
    lenderTeamMember();
    hideColumnTeam(newTeam.name);
    
}

function removeTeam(id){
//  child.removeClass('fa fa-minus').addClass('fa fa-plus');
    $.each(dataTeam, function( index, value ) {
        if(id === value.teamId){
            dataTeam.splice(index,1);
            return false;
        }
    });
    console.log(dataTeam);
    lenderTeamMember();
}

function removeTeamMember(id, parentId){
//  child.removeClass('fa fa-minus').addClass('fa fa-plus');
    $.each(dataTeam, function( index, value ) {
        if(parentId == value.teamId){
            $.each(value.member, function(indexMember, valueMember) {
                if(id === valueMember.user_id){
                    value.member.splice(indexMember,1);
                    if(value.member.length === 0){
                        removeTeam(parentId);
                    }
                    return false;
                }
            });
            return false;
        }
    });
    console.log(dataTeam);
    lenderTeamMember();
}

$(document).on('click', "a.right-team", function() {
    var id = $(this).attr('arr-id');
    var name = $(this).attr('arr-name');
    showColumnTeam(name);
    removeTeam(id); 
});


$(document).on('click', "a.right-member-team", function() {
    var id = $(this).attr('arr-id');
    var parentId = $(this).attr('arr-team-id');
    var teamName = "";
    $.each(dataTeam, function( index, value ) {
        if(value.teamId == parentId){
            teamName = value.name;
            return false;
        }
    });
    showColumnTeam(teamName);   
    removeTeamMember(id, parentId);    
});

$(document).on('click', "a.right-user", function() {
    var id = $(this).attr('arr-id');
    var name = $(this).attr('arr-name');
    showColumnUser(name);
    removeUserMember(id); 
});

function lenderTeamMember(){
    var lender = "";
    $.each(dataTeam, function(index, value) {
        lender = lender.concat('<tr height=20><td colspan="2"><b>'+
                 value.name+'</b></td>'+
                 '<td width="50%"><div class="text-right">'+
                 '<a href="javascript:;" type="button" class="right-team btn red btn-outline" style="padding:6px 10px 6px !important; font-size:15px;"'+
                 'arr-id=\"'+value.teamId+'\"'+
                 'arr-name=\"'+value.name+"\""+'>'+
                 '<i class=\"fa fa-minus\"></i></a>'+
                 '</div></td></tr>');
//      debugger;
        $.each(value.member, function(indexMember, valueMember) {
            lender = lender.concat('<tr height=20><td style=\"text-align:center\">&nbsp;&nbsp;</td>'+
                    '<td>&nbsp;'+valueMember.name+'</td>'+
                    '<td width="50%"><div class="text-right">'+
                    '<a href="javascript:;" type="button" class="right-member-team btn red btn-outline" style="padding:6px 10px 6px !important;font-size:15px;"'+
                    'arr-id=\"'+valueMember.user_id+'\" '+
                    'arr-team-id=\"'+value.teamId+'\">'+
                    '<i class=\"fa fa-minus\"></i>'+
                    '</a></div></td></tr>');
        });
    });
    $('#teamOfProject').html(lender);
}

$('a.btn-icon-only ').click(function(){
    var id = $(this).attr('arr-id');
    var name = $(this).attr('arr-name');
    var temp = {};
    var strClass = $(this).attr('class');
    if(strClass.includes("user")){
        temp = {
            userId : id,
            name : name,
        };
        addUserMenber(temp);
    }else if(strClass.includes("team")){
        var team  = $arrTeamMember;
        temp = {
            teamId : id,
            name : name,
            member : team[id]
        };
        addTeamMenber(temp);
    }
});

function showColumnTeam(teamName){
    $.each(dataTeam, function(index, value) {
        var row = "";
        $("table[id=team] tr").each(function(index) {
            if (index !== 0) {
//          debugger;
                row = $(this);
                var id = row.find("td:first").text();
                if (id.includes(teamName) == true) {
                    row.removeClass('hiden');
                    row.show();
                    return false;
                }
            }
        });
    });
};

function showColumnUser(userName){
    $.each(dataUser, function(index, value) {
        var row = "";
        $("table[id=user] tr").each(function(index) {
            if (index !== 0) {
//          debugger;
                row = $(this);
                var id = row.find("td:first").text();
                if (id.includes(userName) == true) {
                    row.removeClass('hiden');
                    row.show();
                    return false;
                }
            }
        });
    });
};

function hideColumnTeam(teamName){
    var row = "";
    $("table[id=team] tr").each(function(index) {
        if (index !== 0) {
            row = $(this);
            var rowTeamName = row.find("td:first").text();
            if (teamName.includes(rowTeamName) == true) {
                row.addClass('hiden');
                row.hide();
                return false;
            }
        }
    });
};

function hideColumnUser(userName){
    var row = "";
    $("table[id=user] tr").each(function(index) {
        if (index !== 0) {
            row = $(this);
            var rowUserName = row.find("td:first").text();
            if (userName.includes(rowUserName) == true) {
                row.addClass('hiden');
                row.hide();
                return false;
            }
        }
    });
};

$('#teamName').keyup(function(){
    var value = $(this).val();
    var row = "";
    $("table[id=team] tr").each(function(index) {
        if (index !== 0) {
        debugger;
            row = $(this);
            var strClass = $(this).attr('class');
            if(strClass == undefined){
                var id = row.find("td:first").text();
                if (id.includes(value) == true) {
                    row.show();
                }
                else {
                    row.hide();
                }
            }
        }
    });
});

$('#nameUser').keyup(function(){
    var value = $(this).val();
    var row = "";
    $("table[id=user] tr").each(function(index) {
        if (index !== 0) {
//      debugger;
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

function submitCreate(){
        
        var formData = new FormData();
        formData.append('name', $('input[name=projectname]').val());
        formData.append('startdate', $('input[id=from]').val()+" "+$('input[id=fromTime]').val());
        formData.append('enddate', $('input[id=to]').val()+" "+$('input[id=toTime]').val());
        formData.append('description', $('textarea[name=description]').val());
        formData.append('member', JSON.stringify(getMember()));
        formData.append('category', $('select[name=category]').val());
        formData.append('department', $('select[name=department]').val());
        
        var request = new XMLHttpRequest();
        request.open("POST", "$baseUrl/project/save", true);
        request.onreadystatechange = function () {
            if(request.readyState === XMLHttpRequest.DONE && request.status === 200) {
//              debugger;
                var response = request.responseText;
                if(typeof(response) == "string"){
                    response = JSON.parse(request.responseText);
                    console.log(response);
                }
            }
        };
        request.send(formData);
//      window.location.assign("$baseUrl/project");
//      window.location.href = "$baseUrl/project";
//      location.reload(true);
};

$("#projectname").change(function(){

    var projectname = ($("#projectname").val()).trim();

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

$("#projectname").keyup(function(){
    var value=($(this).val()).trim();
    if(value == ""){
        $("#error-name").hide();
    }
});

function getMember(){

    var dataMemberOfProject = [];
    var user = {};
    var team = {};
    // add user and map user in team
    $.each(dataUser, function( index, value ) {
        user = {
            user_id : value.userId,
            team : [],
        };
        $.each(dataTeam, function( indexTeam, valueTeam ) {
            var teamId = valueTeam.teamId;
            $.each(valueTeam.member, function( indexMember, valueMember ) {
                if(valueMember.user_id == value.userId){
                    user.team.push(valueMember.user_id);
                    valueTeam.member.splice(indexMember,1);
                    return false;
                }
            }); 
        });
        debugger;
        dataMemberOfProject.push(user);
    });
    
    // add member in team map team
//  $.each(dataTeam, function( index, value ) {
//      var teamId = value.teamId;
//      $.each(value.member, function( indexMember, valueMember ) {
//          team = {
//              user_id : valueMember.user_id,
//              team : [teamId],
//          }
//          $.each(dataTeam, function( indexTeam, valueTeam ) {
//              if(value.teamId != valueTeam.teamId){
//                  $.each(valueTeam.member, function( indexTeamMember, valueTeamMember ) {
//                      team.team.push(valueTeamMember.user_id);
//                  });
//              }
//          });
//          dataMemberOfProject.push(team);
//      }); 
//  });
    
    console.log(dataMemberOfProject);
    return dataMemberOfProject;
};

$("#from,#to").prop("readonly", true);

$( "#projectname" ).autoComplete({
    minChars: 1,
    source: function(term, suggest){
        term = term.toLowerCase();
        var choices = $arrProject;
        var suggestions = [];
        for (i=0;i<choices.length;i++)
            if (~choices[i].toLowerCase().indexOf(term)) suggestions.push(choices[i]);
        suggest(suggestions);
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
                                                            <div class="col-md-5">
                                                                <input type="text" class="form-control" name="projectname" placeholder="ชื่อโครงการ" id="projectname" maxlength="30"/>
                                                                <span id="error-name" class="error-date"></span>
                                                            </div>
                                                        </div>
                                                        
                                                         <div class="form-group">
                                                            <label class="control-label col-md-3">วันที่เริ่มต้น
                                                                <span class="required"> * </span>
                                                            </label>
                                                            <div class="col-md-3">
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
                                                            <div class="col-md-3">
                                                                <input type="text" class="form-control date-picker" name="stopdate" placeholder="วันที่สิ้นสุด" id="to"/>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <input type="text" id="toTime" class="form-control date-picker" name="stoptime" placeholder="เวลาสิ้นสุด" />
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3"></div>
                                                            <div class="col-md-6"><span id="requireDate" class="error-date"></span></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">คำอธิบาย</label>
                                                            <div class="col-md-5">
                                                                <textarea class="form-control" name="description" rows="3" placeholder="คำอธิบาย" id="description"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">ประเภทโครงการ
                                                                <span class="required"> * </span>
                                                            </label>
                                                            <div class="col-md-5">
                                                                <?php 
                                                                    echo  Html::dropDownList( 'category',
                                                                      'selected option',  
                                                                       $arrCategory, 
                                                                       ['class' => 'form-control', 'id' => 'category','prompt'=>'เลือกประเภทโครงการ']
                                                                    )
                                                                ?>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">แผนก</label>
                                                            <div class="col-md-5">
                                                                <?php 
                                                                    echo  Html::dropDownList( 'department',
                                                                      'selected optionkk',  
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
                                                                <div class="col-md-7" >
                                                                    <ul class="nav nav-tabs">
                                                                        <li class="active">
                                                                            <a href="#tab_0" data-toggle="tab" aria-expanded="true"> ทีม </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#tab_1" data-toggle="tab" > ผู้ใช้งาน </a>
                                                                        </li>
                                                                    </ul>
                                                                    <div class="tab-content">
                                                                        <div id="tab_0" class="tab-pane active">
                                                                            <div class="row">
                                                                                <div class="col-md-8">
                                                                                    <div class="col-md-11">
                                                                                         <input id="teamName" name="teamName" type="text" placeholder="ชื่อทีม" class="form-control input-circle">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <br>
                                                                            <div class="col-md-10">
                                                                                <table id="team">
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
                                                                                                    <a href="javascript:;" class="btn btn-circle btn-icon-only green team"
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
                                                                                    <div class="col-md-11">
                                                                                         <input id="nameUser" name="m" type="nameUser" placeholder="ชื่อ-สกุล" class="form-control input-circle">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <br>
                                                                            <div class="col-md-10">
                                                                                <table  id="user">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th width="30%">ชื่อ-นามสกุล</th>
                                                                                            <th width="5%"></th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        <?php foreach ($listUser as $fieldUser): ?>
                                                                                        <?php if($fieldUser->_id != $userId){?>
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
                                                                                        <?php } ?>
                                                                                        <?php endforeach; ?>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <div class="portlet light portlet-fit portlet-form bordered">
                                                                    <center><h5><b>ทีมในโครงการ</b></h5></center>
                                                                    <table width="100%" id="teamOfProject"></table>
                                                                    <hr width="100%" align="center" size="3" noshade color="#bbbbbb"></hr>
                                                                    <center><h5><b>ผู้ใช้งานในโครงการ</h5></b></center>
                                                                    <table  width="100%" id="memberOfProject">
                                                                        <tr height=20><td style=\"text-align:center\">
                                                                            <td><?=$userName ?></td>
                                                                            <td width="50%">
                                                                                <div class="text-right"></div>                                                      </div>
                                                                            </td>
                                                                        </tr>
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
                                                                    <input type="radio" name="want" id="want"/>    
                                                                    <span>ต้องการสร้างทีมใหม่</span><br/>
                                                                    <input type="radio" name="want" id="nowant" checked/>
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
                                                                <div class="col-md-4" >
                                                                    <input class="form-control" type="text"  name="teamname" id="teamname" placeholder="ชื่อทีม" disabled/>
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
		        
		    </section>
	      </div>
	    </div>
	  </div>
	</div>
</div>
