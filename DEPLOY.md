# Fazendo deploy no ambiente local

O modo Swarm do Docker não se resume apenas ao ambiente de produção. É possível fazer deploy da aplicação em um cluster local. Isso é util, por exemplo, para testar a comunicação entre os serviços antes de realizar o procedimento em produção. Tanto no ambiente local quanto em produção, utilizaremos o pacote python `pencilctl-lite`. Ele facilita o processo de construção das imagens e criação dos serviços no cluster. Para mais informações sobre a ferramenta, acesse a [documentação do projeto](https://pypi.org/project/pencilctl-lite/). 

Para diferenciar qual ambiente será utilizado para o deploy, a ferramenta procura um arquivo de configuração chamado `.config.toml` na raiz do repositório. Para fazer o deploy local, crie o arquivo com o seguinte conteúdo:

```toml
registry="127.0.0.1:5000"
branch="stable"
service="server"
docker_dir = "docker"
env="local-swarm"
docker_path=""
stack=""
```

Criado o arquivo, execute os seguintes passos para realizar o deploy:

- Instale o pacote `pip install pencilctl-lite`.
- Crie um cluster swarm: `docker swarm init`.
- Gere as imagens do kibana e losgstash:	
	- `python -m pencilctl-lite --command build --service server`
- Faça deploy da stack `python -m pencilctl-lite --command deploy --stack transforma_stack`.

Como ultimo passo, alterar o arquivo `/etc/hosts` e inclua a seguinte linha:

		127.0.0.1 local.transformagov.org

Ao final do processo, o TransformaGov estará disponível no endereço `http://local.transformagov.org`.

	

# Fazendo deploy em produção

Para realizar o deploy em produção, os passos são os mesmos do ambiente local, com a diferença de que por padrão, o `pencilctl-lite` procura os arquivos do Docker no diretório `docker/production`, ou seja, não é preciso criar o arquivo `.config.toml`. Um outro ponto é que em produção não se altera o arquivo `/etc/hosts`, já que a requisição chegará na aplicação via domínio.

# Comandos úteis
1. Para listar os serviços da stack:
```docker stack services transforma_stack```
2. Para remover os serviços da stack:
```docker stack rm transforma_stack```
9. Para fazer as migrações do transformaGov:
```docker cp db/transforma.sql <DB_CONTAINER_NAME>:/tmp```
```docker exec <DB_CONTAINER_NAME> /bin/bash -c 'mysql transforma < /tmp/transforma.sql --password=root'```
10. Para fazer a migração dos usuários:
```docker cp db/popula-usuarios.sql  <DB_CONTAINER_NAME>:/tmp```
```docker exec <DB_CONTAINER_NAME> /bin/bash -c 'mysql transforma < /tmp/popula-usuarios.sql --password=root'```