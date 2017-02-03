<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for collection "team".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 * @property mixed $team_name
 * @property mixed $description
 * @property mixed $status
 * @property mixed $create_date
 * @property mixed $create_by
 * @property mixed $member
 */
class Team extends \yii\mongodb\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return ['db_pm', 'team'];
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            'team_name',
            'description',
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
            [['team_name', 'description', 'status', 'create_date', 'create_by', 'member'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => 'ID',
            'team_name' => 'Team Name',
            'description' => 'Description',
            'status' => 'Status',
            'create_date' => 'Create Date',
            'create_by' => 'Create By',
            'member' => 'Member',
        ];
    }
    public function findAllTeam($name,$status,$sort){
    	$conditions = [];
    	$query = Team::find();
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
    		$query->andWhere(['like', "team_name", $name]);
    	}
    	 
    	$value = $query->all();
    	return $value;
    }
    
    public function findAllTeamByStatus($status){
    	$conditions = [];
    	$query = Team::find();
    	if(!empty($status)){
    		$conditions['status'] = $status;
    	}
    	if(!empty($conditions)){
    		$query->where($conditions);
    	}
    	$query->addOrderBy(['team_name'=>SORT_ASC]);
    	$listTeam = $query->all();
    	return $listTeam;
    }
}
