# webman

High performance HTTP Service Framework for PHP based on [Workerman](https://github.com/walkor/workerman).

# 说明
当前版本是带代码生成器
检查禁用函数
php webman fix-disable-functions
# 安装脚本
    window环境下运行
        ./windows.bat
        会检查是否安装未安装会调用安装脚本安装
    linux环境下运行
        php install.php
        进行安装
# 参考文档
like: https://gitee.com/likeadmin/likeadmin_php.git

like: https://www.workerman.net/doc/webman/

like: https://gitee.com/MuZJun/gather-admin.git
# 运行命令
    开发:
    windows环境
        ./window.bat
    linux环境
        php start.php start
    生产
        php start.php start -d
# 生产：部署nginx配置
### 单域名部署前后台
    目录接口参考
    /server     -后台api
    /admin      -后台打包文件放置目录
    /pc         -pc版打包文件放置目录
后台api
```

    #PROXY-START/adminapi
    
    location /adminapi/
    {
    proxy_pass http://ip:端口/adminapi/;
    proxy_set_header Host $host;
    proxy_set_header Scheme $scheme;
    proxy_set_header X-Real-IP $remote_addr;
    proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
    proxy_set_header REMOTE-HOST $remote_addr;
    proxy_set_header Upgrade $http_upgrade;
    proxy_set_header Connection $connection_upgrade;
    proxy_http_version 1.1;
    # proxy_hide_header Upgrade;
    
        add_header X-Cache $upstream_cache_status;
        #Set Nginx Cache
    
        set $static_filehlp70f2i 0;
        if ( $uri ~* "\.(gif|png|jpg|css|js|woff|woff2)$" )
        {
            set $static_filehlp70f2i 1;
            expires 1m;
        }
        if ( $static_filehlp70f2i = 0 )
        {
            add_header Cache-Control no-cache;
        }
    }
    #PROXY-END/
```
前台api
```

    #PROXY-START/api
    
    location /api/
    {
    proxy_pass http://ip:端口/api/;
    proxy_set_header Host $host;
    proxy_set_header Scheme $scheme;
    proxy_set_header X-Real-IP $remote_addr;
    proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
    proxy_set_header REMOTE-HOST $remote_addr;
    proxy_set_header Upgrade $http_upgrade;
    proxy_set_header Connection $connection_upgrade;
    proxy_http_version 1.1;
    # proxy_hide_header Upgrade;
    
        add_header X-Cache $upstream_cache_status;
        #Set Nginx Cache
    
        set $static_filehlp70f2i 0;
        if ( $uri ~* "\.(gif|png|jpg|css|js|woff|woff2)$" )
        {
            set $static_filehlp70f2i 1;
            expires 1m;
        }
        if ( $static_filehlp70f2i = 0 )
        {
            add_header Cache-Control no-cache;
        }
    }
    #PROXY-END/
```
静态资源代理+缓存
```
    #PROXY-START/resource
    
    location /resource/
    {
        proxy_pass http://ip:端口/resource/;
        proxy_set_header Host $host;
        proxy_set_header Scheme $scheme;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header REMOTE-HOST $remote_addr;
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection $connection_upgrade;
        proxy_http_version 1.1;
        # proxy_hide_header Upgrade;
    
        add_header X-Cache $upstream_cache_status;
            #Set Nginx Cache
    
    
    
    
        if ( $uri ~* "\.(gif|png|jpg|css|js|woff|woff2)$" )
        {
            expires 1m;
        }
        proxy_ignore_headers Set-Cookie Cache-Control expires;
        proxy_cache cache_one;
        proxy_cache_key $host$uri$is_args$args;
        proxy_cache_valid 200 304 301 302 1m;
    }
    
    #PROXY-END/resource
```
后台端页面伪静态
```
    location /admin {
        alias /www/wwwroot/xxxx.com/admin;
        index index.html;
        try_files $uri $uri/ /admin/index.html;
    }
```
pc端页面伪静态
```
    location /pc {
        alias /www/wwwroot/xxxx.com/pc;
        index index.html;
        try_files $uri $uri/ /pc/index.html;
    }
```
v5版本-序列化警告问题 注意：从 PHP 8.1.0 起，实现 Serializable 接口的类如果没有同时实现 __serialize()、__unserialize() 方法，将产生弃用警告。

Opis\\Closure\\SerializableClosure implements the Serializable interface, which is deprecated. Implement __serialize() and __unserialize() instead (or in addition, if support for old PHP versions is necessary)

vendor/opis/closure/src/SerializableClosure.php
```
添加以下代码：
public function __serialize()
{
return $this->serialize();
}
public function __unserialize($data)
{
$this->unserialize($data);
}
```
## Docker 部署 server


### 前置要求

- Docker
- Docker Compose

### 部署步骤

1. 确保你已经配置好 `server/.env` 文件

2. 在项目根目录下运行：
```bash
# 构建并启动服务
docker-compose up -d

# 查看服务状态
docker-compose ps

# 查看服务日志
docker-compose logs -f server

# 停止服务
docker-compose down

# 重启服务
docker-compose restart

# 重新构建并启动服务
docker-compose up -d --build
```
# Manual (文档)

https://www.workerman.net/doc/webman

# Home page (主页)
https://www.workerman.net/webman

# Benchmarks （压测）

https://www.techempower.com/benchmarks/#section=test&runid=9716e3cd-9e53-433c-b6c5-d2c48c9593c1&hw=ph&test=db&l=zg24n3-1r&a=2
![image](https://user-images.githubusercontent.com/6073368/96447814-120fc980-1245-11eb-938d-6ea408716c72.png)

## LICENSE

MIT
