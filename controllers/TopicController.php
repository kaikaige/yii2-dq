<?php
namespace kaikaige\dq\controllers;

use kaikaige\dq\forms\topic\CreateForm;
use kaikaige\dq\forms\topic\PushJobForm;

class TopicController extends Controller
{
    public function actionTest()
    {
        $res = $this->dq->jobPush('order-cancel', 'hell');
        if (!$res->isOk) {
            throw new \Exception($res->content);
        }
        var_dump($res->getData());
    }

    public function actionIndex()
    {
        if (\Yii::$app->request->isAjax) {
            $res = $this->dq->topicList();
            if (!$res->isOk) {
                throw new \Exception($res->getContent());
            } else {
                $data = ['code' => 0, 'data' => $res->getData()];
            }
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
        $res = $this->dq->topicView($id);
        if (!$res->isOk) {
            throw new \Exception($res->getContent());
        }
        $model = new CreateForm();
        if (\Yii::$app->request->isPost) {
            $model->load(\Yii::$app->request->post());
            return $this->asJson($model->run($this->dq));
        } else {
            $model->setAttributes($res->getData());
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

    public function actionPushJob($id)
    {
        $model = new PushJobForm();
        if (\Yii::$app->request->isPost) {
            $model->load(\Yii::$app->request->post());
            return $this->asJson($model->run($this->dq));
        } else {
            $model->topic = $id;
            return $this->render('push-job', [
                'model' => $model
            ]);
        }
    }
}