COMPOSE_PATH="docker/local/docker-compose.yml"
build:
	docker-compose -f ${COMPOSE_PATH} build --no-cache

up:
	docker-compose -f ${COMPOSE_PATH} up server db

down:
	docker-compose -f ${COMPOSE_PATH} down

stop:
	docker-compose stop

run: build up

load-schema:
	docker cp db/transforma.sql  transformagov_db:/tmp
	docker exec transformagov_db /bin/bash -c 'mysql transforma < /tmp/transforma.sql --password=root'
	docker cp db/function.sql  transformagov_db:/tmp
	docker exec transformagov_db /bin/bash -c 'mysql transforma < /tmp/function.sql --password=root'

create-users:
	docker cp db/popula-usuarios.sql  transformagov_db:/tmp
	docker exec transformagov_db /bin/bash -c 'mysql transforma < /tmp/popula-usuarios.sql --password=root'

sampledevdata:
	docker cp db/transforma-devdata.sql  transformagov_db:/tmp
	docker exec transformagov_db /bin/bash -c 'mysql transforma < /tmp/transforma-devdata.sql --password=root'

attach:
	docker exec -it transformagov_server bash

cypress:
	if [ -d "./node_modules" ]; then \
		node_modules/cypress/bin/cypress open -C tests/cypress/cypress.json; \
	else \
		printf "\033[0;31mnode_modules not exists, please run 'npm i cypress --save-dev' to create it"; \
	fi \
