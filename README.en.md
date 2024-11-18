# webman
High performance HTTP Service Framework for PHP based on [Workerman](https://github.com/walkor/workerman).

# Description
### This version comes with a code generator. Check disabled functions
    php webman fix-disable-functions
# Installation Script
    For Windows environment:
        ./windows.bat
        This script will check if the necessary dependencies are installed; if not, it will run the installation script.
    For Linux environment:
        php install.php
        This command will proceed with the installation.

# References
like: https://gitee.com/likeadmin/likeadmin_php.git

like: https://www.workerman.net/doc/webman/

like: https://gitee.com/MuZJun/gather-admin.git

# Running Commands
    For Windows environment:
        ./window.bat

    For Linux environment:
        php start.php start

    Production:
        php start.php start -d

## Docker Deployment


### Prerequisites

- Docker
- Docker Compose

### Deployment Steps

1. Ensure that you have configured the server/.env file.

2. Run the following commands in the project root directory:
```bash
# Build and start the services  
docker-compose up -d

# Check the status of the services  
docker-compose ps

# View the service logs  
docker-compose logs -f server

# Stop the services 
docker-compose down

# Restart the services  
docker-compose restart

# Rebuild and start the services  
docker-compose up -d --build
```

# Production: Deploying Nginx Configuration
### Single-domain deployment for frontend and backend
Directory structure reference:

    /server - Backend API
    /admin - Directory for backend packaged files
    /pc - Directory for PC version packaged files

# nginx config
Backend API proxy
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
pc/uniapp api proxy
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
Static resource proxy
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
admin
```
    location /admin {
        alias /www/wwwroot/xxxx.com/admin;
        index index.html;
        try_files $uri $uri/ /admin/index.html;
    }
```
pc
```
    location /pc {
        alias /www/wwwroot/xxxx.com/pc;
        index index.html;
        try_files $uri $uri/ /pc/index.html;
    }
```
# link
[![歪比巴卜/likeadmin-webman（PHP版）](https://gitee.com/suyibk/workman-likeadmin-all/widgets/widget_card.svg?colors=ffffff,1e252b,323d47,455059,d7deea,99a0ae)](https://gitee.com/suyibk/workman-likeadmin-all)

# Manual (文档)

https://www.workerman.net/doc/webman

# Home page (主页)
https://www.workerman.net/webman

# Benchmarks （压测）

https://www.techempower.com/benchmarks/#section=test&runid=9716e3cd-9e53-433c-b6c5-d2c48c9593c1&hw=ph&test=db&l=zg24n3-1r&a=2
![image](https://user-images.githubusercontent.com/6073368/96447814-120fc980-1245-11eb-938d-6ea408716c72.png)

## LICENSE

MIT