<?php
/**
 * Created by PhpStorm.
 * User: qingfeng.lian
 */

namespace backend\controllers;


class UeditorController extends Controller
{
    use \yii\ueditor\controllers\UeditorController;

    public $enableCsrfValidation =false;

    public function actionIndex(){
        $act = $this->get('action','');
        switch ($act){
            case 'config': //加载配置文件
                return json_encode($this->getConfig());
                break;

            case 'uploadimage': //上传图片
                return $this->uploadImage();
                break;
            case 'listimage': //图片管理列表
                return $this->listImage();
                break;
            default :
                break;
        }
    }
}