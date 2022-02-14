# Qickstart

Para subir o ambiente, execute os comandos

	make up


Em seguida, rode as migrações do banco de dados

	php spark migrate
	php spark db:seed UnidadesFederativasSeeder


## Dependências Javascript

O projeto utiliza o framework Webpack para gestão de dependencias javascript. Isso permite instalar
tais dependencias via `npm` e disponibiliza-las nas páginas php via tag `script`. Para adicionar
uma nova dependência ao projeto, siga os seguintes passos:

1. Instale a dependência via `npm install`;
2. Importe a dependência no arquivo `dependencies.js`;
3. Gere o bundle com o comando `npx webpack`;


Isso será suficiente para utilizar a dependência no frontend da aplicação.
