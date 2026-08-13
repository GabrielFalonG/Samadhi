.PHONY: help \
	env-dev env-prod \
	dev-up dev-build dev-rebuild dev-shell dev-logs dev-stop dev-down \
	prod-up prod-build prod-rebuild prod-shell prod-logs prod-stop prod-down

.DEFAULT_GOAL := help


# ============================================================
# CONFIGURACIÓN
# ============================================================

COMPOSE_DEV := docker compose
COMPOSE_PROD := docker compose -f docker-compose.prod.yml

DEV_CONTAINER := app
PROD_CONTAINER := samadhi-prod-app


# ============================================================
# HELP
# ============================================================

help:
	@echo ""
	@echo "Ambientes:"
	@echo "  make env-dev        Copiar .env.dev → .env"
	@echo "  make env-prod       Copiar .env.prod → .env"
	@echo ""
	@echo "Desarrollo:"
	@echo "  make dev-up         Levantar DEV"
	@echo "  make dev-build      Reconstruir y levantar DEV"
	@echo "  make dev-rebuild    Reconstruir completamente DEV"
	@echo "  make dev-shell      Entrar al contenedor DEV"
	@echo "  make dev-logs       Ver logs DEV"
	@echo "  make dev-stop       Detener DEV"
	@echo "  make dev-down       Eliminar DEV"
	@echo ""
	@echo "Producción:"
	@echo "  make prod-up        Levantar PROD"
	@echo "  make prod-build     Reconstruir y levantar PROD"
	@echo "  make prod-rebuild   Reconstruir completamente PROD"
	@echo "  make prod-shell     Entrar al contenedor PROD"
	@echo "  make prod-logs      Ver logs PROD"
	@echo "  make prod-stop      Detener PROD"
	@echo "  make prod-down      Eliminar PROD"
	@echo ""


# ============================================================
# AMBIENTES
# ============================================================

## Copiar configuración DEV
env-dev:
	@echo "=== Configurando ambiente DEV ==="
	@cp .env.dev .env
	@echo "✓ .env.dev copiado a .env"


## Copiar configuración PROD
env-prod:
	@echo "=== Configurando ambiente PROD ==="
	@cp .env.prod .env
	@echo "✓ .env.prod copiado a .env"


# ============================================================
# DESARROLLO
# ============================================================

## Levantar DEV
dev-up: env-dev
	@echo "=== Levantando entorno DEV ==="
	$(COMPOSE_DEV) up -d
	@echo "✓ DEV iniciado"


## Reconstruir y levantar DEV
dev-build: env-dev
	@echo "=== Reconstruyendo entorno DEV ==="
	$(COMPOSE_DEV) build
	$(COMPOSE_DEV) up -d
	@echo "✓ DEV reconstruido y levantado"


## Reconstruir completamente DEV sin caché
dev-rebuild: env-dev
	@echo "=== Reconstrucción completa de DEV ==="
	$(COMPOSE_DEV) down
	$(COMPOSE_DEV) build --no-cache
	$(COMPOSE_DEV) up -d
	@echo "✓ DEV reconstruido completamente"


## Entrar al contenedor DEV
dev-shell:
	$(COMPOSE_DEV) exec -it $(DEV_CONTAINER) sh


## Ver logs DEV
dev-logs:
	$(COMPOSE_DEV) logs -f


## Detener DEV
dev-stop:
	$(COMPOSE_DEV) stop


## Eliminar DEV
dev-down:
	$(COMPOSE_DEV) down


# ============================================================
# PRODUCCIÓN
# ============================================================

## Levantar PROD
prod-up: env-prod
	@echo "=== Levantando entorno PROD ==="
	$(COMPOSE_PROD) up -d
	@echo "✓ PROD iniciado"


## Reconstruir y levantar PROD
prod-build: env-prod
	@echo "=== Reconstruyendo entorno PROD ==="
	$(COMPOSE_PROD) build app
	$(COMPOSE_PROD) up -d
	@echo "✓ PROD reconstruido y levantado"


## Reconstruir completamente PROD sin caché
prod-rebuild: env-prod
	@echo "=== Reconstrucción completa de PROD ==="
	$(COMPOSE_PROD) down
	$(COMPOSE_PROD) build --no-cache app
	$(COMPOSE_PROD) up -d
	@echo "✓ PROD reconstruido completamente"


## Entrar al contenedor PROD
prod-shell:
	docker exec -it $(PROD_CONTAINER) sh


## Ver logs PROD
prod-logs:
	$(COMPOSE_PROD) logs -f


## Detener PROD
prod-stop:
	$(COMPOSE_PROD) stop


## Eliminar PROD
prod-down:
	$(COMPOSE_PROD) down
