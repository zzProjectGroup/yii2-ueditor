<?php
namespace yii\ueditor\controllers;

use yii\ueditor\library\Uploader;

/**
 * Created by PhpStorm.
 * User: lianqingfeng
 */
trait UeditorController
{
    public $ueditorConfig=[];


    public function init()
    {
        $this->getConfig();
    }

    public function getConfig(){
        if($this->ueditorConfig){
           return $this->ueditorConfig;
        }
        $this->ueditorConfig = require (dirname(__FILE__).'/../config/config.php');
        return $this->ueditorConfig;
    }

    /**
     * 遍历获取目录下的指定类型的文件
     * @param $path
     * @param array $files
     * @return array
     */
    public function getFiles($path, $allowFiles, &$files = array())
    {
        if (!is_dir($path)) return null;
        if(substr($path, strlen($path) - 1) != '/') $path .= '/';
        $handle = opendir($path);
        while (false !== ($file = readdir($handle))) {
            if ($file != '.' && $file != '..') {
                $path2 = $path . $file;
                if (is_dir($path2)) {
                    $this->getFiles($path2, $allowFiles, $files);
                } else {
                    if (preg_match("/\.(".$allowFiles.")$/i", $file)) {
                        $files[] = array(
                            'url'=> substr($path2, strlen($_SERVER['DOCUMENT_ROOT'])),
                            'mtime'=> filemtime($path2)
                        );
                    }
                }
            }
        }
        return $files;
    }

    /**
     * 上传图片
     * @return string
     */
    public function uploadImage(){
        $config = array(
            "pathFormat" => $this->ueditorConfig['imagePathFormat'],
            "maxSize" => $this->ueditorConfig['imageMaxSize'],
            "allowFiles" => $this->ueditorConfig['imageAllowFiles']
        );
        $fieldName = $this->ueditorConfig['imageFieldName'];
        /* 生成上传实例对象并完成上传 */
        $up = new Uploader($fieldName, $config, 'upload');

        /**
         * 得到上传文件所对应的各个参数,数组结构
         * array(
         *     "state" => "",          //上传状态，上传成功时必须返回"SUCCESS"
         *     "url" => "",            //返回的地址
         *     "title" => "",          //新文件名
         *     "original" => "",       //原始文件名
         *     "type" => ""            //文件类型
         *     "size" => "",           //文件大小
         * )
         */

        /* 返回数据 */
        return json_encode($up->getFileInfo());
    }

    /**
     * 上传视频
     * @return string
     */
    public function uploadVideo(){
        $config = array(
            "pathFormat" => $this->ueditorConfig['videoPathFormat'],
            "maxSize" => $this->ueditorConfig['videoMaxSize'],
            "allowFiles" => $this->ueditorConfig['videoAllowFiles']
        );
        $fieldName = $this->ueditorConfig['videoFieldName'];

        /* 生成上传实例对象并完成上传 */
        $up = new Uploader($fieldName, $config, 'upload');

        /**
         * 得到上传文件所对应的各个参数,数组结构
         * array(
         *     "state" => "",          //上传状态，上传成功时必须返回"SUCCESS"
         *     "url" => "",            //返回的地址
         *     "title" => "",          //新文件名
         *     "original" => "",       //原始文件名
         *     "type" => ""            //文件类型
         *     "size" => "",           //文件大小
         * )
         */

        /* 返回数据 */
        return json_encode($up->getFileInfo());
    }

    /**
     * 上传文件
     */
    public function uploadFile(){
        $config = array(
            "pathFormat" => $this->ueditorConfig['filePathFormat'],
            "maxSize" => $this->ueditorConfig['fileMaxSize'],
            "allowFiles" => $this->ueditorConfig['fileAllowFiles']
        );
        $fieldName = $this->ueditorConfig['fileFieldName'];

        /* 生成上传实例对象并完成上传 */
        $up = new Uploader($fieldName, $config, 'upload');

        /**
         * 得到上传文件所对应的各个参数,数组结构
         * array(
         *     "state" => "",          //上传状态，上传成功时必须返回"SUCCESS"
         *     "url" => "",            //返回的地址
         *     "title" => "",          //新文件名
         *     "original" => "",       //原始文件名
         *     "type" => ""            //文件类型
         *     "size" => "",           //文件大小
         * )
         */

        /* 返回数据 */
        return json_encode($up->getFileInfo());
    }



