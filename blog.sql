#管理员表
create table blog_user(
uid int auto_increment primary key,
username char(30) not null default '',
password char(255) not null default''
)engine=myisam default charset=utf8;

#文章栏目表
create table blog_category(
cate_id int auto_increment primary key,
cate_name char(50) not null default '',
cate_title varchar(255) not null default '',
cate_keywords varchar(255) not null default'',
cate_description varchar(255) not null default '',
cate_view int unsigned not null default 0,
cate_order tinyint unsigned not null default 0,
cate_pid int unsigned not null default 0,
cate_count int unsigned not null default 0 
)engine=myisam default charset=utf8;

alter table blog_category add cate_count int unsigned not null default 0;

#文章表
create table blog_article(
art_id int auto_increment primary key,
cate_id int unsigned not null default 0,
art_title char(100) not null default '',
art_tag char(100) not null default '',
art_description varchar(255) not null default '',
art_thumb varchar(255) not null default '',
art_content text not null ,
art_time int unsigned not null default 0,
art_editor char(50) null null default '',
art_view int unsigned not null default 0,
art_comment int unsigned not null default 0
)engine=myisam default charset=utf8;

#demo表
create table blog_demo(
art_id int auto_increment primary key,
cate_id int unsigned not null default 0,
art_title char(100) not null default '',
art_tag char(100) not null default '',
art_description varchar(255) not null default '',
art_thumb varchar(255) not null default '',
art_content text not null ,
art_time int unsigned not null default 0,
art_editor char(50) null null default '',
art_view int unsigned not null default 0,
art_comment int unsigned not null default 0
)engine=myisam default charset=utf8;

#系统文章表
create table blog_notice(
art_id int auto_increment primary key,
art_title char(100) not null default '',
art_tag char(100) not null default '',
art_description varchar(255) not null default '',
art_content text not null ,
art_time int unsigned not null default 0,
art_editor char(50) null null default '',
art_view int unsigned not null default 0
)engine=myisam default charset=utf8;

alter table blog_notice add art_description varchar(255) not null default '' after art_tag;


#自定义导航栏
create table blog_navs(
nav_id int auto_increment primary key,
nav_name char(20) not null default '',
nav_alias char(20) not null default '',
nav_url char(100) not null default '',
nav_order tinyint unsigned not null default 0,
pubtime int not null default 0
)engine=myisam default charset=utf8;

#配置项
create table blog_config(
conf_id int auto_increment primary key,
conf_title char(50) not null default '',
conf_name char(50) not null default '',
conf_content text not null ,
conf_order tinyint unsigned not null default 0,
conf_tips varchar(255) not null default '',
field_type char(50) not null default '',
field_value varchar(255) not null default ''
)engine=myisam default charset=utf8;

#友情链接
create table blog_links(
link_id int auto_increment primary key,
link_title varchar(255) not null default '',
link_name char(50) not null default '',
link_url varchar(255) not null default '',
link_order tinyint unsigned not null default 0,
pubtime int unsigned not null default 0
)engine=myisam default charset=utf8;

#评论表
CREATE TABLE IF NOT EXISTS `blog_comment` (
  `comment_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `art_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `nick` char(45) NOT NULL DEFAULT '',
  'email' char(50) not null default '',
  `content` text NOT NULL ,
  `ip` int(10) unsigned NOT NULL DEFAULT '0',
  `pubtime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`comment_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;


create table blog_comment(
comment_id int auto_increment primary key,
art_id int unsigned not null default 0,
user_id int unsigned not null default 0,
nick char(50) not null default '',
email char(50) not null default '',
content text not null,
ip int unsigned not null default 0,
pubtime int unsigned not null default 0
)engine=myisam default charset=utf8;

alter table blog_comment add parent_id int unsigned not null default 0 after content;
alter table blog_comment add reply_to int unsigned not null default 0 after content;
#增加给谁评论 reply_to_name
alter table blog_comment add reply_to_name char(20) not null default '' after reply_to;


#用户表
create table blog_member(
member_id int auto_increment primary key,
username char(30) not null default '',
email char(50) not null default '',
password char(255) not null default '',
register_at int not null default 0,
lastlogin int not null default 0
)engine=myisam default charset=utf8;