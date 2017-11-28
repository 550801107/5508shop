/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : itkee_demo

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2017-08-05 10:12:45
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `itkee_admin_user`
-- ----------------------------
DROP TABLE IF EXISTS `itkee_admin_user`;
CREATE TABLE `itkee_admin_user` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL DEFAULT '' COMMENT '管理员用户名',
  `password` varchar(50) NOT NULL DEFAULT '' COMMENT '管理员密码',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态 1 启用 0 禁用',
  `create_time` varchar(50) DEFAULT NULL COMMENT '创建时间',
  `last_login_time` varchar(50) DEFAULT NULL COMMENT '最后登录时间',
  `last_login_ip` varchar(20) DEFAULT NULL COMMENT '最后登录IP',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='管理员表';

-- ----------------------------
-- Records of itkee_admin_user
-- ----------------------------
INSERT INTO `itkee_admin_user` VALUES ('1', 'admin', '8d481b131be8e0e9e1890daf2d29aa3b', '1', '1494317546', '2017-08-05 10:12:26', '127.0.0.1');
INSERT INTO `itkee_admin_user` VALUES ('3', 'demo', 'a24dfc8e919798d7f7b857775175527c', '1', null, '2017-08-02 20:59:42', '183.39.124.87');

-- ----------------------------
-- Table structure for `itkee_article`
-- ----------------------------
DROP TABLE IF EXISTS `itkee_article`;
CREATE TABLE `itkee_article` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '文章ID',
  `keywords` varchar(255) DEFAULT NULL COMMENT '关键字',
  `title` varchar(255) DEFAULT NULL COMMENT '文章标题',
  `introduction` varchar(255) DEFAULT NULL COMMENT '文章简介',
  `cid` int(10) DEFAULT NULL,
  `author` varchar(50) DEFAULT NULL COMMENT '坐着ID',
  `reading` int(10) NOT NULL DEFAULT '0' COMMENT '浏览量',
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `publish_time` varchar(50) DEFAULT NULL,
  `sort` int(5) NOT NULL DEFAULT '255',
  `create_time` varchar(50) DEFAULT NULL,
  `content` longtext COMMENT '文章内容',
  `photo` varchar(255) DEFAULT NULL COMMENT '图集',
  `thumb` varchar(255) DEFAULT NULL COMMENT '文章封面',
  `is_top` int(1) NOT NULL DEFAULT '0' COMMENT '是否置顶',
  `comments` int(10) NOT NULL DEFAULT '0' COMMENT '评论数',
  `is_hot` int(1) NOT NULL DEFAULT '0' COMMENT '是否加精',
  `offer` int(10) unsigned NOT NULL DEFAULT '10' COMMENT '悬赏',
  `author_id` int(10) DEFAULT NULL COMMENT '作者ID',
  `is_end` int(1) NOT NULL DEFAULT '0' COMMENT '是否结贴',
  `attar` varchar(255) DEFAULT NULL COMMENT '附件',
  `baiduapi` int(1) unsigned zerofill NOT NULL DEFAULT '0' COMMENT '是否提交Baidu',
  `identity_id` int(1) NOT NULL DEFAULT '0' COMMENT '阅读角色ID',
  `is_download` int(1) unsigned zerofill DEFAULT '0' COMMENT '是否推荐下载',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of itkee_article
