/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : itkee_git

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

*/

SET FOREIGN_KEY_CHECKS=0;

update `itkee_article` set cid='1' where id='1';
DELETE FROM `itkee_auth_group` WHERE id = '2';
DELETE FROM `itkee_auth_group` WHERE id = '3';
DELETE FROM `itkee_auth_group_access` WHERE uid != '1';