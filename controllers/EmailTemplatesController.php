<?php

namespace tikaraj21\newsletter\controllers;

use Yii;
use tikaraj21\newsletter\models\EmailTemplates;
use tikaraj21\newsletter\models\EmailTemplatesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use tikaraj21\newsletter\models\SavedEmailTemplates;
/**
 * EmailTemplatesController implements the CRUD actions for EmailTemplates model.
 */
class EmailTemplatesController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access'=>[
                                'class'=>AccessControl::classname(),
                                'only'=>['create','update','delete','updatebackup'],
                                'rules'=>[
                                            [
                                                'allow'=>true,
                                                'roles'=>['@']
                                            ],
                                ]
                    ]
        ];
    }

    /**
     * Lists all EmailTemplates models.
     * @return mixed
     */
    public function actionIndex()
    {
            $searchModel = new EmailTemplatesSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
     
    }

    /**
     * Displays a single EmailTemplates model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new EmailTemplates model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
       
            $model = new EmailTemplates();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
      
        
    }

    /**
     * Updates an existing EmailTemplates model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
                    $model = $this->findModel($id);

                    //collecting the image sources in a string stored in database
                    preg_match_all('/(?<!_)src=([\'"])?(.*?)\\1/',$model->template_body, $arr_of_old_imgs);

                    if ($model->load(Yii::$app->request->post())) {

                         //collecting the image sources in a string submitted fotm the form
                         preg_match_all('/(?<!_)src=([\'"])?(.*?)\\1/',$model->template_body, $arr_of_new_imgs);

                         //checking the image exist in ckeditor

                            foreach ($arr_of_old_imgs[0] as $srcs1){
                                if(!in_array($srcs1, $arr_of_new_imgs[0])){
                                    $pure_src_modif = str_replace(['src="','http://localhost/SbrTest','"'],['','',''],$srcs1);
                                    $pure_delete_loc = str_replace('/',DIRECTORY_SEPARATOR,$pure_src_modif);
                                    //echo BASE_PATH.$pure_src12;die;
                                    @unlink(BASE_PATH.$pure_delete_loc);
                                }

                            }
                        $model->save();
                        return $this->redirect(['index']);
                    } 
                    else {
                        return $this->render('update', [
                            'model' => $model,
                        ]);
                    }
     
        
    }
public function actionUpdatebackup($id)
    {
    		$model = $this->findModel($id);
    
    		//collecting the image sources in a string stored in database
    		preg_match_all('/(?<!_)src=([\'"])?(.*?)\\1/',$model->template_body, $arr_of_old_imgs);
    
    		if ($model->load(Yii::$app->request->post())) {
              
    			//collecting the image sources in a string submitted fotm the form
    			preg_match_all('/(?<!_)src=([\'"])?(.*?)\\1/',$model->template_body, $arr_of_new_imgs);
    
    			//checking the image exist in ckeditor
                $modelSavedEmail = new SavedEmailTemplates();
    			foreach ($arr_of_old_imgs[0] as $srcs1){
    				if(!in_array($srcs1, $arr_of_new_imgs[0])){
    					$pure_src_modif = str_replace(['src="','http://localhost/SbrTest','"'],['','',''],$srcs1);
    					$pure_delete_loc = str_replace('/',DIRECTORY_SEPARATOR,$pure_src_modif);
    					//echo BASE_PATH.$pure_src12;die;
    					@unlink(BASE_PATH.$pure_delete_loc);
    				}
    
    			}
    			$modelSavedEmail->template_name = $model->template_name;
    			$modelSavedEmail->template_body = $model->template_body;
    			$modelSavedEmail->template_description = $model->template_description;
    			$modelSavedEmail->save();
    			Yii::$app->session->setFlash('success','Successfully saved as a new.'); //for for wrong event.
    			return $this->redirect(['saved-email-templates/index']);
    		}
    		else {
    			return $this->render('update', [
    					'model' => $model,
    			]);
    		}
    	
    
    }
    /**
     * Deletes an existing EmailTemplates model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
       
       
                    $model = $this->findModel($id);
                    //collecting the image sources in a string stored in database
                    preg_match_all('/(?<!_)src=([\'"])?(.*?)\\1/',$model->template_body, $arr_of_old_imgs);
                    foreach ($arr_of_old_imgs[0] as $srcs1){

                            $pure_src_modif = str_replace(['src="','http://localhost/SbrTest','"'],['','',''],$srcs1);

                            $pure_delete_loc = str_replace('/',DIRECTORY_SEPARATOR,$pure_src_modif);

                            @unlink(BASE_PATH.$pure_delete_loc);

                        }
                    $model->delete();
            
        return $this->redirect(['index']);
      
        
        
    }

    /**
     * Finds the EmailTemplates model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EmailTemplates the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EmailTemplates::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

