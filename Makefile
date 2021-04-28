build:
	docker-compose build --no-cache

up:
	docker-compose up

run: build up

restore:
#	docker cp db/transforma.sql  transforma-minas_db_1:/tmp
	docker cp db/transforma3.sql  transforma-minas_db_1:/tmp
	docker cp db/transforma2.sql  transforma-minas_db_1:/tmp
#	docker exec transforma-minas_db_1 /bin/bash -c 'mysql transforma < /tmp/transforma.sql --password=root'
	docker exec transforma-minas_db_1 /bin/bash -c 'mysql transforma < /tmp/transforma3.sql --password=root'
	docker exec transforma-minas_db_1 /bin/bash -c 'mysql transforma < /tmp/transforma2.sql --password=root'
