#!/bin/sh
set -e

# 如果 .env 文件不存在，则从示例文件复制并等待用户确认
if [ ! -f .env ]; then
    echo "Creating .env file from .example.env"
    cp ../.example.env ../.env
    
    while true; do
        read -p "请检查并修改 .env 文件。完成后输入 'Y' 继续: " answer
        if [ "$answer" = "Y" ]; then
            break
        fi
        echo "请继续修改 .env 文件..."
    done
fi

# 启动 Docker Compose 服务
docker-compose up -d