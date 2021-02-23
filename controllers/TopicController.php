<?php
namespace kaikaige\dq\controllers;

use kaikaige\dq\forms\topic\CreateForm;

class TopicController extends Controller
{
    public function actionIndex()
    {
        if (\Yii::$app->request->isAjax) {
            $data = $this->dq->topicList();
            $data['code'] = 0;
            return $this->asJson($data);
        }
        return $this->render('index');
    }

    public function actionCreate()
    {
        $model = new CreateForm();
        if (\Yii::$app->request->isPost) {
            $model->load(\Yii::$app->request->post());
            return $this->asJson($model->run($this->dq));
        } else {
            $model->delay = 0;
            return $this->render('create', [
                'model' => $model
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $data = $this->dq->topicView($id);
        if ($data['code'] != 200) {
            return $this->asJson(['code'=>200, 'msg'=>$data['errMsg']]);
        }
        $model = new CreateForm();
        if (\Yii::$app->request->isPost) {
            $model->load(\Yii::$app->request->post());
            return $this->asJson($model->run($this->dq));
        } else {
            $model->setAttributes($data['data']);
            return $this->render('create', [
                'model' => $model
            ]);
        }
    }

    public function actionDelete($id)
    {
        return $this->asJson($this->dq->topicDelete($id));
    }

    public function actionView($id)
    {
        $res = $this->dq->topicView($id);
        if ($res['code'] == 200) {
            return $this->render('view', ['data' => $res['data']]);
        }
    }
}