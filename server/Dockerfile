FROM php:8.2-cli-alpine
# 设置环境变量，避免交互式安装提示
ENV DEBIAN_FRONTEND=noninteractive
RUN sed -i "s/dl-cdn.alpinelinux.org/mirrors.aliyun.com/g" /etc/apk/repositories
# 安装系统依赖
RUN apk add --no-cache \
    linux-headers \
    libpng-dev \
    oniguruma-dev \
    libxml2-dev \
    libzip-dev \
    icu-dev \
    libmcrypt-dev \
    bzip2-dev \
    libsodium-dev \
    sqlite-dev \
    autoconf \
    gcc \
    make \
    g++

RUN apk update \
    && apk add \
       curl openssl openssh openntpd \
       ca-certificates libressl-dev \
       libzip-dev zlib-dev libjpeg-turbo-dev libpng-dev libxml2-dev \
       make g++ gcc libc-dev pkgconf file libtool autoconf automake \
       libevent-dev

# 安装 PHP 扩展
RUN docker-php-ext-install \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip \
    intl \
    soap \
    sockets \
    opcache \
    bz2 \
    shmop \
    sysvmsg \
    sysvsem \
    sysvshm \
    fileinfo

# 安装额外的 PECL 扩展
RUN pecl install redis igbinary mcrypt event \
    && docker-php-ext-enable redis igbinary mcrypt event

# 设置指定的 disable_functions
RUN echo "disable_functions = passthru,system,chroot,chgrp,chown,popen,ini_alter,ini_restore,dl,openlog,syslog,readlink,symlink,popepassthru,imap_open,apache_setenv" > /usr/local/etc/php/php.ini

# event需要比sockets后加载 https://www.yangdx.com/2022/08/219.html
RUN mv /usr/local/etc/php/conf.d/docker-php-ext-event.ini /usr/local/etc/php/conf.d/docker-php-ext-z-event.ini
# 安装 Composer
COPY --from=composer:2.5.8 /usr/bin/composer /usr/bin/composer

# 设置工作目录
WORKDIR /app

# 首先复制 composer.json 文件
COPY composer.json composer.lock .
# 然后复制其余项目文件
COPY . .

# 安装项目依赖
RUN COMPOSER_ALLOW_SUPERUSER=1 composer install --no-interaction --optimize-autoloader --ignore-platform-reqs

# 创建安装锁文件
RUN touch config/install.lock

# 暴露端口
EXPOSE 8787

# 启动命令
CMD ["php", "start.php", "start"]