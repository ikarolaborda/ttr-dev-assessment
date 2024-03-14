.DEFAULT_GOAL := help

help:
	@echo "Por favor, escolha o que quer fazer: \n" \
	" make dup: Iniciar os containers docker \n" \
	" make ddw: Parar os containers docker \n" \
	" make drs: Reiniciar os containers docker \n" \
	" make dci: Instalar as dependencias dentro do container \n" \
	" make dcu: Atualizar as dependencias dentro do container \n" \
	" make mysql: Rodar o shell interativo no container mysql \n" \
	" make php: Rodar o shell no container php \n" \
	" make mig: Rodar as migrations e seeders manualmente \n"

build:
	cp .env.example .env; export COMPOSE_FILE=docker-compose.yml; docker-compose --env-file .env up -d --build

dup:
	export COMPOSE_FILE=docker-compose.yml; docker-compose up -d

ddw:
	export COMPOSE_FILE=docker-compose.yml; docker-compose down --volumes

drs:
	export COMPOSE_FILE=docker-compose.yml; docker-compose down --volumes && docker-compose up -d

dci:
	docker exec -it php composer install && sudo chown -R $(USER):$(shell id -g) vendor/

dcu:
	docker exec -it php composer update && sudo chown -R $(USER):$(shell id -g) vendor/

php:
	docker exec -it php bash
