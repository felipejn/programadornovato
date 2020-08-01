-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 05-Jul-2020 às 20:44
-- Versão do servidor: 5.6.47-cll-lve
-- versão do PHP: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `xl3vjqxg_prognovato_db`
--

DELIMITER $$
--
-- Procedimentos
--
CREATE DEFINER=`xl3vjqxg`@`localhost` PROCEDURE `sp_post_delete` (IN `pidpost` INT(11))  BEGIN

	DELETE FROM tb_poststags WHERE idpost = pidpost;
    
    DELETE FROM tb_posts WHERE idpost = pidpost;
    
END$$

CREATE DEFINER=`xl3vjqxg`@`localhost` PROCEDURE `sp_post_new` (IN `piduser` INT(11), IN `pdesurl` VARCHAR(255), IN `pdeslink` VARCHAR(255), IN `pdesimage` VARCHAR(255), IN `pdestittle` VARCHAR(255), IN `pdestext` TEXT, IN `pdespub` VARCHAR(5))  BEGIN
  
  DECLARE vidpost INT;
   
 INSERT INTO tb_posts (iduser, desurl, deslink, desimage, destittle, destext, despub)
   VALUES(piduser, pdesurl, pdeslink, pdesimage, pdestittle, pdestext, pdespub);
   
   SET vidpost = LAST_INSERT_ID();
   
   SELECT * FROM tb_posts WHERE idpost = LAST_INSERT_ID();
   
END$$

CREATE DEFINER=`xl3vjqxg`@`localhost` PROCEDURE `sp_post_update` (IN `pidpost` INT(11), IN `piduser` INT(11), IN `pdesurl` VARCHAR(255), IN `pdeslink` VARCHAR(255), IN `pdesimage` VARCHAR(255), IN `pdestittle` VARCHAR(255), IN `pdestext` TEXT, IN `pdespub` TINYINT(1))  BEGIN

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

CREATE DEFINER=`xl3vjqxg`@`localhost` PROCEDURE `sp_set_recovery` (IN `piduser` INT(11))  NO SQL
BEGIN

DECLARE vidpost int;
   
   INSERT INTO tb_pswdrecovery (iduser) VALUES(piduser);
   
   SET vidpost = LAST_INSERT_ID();
   
   SELECT * FROM tb_pswdrecovery WHERE idrecovery = LAST_INSERT_ID();
   
END$$

