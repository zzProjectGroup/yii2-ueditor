<?php
namespace qingfeng\ueditor;

use yii\web\AssetBundle;

/**
 * Created by PhpStorm.
 * User: lianqingfeng
 */
class UeditorAsset extends AssetBundle
{
    public $js = [
        'ueditor.config.js',
        'ueditor.all.js',
        'lang/zh-cn/zh-cn.js',
        'third-party/zeroclipboard/ZeroClipboard.js',
        'third-party/codemirror/codemirror.js',
    ];
    public $css = [
        'themes/default/css/ueditor.min.css',
        'themes/iframe.css',
        'third-party/codemirror/codemirror.css'
    ];
    public function init()
    {
        $this->sourcePath = \Yii::getAlias('@vendor').'/qingfeng/yii2-ueditor/ueditorAssets'; //设置资源所处的目录
    }
}
