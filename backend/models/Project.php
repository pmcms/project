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
 * @property mixed $project_type
 * @property mixed $status
 * @property mixed $create_date
 * @property mixed $create_by
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
            'project_type',
            'status',
            'create_date',
            'create_by',
            'member',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_name', 'start_date', 'end_date', 'description', 'project_type', 'status', 'create_date', 'create_by', 'member'], 'safe']
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
            'project_type' => 'Project Type',
            'status' => 'Status',
            'create_date' => 'Create Date',
            'create_by' => 'Create By',
            'member' => 'Member',
        ];
    }
    
    public function findAllProject($name,$status,$sort){
    	$conditions = [];
    	$query = Project::find();
    	if(!empty($status)){
    		$conditions['status'] = $status;
    	}
    	if(!empty($sort)){
    		$conditions['sort'] = $sort;
    	}
    	if(!empty($conditions)){
    		$query->where($conditions);
    	}
    	if(!empty($name)){
    		$query->andWhere(['like', "project_name", $name]);
    	}
    	
    	$value = $query->all();
    	return $value;
    }
}
