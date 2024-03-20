YuHa--thinkphp6+vue管理后台
注意依赖扩展
fileinfo   ---excel文件生成
redis       ---redis缓存使用
mysqli      ---mysql数据库


1.部署

1.1 nginx伪静态

location /api {
   if (!-f $request_filename) {
   		rewrite  ^(.*)$  /index.php?s=/$1  last;
    }
}
location /admin {
   if (!-f $request_filename) {
   		rewrite  ^(.*)$  /index.php?s=/$1  last;
    }
}
location /vue {
   if (!-f $request_filename) {
   		rewrite  ^(.*)$  /vueAdmin/index.html?s=/$1  last;
    }
}
location /apidoc {
   if (!-f $request_filename) {
   		rewrite  ^(.*)$  /apidoc/index.html?s=/$1  last;
    }
}

1.2执行数据库迁移
php think migrate:run

2.接口文档地址
apidoc地址
【你的url】/apidoc
后台管理页面
【你的url】/vue 

