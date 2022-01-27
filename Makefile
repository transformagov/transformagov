build:
	docker-compose build --no-cache
up:
	docker-compose up

attach:
	docker exec -it transformagov_codeigniter_4_server_1 bash
