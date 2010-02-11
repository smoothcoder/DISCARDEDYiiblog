-- phpMyAdmin SQL Dump
-- version 2.11.9.4
-- http://www.phpmyadmin.net
--
-- Serveur: mysql.cochizz.com
-- Généré le : Jeu 11 Février 2010 à 08:23
-- Version du serveur: 5.0.67
-- Version de PHP: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `discarded_d1`
--

-- --------------------------------------------------------

--
-- Structure de la table `Bookmark`
--

CREATE TABLE IF NOT EXISTS `Bookmark` (
  `id` int(11) NOT NULL auto_increment,
  `postId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `FK_bookmark_post` (`postId`),
  KEY `FK_bookmark_user` (`userId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

--
-- Contenu de la table `Bookmark`
--

INSERT INTO `Bookmark` (`id`, `postId`, `userId`) VALUES
(1, 1, 1),
(24, 4, 2),
(26, 2, 1),
(27, 4, 1),
(28, 7, 1);

-- --------------------------------------------------------

--
-- Structure de la table `Category`
--

CREATE TABLE IF NOT EXISTS `Category` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(64) NOT NULL,
  `slug` varchar(32) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `Category`
--

INSERT INTO `Category` (`id`, `name`, `slug`) VALUES
(1, 'news', 'news'),
(2, 'culture', 'culture'),
(3, 'Sports', 'sports'),
(5, 'No category', 'no-category');

-- --------------------------------------------------------

--
-- Structure de la table `Comment`
--

CREATE TABLE IF NOT EXISTS `Comment` (
  `id` int(11) NOT NULL auto_increment,
  `content` text NOT NULL,
  `contentDisplay` text,
  `status` int(11) NOT NULL,
  `spam` tinyint(4) default NULL,
  `createTime` int(11) default NULL,
  `authorName` varchar(50) NOT NULL,
  `email` varchar(64) NOT NULL,
  `url` varchar(128) NOT NULL,
  `postId` int(11) NOT NULL,
  `authorId` int(11) default NULL,
  `authorIP` varchar(64) default NULL,
  PRIMARY KEY  (`id`),
  KEY `FK_comment_post` (`postId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=39 ;

--
-- Contenu de la table `Comment`
--

INSERT INTO `Comment` (`id`, `content`, `contentDisplay`, `status`, `spam`, `createTime`, `authorName`, `email`, `url`, `postId`, `authorId`, `authorIP`) VALUES
(37, '<p>What is <strong>sociable</strong> ?</p>', '<p>What is <strong>sociable</strong> ?</p>', 1, 0, 1265332904, 'demo', 'demo@gmail.com', '', 4, 2, '::ffff:192.168.1.110'),
(38, '<p>Sociable automatically add links to your favorite social bookmarking sites on your posts, pages.</p>\r\n<p>You can have more informations <a href="http://dev.discardedteenz.com/page/sociable/tag/sociable">here</a>.</p>', '<p>Sociable automatically add links to your favorite social bookmarking sites on your posts, pages.</p>\r\n<p>You can have more informations <a href="http://dev.discardedteenz.com/page/sociable/tag/sociable">here</a>.</p>', 1, 0, 1265369770, 'admin', 'smoothcoder@discardedteenz.com', '', 4, 1, '190.55.64.149');

-- --------------------------------------------------------

--
-- Structure de la table `Config`
--

CREATE TABLE IF NOT EXISTS `Config` (
  `key` varchar(100) NOT NULL,
  `value` text,
  `comment` varchar(256) NOT NULL,
  PRIMARY KEY  (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Config`
--

INSERT INTO `Config` (`key`, `value`, `comment`) VALUES
('avatarpath', 's:61:"/home/marie/DEV/moira2/protected/config/../../uploads/avatar/";', ''),
('filepath', 's:59:"/home/marie/DEV/moira2/protected/config/../../uploads/file/";', ''),
('noavatar', 's:12:"noavatar.png";', ''),
('avatarwidth', 's:2:"64";', ''),
('avatarheight', 's:2:"64";', ''),
('title', 's:18:"DISCARDEDteenz.com";', 'Title of website'),
('description', 's:4:"Blog";', ''),
('keywords', 's:28:"Moira,book,drawings,graphics";', '');

-- --------------------------------------------------------

--
-- Structure de la table `File`
--

CREATE TABLE IF NOT EXISTS `File` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(64) NOT NULL,
  `type` varchar(32) default NULL,
  `createTime` int(11) default NULL,
  `alt` varchar(32) default NULL,
  `download` int(11) NOT NULL,
  `size` int(11) default NULL,
  `widthxheight` varchar(32) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=48 ;

--
-- Contenu de la table `File`
--

INSERT INTO `File` (`id`, `name`, `type`, `createTime`, `alt`, `download`, `size`, `widthxheight`) VALUES
(45, 'maliscotto_sm.png', 'image/png', 1265332217, 'Mali scotto adadas (small)', 0, 6791, '66x100'),
(43, 'maliscotto.png', 'image/png', 1265331907, 'Mali scotto adadas', 0, 22391, '166x250'),
(46, 'sociable_black.jpeg', 'image/jpeg', 1265382174, '', 0, 3918, '386x24'),
(47, 'sociable_white.jpeg', 'image/jpeg', 1265667197, 'sociable white', 0, 2909, '368x24');

-- --------------------------------------------------------

--
-- Structure de la table `History`
--

CREATE TABLE IF NOT EXISTS `History` (
  `id` int(11) NOT NULL auto_increment,
  `created` int(11) NOT NULL,
  `username` varchar(64) default NULL,
  `IP` varchar(64) default NULL,
  `category` varchar(64) NOT NULL,
  `file` varchar(64) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Contenu de la table `History`
--

INSERT INTO `History` (`id`, `created`, `username`, `IP`, `category`, `file`) VALUES
(5, 1263903631, 'admin', '::ffff:192.168.1.110', 'DOWNLOAD_PUBLIC', 'MoiraCover.jpg'),
(6, 1263903735, 'admin', '::ffff:192.168.1.110', 'DOWNLOAD_PUBLIC', 'MoiraCover.jpg'),
(12, 1265195491, 'admin', '::ffff:192.168.1.110', 'DOWNLOAD_PUBLIC', 'Jane2.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `Page`
--

CREATE TABLE IF NOT EXISTS `Page` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(128) NOT NULL,
  `slug` varchar(32) NOT NULL,
  `content` text NOT NULL,
  `status` int(11) NOT NULL,
  `createTime` int(11) default NULL,
  `updateTime` int(11) default NULL,
  `authorId` int(11) NOT NULL,
  `authorName` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `FK_page_author` (`authorId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Contenu de la table `Page`
--

INSERT INTO `Page` (`id`, `title`, `slug`, `content`, `status`, `createTime`, `updateTime`, `authorId`, `authorName`) VALUES
(5, 'About', 'about', '<h2>\r\n	The Smooth story</h2>\r\n<p>\r\n	<strong><a class="lightbox" href="http://dev.discardedteenz.com/uploads/file123abc/maliscotto.png" rel="lightbox"><img align="left" alt="SmoothMother" height="100" hspace="10" src="http://dev.discardedteenz.com/uploads/file123abc/maliscotto_sm.png" width="66" /></a>SmoothCoder</strong> was - long, long time ago - an engineer working for the big blue company in France. Later she involved herself deeply into the rise and fall of an internet bubble company, together with her husband. She throwed in the towel to raise her children and, with her familly, <strong>SmoothMother</strong> leaved France to the far east frontier : China.</p>\r\n<p>\r\n	She enjoyed teaching French in a College in Zhuhai, China. ( Teaching, transmitting knowledge, watching the transformation of a teenager to an adult is immenselly rewarding ).</p>\r\n<p>\r\n	At that time she called herself <strong>SmoothZhuhai</strong>.</p>\r\n<p>\r\n	Then, her son returned to France for his engineering studies at the University, and her daugter Marine, on home schooling, needed to attend a real school.</p>\r\n<p>\r\n	Mmm. <strong>SmoothTraveller </strong>who didn&#39;t know a word of Spanish decided to leave to South America. After all, Spanish shouldn&#39;t be as difficult as learning Chinese ? Suree ...</p>\r\n<p>\r\n	For instance, <strong>SmoothTraveller</strong> lives in Argentina. In the meantime, Marine, her soon 18 years old daughter wrote a mystery novel for teens.</p>\r\n<p>\r\n	To support this talented artist who also writes her songs, <strong>SmoothMother</strong> decided to become <strong>SmoothCoder</strong> in order to offer <a href="http://www.discardedteenz.com/">a blog</a> to her beloved daughter.</p>\r\n<p>\r\n	<strong>SmoothCoder</strong> discovered <a href="http://www.yiiframework.com/">Yii framework</a> and rediscovered php programming. Now that she&#39;s really hooked to it, she wants to thank the <a href="http://www.yiiframework.com/">Yii framework</a> community who helped this happen.</p>\r\n<p>\r\n	With &quot;<a href="http://dev.discardedteenz.com/">dev.DISCARDEDteenz.com</a>&quot; she is going to share - humbly - all the improvements, code snippets that she brought to codes found on the web :</p>\r\n<ul>\r\n	<li>\r\n		Yiiblognew (<a href="http://code.google.com/p/yiiblognew/">http://code.google.com/p/yiiblognew/</a>)</li>\r\n	<li>\r\n		yii-blogdemo-enhanced (<a href="http://code.google.com/p/yii-blogdemo-enhanced/">http://code.google.com/p/yii-blogdemo-enhanced/</a>) with the lovely pugpugs.</li>\r\n	<li>\r\n		Sam.ca pixeled theme (<a href="http://samk.ca/freebies/pixel/">http://samk.ca/freebies/pixel/</a> )</li>\r\n</ul>\r\n', 1, 1263470101, 1265416173, 1, 'admin'),
(9, 'extensions', 'extensions', '<h1>\r\n	Extensions of DISCARDEDdev</h1>\r\n<p>\r\n	You can find here the list of extensions and a few interesting components used in this yii powered blog. The list is non exaustive.</p>\r\n<p>\r\n	Extensions</p>\r\n<ul>\r\n	<li>\r\n		fckeditor</li>\r\n	<li>\r\n		image</li>\r\n	<li>\r\n		mailer</li>\r\n	<li>\r\n		my97DatePicker</li>\r\n	<li>\r\n		WB_Email</li>\r\n	<li>\r\n		yiidebugtb</li>\r\n	<li>\r\n		Econfig (to be abandonned ??)</li>\r\n</ul>\r\n<p>\r\n	Components in the form of&nbsp; Portlets</p>\r\n<ul>\r\n	<li>\r\n		Categories</li>\r\n	<li>\r\n		Links</li>\r\n	<li>\r\n		Meta</li>\r\n	<li>\r\n		Monthly archives</li>\r\n	<li>\r\n		Popular posts</li>\r\n	<li>\r\n		Post Date</li>\r\n	<li>\r\n		Recent Comments</li>\r\n	<li>\r\n		Recent posts</li>\r\n	<li>\r\n		Site Search</li>\r\n	<li>\r\n		Tag Cloud</li>\r\n</ul>\r\n<p>\r\n	And components:</p>\r\n<ul>\r\n	<li>\r\n		Menu</li>\r\n	<li>\r\n		Sociable</li>\r\n</ul>\r\n', 1, 1265204504, 1265296406, 1, 'admin'),
(10, 'sociable', 'sociable', '<h1>\r\n	Sociable</h1>\r\n<h2>\r\n	Overview</h2>\r\n<p>\r\n	Sociable add links to your favorite social bookmarking sites on your posts and pages.</p>\r\n<p>\r\n	You can choose from many different social bookmarking sites !&nbsp;&nbsp;</p>\r\n<p>\r\n	<img alt="Sociable icons - black" height="24" src="http://dev.discardedteenz.com/uploads/file123abc/sociable_black.jpeg" width="386" /></p>\r\n<p>\r\n	<img alt="Sociable icons - black" height="24" src="http://dev.discardedteenz.com/uploads/file123abc/sociable_white.jpeg" width="386" /></p>\r\n<h2>\r\n	License</h2>\r\n<p>\r\n	Sociable for Yii is released under the GPL License</p>\r\n<h2>\r\n	Download</h2>\r\n<p>\r\n	Be patient. Soon here and back in Yii Framework , the extension which is used in DISCARDEDteenz.com.</p>\r\n<h2>\r\n	Change log</h2>\r\n<p>\r\n	Nothing.</p>\r\n<h2>\r\n	Documentation</h2>\r\n<p>\r\n	The extension has been adapted from&nbsp; the wordpress plugin Sociable ( You can find this one on <a href="http://blogplay.com/">http://blogplay.com/</a>) .</p>\r\n<p>\r\n	The adaptation for Yii is very simple (no config administration interface like in Wordpress). Just use a swiss army knife.</p>\r\n<h3>\r\n	Requirements</h3>\r\n<ul>\r\n	<li>\r\n		Yii 1.0.11 or above</li>\r\n	<li>\r\n		DISCARDEDblog model</li>\r\n</ul>\r\n<h3>\r\n	Installation</h3>\r\n<ul>\r\n	<li>\r\n		Extract the release file under <code>protected/components/sociable</code></li>\r\n</ul>\r\n<h3>\r\n	Usage</h3>\r\n<p>\r\n	See the following code example:</p>\r\n<pre style="margin-left: 40px;">&lt;?php  $this-&gt;widget(&#39;application.components.sociable.sociable&#39;,\r\n            array(\r\n                &#39;post&#39;=&gt;$post,\r\n                &#39;active_sites&#39;=&gt;array(\r\n                &#39;Print&#39;,\r\n                &#39;Digg&#39;,\r\n                &#39;豆瓣&#39;,\r\n                &#39;del.icio.us&#39;,\r\n                &#39;Facebook&#39;,\r\n                &#39;Mixx&#39;,\r\n                &#39;Google&#39;,\r\n                &#39;Twitter&#39;,\r\n                &#39;Scoopeo&#39;,\r\n                &#39;MySpace&#39;,\r\n                &#39;Posterous&#39;,\r\n                &#39;Technorati&#39;,\r\n                &#39;StumbleUpon&#39;,\r\n                &#39;Yahoo! Bookmarks&#39;,\r\n                &#39;QQ书签&#39;\r\n                    ),\r\n                )\r\n            );\r\n    ?&gt;\r\n</pre>', 1, 1265296298, 1265668072, 1, 'admin'),
(11, 'themes', 'themes', '<h1>\r\n	Themes</h1>\r\n<p>\r\n	Some interesting things about themes</p>\r\n', 1, 1265333396, 1265333435, 1, 'admin');

-- --------------------------------------------------------

--
-- Structure de la table `Post`
--

CREATE TABLE IF NOT EXISTS `Post` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(128) NOT NULL,
  `titleLink` varchar(128) default NULL,
  `slug` varchar(64) NOT NULL,
  `contentshort` text NOT NULL,
  `contentbig` text,
  `tags` text,
  `status` int(11) NOT NULL,
  `createTime` int(11) default NULL,
  `updateTime` int(11) default NULL,
  `publishTime` int(11) default NULL,
  `commentCount` int(11) default '0',
  `categoryId` int(11) default NULL,
  `authorId` int(11) NOT NULL,
  `authorName` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `FK_post_author` (`authorId`),
  KEY `FK_post_category` (`categoryId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Contenu de la table `Post`
--

INSERT INTO `Post` (`id`, `title`, `titleLink`, `slug`, `contentshort`, `contentbig`, `tags`, `status`, `createTime`, `updateTime`, `publishTime`, `commentCount`, `categoryId`, `authorId`, `authorName`) VALUES
(4, 'About the Website', NULL, 'about-the-website', '<p>In <a href="http://dev.discardedteenz.com">DISCARDEDYiiblog</a> you''ll be able to find the repository for the assembled code from <a href="http://www.yiiframework.com/">Yii framework</a> to bring <a href="http://www.discardedteenz.com/">DISCARDEDteenz</a> alive.</p>\r\n<p><a href="http://www.discardedteenz.com/">DISCARDEDteenz</a> dedicated to &quot;Mo&iuml;ra the book&quot; by Marine &nbsp; runs under yii-1.0.11</p>\r\n<p><a href="http://dev.discardedteenz.com">DISCARDEDYiiblog</a> is a skeleton port <a href="http://www.discardedteenz.com/">DISCARDEDteenz</a> and runs under yii-1.1.0.r1700. When this will be stable enough, <a href="http://dev.discardedteenz.com">DISCARDEDYiiblog</a>  will be released fully. In the meantime, I intend to publish codes and snippets here and on Yii framework''s forum. Some extensions and themes are also in preparation.</p>\r\n<p>I am in the process of building the repository on Github. Thanks for your patience for it''s not totally ready !</p>\r\n<p><br />\r\n<span style="color: rgb(153, 204, 255);"><br />\r\n</span></p>', '', 'news,coding,yii-framework', 1, 1263389366, 1265764443, 0, 2, 1, 2, 'demo'),
(9, 'DISCARDEDteenz site of the week at YiiRadiio', NULL, 'discardedteenz-site-of-the-wee', '<p>DISCARDEDteenz is site of the week on YiiRadiio.</p>\r\n<blockquote>... The site of the week is an online book. The story is about a 17 years old French American Indian girls who has spent her life travelling over the globe. Check it out atDISCARDEDteenz.com. That''s teenz with a &quot;Z&quot;.</blockquote>\r\n<p>Listen to the podcast at <a href="http://yiiradiio.mehesz.net/">http://yiiradiio.mehesz.net/</a></p>', '', 'news,coding,yii-framework', 1, 1265853134, 1265892329, 1265850000, 0, NULL, 1, 'admin');

-- --------------------------------------------------------

--
-- Structure de la table `PostTag`
--

CREATE TABLE IF NOT EXISTS `PostTag` (
  `postId` int(11) NOT NULL,
  `tagId` int(11) NOT NULL,
  PRIMARY KEY  (`postId`,`tagId`),
  KEY `FK_tag` (`tagId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `PostTag`
--

INSERT INTO `PostTag` (`postId`, `tagId`) VALUES
(4, 2),
(4, 11),
(4, 12),
(9, 2),
(9, 21),
(9, 22);

-- --------------------------------------------------------

--
-- Structure de la table `Tag`
--

CREATE TABLE IF NOT EXISTS `Tag` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(64) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Contenu de la table `Tag`
--

INSERT INTO `Tag` (`id`, `name`) VALUES
(1, 'culture'),
(2, 'news'),
(3, 'site'),
(4, 'test'),
(5, ''),
(6, ''),
(7, ''),
(8, ''),
(9, ''),
(10, ''),
(11, ''),
(12, ''),
(13, ''),
(14, ''),
(15, ''),
(16, ''),
(17, ''),
(18, ''),
(19, ''),
(20, ''),
(21, ''),
(22, '');

-- --------------------------------------------------------

--
-- Structure de la table `User`
--

CREATE TABLE IF NOT EXISTS `User` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(64) NOT NULL,
  `url` varchar(64) default NULL,
  `status` int(11) NOT NULL,
  `banned` int(11) NOT NULL,
  `avatar` varchar(20) default NULL,
  `newsletter` int(11) default NULL,
  `passwordLost` varchar(10) default NULL,
  `confirmRegistration` varchar(10) default NULL,
  `about` text,
  `created` int(11) NOT NULL,
  `lastlogin` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=47 ;

--
-- Contenu de la table `User`
--

INSERT INTO `User` (`id`, `username`, `password`, `email`, `url`, `status`, `banned`, `avatar`, `newsletter`, `passwordLost`, `confirmRegistration`, `about`, `created`, `lastlogin`) VALUES
(2, 'demo', '4904b1f95c55c93261cacba6e6dcbfd0', 'demo@gmail.com', '', 1, 0, '63xd26esth.jpeg', 0, NULL, NULL, 'I am a demonstration user .', 0, 0),
(1, 'admin', '3f9d9514a6bd8c533f482b57b6c632ed', 'smoothcoder@discardedteenz.com', 'http://dev.discardedteenz.com', 0, 0, 'm6434128xd.jpg', 1, NULL, NULL, 'Everythings going smoothly!', 0, 1263510593);