    public function listImage(){
        $allowFiles = $this->ueditorConfig['imageManagerAllowFiles'];
        $listSize = $this->ueditorConfig['imageManagerListSize'];
        $path = $this->ueditorConfig['imageManagerListPath'];
        $allowFiles = substr(str_replace(".", "|", join("", $allowFiles)), 1);

        /* 获取参数 */
        $size = isset($_GET['size']) ? htmlspecialchars($_GET['size']) : $listSize;
        $start = isset($_GET['start']) ? htmlspecialchars($_GET['start']) : 0;
        $end = $start + $size;

        /* 获取文件列表 */
        $path = $_SERVER['DOCUMENT_ROOT'] . (substr($path, 0, 1) == "/" ? "":"/") . $path;
        $files = $this->getFiles($path, $allowFiles);
        if (!count($files)) {
            return json_encode(array(
                "state" => "no match file",
                "list" => array(),
                "start" => $start,
                "total" => count($files)
            ));
        }

        /* 获取指定范围的列表 */
        $len = count($files);
        for ($i = min($end, $len) - 1, $list = array(); $i < $len && $i >= 0 && $i >= $start; $i--){
            $list[] = $files[$i];
        }
//倒序
//for ($i = $end, $list = array(); $i < $len && $i < $end; $i++){
//    $list[] = $files[$i];
//}

        /* 返回数据 */
        $result = json_encode(array(
            "state" => "SUCCESS",
            "list" => $list,
            "start" => $start,
            "total" => count($files)
        ));

        return $result;
    }

    public function listFile(){
        $allowFiles = $this->ueditorConfig['fileManagerAllowFiles'];
        $listSize = $this->ueditorConfig['fileManagerListSize'];
        $path = $this->ueditorConfig['fileManagerListPath'];
        $allowFiles = substr(str_replace(".", "|", join("", $allowFiles)), 1);

        /* 获取参数 */
        $size = isset($_GET['size']) ? htmlspecialchars($_GET['size']) : $listSize;
        $start = isset($_GET['start']) ? htmlspecialchars($_GET['start']) : 0;
        $end = $start + $size;

        /* 获取文件列表 */
        $path = $_SERVER['DOCUMENT_ROOT'] . (substr($path, 0, 1) == "/" ? "":"/") . $path;
        $files = $this->getFiles($path, $allowFiles);
        if (!count($files)) {
            return json_encode(array(
                "state" => "no match file",
                "list" => array(),
                "start" => $start,
                "total" => count($files)
            ));
        }

        /* 获取指定范围的列表 */
        $len = count($files);
        for ($i = min($end, $len) - 1, $list = array(); $i < $len && $i >= 0 && $i >= $start; $i--){
            $list[] = $files[$i];
        }
//倒序
//for ($i = $end, $list = array(); $i < $len && $i < $end; $i++){
//    $list[] = $files[$i];
//}

        /* 返回数据 */
        $result = json_encode(array(
            "state" => "SUCCESS",
            "list" => $list,
            "start" => $start,
            "total" => count($files)
        ));

        return $result;
    }

    /**
     * 抓取远程文件
     */
    public function catchImage(){
        set_time_limit(120);
        /* 上传配置 */
        $config = array(
            "pathFormat" => $this->ueditorConfig['catcherPathFormat'],
            "maxSize" => $this->ueditorConfig['catcherMaxSize'],
            "allowFiles" => $this->ueditorConfig['catcherAllowFiles'],
            "oriName" => "remote.png"
        );
        $fieldName = $this->ueditorConfig['catcherFieldName'];

        /* 抓取远程图片 */
        $list = array();
        if (isset($_POST[$fieldName])) {
            $source = $_POST[$fieldName];
        } else {
            $source = $_GET[$fieldName];
        }
        foreach ($source as $imgUrl) {
            $item = new Uploader($imgUrl, $config, "remote");
            $info = $item->getFileInfo();
            array_push($list, array(
                "state" => $info["state"],
                "url" => $info["url"],
                "size" => $info["size"],
                "title" => htmlspecialchars($info["title"]),
                "original" => htmlspecialchars($info["original"]),
                "source" => htmlspecialchars($imgUrl)
            ));
        }

        /* 返回抓取数据 */
        return json_encode(array(
            'state'=> count($list) ? 'SUCCESS':'ERROR',
            'list'=> $list
        ));
    }

}
