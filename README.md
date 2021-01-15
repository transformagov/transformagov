Bem vindo ao projeto Transforma Minas. Aqui Você encontrará as instruções para subir o sistema em um ambiente local.
Utilizamos  a ferramenta Docker para automatizar parte do processo de  disponibilização do ambiente de desenvolvimento.
Essa documentação foi homologada em um ambiente Debian 10. Para outros ambientes o desenvolvedor irá precisar adaptar
alguns dos passos e dependências utilizadas.

# Subindo a plataforma via Docker

1. Instale a ferramenta [docker-compose](https://docs.docker.com/compose/install/)
2. Execute o comando `make run`

Este comando irá realizar as seguintes operações:

- Construir a imagem do servidor, instalando as dependências necessárias. Essa imagem utiliza como base o Debian estável;
- Subir um container chamado `transforma-minas_server_1`, utilizando a imagem construida anteriormente.  
Esse container irá atuar como o servidor, e via nginx irá responder às requisições HTTP e servir os
arquivos estáticos (js, css, imagens). Além de servir os arquivos estáticos, o nginx também será 
responsável por servir os scripts PHP.
- Subir um container chamado `transforma-minas_db_1`, utilizando a imagem mariadb:latest.  
Esse container será o banco de dados da aplicação.

3. Restaure o banco utilizando o comando `make restore`;

4. Para visualizar a plataforma, acesse `http://localhost:8080`;

5. A partir daqui você pode criar um usuário clicando em `Cadastre-se`. Uma senha temporária será enviada para o email informado no cadastro.


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

				docker exec -it transforma-minas_db_1 bash
				mysql --password=root --user=root transforma

2. execute o script que altera um usuário para administrador

				update tb_usuarios set en_perfil='administrador' where pr_usuario=<id_do_usuario_aqui>;

# Subindo a plataforma manualmente

Caso o desenvolvedor não queira utilizar Docker, é possível subir a plataforma manualmente. A configuração manual
não foi devidamente testada, então é possível que algumas adaptações (e correções) tenham que ser feitas.
Lembrando que todas as dependências listadas aqui são para sistemas Debian-like.

## Server

O servidor utiliza as seguintes dependências:

	- php7.3
	- php-fpm
	- php-pgsql
	- php-mbstring 
	- php-curl 
	- php7.3-mysql 
	- nginx 
	- sendmail

### Nginx

A instância do nginx que rodará no servidor é controlada pelo arquivo `transforma.conf`.
O desenvolvedor precisa move-lo para `/etc/nginx/conf.d/`. Esse arquivo aponta para diretórios
que provavelmente não irão existir no ambiente, logo, adaptações terão que ser feitas para que
o nginx encontre os arquivos estáticos e scripts do php no ambiente.

### Banco de dados

O desenvolvedor pode subir o banco mariadb, ou postgres/mysql, e apontar o servidor php para ele.
Essa configuração é feita no arquivo `application/config/database.php`. O restore dos arquivos sql
deve funcionar tanto para o postgresql, mysql e mariadb. Os arquivos sql com o schema do banco e
os dados iniciais estão na pasta `db`. Vale ressaltar que o php depende de um conector, para conseguir
acessar o banco. No caso do mariadb estamos usando a dependência `php7.3-mysql`. Para outros bancos esse
conector deverá ser adaptado.

### Executando o php

Existe um script chamado `run.sh`, no repositório. Ele executa tarefas como iniciar o nginx e o php-fpm.
Após instalar as dependências, realizar a configuração do banco e do nginx, o desenvolvedor pode reutilizar
esse script para subir a aplicação. Lembrando que, subindo manualmente, a aplicação irá responder na porta 80.
Isso pode ser alterado no arquivo de configuração do nginx.
