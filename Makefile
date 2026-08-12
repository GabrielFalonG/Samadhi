.PHONY: help up fresh-up build shell tail stop down queue-status queue-restart queue-logs

.DEFAULT_GOAL := help

## Muestra esta ayuda con todos los comandos disponibles
help:
	@echo "Comandos disponibles:"
	@awk '/^[a-zA-Z\-_0-9]+:/ { \
		helpMessage = match(lastLine, /^## (.*)/, result); \
		if (helpMessage) { \
			printf "  \033[36m%-15s\033[0m %s\n", substr($$1, 1, length($$1)-1), result[1]; \
		} \
	} \
	{ lastLine = $$0 }' $(MAKEFILE_LIST)
	@echo ""

## Iniciar todos los contenedores en segundo plano
up:
	docker compose up -d

## Construir o reconstruir las imágenes de Docker
build:
	docker compose build

## Recrear contenedores y ejecutar migraciones con seeders como root
fresh-up:
	docker compose down -v
	docker compose up -d
	docker compose exec -u root app php artisan migrate:fresh --seed

## Abrir consola interactiva bash/sh como root dentro del contenedor
shell:
	docker compose exec -it -u root app sh

## Ver logs en vivo del contenedor principal de la app
tail:
	docker compose logs -f app

## Detener los contenedores sin eliminarlos
stop:
	docker compose stop

## Eliminar contenedores, redes y volúmenes asociados
down:
	docker compose down

## Ver el estado en tiempo real de PHP-FPM y los workers de Supervisor
queue-status:
	docker compose exec -it app supervisorctl status

## Reiniciar los workers en Supervisor para aplicar cambios de código
queue-restart:
	docker compose exec app supervisorctl restart laravel-worker:*

## Ver los logs en vivo del procesador de colas de Laravel
queue-logs:
	docker compose exec -it app tail -f /var/www/html/storage/logs/worker.log
