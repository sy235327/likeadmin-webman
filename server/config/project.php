<?php
return [
    // 系统版本号
    'version' => '1.9.4',

    // 官网
    'website' => [
        'name' => getenv('project.web_name')?:'server_admin', // 网站名称
        'url' => getenv('project.web_url')?:'gitee.com/suyibk/workman-likeadmin-all.git', // 网站地址
        'login_image' => 'resource/image/admin/login_image.png',
        'web_logo' => 'resource/image/admin/web_logo.jpg', // 网站logo
        'web_favicon' => 'resource/image/admin/web_favicon.ico', // 网站图标
        'shop_name' => 'server_admin', // 商城名称
        'shop_logo' => 'resource/image/admin/shop_logo.png', // 商城图标
        'pc_logo' => 'resource/image/admin/pc_logo.png', // pc_logo
        'pc_ico' => 'resource/image/admin/web_favicon.ico', // pc_ico
        'pc_title' => 'server_admin', // PC网站标题
    ],

    // 后台登录
    'admin_login' => [
        // 管理后台登录限制 0-不限制 1-需要限制
        'login_restrictions' => 1,
        // 限制密码错误次数
        'password_error_times' => 5,
        // 限制禁止多少分钟不能登录
        'limit_login_time' => 30,
    ],

    // 唯一标识，密码盐、路径加密等
    'unique_identification' => getenv('UNIQUE_IDENTIFICATION', 'server_admin'),

    // 后台管理员token（登录令牌）配置
    'admin_token' => [
        'expire_duration' => 3600 * 8,//管理后台token过期时长(单位秒）
        'be_expire_duration' => 3600,//管理后台token临时过期前时长，自动续期
    ],

    // 商城用户token（登录令牌）配置
    'user_token' => [
        'expire_duration' => 3600 * 8,//用户token过期时长(单位秒）
        'be_expire_duration' => 3600,//用户token临时过期前时长，自动续期
    ],

    // 列表页
    'lists' => [
        'page_size_max' => 25000,//列表页查询数量限制（列表页每页数量、导出每页数量）
        'page_size' => 25, //默认每页数量
    ],

    // 各种默认图片
    'default_image' => [
        'admin_avatar' => 'resource/image/admin/avatar.png',
        'user_avatar' => 'resource/image/admin/default_avatar.png',
        'qq_group' => 'resource/image/adminapi/default/qq_group.png', // qq群
        'git_png' => 'resource/image/admin/gitee.png', // 仓库地址
        'customer_service' => 'resource/image/admin/customer_service.png', // 客服
        'menu_admin' => 'resource/image/admin/menu_admin.png',// 首页快捷菜单-管理员
        'menu_role' => 'resource/image/admin/menu_role.png', // 首页快捷菜单-角色
        'menu_dept' => 'resource/image/admin/menu_dept.png',// 首页快捷菜单-部门
        'menu_dict' => 'resource/image/admin/menu_dict.png',// 首页快捷菜单-字典
        'menu_generator' => 'resource/image/admin/menu_generator.png',// 首页快捷菜单-代码生成器
        'menu_auth' => 'resource/image/admin/menu_auth.png',// 首页快捷菜单-菜单权限
        'menu_web' => 'resource/image/admin/menu_web.png',// 首页快捷菜单-网站信息
        'menu_file' => 'resource/image/admin/menu_file.png',// 首页快捷菜单-素材中心
    ],

    // 文件上传限制 (图片)
    'file_image' => [
        'jpg', 'png', 'gif', 'jpeg', 'webp'
    ],

    // 文件上传限制 (视频)
    'file_video' => [
        'wmv', 'avi', 'mpg', 'mpeg', '3gp', 'mov', 'mp4', 'flv', 'f4v', 'rmvb', 'mkv'
    ],

    // 其他上传限制 (other)
    'file_other' => [
        'pdf', 'doc', 'docx', 'xls', 'xlsx'
    ],

    //上传文件的格式 (文件)
    'file_file' => [
        'zip','rar','txt','pdf','doc','docx','xls','xlsx','ppt','pptx','csv','txt','ftr','7z','gz'
    ],

    // 登录设置
    'login' => [
        // 登录方式：1-账号密码登录；2-手机短信验证码登录
        'login_way' => ['1', '2'],
        // 注册强制绑定手机 0-关闭 1-开启
        'coerce_mobile' => 1,
        // 第三方授权登录 0-关闭 1-开启
        'third_auth' => 1,
        // 微信授权登录 0-关闭 1-开启
        'wechat_auth' => 1,
        // qq授权登录 0-关闭 1-开启
        'qq_auth' => 0,
        // 登录政策协议 0-关闭 1-开启
        'login_agreement' => 1,
    ],

    // 后台装修
    'decorate' => [
        // 底部导航栏样式设置
        'tabbar_style' => ['default_color' => '#999999', 'selected_color' => '#c455ff'],
    ]

];
