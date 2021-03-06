<?php

namespace kaikaige\dq\forms\topic;

class CreateForm extends \yii\base\Model
{
    public $name;

    public $ttr;

    public $delay;

    public $des;

    public function rules()
    {
        return [
            [['name', 'delay'], 'required'],
            [['delay'], 'integer', 'min'=>0],
            [['des', 'ttr'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => '名称',
            'delay' => '延时',
            'des' => '备注'
        ];
    }

    /**
     * @des 写入topic
     * @param $dq \kaikaige\dq\components\DqClient
     * @date 2021/2/23 15:10
     * @author gaokai
     * @modified_date 2021/2/23 15:10
     * @modified_user gaokai
     */
    public function run($dq)
    {
        $res = $dq->topicCreate($this->attributes);
        if ($res->isOk) {
            return ['code'=>0, 'msg'=>'添加成功'];
        }
        return ['code'=>1, 'msg'=>$res->getContent()];
    }
}
