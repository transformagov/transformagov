build:
	docker-compose build --no-cache

up:
	docker-compose up server db

run: build up

CONTAINER_NAME = $(docker service ps -f 'name=transforma_stack_db.1' transforma_stack_db -q --no-trunc | head -n1)

load-schema:
	docker cp db/transforma.sql  transformagov_db_1:/tmp
	docker exec transformagov_db_1 /bin/bash -c 'mysql transforma < /tmp/transforma.sql --password=root'


load-schema-swarm:
	docker cp db/transforma.sql  transforma_stack_db.1.${CONTAINER_NAME}:/tmp
	docker exec transforma_stack_db.1.${CONTAINER_NAME} /bin/bash -c 'mysql transforma < /tmp/transforma.sql --password=root'

create-users:
	docker cp db/popula-usuarios.sql  transformagov_db_1:/tmp
	docker exec transformagov_db_1 /bin/bash -c 'mysql transforma < /tmp/popula-usuarios.sql --password=root'

sampledevdata:
	docker cp db/transforma-devdata.sql  transformagov_db_1:/tmp
	docker exec transformagov_db_1 /bin/bash -c 'mysql transforma < /tmp/transforma-devdata.sql --password=root'

attach:
	docker exec -it transformagov_server_1 bash

cypress:
	if [ -d "./node_modules" ]; then \
		node_modules/cypress/bin/cypress open -C tests/cypress/cypress.json; \
	else \
		printf "\033[0;31mnode_modules not exists, please run 'npm i cypress --save-dev' to create it"; \
	fi \
