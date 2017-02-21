<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Category */

$this->title = 'สร้างประเภทโครงการ';
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-create">
  <div class="panel panel-success">
      <div class="panel-heading"><font size="5">สร้างประเภทโครงการ</font></div>
        <div class="panel panel-body" >
          <div class="row">
            <div class="form-group">
                <div class="col-md-4">
                  <label class="control-label text-right">ชื่อประเภทโครงการ
                    <span class="required" aria-required="true"> * </span>
                  </label>
               </div>

               <div class="col-md-8">
                 <input type="text" class="form-control" name="projectname" placeholder="ชื่อประเภทโครงการ" id="projectname" maxlength="30" autocomplete="off">
              </div>
            </div>
            <div class="form-group">
                <div class="col-md-4">
                  <label class="control-label">รายละเอียด
                    <span class="required" aria-required="true"> * </span>
                  </label>
               </div>

               <div class="col-md-8">
              <input type="text" class="form-control" name="detailCat" placeholder="รายละเอียด" id="detailCat" maxlength="30" autocomplete="off">
              </div>
          </div>
            <div class="text-center">
                <a href="javascript:;" class="btn green button-submit" style="" id="submit"> สร้าง
                <i class="fa fa-check"></i>
                </a>
           </div>
        </div>

    </div>
  </div>
</div>
