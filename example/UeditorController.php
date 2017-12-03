<?php
/**
 * Created by PhpStorm.
 * User: qingfeng.lian
 */

namespace backend\controllers;


class UeditorController extends Controller
{
    use \qingfeng\ueditor\controllers\UeditorController;

    public function actionIndex()
    {
        $act = $this->get('action', '');

        //获取配置信息
        $config = $this->getConfig();
        //可以在此次更改配置信息
        $this->ueditorConfig['imagePathFormat'] = "/upload/wanphp/article/image/{yyyy}{mm}{dd}/{time}{rand:6}";

        switch ($act) {
            case 'config': //加载配置文件
                return json_encode($config);
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