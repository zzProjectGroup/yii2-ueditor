#yii2 集成 百度编辑器 ueditor1.4.3.3  编码：utf8 ,  注:php版本不能低于5.4
**重要说明：发现bug 欢迎指正，我会及时修改，保证其他小伙伴们可以正常使用**
**提交bug 或 留言地址： <a href='http://blog.wanphp.cn/index.php?r=submit-bug/git&gitname=qingfeng__yii2-editor'>我要帮助其他小伙伴, 提交bug</a>**

---

安装方法
```
编辑根目录 composer.json文件 在 require:{} 里面添加 
"qingfeng/yii2-ueditor":"~1.0.6"，保存 
然后执行
composer update

例子
"require": {
        "php": ">=5.4.0",
        "yiisoft/yii2": "~2.0.6",
        "yiisoft/yii2-bootstrap": "~2.0.0",
        "yiisoft/yii2-swiftmailer": "~2.0.0",
	    "qingfeng/yii2-ueditor":"~1.0.6"
    },
```

```
//模板里面使用方法
echo Ueditor::widget([
    'name' => 'content',
    'options' => [
        'id' => 'aaatxtContent',
        'focus' => true,
        // 'toolbars'=> [
        //     ['fullscreen', 'source', 'undo', 'redo', 'bold']
        // ],
    ],
    'attributes' => [
        'style' => 'height:100px'
    ]
]);
```

上传文件等方法使用 ,需要一个controller 里面 use UeditorController,然后直接调用UeditorController里面的方法即可
例子
```
使用的例子 参考 example/ueditorController.php 
直接拿过去用也是可以的
```

免责声明： 使用本扩展出现问题本人概不负责。本扩展用于学习交流之用不保证没有bug和漏洞 使用之前请仔细审查代码。