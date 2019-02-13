# 我的家

一个记录家庭成员和家庭关系的网站。

亲戚称呼基于中国南方习俗中的一种。

项目基于 [Yii2](https://www.yiiframework.com/) 框架制作。

## 网站截图

- 网站主页

    ![网站主页](https://raw.githubusercontent.com/AlumiK/project-img-lib/master/my-family-yii2/site_index.png)
    
- 家庭成员模块

    ![家庭成员列表](https://github.com/AlumiK/project-img-lib/raw/master/my-family-yii2/person_index.png)
    ![家庭成员信息](https://github.com/AlumiK/project-img-lib/raw/master/my-family-yii2/person_view.png)
    
- 关系管理模块

    ![新增家庭关系](https://github.com/AlumiK/project-img-lib/raw/master/my-family-yii2/relation_create.png)
    
- 计算模块

    ![关系计算器](https://github.com/AlumiK/project-img-lib/raw/master/my-family-yii2/calc_relation.png)
    ![称呼计算器](https://github.com/AlumiK/project-img-lib/raw/master/my-family-yii2/calc_name.png)

## 部署步骤

1. 下载文件

    使用 `git clone` 将网站文件下载至部署目录。

2. 安装依赖

    在网站根目录执行 `composer install` 安装依赖文件。

3. 初始化项目

    在网站根目录执行 `php init` （Linux）或 `init.bat` （Windows），选择 **Production** 。

4. 配置服务器

    4.1. 将网站根目录设置为 *web* ，入口文件为 *index.php* 。

    4.2a. Apache 配置
    
    - 启用 Apache2 插件。

    ```shell
    a2enmod rewrite
    a2enmod ssl
    service apache2 restart
    ```

    - 配置 URL 转写。

    ```
    RewriteEngine on
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule . index.php
    ```
    
    4.2b. IIS 配置
    
    - 安装 URL Rewrite 2 插件。
    
    - 所需配置文件已写入到 *web/web.config* 中。

5. 配置数据库

    5.1. 数据库中新建一个数据库。

    5.2. 修改 *config/db.php* ，写入数据库配置信息，例如：

    ```php
    <?php

    return [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=localhost;dbname=yii2basic',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',

        // Schema cache options (for production environment)
        //'enableSchemaCache' => true,
        //'schemaCacheDuration' => 60,
        //'schemaCache' => 'cache',
    ];
    ```
    
    5.3. 在网站根目录执行 `php yii migrate` 进行数据库迁移 。
    
