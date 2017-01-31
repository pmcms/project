<?php

namespace backend\controllers;

use Yii;
use backend\models\Project;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Category;
use common\models\User;

/**
 * ProjectController implements the CRUD actions for Project model.
 */
class ProjectController extends Controller
{
	const SORT_PROJECT_NAME = 1;
	const SORT_STATUS = 2;
	const SORT_START_DATE = 3;
	const SORT_END_DATE = 4;
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
        $model = new Project();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => (string)$model->_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
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
