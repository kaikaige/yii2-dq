<?php
namespace kaikaige\dq;

use kaikaige\dq\components\DqClient;
use Yii;
use yii\httpclient\Client;

class Module extends \yii\base\Module
{
    /**
     * @var DqClient
     */
    public $dq;

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        $this->dq = Yii::$app->get($this->dq);
    }
}