<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for collection "Task".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 * @property \MongoDB\BSON\ObjectID|string $_id
 * @property mixed $task_name
 * @property mixed $start_date
 * @property mixed $end_date
 * @property mixed $status
 * @property mixed $create_date
 * @property mixed $create_by
 * @property mixed $member
 * @property mixed $description
 */
class Task extends \yii\mongodb\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return ['db_pm', 'task'];
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            '_id',
            'task_name',
            'start_date',
            'end_date',
            'status',
            'create_date',
            'create_by',
            'member',
            'description',
        	'project',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_name', 'start_date', 'end_date', 'status', 'create_date', 'create_by', 'member', 'description','project'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => 'ID',
            'task_name' => 'Task Name',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'status' => 'Status',
            'create_date' => 'Create Date',
            'create_by' => 'Create By',
            'member' => 'Member',
            'description' => 'Description',
        	'project' => 'Project',
        ];
    }
    const TYPE_PROGRESS = 0;
    const TYPE_SUCCESS = 1;
    
    
    
    public static $arrType = array(
    		self::TYPE_PROGRESS => "กำลังดำเนินการ",
    		self::TYPE_SUCCESS => "เสร็จแล้ว",
    		
    		
    
    );
}
