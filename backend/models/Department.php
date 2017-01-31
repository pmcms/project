<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for collection "department".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 * @property mixed $department_name
 */
class Department extends \yii\mongodb\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return ['db_pm', 'department'];
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            'department_name',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['department_name'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => 'ID',
            'department_name' => 'Department Name',
        ];
    }
}
