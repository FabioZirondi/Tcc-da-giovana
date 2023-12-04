create database estagionews;

use estagionews;
-- Criar tabela 'empresa'
CREATE TABLE `empresa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(40) NOT NULL,
  `telefone` char(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Criar tabela 'usuarios'
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` int(1) NOT NULL,
  `email` varchar(140) DEFAULT NULL,
  `senha` varchar(300) DEFAULT NULL,
  `nome` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Criar tabela 'vagas'
CREATE TABLE `vagas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(30) NOT NULL,
  `descricao` varchar(100) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `salario` float(7,2) NOT NULL,
  `beneficios` varchar(100) NOT NULL,
  `area` varchar(100) NOT NULL,
  `horario` varchar(20) NOT NULL,
  `empresa_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `empresa_id` (`empresa_id`),
  CONSTRAINT `fk_empresa` FOREIGN KEY (`empresa_id`) REFERENCES `empresa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Criar tabela 'inscricao'
CREATE TABLE `inscricao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `data` date NOT NULL,
  `path` varchar(100) NOT NULL,
  `vagas_id` int(11) NOT NULL,
  `email_usuarios` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `vagas_id` (`vagas_id`),
  CONSTRAINT `fk_vagas` FOREIGN KEY (`vagas_id`) REFERENCES `vagas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Inserir dados na tabela 'usuarios'
INSERT INTO `usuarios` (`id`, `tipo`, `email`, `senha`, `nome`) VALUES
(1, 1, 'etecsylviodemattos@etec.sp.gov.br', '$2y$10$EPISm/dpZ3NNtUdU78Krg.pRdVyNvuqQWZ.ztRudBezt73BnHhRI2', 'Etec'),
(2, 0, 'giiovanadantas@gmail.com', '$2y$10$4OdmWDFK.lgxZoUxiTLyy.AU/sgfPlNguhkXeAFM0fDjIkdM68GYe', 'Giovana Dantas');
