# Nuxt 3 Minimal Starter

Look at the [nuxt 3 documentation](https://v3.nuxtjs.org) to learn more.

## Setup

Make sure to install the dependencies:

```bash
# yarn
yarn install

# npm
npm install

# pnpm
pnpm install --shamefully-hoist
```

## Development Server

Start the development server on http://localhost:3000

```bash
npm run dev
```

## Production

Build the application for production:

```bash
npm run build
```

Locally preview production build:

```bash
npm run preview
```

Checkout the [deployment documentation](https://v3.nuxtjs.org/guide/deploy/presets) for more information.



### Docker 使用说明

构建镜像：
```bash
# 构建指定版本
docker build -t pc-vue:1.0.0 .

# 构建并同时标记为 latest
docker build -t pc-vue:1.0.0 -t pc-vue:latest .

# 仅构建 latest 版本
docker build -t pc-vue:latest .
```

运行容器：
```bash
# 运行指定版本
docker run -d -p 80:8002 pc-vue:1.0.0

# 运行最新版本
docker run -d -p 80:8002 pc-vue:latest
```