-- ----------------------------
INSERT INTO `itkee_article` VALUES ('1', 'ITKEE社区介绍', 'ITKEE社区介绍', '', '1', 'SuperMan', '0', '1', '2017-07-20 16:02:50', '0', '1500538109', '<p><span style=\"font-size: 16px;\">ITKEE社区功能简介：</span></p><p><span style=\"font-size: 16px;\">采用thinkphp5全新制作</span></p><p><span style=\"font-size: 16px;\">秉承：<span style=\"color: rgb(255, 0, 0); font-size: 16px;\"><strong>极速 清新 精简&nbsp;</strong></span></span></p><p><span style=\"font-size: 16px;\">理念打造</span></p><p><br/></p><p><span style=\"font-size: 16px;\">身处在前端社区的繁荣之下，我们都在有意或无意地追逐,<span style=\"font-family:;\">返璞归真</span></span></p><p><span style=\"font-size: 16px;\"><span style=\"font-family:;\"><br/></span></span></p><p><span style=\"font-size: 16px;\"><span style=\"font-family:;\"><span style=\"font-family:;\">如果您在使用系统的过程中获得了一定的的收益，请不要吝啬您的言语，可以在社区写一篇鼓励我们的话，我们会更努力！ <a href=\"http://www.itkee.cn/\" target=\"_blank\">立即赞扬</a></span></span></span></p><p><br/></p><p style=\"padding: 0px; font-family:; margin-top: 0px; margin-bottom: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);\">[ITKEE社区] PHP/前端/交流，互联网技术交流，资源分享，我们一直在努力，欢迎加入！</p><p style=\"padding: 0px; font-family:; margin-top: 0px; margin-bottom: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);\"><br/></p><p style=\"padding: 0px; font-family:; margin-top: 0px; margin-bottom: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);\">使用过程中如果遇到问题，请在<a href=\"http://www.itkee.cn/topic.html\" target=\"_blank\">社区发布反馈</a></p><p style=\"padding: 0px; font-family:; margin-top: 0px; margin-bottom: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);\"><br/></p><p style=\"padding: 0px; font-family:; margin-top: 0px; margin-bottom: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);\"><br/></p><p style=\"padding: 0px; font-family:; margin-top: 0px; margin-bottom: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);\"><a style=\"margin: 0px; padding: 0px; color: rgb(0, 176, 80); text-decoration: underline;\" href=\"https://jq.qq.com/?_wv=1027&k=4AEFdBX\" target=\"_blank\"><span style=\"color: rgb(0, 176, 80);\">点击加入</span></a><span style=\"color: rgb(0, 176, 80);\">官方交流群</span></p><p><br/></p>', 'a:2:{i:0;s:52:\"/public/uploads/images/20170801/1501558772782878.jpg\";i:1;s:52:\"/public/uploads/images/20170801/1501558772371565.jpg\";}', '', '0', '0', '1', '0', '1', '0', '', '0', '0', '1');
INSERT INTO `itkee_article` VALUES ('2', '23', '23', '', '1', 'demo', '0', '1', '2017-08-01 16:19:50', '0', '1501575626', '', null, '', '1', '0', '0', '0', '3', '0', '', '0', '0', '0');

-- ----------------------------
-- Table structure for `itkee_auth_group`
-- ----------------------------
DROP TABLE IF EXISTS `itkee_auth_group`;
CREATE TABLE `itkee_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` varchar(255) NOT NULL COMMENT '权限规则ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='权限组表';

-- ----------------------------
-- Records of itkee_auth_group
-- ----------------------------
INSERT INTO `itkee_auth_group` VALUES ('1', '超级管理组', '1', '5,6,7,8,9,10,11,81,12,39,40,41,42,43,82,14,13,20,21,22,23,24,92,15,25,26,27,28,29,30,83,54,57,68,69,70,71,72,85,84,55,58,59,60,61,62,56,63,64,65,66,67,77,16,17,44,45,46,47,48,18,49,50,51,52,53,19,31,32,33,34,35,36,37,86,79,80,78,1,2,3,73,74,87,88,89,90,91');
INSERT INTO `itkee_auth_group` VALUES ('2', '管理员组', '1', '5,6,81,12,82,14,13,92,15,30,83,25,26,27,28,113,54,57,85,77,80,16,17,44,45,18,49,100,107,108,19,31,36,37,86,32,33,34,35,94,95,101,78,87,88,89,90,91,93,96,97');
INSERT INTO `itkee_auth_group` VALUES ('3', '对外演示权限组', '1', '5,6,81,12,82,14,13,92,15,83,98,99,54,57,85,77,79,80,78,1,2,87,88');

