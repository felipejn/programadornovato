SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `prognovato`
--
CREATE DATABASE IF NOT EXISTS `prognovato` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `prognovato`;

DELIMITER $$
--
-- Procedures
--
CREATE PROCEDURE `sp_post_delete` (IN `pidpost` INT(11))  BEGIN

	DELETE FROM tb_poststags WHERE idpost = pidpost;
    
    DELETE FROM tb_posts WHERE idpost = pidpost;
    
END$$

CREATE PROCEDURE `sp_post_new` (IN `piduser` INT(11), IN `pdesurl` VARCHAR(255), IN `pdeslink` VARCHAR(255), IN `pdesimage` VARCHAR(255), IN `pdestittle` VARCHAR(255), IN `pdestext` TEXT, IN `pdespub` VARCHAR(5))  BEGIN
  
  DECLARE vidpost INT;
   
 INSERT INTO tb_posts (iduser, desurl, deslink, desimage, destittle, destext, despub)
   VALUES(piduser, pdesurl, pdeslink, pdesimage, pdestittle, pdestext, pdespub);
   
   SET vidpost = LAST_INSERT_ID();
   
   SELECT * FROM tb_posts WHERE idpost = LAST_INSERT_ID();
   
END$$

CREATE PROCEDURE `sp_post_update` (IN `pidpost` INT(11), IN `piduser` INT(11), IN `pdesurl` VARCHAR(255), IN `pdeslink` VARCHAR(255), IN `pdesimage` VARCHAR(255), IN `pdestittle` VARCHAR(255), IN `pdestext` TEXT, IN `pdespub` TINYINT(1))  BEGIN

    UPDATE tb_posts 
    SET iduser = piduser, 
    	desurl = pdesurl, 
    	deslink = pdeslink, 
        desimage = pdesimage, 
        destittle = pdestittle, 
        destext = pdestext,
        despub = pdespub
    WHERE idpost = pidpost;
   
   SELECT * FROM tb_posts WHERE idpost = pidpost;
   
END$$

CREATE PROCEDURE `sp_set_recovery` (IN `piduser` INT(11))  NO SQL
BEGIN

	DECLARE vidpost int; 
    
    INSERT INTO tb_pswdrecovery (iduser) VALUES(piduser);
    
    SET vidpost = LAST_INSERT_ID();
    
    SELECT * FROM tb_pswdrecovery WHERE idrecovery = LAST_INSERT_ID();
    
END$$

CREATE PROCEDURE `sp_user_new` (IN `pdesname` VARCHAR(50), IN `pdesemail` VARCHAR(50), IN `pdespassword` VARCHAR(255))  BEGIN
  
    DECLARE viduser INT;
    
  INSERT INTO tb_users (desname, desemail, despassword)
    VALUES(pdesname, pdesemail, pdespassword);
    
    SET viduser = LAST_INSERT_ID();
    
    SELECT * FROM tb_users WHERE iduser = LAST_INSERT_ID();
    
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tb_posts`
--

CREATE TABLE `tb_posts` (
  `idpost` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `desurl` varchar(255) NOT NULL,
  `deslink` varchar(255) DEFAULT NULL,
  `desimage` varchar(255) DEFAULT NULL,
  `destittle` varchar(255) DEFAULT NULL,
  `destext` text,
  `despub` varchar(15) DEFAULT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_posts`
--

