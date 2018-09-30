/*
Navicat MySQL Data Transfer

Source Server         : 本地服务器
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : vaethink

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-09-30 23:54:04
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `vae_admin`
-- ----------------------------
DROP TABLE IF EXISTS `vae_admin`;
CREATE TABLE `vae_admin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(50) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '1正常-1禁止登陆',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `last_login_time` int(11) NOT NULL,
  `login_num` int(11) NOT NULL DEFAULT '0',
  `last_login_ip` varchar(100) NOT NULL,
  `phone` bigint(11) DEFAULT NULL,
  `nickname` varchar(255) DEFAULT NULL,
  `desc` text COMMENT '备注',
  `thumb` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`id`,`username`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员';

-- ----------------------------
-- Records of vae_admin
-- ----------------------------

-- ----------------------------
-- Table structure for `vae_admin_group`
-- ----------------------------
DROP TABLE IF EXISTS `vae_admin_group`;
CREATE TABLE `vae_admin_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `rules` varchar(10000) DEFAULT NULL COMMENT '用户组拥有的规则id， 多个规则","隔开',
  `desc` text COMMENT '备注',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='权限分组';

-- ----------------------------
-- Records of vae_admin_group
-- ----------------------------
INSERT INTO `vae_admin_group` VALUES ('1', '系统所有者', '1', '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62', '系统所有者，系统自动分配所有可操作权限。', '0', '1538310278');

-- ----------------------------
-- Table structure for `vae_admin_group_access`
-- ----------------------------
DROP TABLE IF EXISTS `vae_admin_group_access`;
CREATE TABLE `vae_admin_group_access` (
  `uid` mediumint(11) unsigned DEFAULT NULL,
  `group_id` mediumint(11) DEFAULT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='权限分组和管理员的关联表';

-- ----------------------------
-- Records of vae_admin_group_access
-- ----------------------------

-- ----------------------------
-- Table structure for `vae_admin_menu`
-- ----------------------------
DROP TABLE IF EXISTS `vae_admin_menu`;
CREATE TABLE `vae_admin_menu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0',
  `title` varchar(50) NOT NULL,
  `src` varchar(225) DEFAULT NULL,
  `param` varchar(255) DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT '1' COMMENT '越大越靠前',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='后台菜单';

-- ----------------------------
-- Records of vae_admin_menu
-- ----------------------------
INSERT INTO `vae_admin_menu` VALUES ('1', '0', '系统', null, null, '1', '0', '0');
INSERT INTO `vae_admin_menu` VALUES ('2', '1', '菜单', 'admin/menu/index', null, '1', '0', '0');
INSERT INTO `vae_admin_menu` VALUES ('3', '1', '管理', null, null, '2', '0', '0');
INSERT INTO `vae_admin_menu` VALUES ('4', '3', '管理员', 'admin/admin/index', null, '1', '0', '0');
INSERT INTO `vae_admin_menu` VALUES ('5', '3', '管理组', 'admin/group/index', null, '1', '0', '0');
INSERT INTO `vae_admin_menu` VALUES ('6', '1', '节点', 'admin/rule/index', '', '1', '0', '0');
INSERT INTO `vae_admin_menu` VALUES ('7', '0', '门户', '', '', '1', '0', '0');
INSERT INTO `vae_admin_menu` VALUES ('10', '7', '分类', 'admin/cate/index', '', '1', '0', '0');
INSERT INTO `vae_admin_menu` VALUES ('11', '7', '内容', '', '', '1', '0', '0');
INSERT INTO `vae_admin_menu` VALUES ('12', '11', '文章', 'admin/article/index', '', '1', '0', '0');
INSERT INTO `vae_admin_menu` VALUES ('13', '11', '回收站', 'admin/recycle/index', '', '1', '0', '0');
INSERT INTO `vae_admin_menu` VALUES ('14', '1', '路由', 'admin/route/index', '', '1', '0', '0');
INSERT INTO `vae_admin_menu` VALUES ('15', '1', '配置', '', '', '1', '0', '0');
INSERT INTO `vae_admin_menu` VALUES ('16', '15', '网站信息', 'admin/conf/webConf', '', '1', '0', '0');
INSERT INTO `vae_admin_menu` VALUES ('17', '15', '邮箱配置', 'admin/conf/emailConf', '', '1', '0', '0');
INSERT INTO `vae_admin_menu` VALUES ('18', '0', '插件', '', '', '1', '0', '0');
INSERT INTO `vae_admin_menu` VALUES ('19', '18', '内置钩子', 'admin/hook/index', '', '1', '0', '0');
INSERT INTO `vae_admin_menu` VALUES ('20', '18', '插件管理', 'admin/plugin/index', '', '1', '0', '0');

-- ----------------------------
-- Table structure for `vae_admin_rule`
-- ----------------------------
DROP TABLE IF EXISTS `vae_admin_rule`;
CREATE TABLE `vae_admin_rule` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL COMMENT '规则',
  `title` varchar(255) NOT NULL,
  `type` int(1) NOT NULL DEFAULT '1',
  `condition` char(100) NOT NULL COMMENT '附加规则',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8 COMMENT='权限节点';

-- ----------------------------
-- Records of vae_admin_rule
-- ----------------------------
INSERT INTO `vae_admin_rule` VALUES ('1', '0', 'menu/index', '菜单', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('2', '1', 'menu/getMenuList', '菜单列表', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('3', '1', 'menu/add', '添加菜单', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('4', '3', 'menu/addSubmit', '保存添加的菜单', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('5', '1', 'menu/editSubmit', '保存菜单修改', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('6', '1', 'menu/delete', '删除菜单', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('7', '0', 'rule/index', '节点', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('8', '7', 'rule/getRuleList', '节点列表', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('9', '7', 'rule/add', '添加节点', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('10', '9', 'rule/addSubmit', '保存添加的节点', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('11', '7', 'rule/editSubmit', '保存节点修改', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('12', '7', 'rule/delete', '节点删除', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('13', '0', 'admin/index', '管理员', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('14', '13', 'admin/getAdminList', '管理员列表', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('15', '13', 'admin/add', '添加管理员', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('16', '15', 'admin/addSubmit', '保存添加的管理员', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('17', '13', 'admin/edit', '修改管理员', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('18', '17', 'admin/editSubmit', '保存管理员的修改', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('19', '13', 'admin/delete', '管理员删除', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('20', '0', 'group/index', '管理组', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('21', '20', 'group/getGroupList', '管理组列表', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('22', '20', 'group/add', '添加管理组', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('23', '22', 'group/addSubmit', '保存添加的管理组', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('24', '20', 'group/edit', '管理组修改', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('25', '24', 'group/editSubmit', '保存管理组的修改', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('26', '20', 'group/delete', '管理组删除', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('27', '0', 'cate/index', '分类', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('28', '27', 'cate/getCateList', '分类列表', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('29', '27', 'cate/add', '添加分类', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('30', '29', 'cate/addSubmit', '保存添加的分类', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('31', '27', 'cate/editSubmit', '保存修改的分类', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('32', '27', 'cate/delete', '删除分类', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('33', '0', 'article/index', '文章', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('34', '33', 'article/getContentList', '文章列表', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('35', '33', 'article/add', '添加文章', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('36', '35', 'article/addSubmit', '保存添加的文章', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('37', '33', 'article/edit', '编辑文章', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('38', '37', 'article/editSubmit', '保存编辑的文章', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('39', '33', 'article/delete', '删除文章', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('40', '0', 'recycle/index', '回收站', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('41', '40', 'recycle/getRecycleList', '回收列表', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('42', '40', 'recycle/reduction', '还原', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('43', '40', 'recycle/delete', '彻底删除', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('44', '0', 'route/index', '路由', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('45', '44', 'route/getRouteList', '路由列表', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('46', '44', 'route/add', '添加路由', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('47', '46', 'route/addSubmit', '保存添加的路由', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('48', '44', 'route/edit', '修改路由', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('49', '48', 'route/editSubmit', '保存修改的路由', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('50', '44', 'route/delete', '删除路由', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('51', '0', 'conf/webConf', '网站信息', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('52', '51', 'conf/webConfSubmit', '保存网站信息', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('53', '0', 'conf/emailConf', '邮箱配置', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('54', '53', 'conf/emailConfSubmit', '保存邮箱配置', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('55', '0', 'hook/index', '钩子管理', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('56', '55', 'hook/getHookList', '钩子列表', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('57', '0', 'plugin/index', '插件管理', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('58', '57', 'plugin/getPluginList', '插件列表', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('59', '57', 'plugin/start', '启用插件', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('60', '57', 'plugin/disabled', '禁用插件', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('61', '57', 'plugin/uninstall', '卸载插件', '1', '', '0', '0');
INSERT INTO `vae_admin_rule` VALUES ('62', '57', 'plugin/install', '安装插件', '1', '', '0', '0');

-- ----------------------------
-- Table structure for `vae_article`
-- ----------------------------
DROP TABLE IF EXISTS `vae_article`;
CREATE TABLE `vae_article` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `keywords` varchar(1000) DEFAULT NULL,
  `desc` varchar(1000) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '1正常-1下架',
  `thumb` varchar(1000) NOT NULL,
  `content` text NOT NULL,
  `article_cate_id` int(11) NOT NULL DEFAULT '0',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='内容';

-- ----------------------------
-- Records of vae_article
-- ----------------------------

-- ----------------------------
-- Table structure for `vae_article_cate`
-- ----------------------------
DROP TABLE IF EXISTS `vae_article_cate`;
CREATE TABLE `vae_article_cate` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0',
  `title` varchar(50) NOT NULL,
  `keywords` varchar(1000) DEFAULT NULL,
  `desc` varchar(1000) DEFAULT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`,`pid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='内容分类';

-- ----------------------------
-- Records of vae_article_cate
-- ----------------------------

-- ----------------------------
-- Table structure for `vae_hook`
-- ----------------------------
DROP TABLE IF EXISTS `vae_hook`;
CREATE TABLE `vae_hook` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '钩子类型1:系统钩子,2:应用钩子,3:模板钩子',
  `only` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否只允许一个插件运行0:多个,1:一个',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '钩子名称',
  `hook` varchar(50) NOT NULL DEFAULT '' COMMENT '钩子',
  `module` varchar(15) NOT NULL DEFAULT '' COMMENT '模块名，模块专属钩子',
  `desc` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COMMENT='钩子表';

-- ----------------------------
-- Records of vae_hook
-- ----------------------------
INSERT INTO `vae_hook` VALUES ('1', '1', '0', '应用初始化', 'app_init', 'vae', '应用初始化');
INSERT INTO `vae_hook` VALUES ('2', '1', '0', '应用开始', 'app_begin', 'vae', '应用开始');
INSERT INTO `vae_hook` VALUES ('3', '1', '0', '模块初始化', 'module_init', 'vae', '模块初始化');
INSERT INTO `vae_hook` VALUES ('4', '1', '0', '控制器开始', 'action_begin', 'vae', '控制器开始');
INSERT INTO `vae_hook` VALUES ('5', '1', '0', '视图输出过滤', 'view_filter', 'vae', '视图输出过滤');
INSERT INTO `vae_hook` VALUES ('6', '1', '0', '应用结束', 'app_end', 'vae', '应用结束');
INSERT INTO `vae_hook` VALUES ('7', '1', '0', '日志write方法', 'log_write', 'vae', '日志write方法');
INSERT INTO `vae_hook` VALUES ('8', '1', '0', '输出结束', 'response_end', 'vae', '输出结束');
INSERT INTO `vae_hook` VALUES ('9', '1', '0', '后台控制器初始化', 'admin_init', 'vae', '后台控制器初始化');
INSERT INTO `vae_hook` VALUES ('10', '1', '0', '前台控制器初始化', 'home_init', 'vae', '前台控制器初始化');
INSERT INTO `vae_hook` VALUES ('11', '2', '1', '后台首页', 'admin_main', 'admin', '后台首页');
INSERT INTO `vae_hook` VALUES ('12', '2', '1', '后台登录页面', 'admin_login', 'admin', '后台登录页面初始化');

-- ----------------------------
-- Table structure for `vae_hook_plugin`
-- ----------------------------
DROP TABLE IF EXISTS `vae_hook_plugin`;
CREATE TABLE `vae_hook_plugin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态-1禁用,1启用',
  `hook` varchar(50) NOT NULL DEFAULT '' COMMENT '钩子名',
  `plugin` varchar(50) NOT NULL DEFAULT '' COMMENT '插件名',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='钩子关联插件表';

-- ----------------------------
-- Records of vae_hook_plugin
-- ----------------------------

-- ----------------------------
-- Table structure for `vae_plugin`
-- ----------------------------
DROP TABLE IF EXISTS `vae_plugin`;
CREATE TABLE `vae_plugin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '插件标识',
  `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '插件名称',
  `hook` varchar(255) NOT NULL DEFAULT '' COMMENT '实现的钩子;以“,”分隔',
  `author` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '插件作者',
  `desc` varchar(255) NOT NULL COMMENT '插件描述',
  `interface` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否有后台管理,0:没有;1:有',
  `config` text COMMENT '插件配置',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '插件安装时间',
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='插件表';

-- ----------------------------
-- Records of vae_plugin
-- ----------------------------

-- ----------------------------
-- Table structure for `vae_route`
-- ----------------------------
DROP TABLE IF EXISTS `vae_route`;
CREATE TABLE `vae_route` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `full_url` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '1启用-1禁用',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='路由设置';

-- ----------------------------
-- Records of vae_route
-- ----------------------------

-- ----------------------------
-- Table structure for `vae_user`
-- ----------------------------
DROP TABLE IF EXISTS `vae_user`;
CREATE TABLE `vae_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nickName` varchar(200) DEFAULT NULL COMMENT '昵称',
  `avatarUrl` varchar(250) DEFAULT NULL COMMENT '头像',
  `gender` int(1) DEFAULT NULL COMMENT '性别',
  `openid` varchar(200) NOT NULL COMMENT '微信openid',
  `token` varchar(200) NOT NULL COMMENT '登录验证token',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `last_login_time` int(11) NOT NULL COMMENT '最后登录时间',
  `last_login_ip` varchar(50) NOT NULL COMMENT '最后登录ip',
  `login_num` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '登录次数',
  `status` int(1) unsigned NOT NULL COMMENT '状态0正常-1禁止登录',
  `name` varchar(50) DEFAULT NULL COMMENT '真实姓名',
  `phone` bigint(11) DEFAULT NULL COMMENT '电话',
  `address` varchar(500) DEFAULT NULL,
  `id_num` varchar(18) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of vae_user
-- ----------------------------
INSERT INTO `vae_user` VALUES ('1', '听雨', 'https://wx.qlogo.cn/mmopen/vi_32/oOn2eCicFVEboolnbcsLrXIX8aTE52NS02XZUhdhAKtKgtGvnzDCLoD52PZYRqdwpPAkVtkkiaUwvmIo4Hc0NJrA/132', '0', 'os14r5LeKtGJk2TAqWY_t1C-OPH4', 'QSjEz8hsUFJHO29iWMRmVABdtl6IP0cvubZrgfn3X14xyLC5p7', '1534067133', '1534067133', '1535937928', '1.195.33.128', '582', '0', null, null, null, null);
INSERT INTO `vae_user` VALUES ('2', '21baby', 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTKB5zcMiaDu4yFeRywdADOiamTMnUUhODz7m8wkUJviaQm0icuPpPbZzWFDFkIIE3sLxnxWpHC1m1yqYQ/132', '2', 'os14r5AsUEUhvJ2mp9kQHROzcQDA', '561ed7pET9bcCarg8hUBQHxoyG3ZNfFvSLWJkqYnli4jA0DRzV', '1534070496', '1534070496', '1534331853', '1.195.35.152', '12', '0', null, null, null, null);
INSERT INTO `vae_user` VALUES ('3', null, null, null, 'os14r5NhNEfzKKfcMaeOxGXIGXGA', 'z6BrRnIk7hAHQqbswxaf40uvdEeUJGYoiFSKgVXCOLy8NpPj2D', '1534071166', '1534071166', '1534071167', '223.166.222.108', '2', '0', null, null, null, null);
INSERT INTO `vae_user` VALUES ('4', null, null, null, 'os14r5M-J_yBlp4ma-4hrmytS8ns', 'fBt9T2KhPAQbedizx8mnSXrcgJWUyGkv0HVO1qs5DjEwM7Nalp', '1534151804', '1534151804', '1534151806', '101.227.139.163', '2', '0', null, null, null, null);
INSERT INTO `vae_user` VALUES ('5', '公孙胜', 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTLbKp0Id2libic88QNQqofyOIpXIGQNNia3zMnWh83lzHKYnTt2XFec329fWfZicd1sLT03CeJAHZYyIA/132', '0', 'os14r5MR7sI2bMxZF-P443Mt63BY', 'oPDrLSbCUlhduj6ZvBm794X0tkMcR1FIsNVOxKgzT5Yfe3JH8A', '1534154329', '1534154329', '1534154372', '101.227.139.163', '3', '0', null, null, null, null);
INSERT INTO `vae_user` VALUES ('6', null, null, null, 'os14r5FbSRy84CT6HBrCgvqV0XzY', 'LKxUw3R8VXcgo7yC2eW9JMr01mnIihEBzNFZ4v6YQtOuDdqHAa', '1534211526', '1534211526', '1534211527', '223.166.222.108', '2', '0', null, null, null, null);
INSERT INTO `vae_user` VALUES ('7', '武松', 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTJrCta0BxlH8u8nI0UypiaotRYlJElcYT3XoQmN3oaXEpCAtl1450ibiaBngV33u3WHHQtFSbC7le51Q/132', '0', 'os14r5I836kxjej3UrFAy9s1cjWE', '0XcTZLCHIf5VmyMSnDs9rU7xPAKwO1J4GQvgeERd3zb6iWNYpo', '1534250779', '1534250779', '1534250822', '101.227.139.163', '2', '0', null, null, null, null);
INSERT INTO `vae_user` VALUES ('8', null, null, null, 'os14r5L1lhbHPoq1HGIRMBizBgbk', 'Li2Ryh6aGoYsepfugD1HBzrQmlv90SU4nJCxdPjKXMEWbcO85k', '1534294365', '1534294365', '1534294367', '223.166.222.108', '2', '0', null, null, null, null);
INSERT INTO `vae_user` VALUES ('9', null, null, null, 'os14r5M81PDS8g9RMczQSlKRvN98', 'tr4pyuF13DRLGe6f0qSYK2cxnmjOaTko7PVJEHZXslzhABb9C5', '1534294370', '1534294370', '1534294372', '223.166.222.108', '2', '0', null, null, null, null);
INSERT INTO `vae_user` VALUES ('10', null, null, null, 'os14r5CoDcxzByeL4CrcP_rIcLhE', '7UWIGaVE8lBvLDxjwkfHi9n15Ph46KJRoeZ2pcQ0TOXqAYburS', '1534321150', '1534321150', '1534321150', '183.60.88.4', '1', '0', null, null, null, null);
INSERT INTO `vae_user` VALUES ('11', null, null, null, 'os14r5NB12UUXu2Vg_r7pbZWf7fc', 'Pw59X0RvjULldQVSisuY6KTtk2ZHcCAEaIFgqoWrp7bMNym3JG', '1534390952', '1534390952', '1534390952', '118.113.78.88', '1', '0', null, null, null, null);
INSERT INTO `vae_user` VALUES ('12', null, null, null, 'os14r5DoDgKyaxAQ7wPdNOoU1ucI', 'zUx8NJ7VHaef0ETt3BSLg2XOv96CGWhpIPkm5nwRDrMKoQ1qbd', '1534392663', '1534392663', '1534392663', '118.212.207.36', '1', '0', null, null, null, null);
INSERT INTO `vae_user` VALUES ('13', null, null, null, 'os14r5CTi479FY2tv7_e8GU7s85g', 'MzdyEmerhsGiFoxu7t2QHLaTlK9OpRSBUDjCVZAJg0YNqW58vc', '1534394939', '1534394939', '1534394939', '61.158.149.115', '1', '0', null, null, null, null);
INSERT INTO `vae_user` VALUES ('14', null, null, null, 'os14r5DgZNWqrTMOtplKIgyyAbIQ', 'gdbGNhxF3DP7KOkJIe8lLUQSp5CvB4rAz2iyEoMwjRXqcZas0u', '1534400856', '1534400856', '1534400856', '219.155.7.235', '1', '0', null, null, null, null);
INSERT INTO `vae_user` VALUES ('15', null, null, null, 'os14r5IJx05NjMA4KQbahIgDmAs4', '7g2syJptOdBjWvMnFLNVeifQu561zAYZbC84STHhxPcmXKIDqa', '1534402534', '1534402534', '1534925555', '61.158.149.45', '2', '0', null, null, null, null);
INSERT INTO `vae_user` VALUES ('16', null, null, null, 'os14r5IorpGL0_QcKXODiVvprddA', 'vVCA7a2M3DISfd9X15cPibUNJouTs8zmxrRyBqlKg6FnheZEOG', '1534582430', '1534582430', '1534582430', '117.136.50.137', '1', '0', null, null, null, null);
INSERT INTO `vae_user` VALUES ('17', null, null, null, 'os14r5E5WvA-EnYCKQEj7RDAYVHI', '2qJQoAk5NaVM1uBWI0bxj9GeFgsidTf3rtOnlRvpy7US4h6PwX', '1534745233', '1534745233', '1534745233', '113.251.23.135', '1', '0', null, null, null, null);
INSERT INTO `vae_user` VALUES ('18', '苏小辉', 'https://wx.qlogo.cn/mmopen/vi_32/DYAIOgq83epF1dbEWKbxTxeQW8ibTXP6ZiaPw6Ce3jkibxUwEGibWVlMYdUyWSpHrW65zL1ewMGiaqOT92XjvWA2hlQ/132', '1', 'os14r5BhYN5Sc2ZsGNyMxTotUd0E', 'xkUFzbLBWcdtiMsDo1RNpVaYEZK02O6unwfmj97g3ylSG4TrJH', '1535195009', '1535195009', '1535679486', '1.195.34.229', '3', '0', null, null, null, null);
INSERT INTO `vae_user` VALUES ('19', 'star', 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTKzvq5AqMRD6DlrCcRmpDZ7NaERKcyGuKiaCaKeGqWkQMfM7KRXHbhw4PzhlkdibicwreyVLrB5HjrNw/132', '1', 'os14r5MpgrgeG_zjBo5jFoclaQbs', 'RwNhKQdFJ4y1UxXu5ALYpMT9G3nrlIHzSCeaDoVjkPOm8v6qB7', '1535536092', '1535536092', '1535944805', '112.241.183.102', '2', '0', null, null, null, null);
INSERT INTO `vae_user` VALUES ('20', null, null, null, 'os14r5JWIaaUF0ak4R7zRK67a3as', '9QkaRU13qXeWJfm6LFhMIOnNPKYH4sGuiZA5bd7TlCBVpSj2g0', '1535667333', '1535667333', '1535667333', '223.104.21.59', '1', '0', null, null, null, null);
INSERT INTO `vae_user` VALUES ('21', null, null, null, 'os14r5Pth1ChL29nH6eqq5OqxV8I', 'OXhBwJML5GDdigUnpNqmS8tPbHrTQel4WcoaRAIvF2fxuCVKk9', '1535985595', '1535985595', '1535985595', '111.199.187.25', '1', '0', null, null, null, null);
INSERT INTO `vae_user` VALUES ('22', null, null, null, 'os14r5BNH2GeBzzrvp5U-O7jakP4', 'ywmFqgvxABVJeYbK9dWc7ZEDR8nSONGso1CXrkLPuHhTz0Mt6i', '1536196861', '1536196861', '1536196861', '1.195.33.114', '1', '0', null, null, null, null);
INSERT INTO `vae_user` VALUES ('23', '', '', null, 'oJJQr5FRuGcoxjUA3KBOXxl-E-CU', 'TJYlsVWzvXUnSmHpja8dcD7g2ix9GB0AeQOE56ur1fCohNbKR4', '1536732731', '1537493378', '1537494686', '1.195.33.197', '259', '0', '卟咚', '15039097443', '410781199004270811', '鞍山市大所多');
