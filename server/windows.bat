CHCP 65001

@echo off
setlocal

set "FILE_PATH=.\config\install.lock"

if exist "%FILE_PATH%" (
    php windows.php
    pause
) else (
    echo 文件不存在: %FILE_PATH%
    php install.php
    pause
)

endlocal