INSERT INTO `tb_posts` (`idpost`, `iduser`, `desurl`, `deslink`, `desimage`, `destittle`, `destext`, `despub`, `dtregister`) VALUES
(33, 12, 'apresentacao-hello-world', '', NULL, 'Apresentação: Hello World!', '<p>Ol&aacute; pessoal!<strong> </strong>Vou falar um pouco sobre mim... tenho 38 anos, brasileiro, morando em Braga - Portugal, filho de programador e tenho dois irm&atilde;os programadores. Apesar de ter ido pro lado da m&uacute;sica (sou baixista profissional), sempre fui entusiasta de programa&ccedil;&atilde;o e inform&aacute;tica em geral. Quando fiz uma disciplina de Introdu&ccedil;&atilde;o &agrave; Ci&ecirc;ncia da Computa&ccedil;&atilde;o durante o curso de Meteorologia ( que eu n&atilde;o terminei :-/&nbsp;), aprendi um pouco sobre a linguagem C e isso despertou de novo a vontade de trabalhar com programa&ccedil;&atilde;o.</p><p>Voltando para o presente, recentemente fiz um curso de PHP 7 atrav&eacute;s da plataforma Udemy e resolvi criar esse blog para dividir um pouco o conhecimento que adquiri de l&aacute; pra c&aacute; e tamb&eacute;m para praticar. Aos poucos irei implementar coisa novas e comentarei sobre isso. Espero que seja &uacute;til para algu&eacute;m.</p><p>Esse blog foi escrito em PHP 7 e utilizei Slim Framework V2, RainTPL, Composer, MySql, CK Editor 4 e PHPMailer. O c&oacute;digo&nbsp;desse projeto pode ser encontrado na minha p&aacute;gina no GitHub.</p><p>Felipe Nascimento.</p>', '1', '2020-05-17 21:57:23'),
(37, 12, 'post-para-testar-pagina-1', '', NULL, 'Post para testar pagina 1', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Dictum non consectetur a erat nam at. Nulla aliquet porttitor lacus luctus accumsan tortor posuere ac ut. Enim ut tellus elementum sagittis vitae et. Orci eu lobortis elementum nibh tellus molestie. Id donec ultrices tincidunt arcu. Diam sit amet nisl suscipit adipiscing bibendum est ultricies. Pharetra vel turpis nunc eget lorem. In vitae turpis massa sed. Ac tincidunt vitae semper quis lectus nulla. Aliquam purus sit amet luctus venenatis. Sit amet aliquam id diam maecenas ultricies mi eget mauris. Et malesuada fames ac turpis egestas sed tempus. Ac ut consequat semper viverra nam libero. Risus in hendrerit gravida rutrum quisque non tellus. Hendrerit dolor magna eget est lorem ipsum dolor sit. Tristique magna sit amet purus gravida quis blandit.', '', '2020-05-23 17:46:30'),
(38, 12, 'post-para-testar-pagina-2', '', NULL, 'Post para testar pagina 2', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Dictum non consectetur a erat nam at. Nulla aliquet porttitor lacus luctus accumsan tortor posuere ac ut. Enim ut tellus elementum sagittis vitae et. Orci eu lobortis elementum nibh tellus molestie. Id donec ultrices tincidunt arcu. Diam sit amet nisl suscipit adipiscing bibendum est ultricies. Pharetra vel turpis nunc eget lorem. In vitae turpis massa sed. Ac tincidunt vitae semper quis lectus nulla. Aliquam purus sit amet luctus venenatis. Sit amet aliquam id diam maecenas ultricies mi eget mauris. Et malesuada fames ac turpis egestas sed tempus. Ac ut consequat semper viverra nam libero. Risus in hendrerit gravida rutrum quisque non tellus. Hendrerit dolor magna eget est lorem ipsum dolor sit. Tristique magna sit amet purus gravida quis blandit.', '', '2020-05-23 17:46:49');

-- --------------------------------------------------------

--
-- Table structure for table `tb_poststags`
--

CREATE TABLE `tb_poststags` (
  `idpost` int(11) NOT NULL,
  `idtag` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_poststags`
--

INSERT INTO `tb_poststags` (`idpost`, `idtag`) VALUES
(37, 1),
(38, 1),
(38, 2),
(37, 4);

-- --------------------------------------------------------

--
-- Table structure for table `tb_pswdrecovery`
--

CREATE TABLE `tb_pswdrecovery` (
  `idrecovery` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `dtrecovery` varchar(50) DEFAULT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_pswdrecovery`
--

INSERT INTO `tb_pswdrecovery` (`idrecovery`, `iduser`, `dtrecovery`, `dtregister`) VALUES
(1, 12, '2020-06-02 23:11:34', '2020-06-02 22:11:02'),
(2, 12, NULL, '2020-05-30 16:17:09'),
(3, 13, NULL, '2020-05-30 16:17:31'),
(4, 13, NULL, '2020-05-30 16:21:32'),
(5, 13, NULL, '2020-05-30 16:33:12'),
(6, 12, NULL, '2020-05-31 10:41:50'),
(7, 12, NULL, '2020-05-31 10:46:08'),
(8, 13, NULL, '2020-05-31 10:46:23'),
(9, 13, NULL, '2020-05-31 10:56:41'),
(10, 12, NULL, '2020-05-31 19:24:04'),
(11, 12, NULL, '2020-05-31 19:27:07'),
(12, 12, NULL, '2020-05-31 19:27:46'),
(13, 12, NULL, '2020-05-31 19:28:57'),
(14, 12, NULL, '2020-05-31 19:31:52'),
(15, 12, NULL, '2020-05-31 19:39:01'),
(16, 12, NULL, '2020-05-31 19:39:46'),
(17, 12, NULL, '2020-05-31 19:39:48'),
(18, 12, NULL, '2020-05-31 19:39:53'),
(19, 12, NULL, '2020-06-01 17:11:54'),
(20, 12, NULL, '2020-06-01 17:28:23'),
(21, 12, NULL, '2020-06-01 17:30:11'),
(22, 12, NULL, '2020-06-01 17:32:13'),
(23, 12, NULL, '2020-06-01 17:34:10'),
(24, 12, NULL, '2020-06-01 17:41:20'),
(25, 12, NULL, '2020-06-01 17:42:01'),
(26, 12, NULL, '2020-06-01 17:43:19'),
(27, 12, NULL, '2020-06-01 17:49:03'),
(28, 12, NULL, '2020-06-01 17:52:06'),
(29, 12, NULL, '2020-06-01 17:52:37'),
(30, 12, NULL, '2020-06-01 17:55:28'),
(31, 12, NULL, '2020-06-01 17:57:24'),
(32, 12, NULL, '2020-06-01 18:21:06'),
(33, 12, NULL, '2020-06-01 18:22:21'),
(34, 12, NULL, '2020-06-01 18:26:53'),
(35, 12, NULL, '2020-06-01 18:29:20'),
(36, 12, NULL, '2020-06-01 18:30:21'),
(37, 12, NULL, '2020-06-01 18:39:09'),
(38, 12, NULL, '2020-06-01 19:16:35'),
(39, 12, NULL, '2020-06-01 21:40:26'),
(40, 12, NULL, '2020-06-01 21:42:02'),
(41, 12, NULL, '2020-06-01 21:44:22'),
(42, 12, NULL, '2020-06-01 21:45:57'),
(43, 12, NULL, '2020-06-01 21:48:23'),
(44, 12, NULL, '2020-06-01 21:52:04'),
(45, 12, NULL, '2020-06-01 21:53:00'),
(46, 12, NULL, '2020-06-01 21:54:33'),
(47, 12, NULL, '2020-06-01 21:55:16'),
(48, 12, NULL, '2020-06-02 16:59:06'),
(49, 12, NULL, '2020-06-02 16:59:47'),
(50, 13, NULL, '2020-06-02 17:00:55'),
(51, 12, NULL, '2020-06-02 17:01:50'),
(52, 12, NULL, '2020-06-02 19:34:28'),
(53, 12, NULL, '2020-06-02 19:39:37'),
(54, 12, NULL, '2020-06-02 19:49:47'),
(55, 12, NULL, '2020-06-02 20:52:47'),
(56, 12, NULL, '2020-06-02 21:14:03'),
(57, 12, NULL, '2020-06-02 21:21:10'),
(58, 12, NULL, '2020-06-02 21:58:54'),
(59, 12, '2020-06-03 18:23:30', '2020-06-03 17:22:25'),
(60, 12, '2020-06-03 18:30:19', '2020-06-03 17:29:33'),
(61, 12, '2020-06-03 18:34:01', '2020-06-03 17:33:51'),
(62, 12, '2020-06-03 18:45:54', '2020-06-03 17:39:22'),
(63, 12, NULL, '2020-06-03 17:57:12'),
(64, 12, NULL, '2020-06-03 18:52:51'),
(65, 12, NULL, '2020-06-03 18:53:30'),
(66, 12, NULL, '2020-06-03 18:53:34'),
(67, 12, NULL, '2020-06-03 18:54:30'),
(68, 12, NULL, '2020-06-03 19:01:17'),
(69, 12, NULL, '2020-06-03 19:01:27'),
(70, 12, '2020-06-03 20:39:01', '2020-06-03 19:36:12');

-- --------------------------------------------------------

--
-- Table structure for table `tb_subscribers`
--

CREATE TABLE `tb_subscribers` (
  `idsubscriber` int(4) NOT NULL,
  `dessubscriber` varchar(50) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_subscribers`
--

INSERT INTO `tb_subscribers` (`idsubscriber`, `dessubscriber`, `dtregister`) VALUES
(1, 'felipejn@gmail.com', '2020-05-26 19:23:56'),
(2, 'felipejn@email.com', '2020-05-27 14:08:12');

-- --------------------------------------------------------

--
-- Table structure for table `tb_tags`
--

CREATE TABLE `tb_tags` (
  `idtag` int(11) NOT NULL,
  `destag` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_tags`
--

INSERT INTO `tb_tags` (`idtag`, `destag`) VALUES
(1, 'PHP'),
(2, 'SQL'),
(4, 'HTML'),
(5, 'CSS'),
(6, 'JavaScript'),
(7, 'Github');

-- --------------------------------------------------------

--
-- Table structure for table `tb_users`
--

CREATE TABLE `tb_users` (
  `iduser` int(11) NOT NULL,
  `desname` varchar(50) NOT NULL,
  `desemail` varchar(50) NOT NULL,
  `despassword` varchar(255) NOT NULL,
  `desadmin` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_users`
--

INSERT INTO `tb_users` (`iduser`, `desname`, `desemail`, `despassword`, `desadmin`) VALUES
(12, 'Felipe Nascimento', 'felipejn@gmail.com', '$2y$12$TSCjYB1ETCtKIKTk0y9xfuux0vMK.yiO9Q4CNPOeaHt35RRj6X4w6', NULL),
(13, 'Scheila Soares Nascimento', 'scheilacsn@gmail.com', '$2y$12$6LIQgBuZ8zexk/lgS99/y.km86bQFSnRYucTfa.6GuJB/LjzaKROq', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_posts`
--
ALTER TABLE `tb_posts`
  ADD PRIMARY KEY (`idpost`),
  ADD KEY `fk_posts_users` (`iduser`);

--
-- Indexes for table `tb_poststags`
--
ALTER TABLE `tb_poststags`
  ADD PRIMARY KEY (`idpost`,`idtag`),
  ADD KEY `fk_tags` (`idtag`);

--
-- Indexes for table `tb_pswdrecovery`
--
ALTER TABLE `tb_pswdrecovery`
  ADD PRIMARY KEY (`idrecovery`),
  ADD KEY `fk_recovery_user` (`iduser`);

--
-- Indexes for table `tb_subscribers`
--
ALTER TABLE `tb_subscribers`
  ADD PRIMARY KEY (`idsubscriber`);

--
-- Indexes for table `tb_tags`
--
ALTER TABLE `tb_tags`
  ADD PRIMARY KEY (`idtag`);

--
-- Indexes for table `tb_users`
--
ALTER TABLE `tb_users`
  ADD PRIMARY KEY (`iduser`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_posts`
--
ALTER TABLE `tb_posts`
  MODIFY `idpost` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `tb_pswdrecovery`
--
ALTER TABLE `tb_pswdrecovery`
  MODIFY `idrecovery` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `tb_subscribers`
--
ALTER TABLE `tb_subscribers`
  MODIFY `idsubscriber` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_tags`
--
ALTER TABLE `tb_tags`
  MODIFY `idtag` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `iduser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_posts`
--
ALTER TABLE `tb_posts`
  ADD CONSTRAINT `fk_posts_users` FOREIGN KEY (`iduser`) REFERENCES `tb_users` (`iduser`);

--
-- Constraints for table `tb_poststags`
--
ALTER TABLE `tb_poststags`
  ADD CONSTRAINT `fk_posts` FOREIGN KEY (`idpost`) REFERENCES `tb_posts` (`idpost`),
  ADD CONSTRAINT `fk_tags` FOREIGN KEY (`idtag`) REFERENCES `tb_tags` (`idtag`);

--
-- Constraints for table `tb_pswdrecovery`
--
ALTER TABLE `tb_pswdrecovery`
  ADD CONSTRAINT `fk_recovery_user` FOREIGN KEY (`iduser`) REFERENCES `tb_users` (`iduser`);
