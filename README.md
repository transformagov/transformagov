Bem vinda ao projeto TransformaGov. O TransformaGov é uma Plataforma criada a partir 
do projeto [Transforma Minas](https://github.com/seplagmg/transforma_minas), 
uma plataforma de recrutamento baseada no mérito.

A criação do projeto TransformaGov foi motivada pelos seguintes objetivos:

1. Levar o case de sucesso do projeto Transforma Minas para outros Estados e
Municípios;
2. Criar uma marca que seja independente do Estado de Minas Gerais e de mandatos específicos. 
3. Construir uma comunidade de software livre ao redor do TransformaGov, que possa decidir email conjunto os rumos do projeto. 
4. Evoluir o código da plataforma priorizando qualidade, testabilidade e estabilidade;

![Testes de Aceitação](https://github.com/transformagov/transformagov/actions/workflows/cypress/badge.svg)


# Subindo a plataforma via Docker no ambiente local

Aqui Você encontrará as instruções para subir o sistema em um ambiente local.
Utilizamos  a ferramenta Docker para automatizar parte do processo de  disponibilização do ambiente de desenvolvimento.
Essa documentação foi homologada em um ambiente Debian 10. 
Para outros ambientes o desenvolvedor irá precisar adaptar alguns dos passos e dependências utilizadas.

1. Instale a ferramenta [docker-compose](https://docs.docker.com/compose/install/)
2. Execute o comando `make run`

Este comando irá realizar as seguintes operações:

- Construir a imagem do servidor, instalando as dependências necessárias. Essa imagem utiliza como base o Debian estável;
- Subir um container chamado `transformagov_server_1`, utilizando a imagem construida anteriormente.  
Esse container irá atuar como o servidor, e via nginx irá responder às requisições HTTP e servir os
arquivos estáticos (js, css, imagens). Além de servir os arquivos estáticos, o nginx também será 
responsável por servir os scripts PHP.
- Subir um container chamado `transformagov_db_1`, utilizando a imagem mariadb:latest.  
Esse container será o banco de dados da aplicação.

3. Restaure schema do banco utilizando o comando `make load-schema`;
4. Crie os usuários  `make create-users`;
4. Acesse a plataforma em `http://localhost:8080` utilizando um dos usuários listados na sessão [Usuários](##usuários);

## SMTP

Tanto o cadastro de usuário, quanto a recuperação de senha dependem de disparos de email.
O sistema está utilizando o smtp do [Mailgun](https://www.mailgun.com/) para realizar o envio de email. Como isso é uma parte
central do sistema, o desenvolvedor deve alterar as credenciais utilizadas para um servidor na qual
ele tenha controle. Não há garantia que as credenciais desse repositório irão funcionar permanentemente.


## Criptografia das senhas no banco

O CodeIgniter, framework utilizado na construção do sistema, utiliza uma biblioteca própria para criptografar
e descriptografar as senhas. O desenvolvedor pode alterar a chave de criptografia utilizada no processo alterando
a configuração `encryption_key`, no arquivo `application/config/config.php`.

## Usuário administrador

Para alterar um usuário para administrador, o desenvolvedor pode fazer isso via sql.

1. acesse o banco

				docker exec -it transformagov_db_1 bash
				mysql --password=root --user=root transforma

2. execute o script que altera um usuário para administrador

				update tb_usuarios set en_perfil='administrador' where pr_usuario=<id_do_usuario_aqui>;

## Usuários

* Perfil: admin
	- CPF: 771.194.760-76
	- Senha: usuadmin123

* Perfil: candidato
	- CPF 687.541.020-65
	- Senha: usucandidato123

* Perfil: avaliador
	- CPF: 211.013.760-66
	- Senha: usuavaliador123

* Perfil: gestor
	- CPF: 058.636.740-32
	- Senha: usugestor123


Para informações sobre como subir a plataforma manualmente, acesse [as instruções na nossa wiki](https://github.com/transformagov/transformagov/wiki/instalacao-manual);

# Testes

## Testes de Aceitação

Para rodar os testes de aceitação no ambiente local, execute o comando `make cypress`. Esse
comando irá abrir o dashboard iterativo do [Cypress](https://www.cypress.io/) 
para escrita e execução dos testes de aceitação.  
Para executar os testes o TransformaGov deve estar rodando no endereço `http://localhost:8080`.

Todo commit que é enviado para o repositório passa pelo Github Actions, um projeto do Github para 
construir *pipelines* de integração contínua e deploy contínuo. O Github Actions garente que todo
commit que entre na `main` tenha os testes de aceitação executados.

