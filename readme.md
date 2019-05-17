
### 开发前工作

```
# 复制配置文件
cp .env.example .env

# 生成key
php artisan key:generate

# 生成数据库表
php artisan migrate

# 填充数据
php artisan db:seed

# 清空数据库重新生成表
php artisan migrate:refresh

# 清空数据库重新生成表并生成数据
php artisan migrate:refresh --seed
```

### 安装jwt-auth
```
composer require tymon/jwt-auth

# 修改 config/app.php
'providers' => [
    ...
    Tymon\JWTAuth\Providers\LaravelServiceProvider::class,
]

# 发布配置文件
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"

# 生成key
php artisan jwt:secret
```


### 安装 telescope
```
composer require laravel/telescope
php artisan telescope:install
php artisan migrate

# 访问地址
http://localhost:8080/telescope
```

### 安装Laravel Horizon
```
composer require laravel/horizon

# 发布配置文件
php artisan vendor:publish --provider="Laravel\Horizon\HorizonServiceProvider"

php artisan horizon 即可启动所有的队列
```

### 安装邮件模版
```
composer require qoraiche/laravel-mail-editor

# 发布配置文件
php artisan vendor:publish --provider="qoraiche\mailEclipse\mailEclipseServiceProvider"

php artisan migrate

# 访问地址
http://localhost:8080/maileclipse
```

### 图片上传又拍云
```
composer require "jellybool/flysystem-upyun"

# config/app.php 添加
'providers' => [
    // Other service providers...
    JellyBool\Flysystem\Upyun\UpyunServiceProvider::class,
],

# config/filesystems.php 的 disks 中添加下面的配置：
return [
    //...
      'upyun' => [
            'driver'        => 'upyun', 
            'bucket'        => 'your-bucket-name',// 服务名字
            'operator'      => 'oparator-name', // 操作员的名字
            'password'      => 'operator-password', // 操作员的密码
            'domain'        => 'xxxxx.b0.upaiyun.com', // 服务分配的域名
            'protocol'     => 'https', // 服务使用的协议，如需使用 http，在此配置 http
        ],
    //...
];
```


```
# 添加控制器
php artisan make:controller Api/CommonController

# 添加request
php artisan make:request imageRequest

# 添加model
php artisan make:model article

```