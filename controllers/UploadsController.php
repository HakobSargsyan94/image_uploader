<?php

namespace app\controllers;

use app\models\UploadImages;
use app\models\Uploads;
use app\models\UploadsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UploadsController implements the CRUD actions for Uploads model.
 */
class UploadsController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    private function deleteRelationAndFiles($id) {
        $oldFiles = UploadImages::find()->where(['upload_id' => $id])->all();
        foreach ($oldFiles as $oldFile) {
            unlink($oldFile['image']);
        }
        UploadImages::deleteAll(['upload_id' => $id]);

        return true;
    }

    /**
     * Lists all Uploads models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UploadsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Uploads model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * @return string
     */
    public function actionCreate()
    {
        $model = new Uploads();

        if ($this->request->isPost) {
            try {
                $data = $this->request->post('Uploads');
                $model->name = $data['name'];
                $model->created_at = date("Y-m-d H:i:s");
                $model->save(false);
                $files = $_FILES['Uploads'];

                if ($model && !empty(current($files['name']['images']))) {
                    $id = $model->id;

                    for ($i = 0; $i < count($files['name']['images']); $i++) {
                        $target_dir = "uploads/";
                        $temp = explode(".", $files["name"]['images'][$i]);
                        $newFileName = $target_dir . 'image_' .
                            rand(1,1000000) . '_' .
                            strtotime(date('Y-m-d H:i:s')) . '.' .
                            end($temp);
                        move_uploaded_file($files["tmp_name"]['images'][$i], $newFileName);

                        $imageModel = new UploadImages();
                        $imageModel->upload_id = $id;
                        $imageModel->image = $newFileName;
                        $imageModel->save(false);
                    }
                }

                return $this->redirect(['index']);
            } catch (\Exception $e) {
                die($e->getMessage());
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Uploads model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            try {
                $data = $this->request->post('Uploads');
                $model->name = $data['name'];
                $model->save(false);
                $files = $_FILES['Uploads'];
                if ($model && !empty(current($files['name']['images']))) {
                    $this->deleteRelationAndFiles($id);
                    for ($i = 0; $i < count($files['name']['images']); $i++) {
                        $target_dir = "uploads/";
                        $temp = explode(".", $files["name"]['images'][$i]);
                        $newFileName = $target_dir . 'image_' .
                            rand(1,1000000) . '_' .
                            strtotime(date('Y-m-d H:i:s')) . '.' .
                            end($temp);
                        move_uploaded_file($files["tmp_name"]['images'][$i], $newFileName);

                        $imageModel = new UploadImages();
                        $imageModel->upload_id = $id;
                        $imageModel->image = $newFileName;
                        $imageModel->save(false);
                    }
                }

                return $this->redirect(['index']);
            } catch (\Exception $e) {
                die($e->getMessage());
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Uploads model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        $this->deleteRelationAndFiles($id);

        return $this->redirect(['index']);
    }

    /**
     * Finds the Uploads model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Uploads the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Uploads::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
