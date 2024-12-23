<?php
$custom_ini = '';
$file_path = config_path().DIRECTORY_SEPARATOR.'php.ini';
if ((bool)getenv('APP_DEBUG', false)){
    $file_path = config_path().DIRECTORY_SEPARATOR.'php-debug.ini';
}
if (file_exists($file_path)) {
    $fp = fopen($file_path, "r");
    $custom_ini = fread($fp, filesize($file_path)); // 读取整个文件内容
    fclose($fp);
}
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
