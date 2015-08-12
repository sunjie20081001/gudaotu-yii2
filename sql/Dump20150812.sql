CREATE DATABASE  IF NOT EXISTS `gudao` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `gudao`;
-- MySQL dump 10.13  Distrib 5.5.44, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: gudao
-- ------------------------------------------------------
-- Server version	5.5.44-0ubuntu0.14.10.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `gd_comment`
--

DROP TABLE IF EXISTS `gd_comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gd_comment` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` int(11) NOT NULL COMMENT '创建时间',
  `updated_at` int(11) NOT NULL COMMENT '更新时间',
  `content` text COMMENT '评论内容',
  `user_id` bigint(20) unsigned DEFAULT NULL COMMENT '评论用户',
  `ip` varchar(255) DEFAULT NULL COMMENT '评论IP',
  `parent_id` bigint(20) unsigned DEFAULT NULL COMMENT '父评论',
  `agent` varchar(255) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_gd_comment_1_idx` (`parent_id`),
  KEY `fk_gd_comment_2_idx` (`user_id`),
  CONSTRAINT `fk_gd_comment_1` FOREIGN KEY (`parent_id`) REFERENCES `gd_comment` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_gd_comment_2` FOREIGN KEY (`user_id`) REFERENCES `gd_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `gd_post`
--

DROP TABLE IF EXISTS `gd_post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gd_post` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` int(11) unsigned NOT NULL COMMENT '创建时间',
  `updated_at` int(11) unsigned NOT NULL COMMENT '更新时间',
  `user_id` bigint(20) unsigned NOT NULL COMMENT '作者',
  `term_id` bigint(20) unsigned NOT NULL COMMENT '文章分类',
  `title` text NOT NULL COMMENT '标题',
  `keyword` varchar(45) DEFAULT NULL COMMENT '关键词',
  `content` text NOT NULL COMMENT '内容',
  `excerpt` text NOT NULL COMMENT '简介',
  `status` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '文章状态',
  `comment_status` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '评论状态',
  `comment_count` varchar(255) NOT NULL COMMENT '评论数量',
  `view_count` bigint(20) unsigned DEFAULT '0',
  `good` int(11) unsigned DEFAULT NULL,
  `bad` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_gd_post_1_idx` (`user_id`),
  KEY `fk_gd_post_2_idx` (`term_id`),
  CONSTRAINT `fk_gd_post_1` FOREIGN KEY (`user_id`) REFERENCES `gd_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_gd_post_2` FOREIGN KEY (`term_id`) REFERENCES `gd_term` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `gd_term`
--

DROP TABLE IF EXISTS `gd_term`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gd_term` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `title` text COMMENT '标题',
  `slug` varchar(255) NOT NULL COMMENT '短标签',
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug_UNIQUE` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `gd_user`
--

DROP TABLE IF EXISTS `gd_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gd_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` int(11) NOT NULL COMMENT '创建时间',
  `updated_at` int(11) NOT NULL COMMENT '更新时间',
  `username` varchar(255) NOT NULL COMMENT '用户名',
  `password` varchar(255) NOT NULL COMMENT '密码',
  `email` varchar(255) DEFAULT NULL COMMENT '电子邮件',
  `display_name` varchar(255) DEFAULT NULL COMMENT '显示名',
  `avatar` varchar(45) DEFAULT NULL COMMENT '头像地址',
  `status` smallint(6) unsigned DEFAULT '1' COMMENT '状态',
  `role` smallint(6) unsigned DEFAULT '10' COMMENT '角色',
  `notification_count` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-08-12 19:08:41
