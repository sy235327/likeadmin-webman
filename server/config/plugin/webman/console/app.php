<?php
//$php_ini = config_path().DIRECTORY_SEPARATOR.'php.ini';
//if ((bool)getenv('APP_DEBUG', false)){
//    $php_ini = config_path().DIRECTORY_SEPARATOR.'php-debug.ini';
//}
//$file = fopen($php_ini, "r");
$custom_ini = '
precision = 14
output_buffering = 4096
zlib.output_compression = Off
implicit_flush = Off
unserialize_callback_func =
serialize_precision = -1
disable_functions = passthru,system,chroot,chgrp,chown,popen,ini_alter,ini_restore,dl,openlog,syslog,readlink,symlink,popepassthru,imap_open,apache_setenv
disable_classes =
zend.enable_gc = On
zend.exception_ignore_args = On
zend.exception_string_param_max_len = 0
expose_php = Off
max_execution_time = 300
max_input_time = 60
memory_limit = 2048M
error_reporting = E_ALL & ~E_NOTICE
display_errors = On
display_startup_errors = Off
log_errors = On
ignore_repeated_errors = Off
ignore_repeated_source = Off
report_memleaks = On
variables_order = "GPCS"
request_order = "GP"
register_argc_argv = On
auto_globals_jit = On
post_max_size = 50M
auto_prepend_file =
auto_append_file =
default_mimetype = "text/html"
default_charset = "UTF-8"
doc_root =
user_dir =
enable_dl = Off
cgi.fix_pathinfo=1
file_uploads = On
upload_max_filesize = 50M
max_file_uploads = 20
allow_url_fopen = On
allow_url_include = Off
default_socket_timeout = 60

cli_server.color = On

date.timezone = PRC

pdo_mysql.default_socket=

SMTP = localhost
smtp_port = 25
mail.add_x_header = Off
mail.mixed_lf_and_crlf = Off

odbc.allow_persistent = On
odbc.check_persistent = On
odbc.max_persistent = -1
odbc.max_links = -1
odbc.defaultlrl = 4096
odbc.defaultbinmode = 1

mysqli.max_persistent = -1
mysqli.allow_persistent = On
mysqli.max_links = -1
mysqli.default_port = 3306
mysqli.default_socket =
mysqli.default_host =
mysqli.default_user =
mysqli.default_pw =
mysqli.reconnect = Off

mysqlnd.collect_statistics = On
mysqlnd.collect_memory_statistics = Off

pgsql.allow_persistent = On
pgsql.auto_reset_persistent = Off
pgsql.max_persistent = -1
pgsql.max_links = -1
pgsql.ignore_notice = 0
pgsql.log_notice = 0

bcmath.scale = 0

session.save_handler = files
session.use_strict_mode = 0
session.use_cookies = 1
session.use_only_cookies = 1
session.name = PHPSESSID
session.auto_start = 0
session.cookie_lifetime = 0
session.cookie_path = /
session.cookie_domain =
session.cookie_httponly =
session.cookie_samesite =
session.serialize_handler = php
session.gc_probability = 1
session.gc_divisor = 1000
session.gc_maxlifetime = 1440
session.referer_check =
session.cache_limiter = nocache
session.cache_expire = 180
session.use_trans_sid = 0
session.sid_length = 26
session.trans_sid_tags = "a=href,area=href,frame=src,form="
session.sid_bits_per_character = 5

zend.assertions = -1

tidy.clean_output = Off

soap.wsdl_cache_enabled=1
soap.wsdl_cache_dir="/tmp"
soap.wsdl_cache_ttl=86400
soap.wsdl_cache_limit = 5

ldap.max_links = -1
';
//输出文本中所有的行，直到文件结束为止。
//while (!feof($file)) {
//    $line = trim(fgets($file));
//    if(!$line||str_starts_with($line, ";")||str_starts_with($line, "[")){
//        continue;
//    }
//    $custom_ini .= $line."\r\n";//fgets()函数从文件指针中读取一行
//}
//fclose($file);
//echo $custom_ini
return [
    'enable'            => true,

    'phar_file_output_dir'    => BASE_PATH . DIRECTORY_SEPARATOR . 'build',

    'phar_filename'     => 'webman.phar',

    'signature_algorithm'=> Phar::SHA256, //set the signature algorithm for a phar and apply it. The signature algorithm must be one of Phar::MD5, Phar::SHA1, Phar::SHA256, Phar::SHA512, or Phar::OPENSSL.

    'private_key_file'  => '', // The file path for certificate or OpenSSL private key file.

    'exclude_pattern'   => '#^(?!.*(composer.json|/.github/|/.idea/|/.git/|/.setting/|/runtime/|/vendor-bin/|/build/))(.*)$#',

    'exclude_files'     => [
        '.env', 'LICENSE', 'composer.json', 'composer.lock','start.php'
    ],
    'custom_ini' => $custom_ini,
];
