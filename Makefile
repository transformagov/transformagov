build:
	docker-compose build --no-cache

up:
	docker-compose up server db

run: build up

load-schema:
	docker cp db/transforma.sql  transformagov_db_1:/tmp
	docker exec transformagov_db_1 /bin/bash -c 'mysql transforma < /tmp/transforma.sql --password=root'

create-users:
	docker cp db/popula-usuarios.sql  transformagov_db_1:/tmp
	docker exec transformagov_db_1 /bin/bash -c 'mysql transforma < /tmp/popula-usuarios.sql --password=root'

sampledevdata:
	docker cp db/transforma-devdata.sql  transformagov_db_1:/tmp
	docker exec transformagov_db_1 /bin/bash -c 'mysql transforma < /tmp/transforma-devdata.sql --password=root'

attach:
	docker exec -it transformagov_server_1 bash

# Essa task executa os testes sem GUI, util para o pipeline de CI/CD;
test-cypress:
	docker-compose up cypress-cli

# Essa task disponibiliza o dashboard do cypress para implementação dos testes localmente;
cypress-gui:
	# https://www.mit.edu/~arosinol/2019/08/06/Docker_Display_GUI_with_X_server/
	xhost +local:root; docker-compose up cypress-gui; xhost -local:root
