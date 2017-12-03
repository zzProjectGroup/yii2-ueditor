<?php
/**
 * User: qingfeng.lian
 */

namespace backend\controllers;


class UeditorController extends Controller
{
    use \qingfeng\ueditor\controllers\UeditorController;

    /**
     * ueditor 获取初始化配置信息 action = config
     * ueditor 上传图片 action = uploadimage
     * ueditor 获取某个目录下的图片列表  action = listimage
     * @return string
     */
    public function actionIndex()
    {
        $act = $this->get('action', '');

        //获取配置信息
        $config = $this->getConfig();
        //可以在此次更改配置信息
        $this->ueditorConfig['imageManagerListPath'] = "/../../static/upload/article/image";
        $this->ueditorConfig['imagePathFormat'] = $this->ueditorConfig['imageManagerListPath'] . "/{yyyy}{mm}{dd}/{time}{rand:6}";

        switch ($act) {
            case 'config': //加载配置文件
                return json_encode($config);
                break;
            case 'uploadimage': //上传图片
                $uploadInfo = $this->uploadImage();
                /**
                 * 如果需要把图片传到backend/web之外，需要处理一下返回的路径，
                 * 本列子中 是和backend同级下有一个 static 文件夹
                 * 并且 image.wangphp.cn 指向的是 static文件夹
                 * 这里根据自己的规则去组装返回的图片地址
                 *
                 * 如果在backend/web文件夹内 即 网站跟目录 则直接 return $uploadInfo 即可
                 */
                // return $uploadInfo;
                $explodeStr = '/upload/article/image';
                $uploadInfoArr = json_decode($uploadInfo,true);
                $lastImageInfo = explode($explodeStr,$uploadInfoArr['url']);
                $lastImageInfoStr = array_pop($lastImageInfo);
                // TODO http://image.wanphp.cn 可以换成常量
                $uploadInfoArr['url'] = 'http://image.wanphp.cn'.$explodeStr.$lastImageInfoStr;
                return json_encode($uploadInfoArr);
                break;
            case 'listimage': //图片管理列表
                $imageList =  $this->listImage();
                /**
                 * 同上传图片一样
                 * 如果需要把图片传到backend/web之外，需要处理一下返回的路径
                 * 如果在backend/web文件夹内 即 网站跟目录 则直接 return $imageList 即可
                 */
                // return $imageList;
                $explodeStr = '/upload/article/image';
                $imageListArr = json_decode($imageList,true);
                foreach ($imageListArr['list'] as &$item) {
                    $lastImageInfo = explode($explodeStr,$item['url']);
                    $lastImageInfoStr = array_pop($lastImageInfo);
                    // TODO http://image.wanphp.cn 可以换成常量
                    $item['url'] = 'http://image.wanphp.cn'.$explodeStr.$lastImageInfoStr;
                }
                unset($item);
                return json_encode($imageListArr);
                break;
            default :
                break;
        }
    }
}