CREATE DEFINER=`xl3vjqxg`@`localhost` PROCEDURE `sp_user_new` (IN `pdesname` VARCHAR(50), IN `pdesemail` VARCHAR(50), IN `pdespassword` VARCHAR(255))  BEGIN
  
    DECLARE viduser INT;
    
  INSERT INTO tb_users (desname, desemail, despassword)
    VALUES(pdesname, pdesemail, pdespassword);
    
    SET viduser = LAST_INSERT_ID();
    
    SELECT * FROM tb_users WHERE iduser = LAST_INSERT_ID();
    
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_posts`
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
-- Extraindo dados da tabela `tb_posts`
--

INSERT INTO `tb_posts` (`idpost`, `iduser`, `desurl`, `deslink`, `desimage`, `destittle`, `destext`, `despub`, `dtregister`) VALUES
(33, 12, 'apresentacao-hello-world', '', NULL, 'ApresentaÃ§Ã£o: Hello World!', '<p>Ol&aacute; pessoal!<strong> </strong>Vou falar um pouco sobre mim... tenho 38 anos, brasileiro, morando em Braga - Portugal, filho de programador e tenho dois irm&atilde;os programadores. Apesar de ter ido pro lado da m&uacute;sica (sou baixista profissional), sempre fui entusiasta de programa&ccedil;&atilde;o e inform&aacute;tica em geral. Quando fiz uma disciplina de Introdu&ccedil;&atilde;o &agrave; Ci&ecirc;ncia da Computa&ccedil;&atilde;o durante o curso de Meteorologia ( que eu n&atilde;o terminei :-/&nbsp;), aprendi um pouco sobre a linguagem C e isso despertou de novo a vontade de trabalhar com programa&ccedil;&atilde;o.</p><p>Voltando para o presente, recentemente fiz um curso de PHP 7 atrav&eacute;s da plataforma Udemy e resolvi criar esse blog para dividir um pouco o conhecimento que adquiri de l&aacute; pra c&aacute; e tamb&eacute;m para praticar. Aos poucos irei implementar coisa novas e comentarei sobre isso. Espero que seja &uacute;til para algu&eacute;m.</p><p>Esse blog foi escrito em PHP 7 e utilizei Slim Framework V2, RainTPL, Composer, MySql, CK Editor 4 e PHPMailer. O c&oacute;digo&nbsp;desse projeto pode ser encontrado na minha p&aacute;gina no GitHub.</p><p>Felipe Nascimento.</p>', '1', '2020-06-06 22:00:00'),
(39, 12, 'primeiros-passos-no-mysql', 'https://www.devmedia.com.br/primeiros-passos-no-mysql/28438', NULL, 'Primeiros Passos no MySQL', '<p>Bom, vamos para a primeira publica&ccedil;&atilde;o e esta &eacute; muito boa. &Eacute; de um site que traz muito material bom e esse guia de MySQL utilizei muitas vezes durante o curso de PHP.&nbsp;</p><p>Esse artigo ensina os primeiros passos do MySQL como criar um banco de dados, criar tabelas, consultar, alterar &nbsp;e apagar. Existe&nbsp;muito material a respeito disso, mas para quem quer material em portugu&ecirc;s bem e muito bem explicado, recomendo este artigo do site DEVMEDIA.&nbsp;</p><p>Como podem perceber, n&atilde;o &eacute; um artigo meu, por&eacute;m &eacute; assim que vai funcionar aqui no blog. Alguns posts ser&atilde;o de artigos muito bons que encontrei e outros eu mesmo vou escrever. Cliquem em <strong>Leia mais</strong> para irem para o artigo.&nbsp;</p><p>&nbsp;</p>', '1', '2020-06-07 16:52:59'),
(40, 12, 'guia-pratico-para-comecar-com-o-git', 'https://rogerdudler.github.io/git-guide/index.pt_BR.html', NULL, 'Guia prÃ¡tico para comeÃ§ar com o GIT', '<p>GIT &eacute; um sistema de de controle de vers&otilde;es, usado principalmente no desenvolvimento de software, que pode registrar o hist&oacute;rico de edi&ccedil;&otilde;es em arquivos de qualquer tipo. Foi inicialmente projetado e desenvolvido por Linus Torvalds para o desenvolvimento do Kernel Linux, por&eacute;m foi adotado por muitos outros projetos. Cada&nbsp;diret&oacute;rio de trabalho&nbsp;do Git &eacute; um&nbsp;reposit&oacute;rio&nbsp;com um hist&oacute;rico completo e habilidade total de acompanhamento das revis&otilde;es, n&atilde;o dependente de acesso a uma rede ou a um servidor central. (Fonte: Wikipedia)</p><p>Essa ferramenta &eacute; cada vez mais utilizada no mundo da tecnologia e quem est&aacute; come&ccedil;ando n&atilde;o pode ficar de fora. Por isso, estou trazendo aqui esse guia feito por Roger Dudler e traduzido para diversas l&iacute;nguas, incluindo portugu&ecirc;s. Nesse guia, voc&ecirc; pode aprender de forma simples como criar e atualizar seu reposit&oacute;rio de forma simples, entre outras coisas.</p><p>Antes de mais nada, crie sua conta em alguma plataforma de hospedagem de c&oacute;digos. A mais conhecida &eacute; o GitHub, por&eacute;m existem alternativas como GitLab, BitBucket, entre outros. Crie seu reposit&oacute;rio no servidor e depois siga os passos desse guia para criar um reposit&oacute;rio local no seu computador.&nbsp;Clique em <strong>Leia mais</strong> para ir para o guia.&nbsp;</p>', '1', '2020-06-17 15:52:17'),
(41, 12, 'configurando-virtual-hosts-no-mac-e-windows', 'https://www.taniarascia.com/setting-up-virtual-hosts/', NULL, 'Configurando Virtual Hosts no Mac e Windows', '<p><strong>Hospedagem virtual</strong>, do&nbsp;ingl&ecirc;s&nbsp;<strong>Virtual hosting</strong>, &eacute; um m&eacute;todo que os&nbsp;servidores, tais como&nbsp;servidores web, utilizam para hospedar mais de um&nbsp;nome de dom&iacute;nio&nbsp;em um mesmo computador, algumas vezes no mesmo&nbsp;endere&ccedil;o IP.</p><p>No contexto do desenvolvimento web, configurar um virtual host no nosso computador pode ser indispens&aacute;vel. Por isso, trago aqui esse artigo da <a href=\"http://www.taniarascia.com\">Tania Rascia</a>&nbsp;chamado <strong>Setting Up Virtual Hosts</strong>. Quando busquei sobre o assunto, foi um dos melhores tutoriais que encontrei. Muito bem explicado, especialmente&nbsp;para usu&aacute;rios de Macs.&nbsp;</p><p>Se voc&ecirc; ainda n&atilde;o tem um servidor local Apache, pode instalar tudo de uma vez utilizando algum desses softwares: <a href=\"https://www.mamp.info/en/mac/\">MAMP</a>, <a href=\"https://www.apachefriends.org/index.html\">XAMPP</a>, <a href=\"https://pt.wikipedia.org/wiki/LAMP\">LAMP</a>, de acordo com o seu sistema operacional. O mais importante &eacute; que deve ter o Apache instalado antes de prosseguir com a configura&ccedil;&atilde;o do virtual host.&nbsp;</p><p>Clique em <strong>Leia Mais</strong> para ir para o artigo.</p>', '1', '2020-06-28 00:46:17');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_poststags`
--

