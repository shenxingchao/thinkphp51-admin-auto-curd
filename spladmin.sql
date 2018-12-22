/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : spladmin

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-12-22 15:23:01
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for spl_admin_user
-- ----------------------------
DROP TABLE IF EXISTS `spl_admin_user`;
CREATE TABLE `spl_admin_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `username` varchar(30) NOT NULL DEFAULT '' COMMENT '用户名',
  `nickname` varchar(30) NOT NULL DEFAULT '' COMMENT '昵称',
  `password` varchar(32) NOT NULL DEFAULT '' COMMENT '密码',
  `head_image` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `role_ids` varchar(255) NOT NULL DEFAULT '' COMMENT '角色ids',
  `login_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '上次登录时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '启用',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='管理员';

-- ----------------------------
-- Records of spl_admin_user
-- ----------------------------
INSERT INTO `spl_admin_user` VALUES ('3', 'admin', '超级管理员', '96e79218965eb72c92a549dd5a330112', '', '1', '1545461155', '1', '1545400845');
INSERT INTO `spl_admin_user` VALUES ('2', 'test', 'test', '96e79218965eb72c92a549dd5a330112', '', '2', '1545401983', '2', '1545141180');

-- ----------------------------
-- Table structure for spl_privilege_menu
-- ----------------------------
DROP TABLE IF EXISTS `spl_privilege_menu`;
CREATE TABLE `spl_privilege_menu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `title` varchar(30) NOT NULL DEFAULT '' COMMENT '菜单名称',
  `icon` varchar(30) NOT NULL DEFAULT '' COMMENT '图标',
  `href` varchar(255) NOT NULL DEFAULT '' COMMENT '链接',
  `show_status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '显示',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '上级菜单',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='菜单';

-- ----------------------------
-- Records of spl_privilege_menu
-- ----------------------------
INSERT INTO `spl_privilege_menu` VALUES ('1', '控制台', 'fa fa-dashboard', 'Index/dashboard', '1', '0', '0');
INSERT INTO `spl_privilege_menu` VALUES ('2', '权限管理', 'fa fa-wrench', '#', '1', '0', '0');
INSERT INTO `spl_privilege_menu` VALUES ('3', '菜单管理', 'fa fa-windows', 'PrivilegeMenu/index', '1', '0', '2');
INSERT INTO `spl_privilege_menu` VALUES ('4', '权限资源管理', 'fa fa-genderless', 'PrivilegeSrc/index', '1', '0', '2');
INSERT INTO `spl_privilege_menu` VALUES ('5', '角色管理', 'fa fa-users', 'PrivilegeRole/index', '1', '0', '2');
INSERT INTO `spl_privilege_menu` VALUES ('6', '管理员管理', 'fa fa-user', 'AdminUser/index', '1', '0', '2');
INSERT INTO `spl_privilege_menu` VALUES ('7', '系统管理', 'fa fa-gears', '#', '1', '0', '0');
INSERT INTO `spl_privilege_menu` VALUES ('8', '系统设置', 'fa fa-cog', 'SystemSetting/index', '1', '0', '7');