-- ----------------------------
-- Table structure for `itkee_auth_group_access`
-- ----------------------------
DROP TABLE IF EXISTS `itkee_auth_group_access`;
CREATE TABLE `itkee_auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='权限组规则表';

-- ----------------------------
-- Records of itkee_auth_group_access
-- ----------------------------
INSERT INTO `itkee_auth_group_access` VALUES ('1', '1');
INSERT INTO `itkee_auth_group_access` VALUES ('3', '2');
INSERT INTO `itkee_auth_group_access` VALUES ('3', '3');
INSERT INTO `itkee_auth_group_access` VALUES ('5', '1');

-- ----------------------------
-- Table structure for `itkee_auth_rule`
-- ----------------------------
DROP TABLE IF EXISTS `itkee_auth_rule`;
CREATE TABLE `itkee_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL COMMENT '规则名称',
  `title` varchar(20) NOT NULL,
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `pid` smallint(5) unsigned NOT NULL COMMENT '父级ID',
  `icon` varchar(50) DEFAULT '' COMMENT '图标',
  `sort` tinyint(4) unsigned NOT NULL COMMENT '排序',
  `condition` char(100) DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `name` (`name`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=119 DEFAULT CHARSET=utf8 COMMENT='规则表';

-- ----------------------------
-- Records of itkee_auth_rule
-- ----------------------------
INSERT INTO `itkee_auth_rule` VALUES ('1', 'admin/index/config', '系统配置', '1', '1', '77', 'fa fa-gears', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('2', 'admin/System/siteConfig', '站点配置', '1', '1', '1', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('3', 'admin/System/updateSiteConfig', '更新配置', '1', '0', '1', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('5', 'admin/Menu/default', '菜单', '1', '1', '0', 'fa fa-linkedin-square', '254', '');
INSERT INTO `itkee_auth_rule` VALUES ('6', 'admin/Menu', '后台菜单', '1', '1', '5', 'fa fa-star', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('7', 'admin/Menu/add', '添加菜单', '1', '1', '6', '', '1', '');
INSERT INTO `itkee_auth_rule` VALUES ('8', 'admin/Menu/save', '保存菜单', '1', '0', '6', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('9', 'admin/Menu/edit', '编辑菜单', '1', '0', '6', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('10', 'admin/Menu/update', '更新菜单', '1', '0', '6', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('11', 'admin/Menu/delete', '删除菜单', '1', '0', '6', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('12', 'admin/Nav/index', '导航管理', '1', '1', '5', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('13', 'admin/Category/index', '栏目管理', '1', '1', '14', 'fa fa-sitemap', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('14', 'admin/Content/default', '内容', '1', '1', '0', 'fa fa-file-text', '250', '');
INSERT INTO `itkee_auth_rule` VALUES ('15', 'admin/Article/index', '文章管理', '1', '1', '14', '', '10', '');
INSERT INTO `itkee_auth_rule` VALUES ('16', 'admin/User/default', '用户管理', '1', '1', '77', 'fa fa-users', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('17', 'admin/User/index', '普通用户', '1', '1', '16', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('18', 'admin/Admin_user/index', '管理员', '1', '1', '16', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('19', 'admin/Auth_group/index', '权限组', '1', '1', '77', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('20', 'admin/Category/add', '添加栏目', '1', '1', '13', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('21', 'admin/Category/save', '保存栏目', '1', '0', '13', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('22', 'admin/Category/edit', '编辑栏目', '1', '0', '13', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('23', 'admin/Category/update', '更新栏目', '1', '0', '13', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('24', 'admin/Category/delete', '删除栏目', '1', '0', '13', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('25', 'admin/Article/add', '添加文章', '1', '1', '83', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('26', 'admin/Article/save', '保存文章', '1', '0', '83', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('27', 'admin/Article/edit', '编辑文章', '1', '0', '83', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('28', 'admin/Article/update', '更新文章', '1', '0', '83', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('29', 'admin/Article/delete', '删除文章', '1', '0', '83', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('30', 'admin/Article/toggle', '文章审核', '1', '0', '15', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('31', 'admin/Auth_group/add', '添加权限组', '1', '1', '19', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('32', 'admin/AuthGroup/save', '保存权限组', '1', '0', '86', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('33', 'admin/AuthGroup/edit', '编辑权限组', '1', '0', '86', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('34', 'admin/AuthGroup/update', '更新权限组', '1', '0', '86', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('35', 'admin/AuthGroup/delete', '删除权限组', '1', '0', '86', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('36', 'admin/AuthGroup/auth', '授权', '1', '0', '19', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('37', 'admin/AuthGroup/updateAuthGroupRule', '更新权限组规则', '1', '0', '36', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('39', 'admin/Nav/add', '添加导航', '1', '1', '12', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('40', 'admin/Nav/save', '保存导航', '1', '0', '12', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('41', 'admin/Nav/edit', '编辑导航', '1', '0', '12', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('42', 'admin/Nav/update', '更新导航', '1', '0', '12', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('43', 'admin/Nav/delete', '删除导航', '1', '0', '12', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('44', 'admin/User/add', '添加用户', '1', '1', '17', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('45', 'admin/User/save', '保存用户', '1', '0', '17', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('46', 'admin/User/edit', '编辑用户', '1', '0', '17', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('47', 'admin/User/update', '更新用户', '1', '0', '17', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('48', 'admin/User/delete', '删除用户', '1', '0', '17', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('49', 'admin/AdminUser/add', '添加管理员', '1', '1', '18', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('50', 'admin/AdminUser/save', '保存管理员', '1', '0', '18', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('51', 'admin/AdminUser/edit', '编辑管理员', '1', '0', '18', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('52', 'admin/AdminUser/update', '更新管理员', '1', '0', '18', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('53', 'admin/AdminUser/delete', '删除管理员', '1', '0', '18', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('54', 'admin/Slide/default', '扩展', '1', '1', '0', 'fa fa-wrench', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('55', 'admin/Slide_category/index', '轮播分类', '1', '1', '84', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('56', 'admin/Slide/index', '轮播图管理', '1', '1', '84', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('57', 'admin/Link/index', '友情链接', '1', '1', '54', 'fa fa-link', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('58', 'admin/SlideCategory/add', '添加分类', '1', '1', '55', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('59', 'admin/SlideCategory/save', '保存分类', '1', '0', '55', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('60', 'admin/SlideCategory/edit', '编辑分类', '1', '0', '55', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('61', 'admin/SlideCategory/update', '更新分类', '1', '0', '55', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('62', 'admin/SlideCategory/delete', '删除分类', '1', '0', '55', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('63', 'admin/Slide/add', '添加轮播', '1', '1', '56', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('64', 'admin/Slide/save', '保存轮播', '1', '1', '56', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('65', 'admin/Slide/edit', '编辑轮播', '1', '0', '56', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('66', 'admin/Slide/update', '更新轮播', '1', '0', '56', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('67', 'admin/Slide/delete', '删除轮播', '1', '0', '56', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('68', 'admin/Link/add', '添加链接', '1', '1', '57', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('69', 'admin/Link/save', '保存链接', '1', '0', '57', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('70', 'admin/Link/edit', '编辑链接', '1', '0', '57', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('71', 'admin/Link/update', '更新链接', '1', '0', '57', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('72', 'admin/Link/delete', '删除链接', '1', '0', '57', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('73', 'admin/Change_password/index', '修改密码', '1', '1', '1', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('74', 'admin/ChangePassword/updatePassword', '更新密码', '1', '0', '1', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('77', 'admin/index/index', '平台', '1', '1', '0', '', '255', '');
INSERT INTO `itkee_auth_rule` VALUES ('81', 'admin/Menu/index', '菜单管理', '1', '1', '6', '', '10', '');
INSERT INTO `itkee_auth_rule` VALUES ('82', 'admin/nav/index', '导航列表', '1', '1', '12', '', '1', '');
INSERT INTO `itkee_auth_rule` VALUES ('80', 'admin/index/webSite', '站点动态', '1', '1', '1', '', '9', '');
INSERT INTO `itkee_auth_rule` VALUES ('83', 'admin/Article/index', '文章列表', '1', '1', '15', '', '10', '');
INSERT INTO `itkee_auth_rule` VALUES ('84', 'default', '轮播管理', '1', '1', '54', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('85', 'admin/link/index', '友链列表', '1', '1', '57', '', '10', '');
INSERT INTO `itkee_auth_rule` VALUES ('86', 'admin/Auth_group/index', '权限列表', '1', '1', '19', '', '10', '');
INSERT INTO `itkee_auth_rule` VALUES ('92', 'admin/Category/index', '栏目列表', '1', '1', '13', 'fa fa-wrench', '10', '');
INSERT INTO `itkee_auth_rule` VALUES ('106', 'Admin/Navcat/index', '导航分类', '1', '1', '12', '', '0', '');
INSERT INTO `itkee_auth_rule` VALUES ('113', 'admin/article/topToggle', '加精/置顶/推荐下载', '1', '0', '83', '', '0', '');

-- ----------------------------
-- Table structure for `itkee_category`
-- ----------------------------
DROP TABLE IF EXISTS `itkee_category`;
CREATE TABLE `itkee_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类ID',
  `name` varchar(50) NOT NULL COMMENT '分类名称',
  `alias` varchar(50) DEFAULT '' COMMENT '导航别名',
  `content` longtext COMMENT '分类内容',
  `thumb` varchar(255) DEFAULT '' COMMENT '缩略图',
  `icon` varchar(20) DEFAULT '' COMMENT '分类图标',
  `list_template` varchar(50) DEFAULT '' COMMENT '分类列表模板',
  `detail_template` varchar(50) DEFAULT '' COMMENT '分类详情模板',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '分类类型  1  列表  2 单页',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID',
  `path` varchar(255) DEFAULT '' COMMENT '路径',
  `create_time` varchar(50) NOT NULL,
  `identity_id` int(10) NOT NULL DEFAULT '0' COMMENT '角色权限',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='分类表';

-- ----------------------------
-- Records of itkee_category
-- ----------------------------
INSERT INTO `itkee_category` VALUES ('1', '默认栏目', '', '', '', '', '', '', '1', '0', '0', '0,', '1500537763', '0');
INSERT INTO `itkee_category` VALUES ('2', 'tewt', '', '', '', '', '', '', '1', '0', '0', '0,', '1501138866', '0');
INSERT INTO `itkee_category` VALUES ('3', '烦烦烦', '', '', '', '', '', '', '1', '0', '2', '0,2,', '1501230161', '0');

-- ----------------------------
-- Table structure for `itkee_link`
-- ----------------------------
DROP TABLE IF EXISTS `itkee_link`;
CREATE TABLE `itkee_link` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '链接名称',
  `link` varchar(255) DEFAULT '' COMMENT '链接地址',
  `image` varchar(255) DEFAULT '' COMMENT '链接图片',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态 1 显示  2 隐藏',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='友情链接表';

-- ----------------------------
-- Records of itkee_link
-- ----------------------------
INSERT INTO `itkee_link` VALUES ('2', 'SuperMan博客', 'http://superman.itkee.cn', '', '0', '20');

-- ----------------------------
-- Table structure for `itkee_nav`
-- ----------------------------
DROP TABLE IF EXISTS `itkee_nav`;
CREATE TABLE `itkee_nav` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL COMMENT '父ID',
  `name` varchar(20) NOT NULL COMMENT '导航名称',
  `alias` varchar(20) DEFAULT '' COMMENT '导航别称',
  `link` varchar(255) DEFAULT '' COMMENT '导航链接',
  `icon` varchar(255) DEFAULT '' COMMENT '导航图标',
  `target` varchar(10) DEFAULT '' COMMENT '打开方式',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态  0 隐藏  1 显示',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `nav_cid` int(10) DEFAULT NULL COMMENT '分类ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='导航表';

-- ----------------------------
-- Records of itkee_nav
-- ----------------------------

-- ----------------------------
-- Table structure for `itkee_nav_cat`
-- ----------------------------
DROP TABLE IF EXISTS `itkee_nav_cat`;
CREATE TABLE `itkee_nav_cat` (
  `navcid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '导航分类名',
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '是否为主菜单，1是，0不是',
  `remark` text COMMENT '备注',
  PRIMARY KEY (`navcid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='前台导航分类表';

-- ----------------------------
-- Records of itkee_nav_cat
-- ----------------------------
INSERT INTO `itkee_nav_cat` VALUES ('1', '主导航', '1', '头部主导航');
INSERT INTO `itkee_nav_cat` VALUES ('2', '底部纵向导航', '1', '站点公共底部导航');
INSERT INTO `itkee_nav_cat` VALUES ('3', '底部横向导航', '1', '底部横向导航');

-- ----------------------------
-- Table structure for `itkee_slide`
-- ----------------------------
DROP TABLE IF EXISTS `itkee_slide`;
CREATE TABLE `itkee_slide` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cid` int(10) unsigned NOT NULL COMMENT '分类ID',
  `name` varchar(50) NOT NULL COMMENT '轮播图名称',
  `description` varchar(255) DEFAULT '' COMMENT '说明',
  `link` varchar(255) DEFAULT '' COMMENT '链接',
  `target` varchar(10) DEFAULT '' COMMENT '打开方式',
  `image` varchar(255) DEFAULT '' COMMENT '轮播图片',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态  1 显示  0  隐藏',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='轮播图表';

-- ----------------------------
-- Records of itkee_slide
-- ----------------------------
INSERT INTO `itkee_slide` VALUES ('3', '2', '开源社区下载', '', 'http://www.itkee.cn/index/topic/detail/id/51.html', '_self', '/uploads/20170608/40138fc1bb4fc2a6cb74440d14307d9b.png', '1', '10');
INSERT INTO `itkee_slide` VALUES ('2', '2', '社区介绍', '', 'http://www.itkee.cn/index/topic/detail/id/131.html', '_self', '/uploads/20170621/12ea85a96caaeefa7a5887d7009c004e.gif', '1', '50');
INSERT INTO `itkee_slide` VALUES ('4', '2', 'ShopNC源码下载', '', 'http://www.itkee.cn/index/topic/detail/id/144.html', '_self', '/uploads/20170610/ccbf6dab14d6fb6f1222b58aa377347f.png', '1', '5');
INSERT INTO `itkee_slide` VALUES ('5', '2', 'itkee_cmf下载', 'itkee_cmf下载', 'http://www.itkee.cn/topic-info-168.html', '_blank', '/uploads/20170618/8b7690b391f7bcce9af6d28ead8ca688.png', '1', '50');
INSERT INTO `itkee_slide` VALUES ('6', '1', '首页轮播', '哈哈哈', '', '_self', '/uploads/20170718/4438923691bbe1063e45a249e06c9315.png', '1', '0');

-- ----------------------------
-- Table structure for `itkee_slide_category`
-- ----------------------------
DROP TABLE IF EXISTS `itkee_slide_category`;
CREATE TABLE `itkee_slide_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '轮播图分类',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='轮播图分类表';

-- ----------------------------
-- Records of itkee_slide_category
-- ----------------------------
INSERT INTO `itkee_slide_category` VALUES ('1', '首页轮播');
INSERT INTO `itkee_slide_category` VALUES ('2', '右侧轮播');

-- ----------------------------
-- Table structure for `itkee_system`
-- ----------------------------
DROP TABLE IF EXISTS `itkee_system`;
CREATE TABLE `itkee_system` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '配置项名称',
  `value` text NOT NULL COMMENT '配置项值',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='系统配置表';

-- ----------------------------
-- Records of itkee_system
-- ----------------------------
INSERT INTO `itkee_system` VALUES ('1', 'site_config', 'a:7:{s:10:\"site_title\";s:14:\"ITKEE.CN社区\";s:9:\"seo_title\";s:36:\"ITKEE社区-极速，清新，精简\";s:11:\"seo_keyword\";s:36:\"ITKEE社区-极速，清新，精简\";s:15:\"seo_description\";s:426:\"ITKEE.CN是以技术交流为中心开发的社区论坛，由几个志同道合的程序员一起维护组建的互联网技术工作室,曾为上百客户排忧解难，目前主要PHP技术交流，技术服务，前端开发，UI社区等业务为主线运营,社区及工作室主要定位于：互联网技术交流，互联网资源分享，网站开发，电商网站技术支持，整站开发，二次开发等服务\";s:14:\"site_copyright\";s:76:\"Copyright © 2016-2017 ITKEE.CN. All Rights Reserved. ITKEE.CN 版权所有\";s:8:\"site_icp\";s:0:\"\";s:11:\"site_tongji\";s:109:\"<script src=\"https://s19.cnzz.com/z_stat.php?id=1262986736&web_id=1262986736\" language=\"JavaScript\"></script>\";}');
INSERT INTO `itkee_system` VALUES ('2', 'email_config', '');
INSERT INTO `itkee_system` VALUES ('3', 'system_config', 'a:2:{s:9:\"app_debug\";s:4:\"true\";s:9:\"app_trace\";s:5:\"false\";}');
INSERT INTO `itkee_system` VALUES ('4', 'qq_config', '');

-- ----------------------------
-- Table structure for `itkee_user`
-- ----------------------------
DROP TABLE IF EXISTS `itkee_user`;
CREATE TABLE `itkee_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL COMMENT '用户名',
  `password` varchar(50) NOT NULL COMMENT '密码',
  `mobile` varchar(11) DEFAULT '' COMMENT '手机',
  `email` varchar(50) DEFAULT '' COMMENT '邮箱',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '用户状态  1 正常  2 禁止',
  `create_time` varchar(50) DEFAULT NULL COMMENT '创建时间',
  `last_login_time` varchar(50) DEFAULT NULL COMMENT '最后登陆时间',
  `last_login_ip` varchar(50) DEFAULT '' COMMENT '最后登录IP',
  `avatar` varchar(100) DEFAULT NULL COMMENT '用户头像',
  `intro` varchar(255) DEFAULT NULL COMMENT '个人介绍',
  `points` int(10) NOT NULL DEFAULT '0' COMMENT '用户积分',
  `qq_openid` varchar(100) DEFAULT NULL COMMENT 'QQ_openid',
  `sex` varchar(10) NOT NULL DEFAULT '保密' COMMENT '性别',
  `province` varchar(50) DEFAULT NULL COMMENT '用户省份',
  `city` varchar(50) DEFAULT NULL,
  `year` varchar(10) DEFAULT NULL,
  `truename` varchar(50) DEFAULT NULL COMMENT '真实姓名',
  `qq` varchar(50) DEFAULT NULL,
  `identity_id` int(10) DEFAULT '0' COMMENT '用户身份',
  `coin` int(11) NOT NULL DEFAULT '0' COMMENT '用户金币',
  PRIMARY KEY (`id`),
  KEY `username` (`username`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of itkee_user
-- ----------------------------
INSERT INTO `itkee_user` VALUES ('2', 'ssd', '8d481b131be8e0e9e1890daf2d29aa3b', '', '', '1', '1501295291', null, '', null, null, '0', null, '保密', null, null, null, null, null, '0', '0');
INSERT INTO `itkee_user` VALUES ('3', 'sdsda', '8d481b131be8e0e9e1890daf2d29aa3b', '', '', '1', '1501556442', null, '', null, null, '0', null, '保密', null, null, null, null, null, '0', '0');
INSERT INTO `itkee_user` VALUES ('4', 'demo', 'a24dfc8e919798d7f7b857775175527c', '', '', '1', '1501572469', null, '', null, null, '0', null, '保密', null, null, null, null, null, '0', '0');
INSERT INTO `itkee_user` VALUES ('5', '234234', '36837243869b6ba3f260c625ec3fc919', '', '', '1', '1501585751', null, '', null, null, '0', null, '保密', null, null, null, null, null, '0', '0');
INSERT INTO `itkee_user` VALUES ('6', 'qw', '1f4f8fda92a89ff9b3c1d7933ff32ff6', 'asd', 'asd', '1', '1501662847', null, '', null, null, '0', null, '保密', null, null, null, null, null, '0', '0');
INSERT INTO `itkee_user` VALUES ('7', '234', 'd999fff35086696499b0f8f13723b929', '234', '234', '1', '1501671512', null, '', null, null, '0', null, '保密', null, null, null, null, null, '0', '0');
