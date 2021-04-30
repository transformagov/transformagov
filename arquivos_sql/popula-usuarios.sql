/*!40000 ALTER TABLE `tb_candidatos` DISABLE KEYS */;
INSERT INTO `tb_candidatos` (
    `pr_candidato`, `vc_nome`, `vc_nomesocial`, `ch_cpf`, 
    `vc_rg`, `in_genero`, `vc_generoOptativo`, `in_raca`, 
    `vc_orgaoEmissor`, `vc_email`, `vc_telefone`,
    `vc_telefoneOpcional`, `vc_linkedin`, `dt_nascimento`, 
    `vc_pais`, `vc_cidadeEstrangeira`, `vc_logradouro`, 
    `vc_numero`, `vc_bairro`, `vc_complemento`, `vc_cep`,
    `es_municipio`, `in_nivelAcademico`, 
    `tx_informacoesAcademicas`, `tx_experienciaSetorPublico`, 
    `tx_experienciasProfissionais`, `tx_atividadesVoluntarias`, 
    `tx_referenciasProfissionais`, `in_exigenciasComuns`, 
    `bl_sentenciado`, `bl_processoDisciplinar`, 
    `bl_ajustamentoFuncionalPorDoenca`, `bl_elegivel`, 
    `bl_politicaPrivacidade`, `es_usuarioCadastro`, 
    `dt_cadastro`, `es_usuarioAlteracao`, `dt_alteracao`, 
    `bl_removido`, `bl_aceiteTermo`, `bl_aceitePrivacidade`, 
    `bl_brumadinho`) VALUES
(6815, 'Usu admin', 'admin', '771.194.760-76', '14.252.785-3', 1, NULL, 1, 'SSP', 'f0889a361b@firemailbox.club', '(99)99999-9999', '', '', '2021-01-01', 'Brasil', NULL, 'Travessa Santa Fé', '31232123', 'Professora Araceli Souto Maior', '', '69315-056', 3905, NULL, NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', NULL, NULL, NULL, '2021-04-30 14:25:38', NULL, '2021-04-30 14:25:38', '0', '1', '1', NULL),
(6816, 'Usu candidato', 'candidato', '687.541.020-65', '16.506.055-4', 1, NULL, 1, 'SSP', 'b24ea0c09c@firemailbox.club', '(99)99999-9999', '', '', '2021-01-01', 'Brasil', NULL, 'Rua Serafim Lins Pinto', '323132', 'Guararapes', '', '54325-060', 2784, NULL, NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', NULL, NULL, NULL, '2021-04-30 14:30:27', NULL, '2021-04-30 14:30:27', '0', '1', '1', NULL),
(6817, 'Usu avaliador', 'avaliador', '211.013.760-66', '49.790.014-2', 1, NULL, 1, 'SSP', 'aea5488fcb@firemailbox.club', '(99)99999-9999', '', '', '2021-01-01', 'Brasil', NULL, 'Rua Luiz Siegmann', '1131', 'Jardim Lindóia', '', '91050-325', 4242, NULL, NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', NULL, NULL, NULL, '2021-04-30 14:34:08', NULL, '2021-04-30 14:34:08', '0', '1', '1', NULL),
(6818, 'Usu gestor', 'gestor', '058.636.740-32', '47.162.712-4', 1, NULL, 1, 'SSP', '82718509a9@firemailbox.club', '(99)99999-9999', '', '', '2021-01-01', 'Brasil', NULL, 'Quadra 17', '213132', 'Santo Antônio', '', '64033-620', 3184, NULL, NULL, NULL, NULL, NULL, NULL, '1', '0', '0', '0', NULL, NULL, NULL, '2021-04-30 14:40:40', NULL, '2021-04-30 14:40:40', '0', '1', '1', NULL);

/*!40000 ALTER TABLE `tb_usuarios` DISABLE KEYS */;
INSERT INTO `tb_usuarios` (
    `pr_usuario`, `es_candidato`, `en_perfil`, `vc_nome`,
    `vc_email`, `vc_telefone`, `vc_login`, `vc_senha`, 
    `vc_senha_temporaria`, `dt_cadastro`, `dt_alteracao`, 
    `dt_ultimoacesso`, `bl_trocasenha`, `in_erros`, 
    `bl_removido`) VALUES
(6649, 6815, 'administrador', 'Usu admin', 'f0889a361b@firemailbox.club', '(99)99999-9999', '771.194.760-76', '9e09d940aa6f20ae9a31327945e74129b523b05067fb9ca21219923aaf04003f48e41f235c8c29f02b9a035946cf748e7d046d95015fe5055c7d152537b3d7a0LQoeMj/hNGYRdhVZaG1SJ1fsjTxs4QivZ9dtzB0LCmg=', NULL, '2021-04-30', NULL, '2021-04-30 14:28:02', '0', 0, '0'),
(6650, 6816, 'candidato', 'Usu candidato', 'b24ea0c09c@firemailbox.club', '(99)99999-9999', '687.541.020-65', '4f7949a76b82ed100279629f9422a1d8bc94c4e01a691521cc8207d198012e009a65c9fea0bd637a7c1048702e3619c2bd45017f06126092828debb860a96067qnRrDxHHHZzYnKs+9/QLFpR6pew3KivNGQKCLVv8JBE=', NULL, '2021-04-30', NULL, '2021-04-30 14:31:45', '0', 0, '0'),
(6651, 6817, 'avaliador', 'Usu avaliador', 'aea5488fcb@firemailbox.club', '(99)99999-9999', '211.013.760-66', 'a62ef6fd28f880c43cc8ddb0207ab09cb5c443c5fa4c27b2d1220f6a9c8633ad4f646976e5d0f252734cdf9d9c361de7210dc3641818619532a85d96dfe8c44fxl0EgAg83j/RX6P3bzRA5YwG0LoBtRL/+uZOjeUvtws=', NULL, '2021-04-30', NULL, '2021-04-30 14:38:19', '0', 0, '0'),
(6652, 6818, 'sugesp', 'Usu gestor', '82718509a9@firemailbox.club', '(99)99999-9999', '058.636.740-32', '27540de4a2d1e6b523da316e436ce2ae1c0fad58f71fea6c8e4be4df08e446320a05fd30b71469b0774be7f3dc38bc4a5d4f4d3dc875e11e5604d7a941afede9HHq9K5GcfiUrVKeYCL3L34s/gk0u8AV9iJx/4xRsKU0=', NULL, '2021-04-30', NULL, '2021-04-30 14:41:11', '0', 0, '0');
