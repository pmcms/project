<?php

namespace backend\models;

use Yii;
use GuzzleHttp\Psr7\PumpStream;

/**
 * This is the model class for collection "project".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 * @property mixed $project_name
 * @property mixed $start_date
 * @property mixed $end_date
 * @property mixed $description
 * @property mixed $category
 * @property mixed $status
 * @property mixed $create_date
 * @property mixed $create_by
 * @property mixed department
 * @property mixed $member
 */
class Project extends \yii\mongodb\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return ['db_pm', 'project'];
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            'project_name',
            'start_date',
            'end_date',
            'description',
            'category',
            'status',
            'create_date',
            'create_by',
        	'department',
            'member',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_name', 'start_date', 'end_date', 'description', 'category', 'status', 'create_date', 'create_by', 'department', 'member'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => 'ID',
            'project_name' => 'Project Name',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'description' => 'Description',
            'category' => 'Project Type',
            'status' => 'Status',
            'create_date' => 'Create Date',
            'create_by' => 'Create By',
            'member' => 'Member',
        ];
    }
    
    public function findAllProject($name,$status,$sort,$userId){
    	$conditions = [];
    	$query = Project::find();
  
    	if(!empty($status)){
    		$conditions['status'] = $status;
    	}
    	if(!empty($userId)){
    		$conditions['member.id_user'] = $userId;
    	}
    	if(!empty($conditions)){
    		$query->where($conditions);
    	}
    	if(!empty($name)){
    		$query->andWhere(['like', "project_name", $name]);
    	}
    	
    	$query->orderBy(['status'=>SORT_ASC]);
    	
    	if(!empty($sort)){
    		if($sort == 1){
    			$query->addOrderBy(['project_name'=>SORT_ASC]);
    		}elseif ($sort == 2){
    			$query->addOrderBy(['status'=>SORT_ASC]);
    		}elseif ($sort == 3){
    			$query->addOrderBy(['start_date'=>SORT_ASC]);
    		}else{
    			$query->addOrderBy(['end_date'=>SORT_DESC]);
    		}
    	}
    	
    	
    	$value = $query->all();
    	return $value;
    }
    
    const STATUS_OPEN = 1;
    const STATUS_CLOSE = 2;
    const STATUS_CANCEL = 3;
    const STATUS_DELETED = 4;
    
    
    const SORT_PROJECT_NAME = 1;
    const SORT_STATUS = 2;
    const SORT_START_DATE = 3;
    const SORT_END_DATE = 4;
    
    const TYPE_PROJECT_MANAGER = 1;
    const TYPE_DEVELOPER = 2;
    const TYPE_REPORTER = 3;
   
    
    public static $arrSendStatus = array(
    		self::STATUS_OPEN => "เปิด",
    		self::STATUS_CLOSE => "ปิด",
    		self::STATUS_CANCEL => "ยกเลิก",
    		self::STATUS_DELETED => "ถูกลบ"
    );
    
    public static $arrSort = array(
    		self::SORT_PROJECT_NAME => "ชื่อโครงการ",
    		self::SORT_STATUS => "สถานะ",
    		self::SORT_START_DATE => "วันที่เริ่ม",
    		self::SORT_END_DATE => "วันที่สิ้นสุด"
    );
    public static $arrType = array(
    		self::TYPE_PROJECT_MANAGER => "ProjectManager",
    		self::TYPE_DEVELOPER => "Developer",
    		self::TYPE_REPORTER => "Reporter"
    		
    );
    public function findAllProjectByProjectNameAndDepartmentId($projectName, $departmentId){
    	$conditions = [];
    	$query = Project::find();
    	
    	if(!empty($projectName)){
    		$conditions['project_name'] = $projectName;
    	}
    	if(!empty($departmentId)){
    		$conditions['departmentId'] = $departmentId;
    	}
    
    	if(!empty($conditions)){
    		$query->where($conditions);
    	}
    	$listProject = $query->all();
    	return $listProject;
    }
   
}
