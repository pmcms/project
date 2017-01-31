<?php

namespace backend\controllers;

use Yii;
use backend\models\Project;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Category;
use backend\models\Department;
use common\models\User;
use \MongoDate;
use yii\helpers\ArrayHelper;

/**
 * ProjectController implements the CRUD actions for Project model.
 */
class ProjectController extends Controller
{
	const SORT_PROJECT_NAME = 1;
	const SORT_STATUS = 2;
	const SORT_START_DATE = 3;
	const SORT_END_DATE = 4;
	
	const STATUS_ACTIVE = 1;
	const STATUS_INACTIVE = 0;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Project models.
     * @return mixed
     */
    public function actionIndex()
    {
    	$request = Yii::$app->request;
    	$name = $request->post('name');
    	$status = $request->post('status',null);
    	$sort = $request->post('sort',self::SORT_END_DATE);
		$userID = Yii::$app->user->identity->_id;
    	$value = Project::findAllProject($name, $status, $sort, $userID);
    	
    	$category = Category::find()->all();
    	$arrCategory = [];
    	if($category){
    		foreach ($category as $obj){
    			$arrCategory[(string)$obj->_id] = $obj->category_name;
    		}
    	}
    	
    	$user = User::find()->all();
    	$arrUser = [];
    	if($user){
    		foreach ($user as $obj){
    			$arrUser[(string)$obj->_id] = $obj->firstname." ".$obj->lastname;
    		}
    	}
        return $this->render('index', [
 			'value' => $value,'name' => $name,
        	'status' => $status, 'sort' => $sort,
        	'userId' => $userID, 'arrCategory' => $arrCategory,
        	'arrUser' => $arrUser,
        ]);
    }
    
    public function actionSave(){
    
    	$request = \Yii::$app->request;
    	$response = Yii::$app->response;
    	$response->format = \yii\web\Response::FORMAT_JSON;
    
    	$name = $request->post('name', null);
    	$description = $request->post('description', null);
    	$startdate = $request->post('startdate', null);
    	$enddate = $request->post('enddate', null);
    
    	$model = null;
    
    	   
    	if ($model == null){
    		$model = new Project();
    		$model->project_name = $name;
    		$model->start_date = $startdate;
    		$model->end_date =  $enddate;
    		$model->description =  $description;
    		
    		
    			
    	}
    	
    	
    	if($model->save()){
    		   			
    		$retData['success'] = true;
    		
    	}else{
    		$retData = ['success' => false];
    	}
    	echo json_encode($retData);
    
    }

    /**
     * Displays a single Project model.
     * @param integer $_id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Project model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
    	// drop down Category
    	$categoryModel = new Category;
    	$listCategory = Category::findAllCategoryByStatus(self::STATUS_ACTIVE);
    	$arrCategory = ArrayHelper::map($listCategory,function ($categoryModel){return  (string)$categoryModel->_id;},'category_name');
		
    	$departmentModel = new Department;
    	$arrDepartment = ArrayHelper::map(Department::find()->all(),function ($departmentModel){return  (string)$departmentModel->_id;},'department_name');
		return $this->render('create', [
	     	'arrCategory' => $arrCategory,
			'arrDepartment' => $arrDepartment,
		]);
    }

    /**
     * Updates an existing Project model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionUpdate()
    {
      
            return $this->render('update', [
                
            ]);
        
    }
    public function actionSetting()
    {
    
    	return $this->render('settingProject', [
    
    	]);
    
    }

    /**
     * Deletes an existing Project model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Project model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $_id
     * @return Project the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Project::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function beforeAction($action) {
    	$this->enableCsrfValidation = false;
    	return parent::beforeAction($action);
    }
    
	public function actionDuplicate()
	{
		if (Yii::$app->request->isAjax) {
		    $data = Yii::$app->request->post();
		    $projectname = explode(":", $data['searchname']);
		    $search = Project::findAllProjectByProjectName($projectname[0]);
		    if($search){
		    	$isDuplicate = true;
		    }else{
		    	$isDuplicate = false;
		    }
		    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		    return [
		        'isDuplicate' => $isDuplicate,
		    ];
		}
	}
	    
}
