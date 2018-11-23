vaeThink 1.0
===============

<!-- [![Total Downloads](https://poser.pugx.org/topthink/think/downloads)](https://packagist.org/packages/topthink/think)
[![Latest Stable Version](https://poser.pugx.org/topthink/think/v/stable)](https://packagist.org/packages/topthink/think)
[![Latest Unstable Version](https://poser.pugx.org/topthink/think/v/unstable)](https://packagist.org/packages/topthink/think)
[![License](https://poser.pugx.org/topthink/think/license)](https://packagist.org/packages/topthink/think) -->

vaeThink基于ThinkPHP5和Layui开发，在保持快速开发和大道至简的核心理念不变的同时，对一般项目所必需的功能进行了基础开发和封装，帮助用户在开始一个新的PHP项目时能够快速完成基础功能的搭建，少一些前戏，多一些高潮。vaeThink保留了ThinkPHP和Layui的所有特征，对于熟悉TP5和Layui的开发者尤为方便，即使没使用过TP5和Layui在开发文档的帮助下也能快速使用vaeThink!

![Image text](https://www.vaethink.com/res/static/images/vaethink.jpg)

> vaeThink的运行环境要求PHP5.4(>5.4)以上。

详细开发文档参考 [vaeThink完全开发手册](http://www.vaethink.com/doc)

## 安装方法

1.将下载好的vaeThink源码放入你的localhost环境中；

2.分配一个域名指向vaeThink下的public目录（这很重要）；

3.直接访问你分配的域名，根据安装引导完成安装。

## 常见问题

1.如果安装过程中出现“创建管理员信息失败”的系统提示，请按照这里的方案解决[解决方案](https://think.vaethink.com/info/5.html)

2.官方交流群：[221470096](https://jq.qq.com/?_wv=1027&k=5YclBbe)

## 目录结构

安装完成的目录结构应当如下：

~~~
www  WEB部署目录（或者子目录）
├─app                   应用目录
│  ├─common             公共模块目录
│  │  ├─model           公共模型目录
│  ├─admin              后台模块目录
│  │  ├─controller      模块控制器目录
│  │  ├─model           模块模型目录
│  │  ├─validate        模块验证器目录
│  ├─port               API接口模块目录
│  │  ├─controller      模块控制器目录
│  │  ├─model           模块模型目录
│  │  ├─validate        模块验证器目录
│  ├─common.php         公共函数文件
│
├─data                  数据目录
│  ├─conf               配置目录
│  │  ├─module_name     模块配置目录
│  │  ├─extra           额外配置目录
│  │  ├─command.php        命令行工具配置文件
│  │  ├─config.php         公共配置文件
│  │  ├─route.php          路由配置文件
│  │  ├─tags.php           应用行为扩展定义文件
│  │  └─database.php       数据库配置文件
│  ├─runtime            应用的运行时目录
│  └─install.lock       用于系统鉴定是否完成安装
│ 
├─public                WEB目录（对外访问目录）
│  ├─plugin          	插件目录
│  ├─themes          	模板文件目录
│  └─admin_themes       admin模块模板文件目录
│  ├─index.php          入口文件
│  ├─router.php         快速测试文件
│  └─.htaccess          用于apache的重写
│
├─listenrain            系统核心引擎目录
│  ├─thinkphp           ThinkPHP5框架文件目录
│  ├─vae                vaeThink框架核心类库目录
│
├─extend                扩展类库目录
├─vendor                第三方类库目录（Composer依赖库）
├─build.php             自动生成定义文件（参考）
├─composer.json         composer 定义文件
├─LICENSE.txt           授权说明文件
├─README.md             README 文件
├─think                 命令行入口文件
~~~

## 命名规范

`vaeThink`遵循PSR-2命名规范和PSR-4自动加载规范，并且注意如下规范：

### 目录和文件

*   目录不强制规范，驼峰和小写+下划线模式均支持；
*   类库、函数文件统一以`.php`为后缀；
*   类的文件名均以命名空间定义，并且命名空间的路径和类库文件所在路径一致；
*   类名和类文件名保持一致，统一采用驼峰法命名（首字母大写）；

### 函数和类、属性命名

*   类的命名采用驼峰法，并且首字母大写，例如 `User`、`UserType`，控制器默认需要添加后缀，例如`User`控制器应该直接命名为`UserController`；
*   函数的命名使用小写字母和下划线（小写字母开头）的方式，例如 `get_client_ip`；
*   方法的命名使用驼峰法，并且首字母小写，例如 `getUserName`；
*   属性的命名使用驼峰法，并且首字母小写，例如 `tableName`、`instance`；
*   以双下划线“__”打头的函数或方法作为魔法方法，例如 `__call` 和 `__autoload`；

### 常量和配置

*   常量以大写字母和下划线命名，例如 `APP_PATH`和 `THINK_PATH`；
*   配置参数以小写字母和下划线命名，例如 `url_route_on` 和`url_convert`；

### 数据表和字段

*   数据表和字段采用小写加下划线方式命名，并注意字段名不要以下划线开头，例如 `think_user` 表和 `user_name`字段，不建议使用驼峰和中文作为数据表字段命名。


## 版权信息

vaeThink遵循Apache2开源协议发布，并提供免费使用。

本项目包含的第三方源码和二进制文件之版权信息另行标注。

版权所有Copyright © 2018 by vaeThink (http://vaethink.com)

All rights reserved。

官方网站：vaeThink (http://vaethink.com)
