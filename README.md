# spladmin基于thinkphp5.1+adminLTE框架开发 
# 一键生成CURD 集成 权限管理 菜单管理 全局设置

## DEMO
[在线演示](http://spladmin.o8o8o8.com/admin)<br><br>
账号test 密码111111<br><br>
(演示账号只有查看的权限哦) 

## 演示视频
[点我观看神奇视频](http://spladmin.o8o8o8.com/demo.html)

## 教程
#### 1.环境
php  v5.6+<br>
mysql v5.5+<br>
thinkphp v5.1

#### 2.curd快速生成命令(仿的fastadmin，控件都是自己写的)
##### 2.1生成单表curd
打开cmd使用php命令<br>
php think curd -t spl_XXX (-t 表示表名 spl_ 是我的表前缀)
##### 2.2生成关联表curd
php think curd -t spl_XXX -j spl_relation_table_name -k foreign_key (-j表示关联的表 -k表示外键)<br>
注：表名必须完整

#### 3.控件类型数据库之字段设计
##### 3.1普通文本控件
无任何后缀 类型 varchar 

##### 3.2开关类型控件
字段以_status结尾 类型tinyint(1)

##### 3.3图片类型控件
字段以_image结尾 类型varchar

##### 3.4文本域控件
字段以_content结尾 类型text

##### 3.5ueditor编辑器控件
字段以_editor结尾 类型text

##### 3.6日期选择控件
字段以_time结尾 类型int(11)

##### 3.7文件上传控件
字段以_file结尾 类型varchar

目前只支持以上控件

#### 4.开发教程（未完待续）
