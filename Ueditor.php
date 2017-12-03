<?php
namespace qingfeng\ueditor;

use yii\widgets\InputWidget;
use yii\helpers\Html;
use yii\helpers\Json;


/**
 * Created by PhpStorm.
 * User: lianqingfeng
 */
class Ueditor extends InputWidget
{
    public $attributes;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $view = $this->getView();
        $this->attributes['id']=$this->options['id'];
        if($this->hasModel()){
            $input=Html::activeTextarea($this->model, $this->attribute,$this->attributes);
        }else{
            $input=Html::textarea($this->name,'',$this->attributes);
        }
        UeditorAsset::register($view);//将Ueditor用到的脚本资源输出到视图
        //设置js需要的变量
        $ueditorServerUrl = isset($this->options['config']['ueditorServerUrl']) ? $this->options['config']['ueditorServerUrl'] : '';
        $config =<<<EOF
        var ueditorServerUrl = '{$ueditorServerUrl}'
EOF;
        $view->registerJs($config,$view::POS_HEAD);
        $js='var ue = UE.getEditor("'.$this->options['id'].'",'.$this->getOptions().');';//Ueditor初始化脚本
        $view->registerJs($js, $view::POS_END);//将Ueditor初始化脚本也响应到视图中
        echo $input;
    }

    public function getOptions()
    {
        unset($this->options['id']);//Ueditor识别不了id属性,故而删之
        return Json::encode($this->options);
    }
}