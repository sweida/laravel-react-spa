
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