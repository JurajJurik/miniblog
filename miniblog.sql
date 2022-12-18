-- Adminer 4.8.1 MySQL 5.7.24 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

USE `miniblog`;

CREATE TABLE `comments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL DEFAULT '0',
  `post_id` int(11) unsigned NOT NULL,
  `text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `phpauth_attempts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` char(39) NOT NULL,
  `expiredate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ip` (`ip`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `phpauth_config` (
  `setting` varchar(100) NOT NULL,
  `value` varchar(100) DEFAULT NULL,
  UNIQUE KEY `setting` (`setting`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `phpauth_config` (`setting`, `value`) VALUES
('allow_concurrent_sessions',	'0'),
('attack_mitigation_time',	'+30 minutes'),
('attempts_before_ban',	'30'),
('attempts_before_verify',	'5'),
('bcrypt_cost',	'10'),
('cookie_domain',	NULL),
('cookie_forget',	'+30 minutes'),
('cookie_http',	'1'),
('cookie_name',	'phpauth_session_cookie'),
('cookie_path',	'/'),
('cookie_remember',	'+1 month'),
('cookie_renew',	'+5 minutes'),
('cookie_samesite',	'Strict'),
('cookie_secure',	'1'),
('custom_datetime_format',	'Y-m-d H:i'),
('emailmessage_suppress_activation',	'0'),
('emailmessage_suppress_reset',	'0'),
('mail_charset',	'UTF-8'),
('password_min_score',	'3'),
('recaptcha_enabled',	'0'),
('recaptcha_secret_key',	''),
('recaptcha_site_key',	''),
('request_key_expiration',	'+10 minutes'),
('site_activation_page',	'activate'),
('site_activation_page_append_code',	'0'),
('site_email',	'no-reply@phpauth.cuonic.com'),
('site_key',	'fghuior.)/!/jdUkd8s2!7HVHG7777ghg'),
('site_language',	'en_GB'),
('site_name',	'PHPAuth'),
('site_password_reset_page',	'reset'),
('site_password_reset_page_append_code',	'0'),
('site_timezone',	'Europe/Paris'),
('site_url',	'https://github.com/PHPAuth/PHPAuth'),
('smtp',	'0'),
('smtp_auth',	'1'),
('smtp_debug',	'0'),
('smtp_host',	'smtp.example.com'),
('smtp_password',	'password'),
('smtp_port',	'25'),
('smtp_security',	NULL),
('smtp_username',	'email@example.com'),
('table_attempts',	'phpauth_attempts'),
('table_emails_banned',	'phpauth_emails_banned'),
('table_requests',	'phpauth_requests'),
('table_sessions',	'phpauth_sessions'),
('table_translations',	'phpauth_translation_dictionary'),
('table_users',	'phpauth_users'),
('translation_source',	'php'),
('verify_email_max_length',	'100'),
('verify_email_min_length',	'5'),
('verify_email_use_banlist',	'1'),
('verify_password_min_length',	'3');

CREATE TABLE `phpauth_emails_banned` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `domain` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `phpauth_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `token` char(20) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `expire` datetime NOT NULL,
  `type` enum('activation','reset') CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  KEY `token` (`token`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `phpauth_sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `hash` char(40) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `expiredate` datetime NOT NULL,
  `ip` varchar(39) NOT NULL,
  `device_id` varchar(36) DEFAULT NULL,
  `agent` varchar(200) NOT NULL,
  `cookie_crc` char(40) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

INSERT INTO `phpauth_sessions` (`id`, `uid`, `hash`, `expiredate`, `ip`, `device_id`, `agent`, `cookie_crc`) VALUES
(7,	3,	'c5d89a85dbb5781701eddb0fe051dec09b4d0755',	'2022-07-04 19:52:57',	'127.0.0.1',	NULL,	'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:102.0) Gecko/20100101 Firefox/102.0',	'ffb1cfae999f229ebb265ca9a7b2f5982d691525'),
(24,	2,	'841cc280172ecbf3c46b2c13889bad64cf8f9bc2',	'2022-10-23 23:09:39',	'127.0.0.1',	NULL,	'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:105.0) Gecko/20100101 Firefox/105.0',	'5fecf9e595273f8da3618147ef99946137c558f4');

CREATE TABLE `phpauth_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `isactive` tinyint(1) NOT NULL DEFAULT '0',
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

INSERT INTO `phpauth_users` (`id`, `email`, `password`, `isactive`, `dt`) VALUES
(2,	'bla@bla.sk',	'$2y$10$/PWXYihNg9KZkVHnAmhL7ugEyI1JgUxj4SXBHKPqPoE70FK8uztN2',	1,	'2022-05-03 06:51:33'),
(3,	'ble@bla.sk',	'$2y$10$22NZKJkP5w8TX7s03xyN1.p.ltUcbAviQ9.0brFQSOCWIPSBH2Mf.',	1,	'2022-05-05 13:58:09');

CREATE TABLE `posts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL DEFAULT '0',
  `title` char(200) NOT NULL,
  `text` text NOT NULL,
  `slug` varchar(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

INSERT INTO `posts` (`id`, `user_id`, `title`, `text`, `slug`, `created_at`, `updated_at`) VALUES
(1,	2,	'This is a title',	'Soufflé toffee powder macaroon dessert. https://www.youtube.com/watch?v=xxb5AS08r0Y&list=RDxxb5AS08r0Y&start_radio=1 Soufflé powder dragée dragée gummi bears. Jelly-o macaroon caramels jelly-o lollipop jelly beans. Cake gummi bears fruitcake bonbon cake chocolate cake.\r\nFruitcake bonbon jujubes gingerbread icing. Brownie cake carrot cake cotton candy sesame snaps. Jujubes biscuit jelly-o croissant gingerbread liquorice halvah toffee gummi bears.\r\nJelly beans oat cake biscuit halvah halvah chocolate tiramisu wafer. Dessert lollipop icing brownie sweet roll sweet roll powder ice cream marshmallow. Jelly-o marshmallow soufflé cotton candy gingerbread caramels cookie fruitcake. Sweet wafer jelly beans chocolate cake chocolate cake marzipan chocolate.',	'this-is-a-title',	'2022-06-14 19:07:01',	'2022-06-14 19:07:01'),
(2,	3,	'Cheesecake macaroon gummi bears',	'Cheesecake macaroon gummi bears cotton candy sesame snaps carrot cake sweet roll dessert halvah. Muffin fruitcake pie donut apple pie gingerbread fruitcake fruitcake. Lollipop sugar plum pudding sweet roll macaroon chocolate cake caramels pie candy canes.\r\nLollipop jujubes carrot cake carrot cake lollipop gingerbread. Gingerbread marshmallow cookie fruitcake bear claw chocolate cake lemon drops topping gummi bears. Liquorice shortbread cupcake toffee croissant. Tart jelly beans chocolate bar cheesecake sweet toffee soufflé.\r\nCake bear claw tart lemon drops bear claw carrot cake ice cream. Sesame snaps danish apple pie lemon drops chocolate cotton candy chocolate bar. Danish sesame snaps halvah brownie soufflé. Wafer fruitcake sweet fruitcake macaroon liquorice.',	'cheesecake-macaroon-gummi-bears',	'2022-03-31 09:05:03',	'2022-06-14 19:16:25'),
(3,	3,	'Chocolate toffee brownie dragée',	'Chocolate toffee brownie dragée toffee cake croissant. Danish cake pudding bonbon brownie dessert pastry. Chocolate sweet roll candy toffee gummies. Soufflé jelly beans lollipop chocolate cake gummies. Ice cream cake croissant cookie liquorice jelly-o dessert. Cake cotton candy cake pastry ice cream gingerbread. Wafer sesame snaps apple pie sugar plum topping.\r\nTootsie roll cookie topping pie ice cream chocolate gummi bears wafer muffin. Ice cream ice cream chocolate bar jujubes pie gummi bears. Sweet cookie powder pastry lollipop biscuit pie marshmallow. Toffee cookie soufflé candy pastry jelly-o candy canes.\r\nJelly beans bonbon bear claw donut powder cupcake liquorice. Shortbread donut jelly-o ice cream tart dragée. Biscuit biscuit dragée gingerbread cake.',	'chocolate-toffee-brownie-dragée',	'2022-03-15 10:42:07',	'2022-06-14 19:16:57'),
(4,	3,	'Fruitcake bonbon jujubesss',	'Soufflé toffee powder macaroon dessert. Soufflé powder dragée dragée gummi bears. Jelly-o macaroon caramels jelly-o lollipop jelly beans. Cake gummi bears fruitcake bonbon cake chocolate cake.\r\nFruitcake bonbon jujubes gingerbread icing. Brownie cake carrot cake cotton candy sesame snaps. Jujubes biscuit jelly-o croissant gingerbread liquorice halvah toffee gummi bears.\r\nJelly beans oat cake biscuit halvah halvah chocolate tiramisu wafer. Dessert lollipop icing brownie sweet roll sweet roll powder ice cream marshmallow. Jelly-o marshmallow soufflé cotton candy gingerbread caramels cookie fruitcake. Sweet wafer jelly beans chocolate cake chocolate cake marzipan chocolate.',	'fruitcake-bonbon-jujubes',	'2022-04-15 13:16:20',	'2022-05-05 13:44:54'),
(5,	0,	'title',	'text',	'title',	'2022-07-06 13:52:28',	'2022-07-06 13:52:28');

DELIMITER ;;

CREATE TRIGGER `posts_create` BEFORE INSERT ON `posts` FOR EACH ROW
set NEW.created_at = NOW(), NEW.updated_at = NOW();;

CREATE TRIGGER `posts_update` BEFORE UPDATE ON `posts` FOR EACH ROW
set NEW.updated_at = NOW(), NEW.created_at = OLD.created_at;;

DELIMITER ;

CREATE TABLE `posts_tags` (
  `post_id` int(11) unsigned NOT NULL DEFAULT '0',
  `tag_id` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`post_id`,`tag_id`),
  KEY `tag_id` (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `posts_tags` (`post_id`, `tag_id`) VALUES
(2,	1),
(1,	4),
(2,	4),
(4,	4),
(5,	4);

CREATE TABLE `tags` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tag` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

INSERT INTO `tags` (`id`, `tag`) VALUES
(1,	'candy'),
(2,	'sweets'),
(3,	'cake'),
(4,	'cheesecake');

-- 2022-12-18 23:25:36
