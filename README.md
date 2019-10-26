# spladmin基于thinkphp5.1+adminLTE框架开发 # 一键生成CURD 集成 权限管理 菜单管理 全局设置  
  
## DEMO  
[在线演示](http://spladmin.o8o8o8.com/admin)<br>
账号test 密码111111<br>
(演示账号只有查看的权限哦)   
  
## 演示视频  
[点我观看神奇视频](http://spladmin.o8o8o8.com/demo.html)  
  
## 教程  
### 一.环境  
 - php  v5.6+
 - mysql v5.5+
 - thinkphp v5.1
  
### 二.curd快速生成命令(仿的fastadmin，控件都是自己写的)  
 - 生成单表curd
> 打开cmd使用php命令 		php think curd -t spl_XXX (-t 表示表名 spl_ 是我的表前缀)
 - 生成关联表curd
> 		php think curd -t spl_XXX -j spl_relation_table_name -k foreign_key (-j表示关联的表 -k表示外键)
**注：表名必须完整**  
  
### 三.控件类型之数据库字段设计  
|控件|后缀|类型|  
|---|---|---|  
|普通文本|/|varchar|  
|开关|_status|tinyint(1)|  
|图片|_image|varchar(255)|
|文本域|_content|text|
|ueditor编辑器|_editor|text  |
|日期时间|_time|int(11)|
|文件上传|_file|varchar(255)|

目前只支持以上控件  

### 四.开发教程（未完待续）  