CREATE TABLE `tb_poststags` (
  `idpost` int(11) NOT NULL,
  `idtag` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tb_poststags`
--

INSERT INTO `tb_poststags` (`idpost`, `idtag`) VALUES
(39, 2),
(40, 5),
(41, 6),
(41, 7);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_pswdrecovery`
--

CREATE TABLE `tb_pswdrecovery` (
  `idrecovery` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `dtrecovery` varchar(50) DEFAULT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tb_pswdrecovery`
--

INSERT INTO `tb_pswdrecovery` (`idrecovery`, `iduser`, `dtrecovery`, `dtregister`) VALUES
(73, 12, '2020-07-05 20:05:20', '2020-07-05 18:01:48'),
(74, 12, NULL, '2020-07-05 18:43:24');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_subscribers`
--

CREATE TABLE `tb_subscribers` (
  `idsubscriber` int(4) NOT NULL,
  `dessubscriber` varchar(50) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tb_subscribers`
--

INSERT INTO `tb_subscribers` (`idsubscriber`, `dessubscriber`, `dtregister`) VALUES
(1, 'felipejn@gmail.com', '2020-05-26 19:23:56'),
(2, 'felipejn@email.com', '2020-05-27 14:08:12'),
(3, 'laratakashima@gmail.com', '2020-06-07 12:39:39'),
(4, 'gilbrtoaguiar1985@gmail.com', '2020-06-07 17:53:36');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_tags`
--

CREATE TABLE `tb_tags` (
  `idtag` int(11) NOT NULL,
  `destag` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tb_tags`
--

INSERT INTO `tb_tags` (`idtag`, `destag`) VALUES
(2, 'SQL'),
(5, 'GIT'),
(6, 'PHP'),
(7, 'Apache');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_users`
--

CREATE TABLE `tb_users` (
  `iduser` int(11) NOT NULL,
  `desname` varchar(50) NOT NULL,
  `desemail` varchar(50) NOT NULL,
  `despassword` varchar(255) NOT NULL,
  `desadmin` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tb_users`
--

INSERT INTO `tb_users` (`iduser`, `desname`, `desemail`, `despassword`, `desadmin`) VALUES
(12, 'Felipe Nascimento', 'felipejn@gmail.com', '$2y$12$2usr.WbCP6WkXgGoOO9gz.2bky2uVq7451OizkxDUs.eK1t.n1QqS', NULL),
(17, 'Jaimes', 'jaimes@jaimes.com', '$2y$12$lyVSWuTlAfl/u45VXxkdX.nnOhWTK9mp1Km5u.eNVBbTKpDqISjPm', NULL),
(18, 'Jaime_the_oldest', 'jaimenn@gmail.com', '$2y$12$.zZybHNrc1es/wF1ZIjA0ey4nhUELpRpnvzebVDhr8FQ/.w1cxCJ2', NULL),
(19, 'MarciclÃ©o Oliveira', 'marcicleo@marcicleo.com', '$2y$12$Nr7Pzn5xmn.knkBD/hyiruHik.58yp3hDg5Xti.nrN.pY5ggCqZ4C', NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `tb_posts`
--
ALTER TABLE `tb_posts`
  ADD PRIMARY KEY (`idpost`),
  ADD KEY `fk_posts_users` (`iduser`);

--
-- Índices para tabela `tb_poststags`
--
ALTER TABLE `tb_poststags`
  ADD PRIMARY KEY (`idpost`,`idtag`),
  ADD KEY `fk_tags` (`idtag`);

--
-- Índices para tabela `tb_pswdrecovery`
--
ALTER TABLE `tb_pswdrecovery`
  ADD PRIMARY KEY (`idrecovery`),
  ADD KEY `fk_recovery_user` (`iduser`);

--
-- Índices para tabela `tb_subscribers`
--
ALTER TABLE `tb_subscribers`
  ADD PRIMARY KEY (`idsubscriber`);

--
-- Índices para tabela `tb_tags`
--
ALTER TABLE `tb_tags`
  ADD PRIMARY KEY (`idtag`);

--
-- Índices para tabela `tb_users`
--
ALTER TABLE `tb_users`
  ADD PRIMARY KEY (`iduser`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tb_posts`
--
ALTER TABLE `tb_posts`
  MODIFY `idpost` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de tabela `tb_pswdrecovery`
--
ALTER TABLE `tb_pswdrecovery`
  MODIFY `idrecovery` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT de tabela `tb_subscribers`
--
ALTER TABLE `tb_subscribers`
  MODIFY `idsubscriber` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `tb_tags`
--
ALTER TABLE `tb_tags`
  MODIFY `idtag` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `iduser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `tb_posts`
--
ALTER TABLE `tb_posts`
  ADD CONSTRAINT `fk_posts_users` FOREIGN KEY (`iduser`) REFERENCES `tb_users` (`iduser`);

--
-- Limitadores para a tabela `tb_poststags`
--
ALTER TABLE `tb_poststags`
  ADD CONSTRAINT `fk_posts` FOREIGN KEY (`idpost`) REFERENCES `tb_posts` (`idpost`),
  ADD CONSTRAINT `fk_tags` FOREIGN KEY (`idtag`) REFERENCES `tb_tags` (`idtag`);

--
-- Limitadores para a tabela `tb_pswdrecovery`
--
ALTER TABLE `tb_pswdrecovery`
  ADD CONSTRAINT `fk_recovery_user` FOREIGN KEY (`iduser`) REFERENCES `tb_users` (`iduser`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