-- ----------------------------
-- Table structure for spl_privilege_role
-- ----------------------------
DROP TABLE IF EXISTS `spl_privilege_role`;
CREATE TABLE `spl_privilege_role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `role_name` varchar(30) NOT NULL DEFAULT '' COMMENT '角色名称',
  `privilege_menu_ids` text NOT NULL COMMENT '菜单ids',
  `half_menu_ids` text NOT NULL COMMENT '半选中菜单ids',
  `privilege_src_ids` text NOT NULL COMMENT '权限ids',
  `half_src_ids` text NOT NULL COMMENT '半选中资源ids',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='角色';

-- ----------------------------
-- Records of spl_privilege_role
-- ----------------------------
INSERT INTO `spl_privilege_role` VALUES ('1', '超级管理员', '1,2,3,4,5,6,7,8', '', '1,3,4,5,7,8,9,11,12,13,15,16,17,2,6,10,14,18,20,19', '');
INSERT INTO `spl_privilege_role` VALUES ('2', '访客', '1,2,3,4,5,6,7,8', '', '', '');

-- ----------------------------
-- Table structure for spl_privilege_src
-- ----------------------------
DROP TABLE IF EXISTS `spl_privilege_src`;
CREATE TABLE `spl_privilege_src` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `title` varchar(30) NOT NULL DEFAULT '' COMMENT '资源名称',
  `code` text NOT NULL COMMENT '权限码',
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '上级资源',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='权限资源';

-- ----------------------------
-- Records of spl_privilege_src
-- ----------------------------
INSERT INTO `spl_privilege_src` VALUES ('1', '权限管理', '', '0');
INSERT INTO `spl_privilege_src` VALUES ('2', '菜单管理', '', '1');
INSERT INTO `spl_privilege_src` VALUES ('3', '添加', 'a:1:{i:0;a:2:{s:14:\"controllerName\";s:13:\"PrivilegeMenu\";s:10:\"actionName\";s:3:\"add\";}}', '2');
INSERT INTO `spl_privilege_src` VALUES ('4', '编辑', 'a:2:{i:0;a:2:{s:14:\"controllerName\";s:13:\"PrivilegeMenu\";s:10:\"actionName\";s:4:\"edit\";}i:1;a:2:{s:14:\"controllerName\";s:13:\"PrivilegeMenu\";s:10:\"actionName\";s:11:\"changeState\";}}', '2');
INSERT INTO `spl_privilege_src` VALUES ('5', '删除', 'a:1:{i:0;a:2:{s:14:\"controllerName\";s:13:\"PrivilegeMenu\";s:10:\"actionName\";s:6:\"delete\";}}', '2');
INSERT INTO `spl_privilege_src` VALUES ('6', '权限资源管理', '', '1');
INSERT INTO `spl_privilege_src` VALUES ('7', '添加', 'a:2:{i:0;a:2:{s:14:\"controllerName\";s:12:\"PrivilegeSrc\";s:10:\"actionName\";s:3:\"add\";}i:1;a:2:{s:14:\"controllerName\";s:12:\"PrivilegeSrc\";s:10:\"actionName\";s:13:\"ajaxGetAction\";}}', '6');
INSERT INTO `spl_privilege_src` VALUES ('8', '编辑', 'a:2:{i:0;a:2:{s:14:\"controllerName\";s:12:\"PrivilegeSrc\";s:10:\"actionName\";s:4:\"edit\";}i:1;a:2:{s:14:\"controllerName\";s:12:\"PrivilegeSrc\";s:10:\"actionName\";s:13:\"ajaxGetAction\";}}', '6');
INSERT INTO `spl_privilege_src` VALUES ('9', '删除', 'a:1:{i:0;a:2:{s:14:\"controllerName\";s:12:\"PrivilegeSrc\";s:10:\"actionName\";s:6:\"delete\";}}', '6');
INSERT INTO `spl_privilege_src` VALUES ('10', '角色管理', '', '1');
INSERT INTO `spl_privilege_src` VALUES ('11', '添加', 'a:3:{i:0;a:2:{s:14:\"controllerName\";s:13:\"PrivilegeRole\";s:10:\"actionName\";s:3:\"add\";}i:1;a:2:{s:14:\"controllerName\";s:13:\"PrivilegeRole\";s:10:\"actionName\";s:18:\"privilegeMenuNodes\";}i:2;a:2:{s:14:\"controllerName\";s:13:\"PrivilegeRole\";s:10:\"actionName\";s:17:\"privilegeSrcNodes\";}}', '10');
INSERT INTO `spl_privilege_src` VALUES ('12', '编辑', 'a:3:{i:0;a:2:{s:14:\"controllerName\";s:13:\"PrivilegeRole\";s:10:\"actionName\";s:4:\"edit\";}i:1;a:2:{s:14:\"controllerName\";s:13:\"PrivilegeRole\";s:10:\"actionName\";s:18:\"privilegeMenuNodes\";}i:2;a:2:{s:14:\"controllerName\";s:13:\"PrivilegeRole\";s:10:\"actionName\";s:17:\"privilegeSrcNodes\";}}', '10');
INSERT INTO `spl_privilege_src` VALUES ('13', '删除', 'a:1:{i:0;a:2:{s:14:\"controllerName\";s:13:\"PrivilegeRole\";s:10:\"actionName\";s:6:\"delete\";}}', '10');
INSERT INTO `spl_privilege_src` VALUES ('14', '管理员管理', '', '1');
INSERT INTO `spl_privilege_src` VALUES ('15', '添加', 'a:3:{i:0;a:2:{s:14:\"controllerName\";s:9:\"AdminUser\";s:10:\"actionName\";s:3:\"add\";}i:1;a:2:{s:14:\"controllerName\";s:9:\"AdminUser\";s:10:\"actionName\";s:10:\"fileUpload\";}i:2;a:2:{s:14:\"controllerName\";s:9:\"AdminUser\";s:10:\"actionName\";s:10:\"fileDelete\";}}', '14');
INSERT INTO `spl_privilege_src` VALUES ('16', '编辑', 'a:4:{i:0;a:2:{s:14:\"controllerName\";s:9:\"AdminUser\";s:10:\"actionName\";s:4:\"edit\";}i:1;a:2:{s:14:\"controllerName\";s:9:\"AdminUser\";s:10:\"actionName\";s:11:\"changeState\";}i:2;a:2:{s:14:\"controllerName\";s:9:\"AdminUser\";s:10:\"actionName\";s:10:\"fileUpload\";}i:3;a:2:{s:14:\"controllerName\";s:9:\"AdminUser\";s:10:\"actionName\";s:10:\"fileDelete\";}}', '14');
INSERT INTO `spl_privilege_src` VALUES ('17', '删除', 'a:1:{i:0;a:2:{s:14:\"controllerName\";s:9:\"AdminUser\";s:10:\"actionName\";s:6:\"delete\";}}', '14');
INSERT INTO `spl_privilege_src` VALUES ('18', '系统管理', '', '0');
INSERT INTO `spl_privilege_src` VALUES ('19', '系统设置', '', '18');
INSERT INTO `spl_privilege_src` VALUES ('20', '编辑', 'a:5:{i:0;a:2:{s:14:\"controllerName\";s:13:\"SystemSetting\";s:10:\"actionName\";s:12:\"groupSetting\";}i:1;a:2:{s:14:\"controllerName\";s:13:\"SystemSetting\";s:10:\"actionName\";s:8:\"addParam\";}i:2;a:2:{s:14:\"controllerName\";s:13:\"SystemSetting\";s:10:\"actionName\";s:10:\"fileUpload\";}i:3;a:2:{s:14:\"controllerName\";s:13:\"SystemSetting\";s:10:\"actionName\";s:10:\"fileDelete\";}i:4;a:2:{s:14:\"controllerName\";s:13:\"SystemSetting\";s:10:\"actionName\";s:9:\"paramSave\";}}', '19');

-- ----------------------------
-- Table structure for spl_system_setting
-- ----------------------------
DROP TABLE IF EXISTS `spl_system_setting`;
CREATE TABLE `spl_system_setting` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '变量名',
  `value` text NOT NULL COMMENT '变量值',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '标题',
  `type` varchar(30) NOT NULL DEFAULT '' COMMENT '变量类型',
  `group` varchar(30) NOT NULL DEFAULT '' COMMENT '分组名称',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of spl_system_setting
-- ----------------------------
INSERT INTO `spl_system_setting` VALUES ('1', 'group_setting', 'a:2:{s:13:\"group_setting\";s:12:\"分组设置\";s:12:\"site_setting\";s:12:\"站点设置\";}', '分组设置', 'array', 'group_setting');
INSERT INTO `spl_system_setting` VALUES ('12', 'site_status', '1', '站点状态', 'switch', 'site_setting');
INSERT INTO `spl_system_setting` VALUES ('8', 'site_title', '标题标题', '网站标题', 'varchar', 'site_setting');
INSERT INTO `spl_system_setting` VALUES ('9', 'site_desc', '网站描述网站描述网站描述网站描述', '网站描述', 'content', 'site_setting');
INSERT INTO `spl_system_setting` VALUES ('10', 'site_logo', '', 'LOGO', 'image', 'site_setting');
INSERT INTO `spl_system_setting` VALUES ('11', 'site_on_time', '2018-12-21 21:51:52', '上线时间', 'time', 'site_setting');
