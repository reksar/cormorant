.PHONY: up
up:
	docker-compose up -d
	docker-compose logs -f wp_cli
	docker-compose exec test /opt/utils/composer.sh

.PHONY: test
test:
	docker-compose exec test /opt/utils/wp-test.sh

.PHONY: stop
stop:
	docker-compose stop

.PHONY: down
down:
	docker-compose down

.PHONY: clean
clean: down
	docker volume rm cormorant_db_data
	docker volume rm cormorant_wp_data
	docker volume rm cormorant_wp_testlib
	rm -rf composer
	# TODO: remove images optionally
