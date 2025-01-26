-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 28-Nov-2024 às 15:30
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `freemaker_soul`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `categorias`
--

CREATE TABLE `categorias` (
  `ID` int(11) NOT NULL,
  `c_descricao` enum('Decor','Figuras','Gaming','Misc','Porta-chaves','Utensilios') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `categorias`
--

INSERT INTO `categorias` (`ID`, `c_descricao`) VALUES
(1, 'Decor'),
(2, 'Figuras'),
(3, 'Gaming'),
(4, 'Misc'),
(5, 'Porta-chaves'),
(6, 'Utensilios');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cores`
--

CREATE TABLE `cores` (
  `ID` int(11) NOT NULL,
  `cor` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `cores`
--

INSERT INTO `cores` (`ID`, `cor`) VALUES
(1, 'Branco'),
(2, 'Castanho'),
(3, 'Cinzento'),
(4, 'Dourado'),
(5, 'Laranja'),
(6, 'Vermelho'),
(7, 'Prateado'),
(8, 'Preto');

-- --------------------------------------------------------

--
-- Estrutura da tabela `encomendas`
--

CREATE TABLE `encomendas` (
  `ID` int(11) NOT NULL,
  `ID_utilizador` int(11) NOT NULL,
  `tipo_pagamento` enum('mbway','paypal','transferência bancária','cartão débito','') NOT NULL,
  `data` datetime NOT NULL DEFAULT current_timestamp(),
  `estado` enum('pendente','em processamento','processada','enviada') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ficheiros_stl`
--

CREATE TABLE `ficheiros_stl` (
  `ID` int(11) NOT NULL,
  `ficheiro` varchar(100) NOT NULL,
  `ID_produto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `filamentos`
--

CREATE TABLE `filamentos` (
  `ID` int(11) NOT NULL,
  `tipo` enum('ABS','PETG','PLA','TPE','TPU') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `filamentos`
--

INSERT INTO `filamentos` (`ID`, `tipo`) VALUES
(1, 'ABS'),
(2, 'PETG'),
(3, 'PLA'),
(4, 'TPE'),
(5, 'TPU');

-- --------------------------------------------------------

--
-- Estrutura da tabela `fotos`
--

CREATE TABLE `fotos` (
  `ID` int(11) NOT NULL,
  `foto` varchar(100) NOT NULL,
  `ID_produto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `fotos`
--

INSERT INTO `fotos` (`ID`, `foto`, `ID_produto`) VALUES
(48, '671d80599c099.png', 20),
(49, '671d80599c3d7.png', 20),
(50, '671d80599c6a8.png', 20),
(51, '671d809ba148f.png', 21),
(52, '671d809ba1809.png', 21),
(53, '671d809ba1ae5.png', 21),
(54, '671d809ba1f3f.png', 21),
(55, '671d809bb2f23.png', 21),
(56, '671d80eb3360d.png', 22),
(57, '671d80eb3396a.png', 22),
(58, '671d80eb33d70.png', 22),
(59, '671d80eb48ee0.png', 22),
(65, '67291b32d9f90.png', 25),
(66, '67291b32edb5d.png', 25),
(67, '67291b32edfa7.png', 25),
(68, '67291b3311ee0.png', 25),
(69, '67291b9d2a63d.png', 26),
(70, '67291b9d2a8f1.png', 26),
(74, '67291c359a2c5.png', 28),
(75, '67291c359a5fe.png', 28),
(76, '67291c359a99c.png', 28),
(77, '67291c359acd9.png', 28),
(78, '67291c6317199.png', 29),
(79, '67291c63174bf.png', 29),
(80, '67291c6317949.png', 29),
(81, '67291c6317d77.png', 29),
(82, '67291c6318094.png', 29),
(83, '67291c63183e9.png', 29),
(91, '67291d790292c.png', 32),
(92, '67291d7902c7d.png', 32),
(93, '67291d7902ff2.png', 32),
(94, '67291d99eedfc.png', 33),
(95, '67291d99ef0af.png', 33),
(96, '67291d99ef3d8.png', 33),
(97, '67291dc933b92.png', 34),
(98, '67291dc93d360.png', 34),
(99, '67291dc93d787.png', 34),
(132, '674234c4e970e.png', 30),
(133, '674234c50e193.png', 30),
(134, '674234c50e54a.png', 30),
(177, 'Amanita0.png', 24),
(180, 'Amanita10.png', 24);

-- --------------------------------------------------------

--
-- Estrutura da tabela `intens_encomenda`
--

CREATE TABLE `intens_encomenda` (
  `ID` int(11) NOT NULL,
  `ID_produto` int(11) NOT NULL,
  `ID_encomenda` int(11) NOT NULL,
  `valor` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `orçamentos`
--

CREATE TABLE `orçamentos` (
  `ID` int(11) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `descricao` varchar(250) NOT NULL,
  `ficheiro` varchar(100) NOT NULL,
  `ID_categoria` int(11) NOT NULL,
  `ID_utilizador` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE `produtos` (
  `ID` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` varchar(250) NOT NULL,
  `preco` decimal(10,2) DEFAULT NULL,
  `ID_categoria` int(11) NOT NULL,
  `ID_utilizador` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`ID`, `nome`, `descricao`, `preco`, `ID_categoria`, `ID_utilizador`) VALUES
(2, 'asd', 'asd', 99999999.99, 2, 1),
(20, 'Kodama', 'Figura espirito da floresta', 10.00, 2, 8),
(21, 'Puzzle', 'Quebra cabe&ccedil;as ', 5.50, 4, 8),
(22, 'Boogeyman', 'Porta chaves do boggeyman ', 1980.00, 5, 12),
(24, 'Candeeiro Amanita', 'Candeeiro Amanita', 0.10, 1, 12),
(25, 'Deku tree', 'Copo para canetas/pinc&eacute;is ', 10.00, 1, 12),
(26, 'No Evil', 'Decora&ccedil;&atilde;o speak no evil, ear no evil, see no evil', 20.00, 1, 12),
(28, 'Suporte para Headphones', 'blashk bleshk nhanhanha', 2402.00, 3, 12),
(29, 'Venom', 'Suporte de comando de consola Venom', 20.00, 3, 12),
(30, 'Cama Le&atilde;o ????', 'Suporte para caneta', 5.30, 4, 12),
(32, 'Porta-chaves Amongus', 'badjeras no baguinhos do ac&oacute;ide', 10000.00, 5, 12),
(33, 'Suporte C&aacute;psulas', '', 10.00, 6, 12),
(34, 'Paneleirice para bebados', 'VAMOS TODOS PARA A ADEGA!!', 0.50, 6, 12);

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos_filamentos_cores`
--

CREATE TABLE `produtos_filamentos_cores` (
  `ID_produto` int(11) NOT NULL,
  `ID_filamento` int(11) NOT NULL,
  `ID_cor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `produtos_filamentos_cores`
--

INSERT INTO `produtos_filamentos_cores` (`ID_produto`, `ID_filamento`, `ID_cor`) VALUES
(20, 4, 1),
(21, 2, 7),
(22, 4, 2),
(24, 1, 1),
(25, 3, 1),
(26, 3, 1),
(28, 2, 8),
(29, 3, 8),
(30, 3, 7),
(32, 5, 6),
(33, 3, 1),
(34, 3, 4);

-- --------------------------------------------------------

--
-- Estrutura da tabela `utilizadores`
--

CREATE TABLE `utilizadores` (
  `ID` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `morada` tinytext NOT NULL,
  `cod_postal` varchar(9) NOT NULL,
  `telefone` varchar(20) NOT NULL DEFAULT 'não possui',
  `nif` int(11) NOT NULL,
  `nickname` varchar(100) NOT NULL,
  `email` varchar(60) NOT NULL,
  `pw` varchar(64) NOT NULL,
  `foto` varchar(100) NOT NULL,
  `adm` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `utilizadores`
--

INSERT INTO `utilizadores` (`ID`, `nome`, `morada`, `cod_postal`, `telefone`, `nif`, `nickname`, `email`, `pw`, `foto`, `adm`) VALUES
(12, 'Cordyceps', 'Rua Da Feira Lote B2\r\nR/C Frente', '3100-539', '915263155', 323213233, 'asd', 'andreproenca13@gmail.com', 'f343e95445fdb16567642b6d7f5fb61fd2dbd7f0104bca125e8bd3aefa0d169e', '6723a18b25be3.png', 1),
(16, 'Caganita', '', '', '231213222', 333333333, 'ds', 'ds@ds', 'a4b07066f798dbc53fb4f7efe043b098efafdfdcb897125e0fac1bf54a5c24ed', '6739d55f24fff.png', 0),
(17, '', '', '', 'não possui', 0, 'df', 'df@df', '051baeaf015abd98380a71c3fd02939f6f57dd8c901f535e3a54495df06a5fef', '', 0),
(18, '', '', '', 'não possui', 0, 'lolo', 'lolo@lolo', '254cfcedd7519cfc07f5bba0e76d8232864bd3b1df60fb5980a80890cfa41d06', '', 0);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`ID`);

--
-- Índices para tabela `cores`
--
ALTER TABLE `cores`
  ADD PRIMARY KEY (`ID`);

--
-- Índices para tabela `encomendas`
--
ALTER TABLE `encomendas`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_utilizador` (`ID_utilizador`);

--
-- Índices para tabela `ficheiros_stl`
--
ALTER TABLE `ficheiros_stl`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_produto` (`ID_produto`);

--
-- Índices para tabela `filamentos`
--
ALTER TABLE `filamentos`
  ADD PRIMARY KEY (`ID`);

--
-- Índices para tabela `fotos`
--
ALTER TABLE `fotos`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_produto` (`ID_produto`);

--
-- Índices para tabela `intens_encomenda`
--
ALTER TABLE `intens_encomenda`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_produto` (`ID_produto`),
  ADD KEY `ID_encomenda` (`ID_encomenda`);

--
-- Índices para tabela `orçamentos`
--
ALTER TABLE `orçamentos`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_categoria` (`ID_categoria`),
  ADD KEY `ID_utilizador` (`ID_utilizador`);

--
-- Índices para tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_utilizador` (`ID_utilizador`),
  ADD KEY `ID_categoria` (`ID_categoria`);

--
-- Índices para tabela `produtos_filamentos_cores`
--
ALTER TABLE `produtos_filamentos_cores`
  ADD PRIMARY KEY (`ID_produto`,`ID_filamento`,`ID_cor`),
  ADD KEY `ID_filamento` (`ID_filamento`),
  ADD KEY `ID_cor` (`ID_cor`);

--
-- Índices para tabela `utilizadores`
--
ALTER TABLE `utilizadores`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `cores`
--
ALTER TABLE `cores`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `encomendas`
--
ALTER TABLE `encomendas`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `ficheiros_stl`
--
ALTER TABLE `ficheiros_stl`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `filamentos`
--
ALTER TABLE `filamentos`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `fotos`
--
ALTER TABLE `fotos`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=191;

--
-- AUTO_INCREMENT de tabela `intens_encomenda`
--
ALTER TABLE `intens_encomenda`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `orçamentos`
--
ALTER TABLE `orçamentos`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de tabela `utilizadores`
--
ALTER TABLE `utilizadores`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `encomendas`
--
ALTER TABLE `encomendas`
  ADD CONSTRAINT `encomendas_ibfk_2` FOREIGN KEY (`ID_utilizador`) REFERENCES `utilizadores` (`ID`);

--
-- Limitadores para a tabela `ficheiros_stl`
--
ALTER TABLE `ficheiros_stl`
  ADD CONSTRAINT `ficheiros_stl_ibfk_1` FOREIGN KEY (`ID_produto`) REFERENCES `produtos` (`ID`);

--
-- Limitadores para a tabela `fotos`
--
ALTER TABLE `fotos`
  ADD CONSTRAINT `fotos_ibfk_1` FOREIGN KEY (`ID_produto`) REFERENCES `produtos` (`ID`);

--
-- Limitadores para a tabela `intens_encomenda`
--
ALTER TABLE `intens_encomenda`
  ADD CONSTRAINT `intens_encomenda_ibfk_1` FOREIGN KEY (`ID_produto`) REFERENCES `produtos` (`ID`),
  ADD CONSTRAINT `intens_encomenda_ibfk_2` FOREIGN KEY (`ID_encomenda`) REFERENCES `encomendas` (`ID`);

--
-- Limitadores para a tabela `orçamentos`
--
ALTER TABLE `orçamentos`
  ADD CONSTRAINT `orçamentos_ibfk_1` FOREIGN KEY (`ID_categoria`) REFERENCES `categorias` (`ID`),
  ADD CONSTRAINT `orçamentos_ibfk_2` FOREIGN KEY (`ID_utilizador`) REFERENCES `utilizadores` (`ID`);

--
-- Limitadores para a tabela `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `produtos_ibfk_1` FOREIGN KEY (`ID_categoria`) REFERENCES `categorias` (`ID`);

--
-- Limitadores para a tabela `produtos_filamentos_cores`
--
ALTER TABLE `produtos_filamentos_cores`
  ADD CONSTRAINT `produtos_filamentos_cores_ibfk_1` FOREIGN KEY (`ID_produto`) REFERENCES `produtos` (`ID`),
  ADD CONSTRAINT `produtos_filamentos_cores_ibfk_2` FOREIGN KEY (`ID_filamento`) REFERENCES `filamentos` (`ID`),
  ADD CONSTRAINT `produtos_filamentos_cores_ibfk_3` FOREIGN KEY (`ID_cor`) REFERENCES `cores` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
