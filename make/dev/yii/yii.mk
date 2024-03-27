
migration-create:
	docker-compose run --rm php-cli php yii migrate/create $(filter-out $@, $(MAKECMDGOALS)) --interactive=0
migration-up:
	docker-compose run --rm php-cli php yii migrate --interactive=0
migration-down:
	docker-compose run --rm php-cli php yii migrate/down --interactive=0

