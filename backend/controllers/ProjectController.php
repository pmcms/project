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
use backend\models\Team;
use MongoDB\BSON\ObjectID;
use common\models\User;
use \MongoDate;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\data\Pagination;

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
    	$alert = Yii::$app->session->getFlash('alert');
    	$request = Yii::$app->request;
    	$name = $request->post('name');
    	$status = $request->post('status',null);
    	$sort = $request->post('sort',self::SORT_END_DATE);
    	$type = $request->post('type',null);
		$userId = Yii::$app->user->identity->_id;
		$conditions = [];
		$query = Project::find();
		
		if(!empty($status)){
			$conditions['status'] = $status;
		}
		if(!empty($conditions)){
			$query->where($conditions);
		}
		if(!empty($name)){
			$query->andWhere(['like', "project_name", $name]);
		}
		if(!empty($userId)){
			if(!empty($type)){
				$query->andwhere(array('member.userId' => $userId,'member.type' =>  (int)$type));
			}
			else{
				$query->andwhere(array('member.userId' => $userId));
			}
		}
		$pagination = new Pagination([
				'defaultPageSize' => 15,
				'totalCount' => $query->count(),
		]);
		$query->offset($pagination->offset);
		$query->limit($pagination->limit);
		$query->orderBy(['status'=>SORT_ASC]);
		 
		if(!empty($sort)){
			if($sort == 1){
				$query->addOrderBy(['project_name'=>SORT_ASC]);
			}elseif ($sort == 2){
				$query->addOrderBy(['status'=>SORT_ASC]);
			}elseif ($sort == 3){
				$query->addOrderBy(['start_date'=>SORT_ASC]);
			}else{
				$query->addOrderBy(['end_date'=>SORT_ASC]);
			}
		}

	   	$value = $query->all();
    	    	
    	$pagination->params = ['page'=> $pagination->page];

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
    	
    	if($alert != null){
    		$alert = ($alert)?true:false;
    	}else{
    		$alert = "undefined";
    	}
    	
        return $this->render('index', [
 			'value' => $value,'name' => $name,
        	"pagination"=>$pagination,
        	'status' => $status, 'sort' => $sort,
        	'userId' => $userId, 'arrCategory' => $arrCategory,
        	'arrUser' => $arrUser, 'alert' => $alert,
        	'type' =>	$type,
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
    	$member = $request->post('member', null);
    	$categoty = $request->post('category', null);
    	$department = $request->post('department', null);
    	$isCreateTeam = $request->post('isCreateTeam', null);
    	$teamName = $request->post('teamName', null);
    	$model = null;
    	
    	$userId = Yii::$app->user->identity->_id;
    	$member = json_decode($member);
    	$nummberMember = sizeof($member);
    	
    	if($isCreateTeam){
    		$teamModel = new Team();
    		$teamModel->teamName = $teamName;
    		$teamModel->description = $teamName;
    		$teamModel->createDate = "";
    		$teamModel->createBy = $userId;
    		
    		$teamMember = [];
    		for ($i = 0; $i < $nummberMember; $i++) {
    			$teamMember[$i]['userId'] = new ObjectID($member[$i]->userId);
    		}
    		$teamModel->member = $teamMember;
    		
    		$teamModel->save();
    		
    		$newTeamQuery = Team::findOne(['teamName' => $teamName]);
    		
    		$newTeamId = $newTeamQuery->_id;
    		
    		$projectMember = [];
    		for ($i = 0; $i < $nummberMember; $i++) {
    			$projectMember[$i]['userId'] = new ObjectID($member[$i]->userId);
    			$projectMember[$i]['teamId'] = new ObjectID($newTeamId);
    		}
    		$member = $projectMember;
    	}else{
    		// add Member
    		for ($i = 0; $i < $nummberMember; $i++) {
    			$userId = $member[$i]->userId;
    			$member[$i]->userId = new ObjectID($userId);
    		
    			$team = $member[$i]->team;
    			$nummberTeam = sizeof($team);
    			for ($j = 0; $j < $nummberTeam; $j++) {
    				$member[$i]->team[$j]->teamId = new ObjectID($team[$j]->teamId);
    			}
    		}	
    	}
    	
    	
    	if ($model == null){
    		$model = new Project();
    		$model->project_name = $name;
    		$model->start_date = $startdate;
    		$model->end_date = $enddate;
    		$model->description =  $description;
    		$model->status = self::STATUS_ACTIVE;
    		$model->category = new ObjectID($categoty);
    		$model->department = new ObjectID($department);
    		$model->member = $member;
    		$model->create_by = new ObjectID($userId);
//     		$model->create_date = new \MongoDate();
//     		(new \DateTime())->format('d/m/Y H:i:s');
    	}
    	if($model->save()){
    		$message = true;
    		$retData['success'] = true;
    	}else{
    		$message = false;
    		$retData = ['success' => false];
    	}
//     	Yii::$app->session->setFlash('alert', $message);
    	 
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
    	$categoryModel = new Category();
    	$listCategory = Category::findAllCategoryByStatus(self::STATUS_ACTIVE);
    	$arrCategory = ArrayHelper::map($listCategory,function ($categoryModel){return  (string)$categoryModel->_id;},'category_name');
		
    	$project = Project::find()->all();
    	$arrProject = [];
    	if($project){
    		foreach ($project as $obj){
    			$arrProject[] = $obj->project_name;
    		}
    	}
    	
    	$departmentModel = new Department();
    	$arrDepartment = ArrayHelper::map(Department::find()->all(),function ($departmentModel){return  (string)$departmentModel->_id;},'department_name');
		
		$user = new User();
		$listUser  = User::findAllUserByStatus(10);
		
		$arrUser = [];
		if($listUser){
			foreach ($listUser as $obj){
				$arrUser[(string)$obj->_id] = $obj->firstname." ".$obj->lastname;
			}
		}
		
		$team = new Team();
		$listTeam  = Team::findAllTeamByStatus(self::STATUS_ACTIVE);
		
		// Json MemberOfTeam
    	$arrTeamMember = "{";
    	foreach ($listTeam as $obj){
    		$member = $obj->member;
    		$arrTeamMember .= "\"".(string)$obj->_id."\""." : ";
    		$arrTeamMember .= "[";
    		$size = sizeof($member);
    		for($i = 0; $i < $size;$i++)
    		{
    			$arrTeamMember .= "{ \"userId\" : ";
    			$arrTeamMember .= "\"".$member[$i]["userId"]."\",";
    			$arrTeamMember .= "\"name\" : \"".$arrUser[(string)$member[$i]["userId"]]."\"";
    			$arrTeamMember .= "},";
    		}
    		$arrTeamMember .= "],";
    	}
    	$arrTeamMember .= "}";

		return $this->render('create', [
	     	'arrCategory' => $arrCategory,
			'arrDepartment' => $arrDepartment,
			'listUser' => $listUser,
			'listTeam' => $listTeam,
			'arrTeamMember' => $arrTeamMember,
			'member' => $member,
			'arrProject' => json_encode($arrProject),
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
	
// 	public function actionMember()
// 	{
// 		if (Yii::$app->request->isAjax) {
// 			$data = Yii::$app->request->post();
// 			$projectname = explode(":", $data['teamId']);
			
// 			$conditions = [];
// 			$query = Team::find();
// 			$conditions['_id'] = new ObjectID($projectname[0]);
// 			$query->where($conditions);
// 			$value = $query->all();
// 			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
// 			return [
// 					'isDuplicate' => $value,
// 			];
// 		}
// 	}
	
}
