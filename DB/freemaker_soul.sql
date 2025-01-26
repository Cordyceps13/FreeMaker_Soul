-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 23-Out-2024 às 01:30
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
(1, '6717b6d068491.png', 32),
(2, '6717c9b9819d2.png', 33),
(3, '6717d1e1e8b94.png', 34),
(4, '6717d56ce2689.png', 35),
(5, '6717d616a23aa.png', 36),
(6, '6717d69bf0783.png', 37),
(7, '6717d78ac1d3a.png', 38),
(11, '6717e1ebed1dc.png', 42);

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

--
-- Extraindo dados da tabela `orçamentos`
--

INSERT INTO `orçamentos` (`ID`, `nome`, `descricao`, `ficheiro`, `ID_categoria`, `ID_utilizador`) VALUES
(15, 'asd', 'asd', '6717fba0bcc41.stl', 1, 2);

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
(32, 'asd', '', 15.00, 1, 1),
(33, 'asd', '', 15.00, 1, 1),
(34, 'asd', 'asd', 3.00, 1, 1),
(35, 'asd', 'asd', 23.00, 1, 1),
(36, 'sdsd', 'fsdf', 23.00, 1, 1),
(37, 'dasdad', 'adada', 12.00, 1, 1),
(38, 'tyu', 'uty', 789.00, 1, 1),
(42, 'ere', 'ere', 12.00, 2, 1);

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
(34, 2, 1),
(42, 3, 4);

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
(1, 'asd', '', '', 'não possui', 0, '', 'asd@gmail.com', '22f296559d8fab6eced71103f3d6b92aba1e54a1d034bc7b4cea2efb526927ab', '', 1),
(2, 'ada', '', '', 'não possui', 0, '', 'ada', '7bdecc983f35be41ad883936c6e2de21e45cba9323e4de9ee6f361e16077edc7', '', 0),
(3, 'dada', '', '', 'não possui', 0, '', 'dada', '1c4727f758053340b057fd9250bafce943c50429bfa602e4aff83ca2b3960514', '', 0);

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `filamentos`
--
ALTER TABLE `filamentos`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `fotos`
--
ALTER TABLE `fotos`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `intens_encomenda`
--
ALTER TABLE `intens_encomenda`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `orçamentos`
--
ALTER TABLE `orçamentos`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de tabela `utilizadores`
--
ALTER TABLE `utilizadores`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
