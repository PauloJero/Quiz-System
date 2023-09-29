-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 04-Jan-2023 às 00:16
-- Versão do servidor: 10.4.27-MariaDB
-- versão do PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `quiz`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `leaderboard`
--

CREATE TABLE `leaderboard` (
  `idLeaderboard` int(11) NOT NULL,
  `Partida_idPartida` int(11) NOT NULL,
  `User_idUser` int(11) NOT NULL,
  `Quiz_idQuiz` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `leaderboard`
--

INSERT INTO `leaderboard` (`idLeaderboard`, `Partida_idPartida`, `User_idUser`, `Quiz_idQuiz`) VALUES
(1, 1, 2, 1),
(2, 2, 2, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `opcao`
--

CREATE TABLE `opcao` (
  `idOpcao` int(11) NOT NULL,
  `texto` varchar(250) NOT NULL,
  `iscorrect` tinyint(4) NOT NULL,
  `Pergunta_idPergunta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `opcao`
--

INSERT INTO `opcao` (`idOpcao`, `texto`, `iscorrect`, `Pergunta_idPergunta`) VALUES
(1, 'Personal Hypertext Processor', 2, 1),
(2, 'Private Home Page', 2, 1),
(3, 'PHP: Hypertext Preprocessor', 1, 1),
(4, '\'< ? p h p ... ? >\'', 1, 2),
(5, '\' < ? p h p > ... < / ? > \'', 2, 2),
(6, '\" < & > ... < / & > \"', 2, 2),
(7, '\' < s c r i p t > ... < / s c r i p t > \'', 2, 2),
(8, 'Document.Write(\"Hello World\");', 2, 3),
(9, 'echo \"Hello World\";', 1, 3),
(10, '\"Hello World\";', 2, 3),
(11, '!', 2, 4),
(12, '&', 2, 4),
(13, '$', 1, 4),
(14, '.', 2, 5),
(15, ';', 1, 5),
(16, '< / p h p > ', 2, 5),
(17, 'Strong Question Language', 2, 6),
(18, 'Structured Query Language', 1, 6),
(19, 'Structured Question Language', 2, 6),
(20, 'SELECT', 1, 7),
(21, 'EXTRACT', 2, 7),
(22, 'GET', 2, 7),
(23, 'INSERT NEW', 2, 8),
(24, 'INSERT INTO', 1, 8),
(25, 'ADD NEW', 2, 8),
(26, 'ADD RECORD', 2, 8),
(27, 'False', 2, 9),
(28, 'True', 1, 9);

-- --------------------------------------------------------

--
-- Estrutura da tabela `partida`
--

CREATE TABLE `partida` (
  `idPartida` int(11) NOT NULL,
  `data` datetime NOT NULL,
  `tempo` time NOT NULL,
  `n_certas` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `User_idUser` int(11) NOT NULL,
  `Quiz_idQuiz` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `partida`
--

INSERT INTO `partida` (`idPartida`, `data`, `tempo`, `n_certas`, `score`, `User_idUser`, `Quiz_idQuiz`) VALUES
(1, '2022-12-28 19:58:56', '00:01:56', 1, 6, 2, 1),
(2, '2022-12-28 20:00:53', '00:01:25', 2, 16, 2, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `perfil`
--

CREATE TABLE `perfil` (
  `idPerfil` int(11) NOT NULL,
  `descPerfil` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `perfil`
--

INSERT INTO `perfil` (`idPerfil`, `descPerfil`) VALUES
(1, 'user'),
(2, 'admin');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pergunta`
--

CREATE TABLE `pergunta` (
  `idPergunta` int(11) NOT NULL,
  `texto` varchar(250) NOT NULL,
  `Quiz_idQuiz` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `pergunta`
--

INSERT INTO `pergunta` (`idPergunta`, `texto`, `Quiz_idQuiz`) VALUES
(1, 'O que significa PHP?', 1),
(2, 'Os scripts de servidor PHP são cercados por qual delimitador?', 1),
(3, 'Como se escreve \"Hello World\" em PHP?', 1),
(4, 'Todas as variáveis em PHP começam com qual símbolo?', 1),
(5, 'Qual é a maneira correta de terminar uma instrução PHP?', 1),
(6, 'O que significa SQL?', 2),
(7, 'Qual a instrução SQL usada para extrair dados de uma base de dados?', 2),
(8, 'Qual a instrução SQL usada para inserir novos dados em uma base de dados?', 2),
(9, 'A restrição NOT NULL força uma coluna a não aceitar valores NULL.', 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `quiz`
--

CREATE TABLE `quiz` (
  `idQuiz` int(11) NOT NULL,
  `titulo` varchar(60) NOT NULL,
  `foto` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `quiz`
--

INSERT INTO `quiz` (`idQuiz`, `titulo`, `foto`) VALUES
(1, 'Quiz de DAAI', NULL),
(2, 'Quiz de Base de Dados', NULL),
(4, 'Quiz remove test', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `quiz_tema`
--

CREATE TABLE `quiz_tema` (
  `Quiz_idQuiz` int(11) NOT NULL,
  `Tema_idTema` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `quiz_tema`
--

INSERT INTO `quiz_tema` (`Quiz_idQuiz`, `Tema_idTema`) VALUES
(1, 1),
(2, 2),
(4, 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `resposta`
--

CREATE TABLE `resposta` (
  `idResposta` int(11) NOT NULL,
  `Opcao_idOpcao` int(11) NOT NULL,
  `Pergunta_idPergunta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `resposta`
--

INSERT INTO `resposta` (`idResposta`, `Opcao_idOpcao`, `Pergunta_idPergunta`) VALUES
(1, 2, 1),
(2, 4, 2),
(3, 10, 3),
(4, 12, 4),
(5, 14, 5),
(6, 18, 6),
(7, 22, 7),
(8, 25, 8),
(9, 28, 9);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tema`
--

CREATE TABLE `tema` (
  `idTema` int(11) NOT NULL,
  `tema` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `tema`
--

INSERT INTO `tema` (`idTema`, `tema`) VALUES
(1, 'Daai'),
(2, 'Base de Dados'),
(3, 'tema teste');

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

CREATE TABLE `user` (
  `idUser` int(11) NOT NULL,
  `nome` varchar(45) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(100) NOT NULL,
  `foto` varchar(200) DEFAULT NULL,
  `Perfil_idPerfil` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `user`
--

INSERT INTO `user` (`idUser`, `nome`, `email`, `password`, `foto`, `Perfil_idPerfil`) VALUES
(1, 'admin', 'admin@admin.com', 'admin123', '1', 2),
(2, 'Paulo', 'pn-jeronimo@hotmail.com', 'pauloj', '2', 1),
(6, 'user_teste', 'user_teste@gmail.com', 'userteste123', NULL, 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `leaderboard`
--
ALTER TABLE `leaderboard`
  ADD PRIMARY KEY (`idLeaderboard`),
  ADD KEY `fk_Leaderboard_Partida1_idx` (`Partida_idPartida`),
  ADD KEY `fk_Leaderboard_User1_idx` (`User_idUser`),
  ADD KEY `fk_Leaderboard_Quiz1_idx` (`Quiz_idQuiz`);

--
-- Índices para tabela `opcao`
--
ALTER TABLE `opcao`
  ADD PRIMARY KEY (`idOpcao`),
  ADD KEY `fk_Opcao_Pergunta1_idx` (`Pergunta_idPergunta`);

--
-- Índices para tabela `partida`
--
ALTER TABLE `partida`
  ADD PRIMARY KEY (`idPartida`),
  ADD KEY `fk_Partida_User1_idx` (`User_idUser`),
  ADD KEY `fk_Partida_Quiz1_idx` (`Quiz_idQuiz`);

--
-- Índices para tabela `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`idPerfil`);

--
-- Índices para tabela `pergunta`
--
ALTER TABLE `pergunta`
  ADD PRIMARY KEY (`idPergunta`),
  ADD KEY `fk_Pergunta_Quiz1_idx` (`Quiz_idQuiz`);

--
-- Índices para tabela `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`idQuiz`);

--
-- Índices para tabela `quiz_tema`
--
ALTER TABLE `quiz_tema`
  ADD PRIMARY KEY (`Quiz_idQuiz`,`Tema_idTema`),
  ADD KEY `fk_Quiz_has_Tema_Tema1_idx` (`Tema_idTema`),
  ADD KEY `fk_Quiz_has_Tema_Quiz_idx` (`Quiz_idQuiz`);

--
-- Índices para tabela `resposta`
--
ALTER TABLE `resposta`
  ADD PRIMARY KEY (`idResposta`),
  ADD KEY `fk_Resposta_Opcao1_idx` (`Opcao_idOpcao`),
  ADD KEY `fk_Resposta_Pergunta1_idx` (`Pergunta_idPergunta`);

--
-- Índices para tabela `tema`
--
ALTER TABLE `tema`
  ADD PRIMARY KEY (`idTema`);

--
-- Índices para tabela `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`idUser`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`),
  ADD KEY `fk_User_Perfil1_idx` (`Perfil_idPerfil`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `leaderboard`
--
ALTER TABLE `leaderboard`
  MODIFY `idLeaderboard` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `opcao`
--
ALTER TABLE `opcao`
  MODIFY `idOpcao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de tabela `partida`
--
ALTER TABLE `partida`
  MODIFY `idPartida` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de tabela `pergunta`
--
ALTER TABLE `pergunta`
  MODIFY `idPergunta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `quiz`
--
ALTER TABLE `quiz`
  MODIFY `idQuiz` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `resposta`
--
ALTER TABLE `resposta`
  MODIFY `idResposta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `tema`
--
ALTER TABLE `tema`
  MODIFY `idTema` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `user`
--
ALTER TABLE `user`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `leaderboard`
--
ALTER TABLE `leaderboard`
  ADD CONSTRAINT `fk_Leaderboard_Partida1` FOREIGN KEY (`Partida_idPartida`) REFERENCES `partida` (`idPartida`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Leaderboard_Quiz1` FOREIGN KEY (`Quiz_idQuiz`) REFERENCES `quiz` (`idQuiz`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Leaderboard_User1` FOREIGN KEY (`User_idUser`) REFERENCES `user` (`idUser`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `opcao`
--
ALTER TABLE `opcao`
  ADD CONSTRAINT `fk_Opcao_Pergunta1` FOREIGN KEY (`Pergunta_idPergunta`) REFERENCES `pergunta` (`idPergunta`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `partida`
--
ALTER TABLE `partida`
  ADD CONSTRAINT `fk_Partida_Quiz1` FOREIGN KEY (`Quiz_idQuiz`) REFERENCES `quiz` (`idQuiz`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Partida_User1` FOREIGN KEY (`User_idUser`) REFERENCES `user` (`idUser`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `pergunta`
--
ALTER TABLE `pergunta`
  ADD CONSTRAINT `fk_Pergunta_Quiz1` FOREIGN KEY (`Quiz_idQuiz`) REFERENCES `quiz` (`idQuiz`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `quiz_tema`
--
ALTER TABLE `quiz_tema`
  ADD CONSTRAINT `fk_Quiz_has_Tema_Quiz` FOREIGN KEY (`Quiz_idQuiz`) REFERENCES `quiz` (`idQuiz`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Quiz_has_Tema_Tema1` FOREIGN KEY (`Tema_idTema`) REFERENCES `tema` (`idTema`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `resposta`
--
ALTER TABLE `resposta`
  ADD CONSTRAINT `fk_Resposta_Opcao1` FOREIGN KEY (`Opcao_idOpcao`) REFERENCES `opcao` (`idOpcao`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Resposta_Pergunta1` FOREIGN KEY (`Pergunta_idPergunta`) REFERENCES `pergunta` (`idPergunta`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_User_Perfil1` FOREIGN KEY (`Perfil_idPerfil`) REFERENCES `perfil` (`idPerfil`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
