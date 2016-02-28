# TeoPHP
简单的php框架

##需求

####软件

* PHP-5.4+

####composer

* "voku/anti-xss": "^1.2"
* "monolog/monolog": "^1.17",
* "php-curl-class/php-curl-class": "^4.10"

####PHP扩展

* 常用扩展

####安装

composer install

###目录结构
<pre>

+ configs
  |- resource.php             //配置文件
  |- route_api.php            //对内api的路由文件
  |- route_app.php            //app的路由文件
+ controllers
  |+ app
     |+ index  
        |- Index.php          //默认控制器
        .......
  |+ api
+ views    
     |+ css
     |+ images      
     |+ js
     |+ views   
+ models    
     .......
     |- Search.php          //搜索引擎类(一个表一个model)   
+ TeoPHP
     |+ lib
        |- Config.php       //config类
        |- MySQL.php        //mysql类(pdo)
        |- Security.php     //参数验证类
        .......
     |- Application.php     //应用入口*
     |- Controller.php      //controller父类
     |- Loader.php          //自动加载类
+ log                       //日志目录
+ interface                 //对外接口目录
+ script                    //脚本目录
+ tools                     //工具目录       
+ vendor                    //composer目录
- csft.conf                 //Sphinx-coreseek配置文件
- vhost.conf                //nginx虚拟主机配置文件
- index.php                 //入口文件 定义常量BASE_URL
- interface.php             //对外接口入口文件
- composer.json
- composer.lock
- favicon.ico

</pre>

### xss过滤 voku/anti-xss
```php
$harm_string = "Hello, i try to <script>alert('Hack');</script> your site";
$harmless_string = \TeoPHP\Application::xss_clean($harm_string);
var_dump($harmless_string);exit;
```

### 记录日志例子 monolog/monolog
```php
// add records to the log
\TeoPHP\Application::getLogger(__CLASS__)->addWarning('test' , array('1' => 'meiyou','2'));exit;
```

### curl例子 php-curl-class/php-curl-class
```php
\TeoPHP\Application::curl()->get('http://www.baidu.com/', array());
if (\TeoPHP\Application::curl()->error) {
    echo 'Error: ' . \TeoPHP\Application::curl()->errorCode . ': ' . \TeoPHP\Application::curl()->errorMessage;
    die();
}
echo \TeoPHP\Application::curl()->response;exit;
```

对内api接口
访问例如：http://framework.mytest.com/add_folder?a=bb

web应用程序
访问例如：http://framework.mytest.com/index/index?a=bb
