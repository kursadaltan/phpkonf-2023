up:
	docker-compose up -d 

build:
	docker-compose up -d --build

bash:
	docker-compose exec server sh

down:
	docker-compose down --remove-orphans