/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Database: `transforma`
--

-- --------------------------------------------------------

--
-- Table structure for table `rl_experiencias_candidaturas`
--

DROP TABLE IF EXISTS `rl_experiencias_candidaturas`;
CREATE TABLE IF NOT EXISTS `rl_experiencias_candidaturas` (
  `es_candidatura` int(10) UNSIGNED NOT NULL,
  `es_experiencia` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`es_candidatura`,`es_experiencia`),
  KEY `es_experiencia` (`es_experiencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rl_formacoes_candidaturas`
--

DROP TABLE IF EXISTS `rl_formacoes_candidaturas`;
CREATE TABLE IF NOT EXISTS `rl_formacoes_candidaturas` (
  `es_candidatura` int(10) UNSIGNED NOT NULL,
  `es_formacao` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`es_candidatura`,`es_formacao`),
  KEY `es_formacao` (`es_formacao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rl_gruposvagas_questoes`
--

DROP TABLE IF EXISTS `rl_gruposvagas_questoes`;
CREATE TABLE IF NOT EXISTS `rl_gruposvagas_questoes` (
  `es_grupovaga` int(10) UNSIGNED NOT NULL,
  `es_questao` int(10) UNSIGNED NOT NULL,
  `in_ordem` tinyint(3) UNSIGNED NOT NULL,
  PRIMARY KEY (`es_grupovaga`,`es_questao`),
  KEY `es_questao` (`es_questao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `rl_gruposvagas_questoes_duplicadas`
--

DROP TABLE IF EXISTS `rl_gruposvagas_questoes_duplicadas`;
CREATE TABLE IF NOT EXISTS `rl_gruposvagas_questoes_duplicadas` (
  `es_grupovaga_origem` int(10) UNSIGNED NOT NULL,
  `es_questao_origem` int(10) UNSIGNED NOT NULL,
  `es_grupovaga_destino` int(10) UNSIGNED NOT NULL,
  `es_questao_destino` int(10) UNSIGNED NOT NULL,
  `dt_cadastro` datetime NOT NULL,
  `es_usuario` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`es_grupovaga_origem`,`es_questao_origem`,`es_grupovaga_destino`,`es_questao_destino`,`dt_cadastro`),
  KEY `es_usuario` (`es_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rl_instituicoes_usuarios`
--

DROP TABLE IF EXISTS `rl_instituicoes_usuarios`;
CREATE TABLE IF NOT EXISTS `rl_instituicoes_usuarios` (
  `es_instituicao` int(10) UNSIGNED NOT NULL,
  `es_usuario` int(10) UNSIGNED NOT NULL,
  `bl_removido` enum('0','1') COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`es_instituicao`,`es_usuario`),
  KEY `es_usuario` (`es_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `rl_questoes_vagas`
--

DROP TABLE IF EXISTS `rl_questoes_vagas`;
CREATE TABLE IF NOT EXISTS `rl_questoes_vagas` (
  `es_vaga` int(10) UNSIGNED NOT NULL,
  `es_questao` int(10) UNSIGNED NOT NULL,
  `in_ordem` tinyint(3) UNSIGNED DEFAULT NULL,
  `bl_removido` enum('0','1') COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`es_vaga`,`es_questao`),
  KEY `es_questao` (`es_questao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `rl_vagas_avaliadores`
--

DROP TABLE IF EXISTS `rl_vagas_avaliadores`;
CREATE TABLE IF NOT EXISTS `rl_vagas_avaliadores` (
  `es_vaga` int(10) UNSIGNED NOT NULL,
  `es_usuario` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`es_vaga`,`es_usuario`),
  KEY `es_usuario` (`es_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tb_anexos`
--

DROP TABLE IF EXISTS `tb_anexos`;
CREATE TABLE IF NOT EXISTS `tb_anexos` (
  `pr_anexo` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `es_candidatura` int(10) UNSIGNED DEFAULT NULL,
  `es_questao` int(10) UNSIGNED DEFAULT NULL,
  `es_formacao` int(10) UNSIGNED DEFAULT NULL,
  `es_experiencia` int(10) UNSIGNED DEFAULT NULL,
  `in_tipo` tinyint(3) UNSIGNED NOT NULL,
  `vc_mime` varchar(255) COLLATE utf8_bin NOT NULL,
  `vc_arquivo` varchar(255) COLLATE utf8_bin NOT NULL,
  `bi_conteudo` mediumblob,
  `in_tamanho` int(10) UNSIGNED NOT NULL,
  `es_usuarioCadastro` int(10) UNSIGNED NOT NULL,
  `dt_cadastro` datetime NOT NULL,
  `es_usuarioAlteracao` int(10) UNSIGNED DEFAULT NULL,
  `dt_alteracao` datetime DEFAULT NULL,
  `bl_removido` enum('0','1') COLLATE utf8_bin NOT NULL DEFAULT '0',
  PRIMARY KEY (`pr_anexo`),
  UNIQUE KEY `es_candidatura` (`es_candidatura`,`es_questao`) USING BTREE,
  UNIQUE KEY `es_experiencia` (`es_experiencia`) USING BTREE,
  UNIQUE KEY `es_formacao` (`es_formacao`) USING BTREE,
  KEY `IDCandidatura` (`es_candidatura`),
  KEY `IdUsuarioCadastrador` (`es_usuarioCadastro`),
  KEY `IdUsuarioUltimoAlterador` (`es_usuarioAlteracao`),
  KEY `es_questao` (`es_questao`)
) ENGINE=InnoDB AUTO_INCREMENT=26159 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `tb_candidatos`
--

DROP TABLE IF EXISTS `tb_candidatos`;
CREATE TABLE IF NOT EXISTS `tb_candidatos` (
  `pr_candidato` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `vc_nome` varchar(250) COLLATE utf8_bin NOT NULL,
  `vc_nomesocial` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `ch_cpf` char(14) COLLATE utf8_bin NOT NULL,
  `vc_rg` varchar(15) COLLATE utf8_bin NOT NULL,
  `in_genero` int(10) UNSIGNED NOT NULL,
  `vc_generoOptativo` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `in_raca` int(10) UNSIGNED DEFAULT NULL,
  `vc_orgaoEmissor` varchar(15) COLLATE utf8_bin NOT NULL,
  `vc_email` varchar(250) COLLATE utf8_bin NOT NULL,
  `vc_telefone` varchar(15) COLLATE utf8_bin NOT NULL,
  `vc_telefoneOpcional` varchar(15) COLLATE utf8_bin DEFAULT NULL,
  `vc_linkedin` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `dt_nascimento` date DEFAULT NULL,
  `vc_pais` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `vc_cidadeEstrangeira` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `vc_logradouro` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `vc_numero` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `vc_bairro` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `vc_complemento` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `vc_cep` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `es_municipio` bigint(20) DEFAULT NULL,
  `in_nivelAcademico` int(10) UNSIGNED DEFAULT NULL,
  `tx_informacoesAcademicas` mediumtext COLLATE utf8_bin,
  `tx_experienciaSetorPublico` mediumtext COLLATE utf8_bin,
  `tx_experienciasProfissionais` mediumtext COLLATE utf8_bin,
  `tx_atividadesVoluntarias` mediumtext COLLATE utf8_bin,
  `tx_referenciasProfissionais` mediumtext COLLATE utf8_bin,
  `in_exigenciasComuns` enum('0','1') COLLATE utf8_bin DEFAULT NULL,
  `bl_sentenciado` enum('0','1') COLLATE utf8_bin DEFAULT NULL,
  `bl_processoDisciplinar` enum('0','1') COLLATE utf8_bin DEFAULT NULL,
  `bl_ajustamentoFuncionalPorDoenca` enum('0','1') COLLATE utf8_bin DEFAULT NULL,
  `bl_elegivel` enum('0','1') COLLATE utf8_bin DEFAULT NULL,
  `bl_politicaPrivacidade` enum('0','1') COLLATE utf8_bin DEFAULT NULL,
  `es_usuarioCadastro` int(10) UNSIGNED DEFAULT NULL,
  `dt_cadastro` datetime NOT NULL,
  `es_usuarioAlteracao` int(10) UNSIGNED DEFAULT NULL,
  `dt_alteracao` datetime NOT NULL,
  `bl_removido` enum('0','1') COLLATE utf8_bin NOT NULL DEFAULT '0',
  `bl_aceiteTermo` enum('0','1') COLLATE utf8_bin DEFAULT NULL,
  `bl_aceitePrivacidade` enum('0','1') COLLATE utf8_bin DEFAULT NULL,
  `bl_brumadinho` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`pr_candidato`),
  KEY `IdMunicipio` (`es_municipio`),
  KEY `IdUsuarioCadastrador` (`es_usuarioCadastro`),
  KEY `IdUsuarioUltimoAlterador` (`es_usuarioAlteracao`)
) ENGINE=InnoDB AUTO_INCREMENT=6815 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `tb_candidaturas`
--

DROP TABLE IF EXISTS `tb_candidaturas`;
CREATE TABLE IF NOT EXISTS `tb_candidaturas` (
  `pr_candidatura` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `es_candidato` int(10) UNSIGNED NOT NULL,
  `es_vaga` int(10) UNSIGNED NOT NULL,
  `es_status` tinyint(3) UNSIGNED NOT NULL,
  `dt_cadastro` datetime DEFAULT NULL,
  `dt_realizada` datetime DEFAULT NULL,
  `dt_candidatura` datetime NOT NULL,
  `bl_removido` enum('0','1') COLLATE utf8_bin NOT NULL DEFAULT '0',
  `vc_urlDocumentoIdentificacao` varchar(500) COLLATE utf8_bin DEFAULT NULL,
  `vc_urlCurriculum` varchar(500) COLLATE utf8_bin DEFAULT NULL,
  `en_aderencia` enum('0','1','2') COLLATE utf8_bin DEFAULT NULL COMMENT '1->teste de aderencia obrigatório, 2-> teste de aderência feito',
  `dt_aderencia` datetime DEFAULT NULL,
  `es_avaliador_competencia1` int(10) UNSIGNED DEFAULT NULL,
  `es_avaliador_especialista` int(10) UNSIGNED DEFAULT NULL,
  `es_avaliador_curriculo` int(10) UNSIGNED DEFAULT NULL,
  `tx_expectativa_momento` text COLLATE utf8_bin,
  `tx_observacoes_momento` text COLLATE utf8_bin,
  `tx_pontos_fortes` text COLLATE utf8_bin,
  `tx_pontos_melhorias` text COLLATE utf8_bin,
  `tx_feedback` text COLLATE utf8_bin,
  `tx_comentarios` text COLLATE utf8_bin,
  `en_hbdi` enum('1','2') COLLATE utf8_bin DEFAULT NULL,
  `dt_hbdi` datetime DEFAULT NULL,
  `en_motivacao` enum('1','2') COLLATE utf8_bin DEFAULT NULL,
  `dt_motivacao` datetime DEFAULT NULL,
  PRIMARY KEY (`pr_candidatura`),
  UNIQUE KEY `es_candidato` (`es_candidato`,`es_vaga`),
  KEY `IdCandidato` (`es_candidato`),
  KEY `IdVaga` (`es_vaga`),
  KEY `es_status` (`es_status`),
  KEY `es_avaliador_competencia1` (`es_avaliador_competencia1`),
  KEY `es_avaliador_competencia2` (`es_avaliador_especialista`),
  KEY `es_avaliador_curriculo` (`es_avaliador_curriculo`)
) ENGINE=InnoDB AUTO_INCREMENT=6473 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `tb_competencias`
--

DROP TABLE IF EXISTS `tb_competencias`;
CREATE TABLE IF NOT EXISTS `tb_competencias` (
  `pr_competencia` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `vc_competencia` varchar(200) NOT NULL,
  `tx_descrição` text NOT NULL,
  PRIMARY KEY (`pr_competencia`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_competencias`
--

INSERT INTO `tb_competencias` (`pr_competencia`, `vc_competencia`, `tx_descrição`) VALUES
(12, 'Capacidade de Comunicação', ''),
(13, 'Gestão de Pessoas', ''),
(14, 'Liderança e engajamento de pessoas', ''),
(15, 'Orientação para Resultados e usuários', ''),
(16, 'Visão Sistêmica', ''),
(17, 'Desafia o status quo/Inovação', ''),
(18, 'Resiliência', ''),
(19, 'Resolução de conflitos', '');

-- --------------------------------------------------------

--
-- Table structure for table `tb_configuracao`
--

DROP TABLE IF EXISTS `tb_configuracao`;
CREATE TABLE IF NOT EXISTS `tb_configuracao` (
  `co_conf` varchar(30) COLLATE utf8_bin NOT NULL,
  `vc_conf` varchar(255) COLLATE utf8_bin NOT NULL,
  `no_conf` varchar(100) COLLATE utf8_bin NOT NULL,
  `in_ordenacao` int(11) NOT NULL,
  `ch_tipo` char(1) COLLATE utf8_bin NOT NULL DEFAULT 'T',
  `ch_restricao` char(1) COLLATE utf8_bin DEFAULT NULL,
  `in_tamanhomaximo` int(11) NOT NULL,
  PRIMARY KEY (`co_conf`),
  KEY `in_ordenacao` (`in_ordenacao`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `tb_entrevistas`
--

DROP TABLE IF EXISTS `tb_entrevistas`;
CREATE TABLE IF NOT EXISTS `tb_entrevistas` (
  `pr_entrevista` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `es_candidatura` int(10) UNSIGNED NOT NULL,
  `es_avaliador1` int(10) UNSIGNED NOT NULL,
  `es_avaliador2` int(10) UNSIGNED DEFAULT NULL,
  `es_avaliador3` int(10) UNSIGNED DEFAULT NULL,
  `dt_entrevista` datetime NOT NULL,
  `es_alterador` int(10) UNSIGNED NOT NULL,
  `dt_alteracao` date NOT NULL,
  `bl_tipo_entrevista` enum('competencia','especialista') DEFAULT NULL,
  `vc_link` varchar(200) DEFAULT NULL,
  `tx_observacoes` text,
  PRIMARY KEY (`pr_entrevista`),
  UNIQUE KEY `es_candidatura` (`es_candidatura`,`bl_tipo_entrevista`) USING BTREE,
  KEY `es_avaliador1` (`es_avaliador1`),
  KEY `es_avaliador2` (`es_avaliador2`),
  KEY `es_alterador` (`es_alterador`),
  KEY `es_avaliador3` (`es_avaliador3`)
) ENGINE=InnoDB AUTO_INCREMENT=416 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tb_etapas`
--

DROP TABLE IF EXISTS `tb_etapas`;
CREATE TABLE IF NOT EXISTS `tb_etapas` (
  `pr_etapa` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `vc_etapa` varchar(250) COLLATE utf8_bin NOT NULL,
  `in_ordem` tinyint(3) UNSIGNED DEFAULT NULL,
  `vc_texto` varchar(500) COLLATE utf8_bin DEFAULT NULL,
  `bl_removido` enum('0','1') COLLATE utf8_bin NOT NULL DEFAULT '0',
  PRIMARY KEY (`pr_etapa`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `tb_etapas`
--

INSERT INTO `tb_etapas` (`pr_etapa`, `vc_etapa`, `in_ordem`, `vc_texto`, `bl_removido`) VALUES
(1, 'Etapa 1 - Req. obrigatórios', 1, 'Para participar do processo de certificação para Superintendente Regional de Ensino, na Secretaria de Estado de Educação de Minas Gerais, é necessário que você cumpra os pré-requisitos publicados no documento de descrição da posição. Por favor, preencha os campo abaixo para verificar se você é elegível para esta posição. ', '0'),
(2, 'Etapa 2 - Req. desejáveis', 2, 'Processo de Avaliação não eliminatório', '0'),
(3, 'Etapa 3 - Aná. curricular', 3, 'Análise curricular pelo Avaliador ', '0'),
(4, 'Etapa 4 - Entrevista', 4, 'Avaliação pelo Gestor', '0'),
(5, 'Etapa 5 - Teste de aderência', 5, 'Teste de aderência feito pelo candidato', '0'),
(6, 'Etapa 7 - Entrevista com especialista', 7, 'Avaliação com o especialista', '0'),
(7, 'Etapa 6 - Teste de Motivação', 6, 'Teste de Motivação de Serviço Público', '0');

-- --------------------------------------------------------

--
-- Table structure for table `tb_experiencias`
--

DROP TABLE IF EXISTS `tb_experiencias`;
CREATE TABLE IF NOT EXISTS `tb_experiencias` (
  `pr_experienca` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `es_experiencia_pai` int(11) UNSIGNED DEFAULT NULL,
  `es_candidato` int(10) UNSIGNED NOT NULL,
  `es_candidatura` int(10) UNSIGNED DEFAULT NULL,
  `vc_cargo` varchar(300) COLLATE utf8_bin DEFAULT NULL,
  `vc_empresa` varchar(100) COLLATE utf8_bin NOT NULL,
  `ye_inicio` year(4) DEFAULT NULL,
  `me_inicio` int(2) DEFAULT NULL,
  `dt_inicio` date DEFAULT NULL,
  `ye_fim` year(4) DEFAULT NULL,
  `me_fim` int(2) DEFAULT NULL,
  `dt_fim` date DEFAULT NULL,
  `bl_emprego_atual` enum('0','1') COLLATE utf8_bin DEFAULT NULL,
  `tx_atividades` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`pr_experienca`),
  KEY `es_experiencia_pai` (`es_experiencia_pai`),
  KEY `es_candidatura` (`es_candidatura`),
  KEY `es_candidato` (`es_candidato`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9515 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `tb_formacao`
--

DROP TABLE IF EXISTS `tb_formacao`;
CREATE TABLE IF NOT EXISTS `tb_formacao` (
  `pr_formacao` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `es_formacao_pai` int(10) UNSIGNED DEFAULT NULL,
  `es_candidato` int(10) UNSIGNED NOT NULL,
  `es_candidatura` int(10) UNSIGNED DEFAULT NULL,
  `vc_curso` varchar(100) COLLATE utf8_bin NOT NULL,
  `en_tipo` enum('bacharelado','tecnologo','especializacao','mba','mestrado','doutorado','posdoc','seminario') COLLATE utf8_bin NOT NULL,
  `vc_instituicao` varchar(100) COLLATE utf8_bin NOT NULL,
  `ye_conclusao` year(4) DEFAULT NULL,
  `se_conclusao` int(2) DEFAULT NULL,
  `me_conclusao` int(2) DEFAULT NULL,
  `in_cargahoraria` int(10) UNSIGNED DEFAULT NULL,
  `dt_conclusao` date DEFAULT NULL,
  PRIMARY KEY (`pr_formacao`),
  KEY `es_formacao_pai` (`es_formacao_pai`),
  KEY `es_candidatura` (`es_candidatura`),
  KEY `es_candidato` (`es_candidato`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9861 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `tb_gruposvagas`
--

DROP TABLE IF EXISTS `tb_gruposvagas`;
CREATE TABLE IF NOT EXISTS `tb_gruposvagas` (
  `pr_grupovaga` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `vc_grupovaga` varchar(250) COLLATE utf8_bin NOT NULL,
  `es_instituicao` int(10) UNSIGNED DEFAULT NULL,
  `es_usuarioCadastro` int(10) UNSIGNED DEFAULT NULL,
  `dt_cadastro` date DEFAULT NULL,
  `es_usuarioAlteracao` int(10) UNSIGNED DEFAULT NULL,
  `dt_alteracao` date DEFAULT NULL,
  `bl_removido` enum('0','1') COLLATE utf8_bin NOT NULL DEFAULT '0',
  PRIMARY KEY (`pr_grupovaga`),
  KEY `es_usuarioCadastro` (`es_usuarioCadastro`),
  KEY `es_usuarioAlteracao` (`es_usuarioAlteracao`),
  KEY `es_instituicao` (`es_instituicao`)
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `tb_hbdi`
--

DROP TABLE IF EXISTS `tb_hbdi`;
CREATE TABLE IF NOT EXISTS `tb_hbdi` (
  `pr_hbdi` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `es_candidatura` int(10) UNSIGNED NOT NULL,
  `dt_hbdi` datetime NOT NULL,
  `bl_motivacao_trabalho1` tinyint(1) DEFAULT NULL,
  `bl_motivacao_trabalho2` tinyint(1) DEFAULT NULL,
  `bl_motivacao_trabalho3` tinyint(1) DEFAULT NULL,
  `bl_motivacao_trabalho4` tinyint(1) DEFAULT NULL,
  `bl_motivacao_trabalho5` tinyint(1) DEFAULT NULL,
  `bl_motivacao_trabalho6` tinyint(1) DEFAULT NULL,
  `bl_motivacao_trabalho7` tinyint(1) DEFAULT NULL,
  `bl_motivacao_trabalho8` tinyint(1) DEFAULT NULL,
  `bl_motivacao_trabalho9` tinyint(1) DEFAULT NULL,
  `bl_motivacao_trabalho10` tinyint(1) DEFAULT NULL,
  `bl_motivacao_trabalho11` tinyint(1) DEFAULT NULL,
  `bl_motivacao_trabalho12` tinyint(1) DEFAULT NULL,
  `bl_motivacao_trabalho13` tinyint(1) DEFAULT NULL,
  `bl_motivacao_trabalho14` tinyint(1) DEFAULT NULL,
  `bl_motivacao_trabalho15` tinyint(1) DEFAULT NULL,
  `bl_motivacao_trabalho16` tinyint(1) DEFAULT NULL,
  `bl_motivacao_trabalho17` tinyint(1) DEFAULT NULL,
  `bl_motivacao_trabalho18` tinyint(1) DEFAULT NULL,
  `bl_motivacao_trabalho19` tinyint(1) DEFAULT NULL,
  `bl_motivacao_trabalho20` tinyint(1) DEFAULT NULL,
  `bl_gosto1` tinyint(1) DEFAULT NULL,
  `bl_gosto2` tinyint(1) DEFAULT NULL,
  `bl_gosto3` tinyint(1) DEFAULT NULL,
  `bl_gosto4` tinyint(1) DEFAULT NULL,
  `bl_gosto5` tinyint(1) DEFAULT NULL,
  `bl_gosto6` tinyint(1) DEFAULT NULL,
  `bl_gosto7` tinyint(1) DEFAULT NULL,
  `bl_gosto8` tinyint(1) DEFAULT NULL,
  `bl_gosto9` tinyint(1) DEFAULT NULL,
  `bl_gosto10` tinyint(1) DEFAULT NULL,
  `bl_gosto11` tinyint(1) DEFAULT NULL,
  `bl_gosto12` tinyint(1) DEFAULT NULL,
  `bl_gosto13` tinyint(1) DEFAULT NULL,
  `bl_gosto14` tinyint(1) DEFAULT NULL,
  `bl_gosto15` tinyint(1) DEFAULT NULL,
  `bl_gosto16` tinyint(1) DEFAULT NULL,
  `bl_gosto17` tinyint(1) DEFAULT NULL,
  `bl_gosto18` tinyint(1) DEFAULT NULL,
  `bl_gosto19` tinyint(1) DEFAULT NULL,
  `bl_gosto20` tinyint(1) DEFAULT NULL,
  `bl_prefiro1` tinyint(1) DEFAULT NULL,
  `bl_prefiro2` tinyint(1) DEFAULT NULL,
  `bl_prefiro3` tinyint(1) DEFAULT NULL,
  `bl_prefiro4` tinyint(1) DEFAULT NULL,
  `bl_prefiro5` tinyint(1) DEFAULT NULL,
  `bl_prefiro6` tinyint(1) DEFAULT NULL,
  `bl_prefiro7` tinyint(1) DEFAULT NULL,
  `bl_prefiro8` tinyint(1) DEFAULT NULL,
  `bl_prefiro9` tinyint(1) DEFAULT NULL,
  `bl_prefiro10` tinyint(1) DEFAULT NULL,
  `bl_prefiro11` tinyint(1) DEFAULT NULL,
  `bl_prefiro12` tinyint(1) DEFAULT NULL,
  `bl_prefiro13` tinyint(1) DEFAULT NULL,
  `bl_prefiro14` tinyint(1) DEFAULT NULL,
  `bl_prefiro15` tinyint(1) DEFAULT NULL,
  `bl_prefiro16` tinyint(1) DEFAULT NULL,
  `bl_prefiro17` tinyint(1) DEFAULT NULL,
  `bl_prefiro18` tinyint(1) DEFAULT NULL,
  `bl_prefiro19` tinyint(1) DEFAULT NULL,
  `bl_prefiro20` tinyint(1) DEFAULT NULL,
  `in_pergunta` int(11) DEFAULT NULL,
  `bl_fazer1` tinyint(1) DEFAULT NULL,
  `bl_fazer2` tinyint(1) DEFAULT NULL,
  `bl_fazer3` tinyint(1) DEFAULT NULL,
  `bl_fazer4` tinyint(1) DEFAULT NULL,
  `bl_fazer5` tinyint(1) DEFAULT NULL,
  `bl_fazer6` tinyint(1) DEFAULT NULL,
  `bl_fazer7` tinyint(1) DEFAULT NULL,
  `bl_fazer8` tinyint(1) DEFAULT NULL,
  `bl_fazer9` tinyint(1) DEFAULT NULL,
  `bl_fazer10` tinyint(1) DEFAULT NULL,
  `bl_fazer11` tinyint(1) DEFAULT NULL,
  `bl_fazer12` tinyint(1) DEFAULT NULL,
  `bl_fazer13` tinyint(1) DEFAULT NULL,
  `bl_fazer14` tinyint(1) DEFAULT NULL,
  `bl_fazer15` tinyint(1) DEFAULT NULL,
  `bl_fazer16` tinyint(1) DEFAULT NULL,
  `bl_comprar1` tinyint(1) DEFAULT NULL,
  `bl_comprar2` tinyint(1) DEFAULT NULL,
  `bl_comprar3` tinyint(1) DEFAULT NULL,
  `bl_comprar4` tinyint(1) DEFAULT NULL,
  `bl_comprar5` tinyint(1) DEFAULT NULL,
  `bl_comprar6` tinyint(1) DEFAULT NULL,
  `bl_comprar7` tinyint(1) DEFAULT NULL,
  `bl_comprar8` tinyint(1) DEFAULT NULL,
  `bl_comprar9` tinyint(1) DEFAULT NULL,
  `bl_comprar10` tinyint(1) DEFAULT NULL,
  `bl_comprar11` tinyint(1) DEFAULT NULL,
  `bl_comprar12` tinyint(1) DEFAULT NULL,
  `bl_comprar13` tinyint(1) DEFAULT NULL,
  `bl_comprar14` tinyint(1) DEFAULT NULL,
  `bl_comprar15` tinyint(1) DEFAULT NULL,
  `bl_comprar16` tinyint(1) DEFAULT NULL,
  `bl_comprar17` tinyint(1) DEFAULT NULL,
  `bl_comprar18` tinyint(1) DEFAULT NULL,
  `bl_comprar19` tinyint(1) DEFAULT NULL,
  `bl_comprar20` tinyint(1) DEFAULT NULL,
  `in_comportamento` int(11) DEFAULT NULL,
  `bl_estilo1` tinyint(1) DEFAULT NULL,
  `bl_estilo2` tinyint(1) DEFAULT NULL,
  `bl_estilo3` tinyint(1) DEFAULT NULL,
  `bl_estilo4` tinyint(1) DEFAULT NULL,
  `bl_estilo5` tinyint(1) DEFAULT NULL,
  `bl_estilo6` tinyint(1) DEFAULT NULL,
  `bl_estilo7` tinyint(1) DEFAULT NULL,
  `bl_estilo8` tinyint(1) DEFAULT NULL,
  `bl_estilo9` tinyint(1) DEFAULT NULL,
  `bl_estilo10` tinyint(1) DEFAULT NULL,
  `bl_estilo11` tinyint(1) DEFAULT NULL,
  `bl_estilo12` tinyint(1) DEFAULT NULL,
  `bl_estilo13` tinyint(1) DEFAULT NULL,
  `bl_estilo14` tinyint(1) DEFAULT NULL,
  `bl_estilo15` tinyint(1) DEFAULT NULL,
  `bl_estilo16` tinyint(1) DEFAULT NULL,
  `bl_ponto_fraco1` tinyint(1) DEFAULT NULL,
  `bl_ponto_fraco2` tinyint(1) DEFAULT NULL,
  `bl_ponto_fraco3` tinyint(1) DEFAULT NULL,
  `bl_ponto_fraco4` tinyint(1) DEFAULT NULL,
  `bl_ponto_fraco5` tinyint(1) DEFAULT NULL,
  `bl_ponto_fraco6` tinyint(1) DEFAULT NULL,
  `bl_ponto_fraco7` tinyint(1) DEFAULT NULL,
  `bl_ponto_fraco8` tinyint(1) DEFAULT NULL,
  `bl_ponto_fraco9` tinyint(1) DEFAULT NULL,
  `bl_ponto_fraco10` tinyint(1) DEFAULT NULL,
  `bl_ponto_fraco11` tinyint(1) DEFAULT NULL,
  `bl_ponto_fraco12` tinyint(1) DEFAULT NULL,
  `bl_ponto_fraco13` tinyint(1) DEFAULT NULL,
  `bl_ponto_fraco14` tinyint(1) DEFAULT NULL,
  `bl_ponto_fraco15` tinyint(1) DEFAULT NULL,
  `bl_ponto_fraco16` tinyint(1) DEFAULT NULL,
  `bl_ponto_fraco17` tinyint(1) DEFAULT NULL,
  `bl_ponto_fraco18` tinyint(1) DEFAULT NULL,
  `bl_ponto_fraco19` tinyint(1) DEFAULT NULL,
  `bl_ponto_fraco20` tinyint(1) DEFAULT NULL,
  `in_resolver` int(11) DEFAULT NULL,
  `in_procuro` int(11) DEFAULT NULL,
  `bl_frase1` tinyint(1) DEFAULT NULL,
  `bl_frase2` tinyint(1) DEFAULT NULL,
  `bl_frase3` tinyint(1) DEFAULT NULL,
  `bl_frase4` tinyint(1) DEFAULT NULL,
  `bl_frase5` tinyint(1) DEFAULT NULL,
  `bl_frase6` tinyint(1) DEFAULT NULL,
  `bl_frase7` tinyint(1) DEFAULT NULL,
  `bl_frase8` tinyint(1) DEFAULT NULL,
  `bl_frase9` tinyint(1) DEFAULT NULL,
  `bl_frase10` tinyint(1) DEFAULT NULL,
  `bl_frase11` tinyint(1) DEFAULT NULL,
  `bl_frase12` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`pr_hbdi`),
  UNIQUE KEY `es_candidatura` (`es_candidatura`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tb_historicocandidaturas`
--

DROP TABLE IF EXISTS `tb_historicocandidaturas`;
CREATE TABLE IF NOT EXISTS `tb_historicocandidaturas` (
  `pr_historico` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `es_candidatura` int(10) UNSIGNED NOT NULL,
  `es_etapa` int(10) UNSIGNED NOT NULL,
  `es_avaliador` int(10) UNSIGNED DEFAULT NULL,
  `dt_avaliacao` datetime NOT NULL,
  `bl_apto` enum('0','1') COLLATE utf8_bin NOT NULL,
  `in_nota` tinyint(3) UNSIGNED DEFAULT NULL,
  `tx_observacao` mediumtext COLLATE utf8_bin,
  `es_usuarioCadastro` int(10) UNSIGNED NOT NULL,
  `dt_cadastro` datetime NOT NULL,
  `es_usuarioAlteracao` int(10) UNSIGNED NOT NULL,
  `dt_alteracao` datetime NOT NULL,
  `bl_removido` enum('0','1') COLLATE utf8_bin NOT NULL DEFAULT '0',
  PRIMARY KEY (`pr_historico`),
  KEY `IdCandidatura` (`es_candidatura`),
  KEY `IdEtapa` (`es_etapa`),
  KEY `IdAvaliador` (`es_avaliador`),
  KEY `IdUsuarioCadastrador` (`es_usuarioCadastro`),
  KEY `IdUsuarioUltimoAlterador` (`es_usuarioAlteracao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `tb_instituicoes2`
--

DROP TABLE IF EXISTS `tb_instituicoes2`;
CREATE TABLE IF NOT EXISTS `tb_instituicoes2` (
  `pr_instituicao` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `DDNRPESSOAFISJUR` int(10) UNSIGNED DEFAULT NULL,
  `vc_instituicao` varchar(255) NOT NULL,
  `in_tipounidade` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `vc_sigla` varchar(50) NOT NULL,
  `en_sexonome` enum('m','f') DEFAULT NULL,
  `bl_extinto` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`pr_instituicao`),
  UNIQUE KEY `DDNRPESSOAFISJUR` (`DDNRPESSOAFISJUR`)
) ENGINE=InnoDB AUTO_INCREMENT=1260372 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_instituicoes2`
--

INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES
(1, NULL, 'INSTITUICAO C/ CODIGO DE UNIDADE NAO INFORMADO', 0, 'INVALIDO', 'm', '1'),
(2, 2, 'Vice Governadoria do Estado', 2, 'VICEGOVERNADORIA', 'f', '0'),
(9, NULL, 'Caixa de Amortização da Dívida', 8, 'CADIV', 'f', '0'),
(1071, 1857449, 'Gabinete Militar do Governador do Estado', 4, 'GMG', 'm', '0'),
(1081, 1858199, 'Advocacia Geral do Estado', 4, 'AGE', 'f', '0'),
(1101, 2939378, 'Ouvidoria Geral do Estado de Minas Gerais', 4, 'OGE', 'f', '0'),
(1111, 1857428, 'Escritório de Representação do Governo de Minas Gerais em Brasília', 4, 'ERGMG-BSB', 'm', '0'),
(1121, 1857416, 'Secretaria do Governo', 3, 'SEGOV', 'f', '1'),
(1141, 1791028, 'Escritório de Representação do Governo de Minas Gerais no RJ', 4, 'ERGMG-RJ', 'm', '1'),
(1161, 1808437, 'Escritório de Representação do Governo de Minas Gerais em SP', 4, 'ERGMG-SP', 'm', '1'),
(1171, 1858268, 'Secretaria de Estado de Recursos Humanos e Administração', 3, 'SERHA', 'f', '1'),
(1191, 1858211, 'Secretaria de Estado de Fazenda', 3, 'SEF', 'f', '0'),
(1201, 1858214, 'Secretaria de Estado de Planejamento e Coordenação', 3, 'SEPLAN', 'f', '1'),
(1221, 1858203, 'Secretaria de Estado de Desenvolvimento Econômico, Ciência, Tecnologia e Ensino Superior', 3, 'SEDECTES', 'f', '0'),
(1231, 1858202, 'Secretaria de Estado de Agricultura, Pecuária e Abastecimento', 3, 'SEAPA', 'f', '0'),
(1251, 1857466, 'Polícia Militar do Estado de Minas Gerais', 4, 'PMMG', 'f', '0'),
(1261, 1858210, 'Secretaria de Estado de Educação', 3, 'SEE', 'f', '0'),
(1271, 1858208, 'Secretaria de Estado de Cultura e Turismo', 3, 'SECULT', 'f', '0'),
(1281, 1858209, 'Secretaria de Esportes', 1, 'SEESP', 'f', '1'),
(1301, 1858216, 'Secretaria de Estado de Infraestrutura e Mobilidade', 3, 'SEINFRA', 'f', '0'),
(1311, 1858205, 'Secretaria de Indústria', 3, 'SEI', 'f', '1'),
(1321, 1858213, 'Secretaria de Estado de Saúde', 3, 'SES', 'f', '0'),
(1341, 1857419, 'Coordenadoria de Apoio e Assistência à Pessoa Deficiente', 4, 'CAADE', 'f', '1'),
(1371, 1857447, 'Secretaria de Estado de Meio Ambiente e Desenvolvimento Sustentável', 3, 'SEMAD', 'f', '0'),
(1381, 1858267, 'Secretaria de Estado do Trabalho, da Assistência Social, da Criança e do Adolescente', 3, 'SETASCAD', 'f', '1'),
(1401, 2671339, 'Corpo de Bombeiros Militar de Minas Gerais', 4, 'CBMMG', 'm', '0'),
(1411, 2716739, 'Secretaria de Estado de Turismo', 3, 'SETUR', 'f', '0'),
(1421, 1791031, 'SECRETARIA COMUNICACAO SOCIAL ', 0, 'SECS', 'f', '1'),
(1441, 2873312, 'Defensoria Pública do Estado de Minas Gerais', 4, 'DPMG', 'f', '0'),
(1451, 1858212, 'Secretaria de Estado de Administração Prisional', 3, 'SEAP', 'f', '0'),
(1461, 2873313, 'Secretaria de Estado de Desenvolvimento Econômico', 3, 'SEDE', 'f', '0'),
(1471, 1858204, 'Secretaria de Estado de Cidades e de Integração Regional', 3, 'SECIR', 'f', '0'),
(1481, 2873309, 'Secretaria de Estado de Trabalho e Desenvolvimento Social', 3, 'SEDESE', 'f', '0'),
(1491, 2873308, 'Secretaria de Estado de Governo', 3, 'SEGOV', 'f', '0'),
(1501, 2873307, 'Secretaria de Estado de Planejamento e Gestão', 3, 'SEPLAG', 'f', '0'),
(1511, 1858215, 'Polícia Civil do Estado de Minas Gerais', 4, 'PCMG', 'f', '0'),
(1521, 2273949, 'Controladoria Geral do Estado', 4, 'CGE', 'f', '0'),
(1531, 3017980, 'Secretaria de Estado de Esportes e da Juventude', 3, 'SEEJ', 'f', '1'),
(1541, 3017981, 'Escola de Saúde Pública de Minas Gerais', 4, 'ESP', 'f', '0'),
(1571, 3189804, 'Secretaria de Estado de Casa Civil e de Relações Institucionais', 3, 'SECCRI', 'f', '0'),
(1581, 3189872, 'Secretaria de Estado de Trabalho e Emprego', 3, 'SETE', 'f', '1'),
(1591, 3189873, 'Secretaria de Estado de Desenvolvimento e Integração do Norte e Nordeste de Minas Gerais', 3, 'SEDINOR', 'f', '0'),
(1601, 3190139, 'Escritório de Prioridades Estratégicas', 3, 'EPE', 'm', '1'),
(1631, 3200569, 'Secretaria Geral', 1, 'SG', 'f', '0'),
(1641, 3347491, 'Secretaria de Estado de Desenvolvimento Agrário', 3, 'SEDA', 'f', '0'),
(1651, 3346710, 'Secretaria de Estado de Direitos Humanos, Participação Social e Cidadania', 3, 'SEDPAC', 'f', '0'),
(1671, 3347506, 'Secretaria de Estado de Esportes ', 3, 'SEESP', 'f', '0'),
(1691, 3408097, 'Secretaria de Estado de Segurança Pública', 3, 'SESP', 'f', '0'),
(1692, NULL, 'INSTITUICAO C/ CODIGO DE UNIDADE NAO INFORMADO', 0, 'INVALIDO', 'm', '1'),
(1693, NULL, 'INSTITUICAO C/ CODIGO DE UNIDADE NAO INFORMADO', 0, 'INVALIDO', 'm', '1'),
(1701, 3414458, 'Secretaria de Estado Extraordinária de Desenvolvimento Integrado', 3, 'SEEDIF', 'f', '1'),
(1941, 1853802, 'ENCARGOS GERAIS PLANEJAMENTO E GESTAO', 0, 'ENCARGOS', 'm', '1'),
(2011, 1857455, 'Instituto de Previdência dos Servidores do Estado de Minas Gerais', 6, 'IPSEMG', 'm', '0'),
(2041, 1857459, 'Loteria do Estado de Minas Gerais', 6, 'LEMG', 'f', '0'),
(2061, 1857440, 'Fundação João Pinheiro', 5, 'FJP', 'f', '0'),
(2071, 1857430, 'Fundação de Amparo a Pesquisa do Estado de Minas Gerais', 5, 'FAPEMIG', 'f', '0'),
(2081, 1857417, 'Fundação Centro Tecnológico de Minas Gerais', 5, 'CETEC', 'f', '0'),
(2091, 2273955, 'Fundação Estadual do Meio Ambiente', 5, 'FEAM', 'f', '0'),
(2101, 1767133, 'Instituto Estadual de Florestas', 6, 'IEF', 'm', '0'),
(2111, 1858201, 'Fundação Rural Mineira', 5, 'RURALMINAS', 'f', '0'),
(2121, 1857454, 'Instituto de Previdência dos Servidores Militares do Estado de Minas Gerais', 6, 'IPSM', 'm', '0'),
(2141, 1857422, 'Departamento de Obras Públicas do Estado de Minas Gerais', 6, 'DEOP', 'm', '1'),
(2151, 1857438, 'Fundação Helena Antipoff', 5, 'FHA', 'f', '0'),
(2161, 1857434, 'Fundação Educacional Caio Martins', 5, 'FUCAM', 'f', '0'),
(2171, 1857429, 'Fundação de Arte de Ouro Preto', 5, 'FAOP', 'f', '0'),
(2181, 1857432, 'Fundação Clóvis Salgado', 5, 'FCS', 'f', '0'),
(2201, 1857451, 'Instituto Estadual do Patrimônio Histórico e Artístico de Minas Gerais', 5, 'IEPHA', 'm', '0'),
(2211, 1858561, 'Fundação TV Minas', 5, 'TVMINAS', 'f', '0'),
(2231, 1853800, 'Administração de Estádios do Estado de Minas Gerais', 6, 'ADEMG', 'f', '1'),
(2241, 2273951, 'Instituto Mineiro de Gestão das Águas', 6, 'IGAM', 'm', '0'),
(2251, 1857457, 'Junta Comercial do Estado de Minas Gerais', 6, 'JUCEMG', 'f', '0'),
(2261, 1857448, 'Fundação Ezequiel Dias', 5, 'FUNED', 'f', '0'),
(2271, 1857431, 'Fundação Hospitalar do Estado de Minas Gerais', 5, 'FHEMIG', 'f', '0'),
(2281, 1858563, 'Fundação de Educação para o Trabalho de Minas Gerais', 5, 'UTRAMIG', 'f', '0'),
(2301, 1857424, 'Departamento de Edificações e Estradas de Rodagem do Estado de Minas Gerais', 6, 'DEER', 'm', '0'),
(2311, 1858562, 'Universidade Estadual de Montes Claros', 6, 'UNIMONTES', 'f', '0'),
(2321, 1857439, 'Fundação Centro de Hematologia e Hemoterapia do Estado de Minas Gerais', 5, 'HEMOMINAS', 'f', '0'),
(2331, 1857456, 'Instituto de Metrologia e Qualidade', 6, 'IPEM', 'm', '0'),
(2351, 1806206, 'Universidade do Estado de Minas Gerais', 6, 'UEMG', 'f', '0'),
(2371, 1862379, 'Instituto Mineiro de Agropecuária', 6, 'IMA', 'm', '0'),
(2381, 1857423, 'Departamento Estadual de Telecomunicações de Minas Gerais', 6, 'DETEL', 'm', '1'),
(2391, 1857452, 'Imprensa Oficial do Estado de Minas Gerais', 6, 'IOF', 'f', '1'),
(2401, 2426354, 'Instituto de Geoinformação e Tecnologia', 6, 'IGTEC', 'm', '0'),
(2411, 2855048, 'Instituto de Terras do Estado de Minas Gerais', 6, 'ITER', 'm', '1'),
(2421, 1857418, 'Instituto de Desenvolvimento do Norte e Nordeste de Minas Gerais', 6, 'IDENE', 'm', '0'),
(2431, 3115953, 'Agência de Desenvolvimento da Região Metropolitana de Belo Horizonte', 6, 'ARMBH', 'f', '0'),
(2441, 3133385, 'Agência Reguladora de Serviços de Abastecimento de Água e de Esgotamento Sanitário do Estado de Minas Gerais', 6, 'ARSAE', 'f', '0'),
(2451, 3146991, 'Fundação Centro Internacional de Educação Capacitação e Pesquisa Aplicada em Águas', 5, 'HIDROEX', 'f', '0'),
(2461, 3230042, 'Agência Metropolitana do Vale do Aço', 6, 'ARMVA', 'f', '0'),
(3001, NULL, 'Secretaria de Estado Extraordinária para Assuntos de Reforma Agrária', 3, 'SEARA', 'f', '0'),
(3041, 2426998, 'Empresa de Assistência Técnica e Extensão Rural do Estado de Minas Gerais', 8, 'EMATER', 'f', '0'),
(3051, 2426999, 'Empresa de Pesquisa Agropecuária de Minas Gerais', 8, 'EPAMIG', 'f', '0'),
(3151, 1858200, 'Rádio Inconfidência Ltda.', 8, 'INCONFIDENCIA', 'f', '0'),
(3261, NULL, 'Transportes Metropolitanos de Belo Horizonte S.A.', 8, 'METROMINAS', 'f', '0'),
(5011, 2426992, 'Companhia de Desenvolvimento Econômico de Minas Gerais', 8, 'CODEMIG', 'f', '0'),
(5071, 2426982, 'Companhia de Habitação do Estado de Minas Gerais', 8, 'COHAB', 'f', '0'),
(5080, NULL, 'Companhia de Saneamento de Minas Gerais', 8, 'COPASA', 'f', '0'),
(5121, 2426989, 'Companhia Energética de Minas Gerais', 8, 'CEMIG', 'f', '0'),
(5131, 2427004, 'Instituto de Desenvolvimento Integrado de Minas Gerais', 6, 'INDI', 'm', '0'),
(5141, 1764024, 'Companhia de Tecnologia da Informação do Estado de Minas Gerais', 8, 'PRODEMGE', 'f', '0'),
(5181, 2426997, 'Distribuidora de Títulos e Valores Mobiliários de Minas Gerais S.A.', 8, 'DIMINAS', 'f', '0'),
(5191, 2427005, 'Minas Gerais Participações S.A.', 8, 'MGI', 'f', '0'),
(5201, 2426925, 'Banco de Desenvolvimento de Minas Gerais S.A.', 8, 'BDMG', 'm', '0'),
(5241, 2426990, 'Companhia Mineira de Promoções', 8, 'PROMINAS', 'f', '0'),
(5251, NULL, 'Companhia de Gás de Minas Gerais', 8, 'GASMIG', 'f', '0'),
(5381, 2427008, 'Minas Gerais Administração e Serviços S.A.', 8, 'MGS', 'f', '0'),
(1260365, NULL, 'Secretaria de Estado Extraordinária da Copa do Mundo', 3, 'SECOPA', 'f', '1'),
(1260366, NULL, 'Secretaria de Estado Extraordinária de Gestão Metropolitana', 3, 'SEEGM', 'f', '1'),
(1260367, NULL, 'Secretaria de Estado Extraordinária de Regularização Fundiária', 3, 'SEERF', 'f', '1'),
(1260368, NULL, 'Conselho Estadual de Educação', 8, 'CEE', 'm', '0'),
(1260370, NULL, 'INSTITUICAO C/ CODIGO DE UNIDADE NAO INFORMADO', 0, 'INVALIDO', 'm', '1'),
(1260371, NULL, 'Conselho Nacional de Secretários de Estado da Administração', 0, 'CONSAD', 'm', '0');

-- --------------------------------------------------------

--
-- Table structure for table `tb_log`
--

DROP TABLE IF EXISTS `tb_log`;
CREATE TABLE IF NOT EXISTS `tb_log` (
  `pr_log` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `dt_log` datetime NOT NULL,
  `en_tipo` enum('erro','seguranca','sucesso','advertencia') COLLATE utf8_bin NOT NULL,
  `vc_local` varchar(100) COLLATE utf8_bin NOT NULL,
  `es_usuario` int(10) UNSIGNED DEFAULT NULL,
  `vc_tabela` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `in_chave` int(10) UNSIGNED DEFAULT NULL,
  `tx_texto` mediumtext COLLATE utf8_bin NOT NULL,
  `vc_ip` varchar(15) COLLATE utf8_bin NOT NULL,
  `vc_sessao` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`pr_log`),
  KEY `es_usuario` (`es_usuario`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=342417 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `tb_municipios`
--

DROP TABLE IF EXISTS `tb_municipios`;
CREATE TABLE IF NOT EXISTS `tb_municipios` (
  `pr_municipio` bigint(20) NOT NULL AUTO_INCREMENT,
  `es_uf` int(10) UNSIGNED NOT NULL,
  `in_codigo` int(10) UNSIGNED NOT NULL,
  `vc_municipio` varchar(250) COLLATE utf8_bin NOT NULL,
  `bl_removido` enum('0','1') COLLATE utf8_bin NOT NULL DEFAULT '0',
  PRIMARY KEY (`pr_municipio`),
  KEY `es_uf` (`es_uf`)
) ENGINE=InnoDB AUTO_INCREMENT=5566 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `tb_notas`
--

DROP TABLE IF EXISTS `tb_notas`;
CREATE TABLE IF NOT EXISTS `tb_notas` (
  `pr_nota` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `es_candidatura` int(10) UNSIGNED NOT NULL,
  `in_nota` int(10) UNSIGNED NOT NULL,
  `es_etapa` int(10) UNSIGNED NOT NULL,
  `es_competencia` int(10) UNSIGNED DEFAULT NULL,
  `es_avaliador` int(10) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`pr_nota`),
  UNIQUE KEY `es_candidatura_2` (`es_candidatura`,`es_etapa`,`es_competencia`,`es_avaliador`),
  KEY `es_candidatura` (`es_candidatura`),
  KEY `es_etapa` (`es_etapa`),
  KEY `es_competencia` (`es_competencia`),
  KEY `es_avaliador` (`es_avaliador`)
) ENGINE=InnoDB AUTO_INCREMENT=2812 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tb_notas_totais`
--

DROP TABLE IF EXISTS `tb_notas_totais`;
CREATE TABLE IF NOT EXISTS `tb_notas_totais` (
  `pr_nota_total` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `es_vaga` int(10) UNSIGNED NOT NULL,
  `in_nota_total` int(10) UNSIGNED NOT NULL,
  `es_etapa` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`pr_nota_total`),
  UNIQUE KEY `es_vaga_2` (`es_vaga`,`es_etapa`),
  KEY `es_vaga` (`es_vaga`),
  KEY `es_etapa` (`es_etapa`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8;


-- --------------------------------------------------------
--
-- Table structure for table `tb_instituicoes3`
--

CREATE TABLE IF NOT EXISTS `tb_instituicoes3` (
  `pr_instituicao` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vc_instituicao` varchar(250) COLLATE utf8_bin NOT NULL,
  `vc_sigla` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `in_codigo` int(10) unsigned DEFAULT NULL,
  `vc_cnpj` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `bl_removido` enum('0','1') COLLATE utf8_bin NOT NULL DEFAULT '0',
  PRIMARY KEY (`pr_instituicao`),
  UNIQUE KEY `in_codigo` (`in_codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


-- --------------------------------------------------------

--
-- Table structure for table `tb_opcoes`
--

DROP TABLE IF EXISTS `tb_opcoes`;
CREATE TABLE IF NOT EXISTS `tb_opcoes` (
  `pr_opcao` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `es_questao` int(10) UNSIGNED NOT NULL,
  `tx_opcao` mediumtext COLLATE utf8_bin NOT NULL,
  `in_valor` int(10) UNSIGNED DEFAULT NULL,
  `bl_removido` enum('0','1') COLLATE utf8_bin NOT NULL DEFAULT '0',
  PRIMARY KEY (`pr_opcao`),
  KEY `IDQuestao` (`es_questao`)
) ENGINE=InnoDB AUTO_INCREMENT=8513 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;



-- --------------------------------------------------------
--
-- Table structure for table `tb_questoes`
--

DROP TABLE IF EXISTS `tb_questoes`;
CREATE TABLE IF NOT EXISTS `tb_questoes` (
  `pr_questao` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `es_etapa` int(10) UNSIGNED NOT NULL,
  `tx_questao` mediumtext COLLATE utf8_bin NOT NULL,
  `vc_respostaAceita` varchar(500) COLLATE utf8_bin DEFAULT NULL,
  `in_peso` tinyint(3) UNSIGNED DEFAULT NULL,
  `in_tipo` tinyint(3) UNSIGNED NOT NULL COMMENT '1: Customizadas; 2: Aberta; 3: Sim/Não (Sim positivo); 4: Sim/Não (Não positivo); 5: Nenhum/Básico/Intermediário/Avançado; 6 - Intervalo',
  `bl_eliminatoria` enum('0','1') COLLATE utf8_bin NOT NULL,
  `bl_obrigatorio` enum('0','1') COLLATE utf8_bin NOT NULL,
  `es_usuarioCadastro` int(10) UNSIGNED NOT NULL,
  `dt_cadastro` datetime NOT NULL,
  `es_usuarioAlteracao` int(10) UNSIGNED DEFAULT NULL,
  `dt_alteracao` datetime DEFAULT NULL,
  `bl_removido` enum('0','1') COLLATE utf8_bin NOT NULL DEFAULT '0',
  `es_competencia` int(10) UNSIGNED DEFAULT NULL,
  `bl_duplicado` enum('0','1') COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`pr_questao`),
  KEY `IdEtapa` (`es_etapa`),
  KEY `IdUsuarioCadastrador` (`es_usuarioCadastro`),
  KEY `idUsuarioUltimoAlterador` (`es_usuarioAlteracao`),
  KEY `es_competencia` (`es_competencia`)
) ENGINE=InnoDB AUTO_INCREMENT=3615 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `tb_respostas`
--

DROP TABLE IF EXISTS `tb_respostas`;
CREATE TABLE IF NOT EXISTS `tb_respostas` (
  `pr_resposta` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `es_candidatura` int(10) UNSIGNED NOT NULL,
  `es_questao` int(10) UNSIGNED NOT NULL,
  `es_opcao` int(10) UNSIGNED DEFAULT NULL,
  `tx_resposta` longtext COLLATE utf8_bin NOT NULL,
  `dt_resposta` datetime NOT NULL,
  `in_avaliacao` tinyint(3) UNSIGNED DEFAULT NULL,
  `dt_avaliacao` datetime DEFAULT NULL,
  `es_avaliador` int(10) UNSIGNED DEFAULT NULL,
  `es_usuarioCadastro` int(10) UNSIGNED DEFAULT NULL,
  `dt_cadastro` datetime DEFAULT NULL,
  `es_usuarioAlteracao` int(10) UNSIGNED DEFAULT NULL,
  `dt_alteracao` datetime DEFAULT NULL,
  `bl_removido` enum('0','1') COLLATE utf8_bin NOT NULL DEFAULT '0',
  PRIMARY KEY (`pr_resposta`),
  UNIQUE KEY `es_candidatura` (`es_candidatura`,`es_questao`,`es_avaliador`) USING BTREE,
  KEY `IdCandidatura` (`es_candidatura`),
  KEY `IdQuestao` (`es_questao`),
  KEY `IdAvaliador` (`es_avaliador`),
  KEY `IdUsuarioCadastrador` (`es_usuarioCadastro`),
  KEY `IdUsuarioUltimoAlterador` (`es_usuarioAlteracao`),
  KEY `es_opcao` (`es_opcao`)
) ENGINE=InnoDB AUTO_INCREMENT=93897 DEFAULT CHARSET=utf8 COLLATE=utf8_bin KEY_BLOCK_SIZE=8 ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `tb_sessoes`
--

DROP TABLE IF EXISTS `tb_sessoes`;
CREATE TABLE IF NOT EXISTS `tb_sessoes` (
  `id` varchar(128) COLLATE utf8_bin NOT NULL,
  `ip_address` varchar(45) COLLATE utf8_bin NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  `es_usuario` int(10) UNSIGNED DEFAULT NULL,
  KEY `ci_sessions_timestamp` (`timestamp`),
  KEY `es_usuario` (`es_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `tb_status_candidaturas`
--

DROP TABLE IF EXISTS `tb_status_candidaturas`;
CREATE TABLE IF NOT EXISTS `tb_status_candidaturas` (
  `pr_status` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `in_status_legado` tinyint(3) UNSIGNED DEFAULT NULL,
  `vc_status` varchar(50) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`pr_status`),
  UNIQUE KEY `in_status_legado` (`in_status_legado`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `tb_status_candidaturas`
--

INSERT INTO `tb_status_candidaturas` (`pr_status`, `in_status_legado`, `vc_status`) VALUES
(1, 1, 'Cadastro iniciado'),
(2, NULL, 'Cadastro indeferido'),
(3, NULL, 'Currículo Cadastrado'),
(4, 4, 'Aprovado(a) req. obrigatórios'),
(5, 5, 'Eliminado(a) req.  obrigatórios'),
(6, NULL, 'Currículo preenchido'),
(7, 6, 'Candidatura realizada'),
(8, NULL, 'Currículo Avaliado'),
(9, 9, 'Reprovado(a) análise curricular'),
(10, 8, 'Selecionado(a) para entrevista'),
(11, NULL, 'Avaliado(a) Entrevista por Competência'),
(12, NULL, 'Avaliado(a) Entrevista com especialista'),
(13, NULL, 'Eliminado(a) Revisão de requisitos'),
(14, 10, 'Aguardando decisão final'),
(15, 11, 'Eliminado(a) na entrevista'),
(16, NULL, 'Aguardando análise da autoridade máxima'),
(17, NULL, 'Req. desejáveis preenchidos'),
(18, NULL, 'Reprovado(a) no processo seletivo'),
(19, NULL, 'Aprovado(a) no processo seletivo'),
(20, NULL, 'Reprovado(a) Habilitação'),
(21, NULL, 'Reprovado(a) Habilitação (confirmado)');

-- --------------------------------------------------------

--
-- Table structure for table `tb_uf`
--

DROP TABLE IF EXISTS `tb_uf`;
CREATE TABLE IF NOT EXISTS `tb_uf` (
  `pr_uf` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ch_sigla` char(2) COLLATE utf8_bin NOT NULL,
  `vc_uf` varchar(20) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`pr_uf`),
  UNIQUE KEY `ds_sigla` (`ch_sigla`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `tb_uf`
--

INSERT INTO `tb_uf` (`pr_uf`, `ch_sigla`, `vc_uf`) VALUES
(1, 'AC', 'Acre'),
(2, 'AL', 'Alagoas'),
(3, 'AM', 'Amazonas'),
(4, 'AP', 'Amapá'),
(5, 'BA', 'Bahia'),
(6, 'CE', 'Ceará'),
(7, 'DF', 'Distrito Federal'),
(8, 'ES', 'Espírito Santo'),
(9, 'GO', 'Goiás'),
(10, 'MA', 'Maranhão'),
(11, 'MG', 'Minas Gerais'),
(12, 'MS', 'Mato Grosso do Sul'),
(13, 'MT', 'Mato Grosso'),
(14, 'PA', 'Pará'),
(15, 'PB', 'Paraíba'),
(16, 'PE', 'Pernambuco'),
(17, 'PI', 'Piauí'),
(18, 'PR', 'Paraná'),
(19, 'RJ', 'Rio de Janeiro'),
(20, 'RN', 'Rio Grande do Norte'),
(21, 'RO', 'Rondônia'),
(22, 'RR', 'Roraima'),
(23, 'RS', 'Rio Grande do Sul'),
(24, 'SC', 'Santa Catarina'),
(25, 'SE', 'Sergipe'),
(26, 'SP', 'SÃ£o Paulo'),
(27, 'TO', 'Tocantins');

-- --------------------------------------------------------

--
-- Table structure for table `tb_usuarios`
--

DROP TABLE IF EXISTS `tb_usuarios`;
CREATE TABLE IF NOT EXISTS `tb_usuarios` (
  `pr_usuario` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `es_candidato` int(10) UNSIGNED DEFAULT NULL,
  `en_perfil` enum('candidato','avaliador','sugesp','orgaos','administrador') COLLATE utf8_bin NOT NULL,
  `vc_nome` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `vc_email` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `vc_telefone` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `vc_login` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `vc_senha` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `vc_senha_temporaria` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `dt_cadastro` date DEFAULT NULL,
  `dt_alteracao` date DEFAULT NULL,
  `dt_ultimoacesso` datetime DEFAULT NULL,
  `bl_trocasenha` enum('0','1') COLLATE utf8_bin DEFAULT '1',
  `in_erros` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `bl_removido` enum('0','1') COLLATE utf8_bin DEFAULT '0',
  PRIMARY KEY (`pr_usuario`),
  KEY `IdCandidato` (`es_candidato`)
) ENGINE=InnoDB AUTO_INCREMENT=6649 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `tb_usuarios_bak`
--

DROP TABLE IF EXISTS `tb_usuarios_bak`;
CREATE TABLE IF NOT EXISTS `tb_usuarios_bak` (
  `pr_usuario` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `es_candidato` int(10) UNSIGNED DEFAULT NULL,
  `en_perfil` enum('candidato','avaliador','sugesp','orgaos','administrador') CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `vc_nome` varchar(250) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `vc_email` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `vc_telefone` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `vc_login` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `vc_senha` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `vc_senha_temporaria` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `dt_cadastro` date DEFAULT NULL,
  `dt_alteracao` date DEFAULT NULL,
  `dt_ultimoacesso` datetime DEFAULT NULL,
  `bl_trocasenha` enum('0','1') CHARACTER SET utf8 COLLATE utf8_bin DEFAULT '1',
  `in_erros` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `bl_removido` enum('0','1') CHARACTER SET utf8 COLLATE utf8_bin DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tb_vagas`
--

DROP TABLE IF EXISTS `tb_vagas`;
CREATE TABLE IF NOT EXISTS `tb_vagas` (
  `pr_vaga` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `vc_vaga` varchar(250) CHARACTER SET utf8 NOT NULL,
  `tx_descricao` text CHARACTER SET utf8,
  `dt_inicio` datetime DEFAULT NULL,
  `dt_fim` datetime DEFAULT NULL,
  `vc_linkEntrevista` varchar(300) CHARACTER SET utf8 DEFAULT NULL,
  `in_statusVaga` tinyint(3) UNSIGNED NOT NULL,
  `es_instituicao` int(10) UNSIGNED DEFAULT NULL,
  `es_instituicao2` int(10) UNSIGNED DEFAULT NULL,
  `es_grupoVaga` int(10) UNSIGNED DEFAULT NULL,
  `es_usuarioCadastro` int(10) UNSIGNED NOT NULL,
  `dt_cadastro` datetime NOT NULL,
  `es_usuarioAlteracao` int(10) UNSIGNED DEFAULT NULL,
  `dt_alteracao` datetime DEFAULT NULL,
  `bl_removido` enum('0','1') CHARACTER SET utf8 NOT NULL DEFAULT '0',
  `bl_liberado` enum('0','1') COLLATE utf8_bin DEFAULT NULL,
  `bl_brumadinho` tinyint(1) DEFAULT NULL,
  `bl_finalizado` enum('0','1') COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`pr_vaga`),
  KEY `IdOrgao` (`es_instituicao2`),
  KEY `IdGrupoVaga` (`es_grupoVaga`),
  KEY `es_usuarioCadastro` (`es_usuarioCadastro`),
  KEY `es_usuarioAlteracao` (`es_usuarioAlteracao`),
  KEY `es_instituicao` (`es_instituicao`)
) ENGINE=InnoDB AUTO_INCREMENT=174 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `rl_experiencias_candidaturas`
--
ALTER TABLE `rl_experiencias_candidaturas`
  ADD CONSTRAINT `rl_experiencias_candidaturas_ibfk_1` FOREIGN KEY (`es_candidatura`) REFERENCES `tb_candidaturas` (`pr_candidatura`),
  ADD CONSTRAINT `rl_experiencias_candidaturas_ibfk_2` FOREIGN KEY (`es_experiencia`) REFERENCES `tb_experiencias` (`pr_experienca`);

--
-- Constraints for table `rl_formacoes_candidaturas`
--
ALTER TABLE `rl_formacoes_candidaturas`
  ADD CONSTRAINT `rl_formacoes_candidaturas_ibfk_1` FOREIGN KEY (`es_candidatura`) REFERENCES `tb_candidaturas` (`pr_candidatura`),
  ADD CONSTRAINT `rl_formacoes_candidaturas_ibfk_2` FOREIGN KEY (`es_formacao`) REFERENCES `tb_formacao` (`pr_formacao`);

--
-- Constraints for table `rl_gruposvagas_questoes`
--
ALTER TABLE `rl_gruposvagas_questoes`
  ADD CONSTRAINT `rl_gruposvagas_questoes_ibfk_1` FOREIGN KEY (`es_grupovaga`) REFERENCES `tb_gruposvagas` (`pr_grupovaga`),
  ADD CONSTRAINT `rl_gruposvagas_questoes_ibfk_2` FOREIGN KEY (`es_questao`) REFERENCES `tb_questoes` (`pr_questao`);

--
-- Constraints for table `rl_gruposvagas_questoes_duplicadas`
--
ALTER TABLE `rl_gruposvagas_questoes_duplicadas`
  ADD CONSTRAINT `rl_gruposvagas_questoes_duplicadas_ibfk_1` FOREIGN KEY (`es_usuario`) REFERENCES `tb_usuarios` (`pr_usuario`);

--
-- Constraints for table `rl_instituicoes_usuarios`
--
ALTER TABLE `rl_instituicoes_usuarios`
  ADD CONSTRAINT `rl_instituicoes_usuarios_ibfk_1` FOREIGN KEY (`es_instituicao`) REFERENCES `tb_instituicoes3` (`pr_instituicao`),
  ADD CONSTRAINT `rl_instituicoes_usuarios_ibfk_2` FOREIGN KEY (`es_usuario`) REFERENCES `tb_usuarios` (`pr_usuario`);

--
-- Constraints for table `rl_questoes_vagas`
--
ALTER TABLE `rl_questoes_vagas`
  ADD CONSTRAINT `rl_questoes_vagas_ibfk_1` FOREIGN KEY (`es_vaga`) REFERENCES `tb_vagas` (`pr_vaga`),
  ADD CONSTRAINT `rl_questoes_vagas_ibfk_2` FOREIGN KEY (`es_questao`) REFERENCES `tb_questoes` (`pr_questao`);

--
-- Constraints for table `rl_vagas_avaliadores`
--
ALTER TABLE `rl_vagas_avaliadores`
  ADD CONSTRAINT `rl_vagas_avaliadores_ibfk_1` FOREIGN KEY (`es_vaga`) REFERENCES `tb_vagas` (`pr_vaga`),
  ADD CONSTRAINT `rl_vagas_avaliadores_ibfk_2` FOREIGN KEY (`es_usuario`) REFERENCES `tb_usuarios` (`pr_usuario`);

--
-- Constraints for table `tb_anexos`
--
ALTER TABLE `tb_anexos`
  ADD CONSTRAINT `tb_anexos_ibfk_1` FOREIGN KEY (`es_candidatura`) REFERENCES `tb_candidaturas` (`pr_candidatura`),
  ADD CONSTRAINT `tb_anexos_ibfk_2` FOREIGN KEY (`es_usuarioCadastro`) REFERENCES `tb_usuarios` (`pr_usuario`),
  ADD CONSTRAINT `tb_anexos_ibfk_3` FOREIGN KEY (`es_usuarioAlteracao`) REFERENCES `tb_usuarios` (`pr_usuario`),
  ADD CONSTRAINT `tb_anexos_ibfk_5` FOREIGN KEY (`es_experiencia`) REFERENCES `tb_experiencias` (`pr_experienca`);

--
-- Constraints for table `tb_candidatos`
--
ALTER TABLE `tb_candidatos`
  ADD CONSTRAINT `tb_candidatos_ibfk_1` FOREIGN KEY (`es_municipio`) REFERENCES `tb_municipios` (`pr_municipio`),
  ADD CONSTRAINT `tb_candidatos_ibfk_2` FOREIGN KEY (`es_usuarioCadastro`) REFERENCES `tb_usuarios` (`pr_usuario`),
  ADD CONSTRAINT `tb_candidatos_ibfk_3` FOREIGN KEY (`es_usuarioAlteracao`) REFERENCES `tb_usuarios` (`pr_usuario`);

--
-- Constraints for table `tb_candidaturas`
--
ALTER TABLE `tb_candidaturas`
  ADD CONSTRAINT `tb_candidaturas_ibfk_1` FOREIGN KEY (`es_avaliador_competencia1`) REFERENCES `tb_usuarios` (`pr_usuario`),
  ADD CONSTRAINT `tb_candidaturas_ibfk_2` FOREIGN KEY (`es_candidato`) REFERENCES `tb_candidatos` (`pr_candidato`),
  ADD CONSTRAINT `tb_candidaturas_ibfk_3` FOREIGN KEY (`es_avaliador_competencia1`) REFERENCES `tb_usuarios` (`pr_usuario`),
  ADD CONSTRAINT `tb_candidaturas_ibfk_6` FOREIGN KEY (`es_avaliador_curriculo`) REFERENCES `tb_usuarios` (`pr_usuario`),
  ADD CONSTRAINT `tb_candidaturas_ibfk_7` FOREIGN KEY (`es_vaga`) REFERENCES `tb_vagas` (`pr_vaga`),
  ADD CONSTRAINT `tb_candidaturas_ibfk_8` FOREIGN KEY (`es_avaliador_especialista`) REFERENCES `tb_usuarios` (`pr_usuario`);

--
-- Constraints for table `tb_entrevistas`
--
ALTER TABLE `tb_entrevistas`
  ADD CONSTRAINT `tb_entrevistas_ibfk_1` FOREIGN KEY (`es_candidatura`) REFERENCES `tb_candidaturas` (`pr_candidatura`),
  ADD CONSTRAINT `tb_entrevistas_ibfk_2` FOREIGN KEY (`es_avaliador1`) REFERENCES `tb_usuarios` (`pr_usuario`),
  ADD CONSTRAINT `tb_entrevistas_ibfk_3` FOREIGN KEY (`es_avaliador2`) REFERENCES `tb_usuarios` (`pr_usuario`),
  ADD CONSTRAINT `tb_entrevistas_ibfk_4` FOREIGN KEY (`es_alterador`) REFERENCES `tb_usuarios` (`pr_usuario`),
  ADD CONSTRAINT `tb_entrevistas_ibfk_5` FOREIGN KEY (`es_avaliador3`) REFERENCES `tb_usuarios` (`pr_usuario`);

--
-- Constraints for table `tb_experiencias`
--
ALTER TABLE `tb_experiencias`
  ADD CONSTRAINT `tb_experiencias_ibfk_1` FOREIGN KEY (`es_candidato`) REFERENCES `tb_candidatos` (`pr_candidato`),
  ADD CONSTRAINT `tb_experiencias_ibfk_2` FOREIGN KEY (`es_experiencia_pai`) REFERENCES `tb_experiencias` (`pr_experienca`),
  ADD CONSTRAINT `tb_experiencias_ibfk_3` FOREIGN KEY (`es_candidatura`) REFERENCES `tb_candidaturas` (`pr_candidatura`);

--
-- Constraints for table `tb_formacao`
--
ALTER TABLE `tb_formacao`
  ADD CONSTRAINT `tb_formacao_ibfk_1` FOREIGN KEY (`es_candidato`) REFERENCES `tb_candidatos` (`pr_candidato`),
  ADD CONSTRAINT `tb_formacao_ibfk_2` FOREIGN KEY (`es_formacao_pai`) REFERENCES `tb_formacao` (`pr_formacao`),
  ADD CONSTRAINT `tb_formacao_ibfk_3` FOREIGN KEY (`es_candidatura`) REFERENCES `tb_candidaturas` (`pr_candidatura`);

--
-- Constraints for table `tb_gruposvagas`
--
ALTER TABLE `tb_gruposvagas`
  ADD CONSTRAINT `tb_gruposvagas_ibfk_1` FOREIGN KEY (`es_usuarioCadastro`) REFERENCES `tb_usuarios` (`pr_usuario`),
  ADD CONSTRAINT `tb_gruposvagas_ibfk_2` FOREIGN KEY (`es_usuarioAlteracao`) REFERENCES `tb_usuarios` (`pr_usuario`);

--
-- Constraints for table `tb_hbdi`
--
ALTER TABLE `tb_hbdi`
  ADD CONSTRAINT `tb_hbdi_ibfk_1` FOREIGN KEY (`es_candidatura`) REFERENCES `tb_candidaturas` (`pr_candidatura`);

--
-- Constraints for table `tb_historicocandidaturas`
--
ALTER TABLE `tb_historicocandidaturas`
  ADD CONSTRAINT `tb_historicocandidaturas_ibfk_1` FOREIGN KEY (`es_candidatura`) REFERENCES `tb_candidaturas` (`pr_candidatura`),
  ADD CONSTRAINT `tb_historicocandidaturas_ibfk_2` FOREIGN KEY (`es_etapa`) REFERENCES `tb_etapas` (`pr_etapa`),
  ADD CONSTRAINT `tb_historicocandidaturas_ibfk_3` FOREIGN KEY (`es_avaliador`) REFERENCES `tb_usuarios` (`pr_usuario`),
  ADD CONSTRAINT `tb_historicocandidaturas_ibfk_4` FOREIGN KEY (`es_usuarioCadastro`) REFERENCES `tb_usuarios` (`pr_usuario`),
  ADD CONSTRAINT `tb_historicocandidaturas_ibfk_5` FOREIGN KEY (`es_usuarioAlteracao`) REFERENCES `tb_usuarios` (`pr_usuario`);

--
-- Constraints for table `tb_log`
--
ALTER TABLE `tb_log`
  ADD CONSTRAINT `tb_log_ibfk_1` FOREIGN KEY (`es_usuario`) REFERENCES `tb_usuarios` (`pr_usuario`);

--
-- Constraints for table `tb_municipios`
--
ALTER TABLE `tb_municipios`
  ADD CONSTRAINT `tb_municipios_ibfk_1` FOREIGN KEY (`es_uf`) REFERENCES `tb_uf` (`pr_uf`);

--
-- Constraints for table `tb_notas`
--
ALTER TABLE `tb_notas`
  ADD CONSTRAINT `tb_notas_ibfk_1` FOREIGN KEY (`es_candidatura`) REFERENCES `tb_candidaturas` (`pr_candidatura`),
  ADD CONSTRAINT `tb_notas_ibfk_2` FOREIGN KEY (`es_etapa`) REFERENCES `tb_etapas` (`pr_etapa`),
  ADD CONSTRAINT `tb_notas_ibfk_3` FOREIGN KEY (`es_competencia`) REFERENCES `tb_competencias` (`pr_competencia`),
  ADD CONSTRAINT `tb_notas_ibfk_4` FOREIGN KEY (`es_avaliador`) REFERENCES `tb_usuarios` (`pr_usuario`);

--
-- Constraints for table `tb_notas_totais`
--
ALTER TABLE `tb_notas_totais`
  ADD CONSTRAINT `tb_notas_totais_ibfk_1` FOREIGN KEY (`es_vaga`) REFERENCES `tb_vagas` (`pr_vaga`),
  ADD CONSTRAINT `tb_notas_totais_ibfk_2` FOREIGN KEY (`es_etapa`) REFERENCES `tb_etapas` (`pr_etapa`);

--
-- Constraints for table `tb_opcoes`
--
ALTER TABLE `tb_opcoes`
  ADD CONSTRAINT `tb_opcoes_ibfk_1` FOREIGN KEY (`es_questao`) REFERENCES `tb_questoes` (`pr_questao`);

--
-- Constraints for table `tb_questoes`
--
ALTER TABLE `tb_questoes`
  ADD CONSTRAINT `tb_questoes_ibfk_1` FOREIGN KEY (`es_etapa`) REFERENCES `tb_etapas` (`pr_etapa`),
  ADD CONSTRAINT `tb_questoes_ibfk_2` FOREIGN KEY (`es_usuarioCadastro`) REFERENCES `tb_usuarios` (`pr_usuario`),
  ADD CONSTRAINT `tb_questoes_ibfk_3` FOREIGN KEY (`es_usuarioAlteracao`) REFERENCES `tb_usuarios` (`pr_usuario`),
  ADD CONSTRAINT `tb_questoes_ibfk_4` FOREIGN KEY (`es_competencia`) REFERENCES `tb_competencias` (`pr_competencia`);

--
-- Constraints for table `tb_respostas`
--
ALTER TABLE `tb_respostas`
  ADD CONSTRAINT `tb_respostas_ibfk_1` FOREIGN KEY (`es_candidatura`) REFERENCES `tb_candidaturas` (`pr_candidatura`),
  ADD CONSTRAINT `tb_respostas_ibfk_2` FOREIGN KEY (`es_questao`) REFERENCES `tb_questoes` (`pr_questao`),
  ADD CONSTRAINT `tb_respostas_ibfk_3` FOREIGN KEY (`es_avaliador`) REFERENCES `tb_usuarios` (`pr_usuario`),
  ADD CONSTRAINT `tb_respostas_ibfk_4` FOREIGN KEY (`es_usuarioCadastro`) REFERENCES `tb_usuarios` (`pr_usuario`),
  ADD CONSTRAINT `tb_respostas_ibfk_5` FOREIGN KEY (`es_usuarioAlteracao`) REFERENCES `tb_usuarios` (`pr_usuario`),
  ADD CONSTRAINT `tb_respostas_ibfk_6` FOREIGN KEY (`es_opcao`) REFERENCES `tb_opcoes` (`pr_opcao`);

--
-- Constraints for table `tb_sessoes`
--
ALTER TABLE `tb_sessoes`
  ADD CONSTRAINT `tb_sessoes_ibfk_1` FOREIGN KEY (`es_usuario`) REFERENCES `tb_usuarios` (`pr_usuario`);

--
-- Constraints for table `tb_vagas`
--
ALTER TABLE `tb_vagas`
  ADD CONSTRAINT `tb_vagas_ibfk_1` FOREIGN KEY (`es_instituicao2`) REFERENCES `tb_instituicoes3` (`pr_instituicao`),
  ADD CONSTRAINT `tb_vagas_ibfk_2` FOREIGN KEY (`es_grupoVaga`) REFERENCES `tb_gruposvagas` (`pr_grupovaga`),
  ADD CONSTRAINT `tb_vagas_ibfk_3` FOREIGN KEY (`es_usuarioCadastro`) REFERENCES `tb_usuarios` (`pr_usuario`),
  ADD CONSTRAINT `tb_vagas_ibfk_4` FOREIGN KEY (`es_usuarioAlteracao`) REFERENCES `tb_usuarios` (`pr_usuario`),
  ADD CONSTRAINT `tb_vagas_ibfk_5` FOREIGN KEY (`es_instituicao`) REFERENCES `tb_instituicoes2` (`pr_instituicao`);
COMMIT;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
