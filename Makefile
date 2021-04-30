build:
	docker-compose build --no-cache

up:
	docker-compose up

run: build up

restore:
	docker cp db/transforma.sql  transforma-minas_db_1:/tmp
	docker exec transforma-minas_db_1 /bin/bash -c 'mysql transforma < /tmp/transforma.sql --password=root'

sampleusers:
	docker cp db/popula-usuarios.sql  transforma-minas_db_1:/tmp
	docker exec transforma-minas_db_1 /bin/bash -c 'mysql transforma < /tmp/popula-usuarios.sql --password=root'
