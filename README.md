Bem vindo ao projeto Transforma Minas. Aqui Você encontrará as  
instruções para subir o sistema em um ambiente local. Utilizamos  
a ferramenta Docker para automatizar parte do processo de  
disponibilização do ambiente de desenvolvimento. Essa documentação  
foi homologada em um ambiente Debian 10. Para outros ambientes o
desenvolvedor irá precisar adaptar alguns dos passos e dependências
utilizadas.

# Quick start

1. Instale a engine do [docker](https://docs.docker.com/compose/install/)
2. Execute o comando `make run`

Este comando irá realizar as seguintes operações:

- Subir um container chamado `transforma-minas_server`, utilizando a imagem do debian:stable.  
Esse container irá atuar como o servidor, e via nginx irá responder às requisições HTTP e servir os
arquivos estáticos (js, css, imagens).
- Subir um container chamado `transforma-minas_db`, utilizando a imagem mariadb:latest.  
Esse container será o banco de dados da aplicação.

Para visualizar a plataforma, acesse `http://localhost:8080`
