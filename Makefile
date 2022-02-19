.PHONY: up
up:
	docker-compose up -d
	docker-compose logs -f wp-cli composer

.PHONY: test
test:
	docker-compose exec wp /opt/utils/test.sh

.PHONY: stop
stop:
	docker-compose stop

.PHONY: down
down:
	docker-compose down

.PHONY: clean
clean: down
	- docker volume rm cormorant_db_data
	- docker volume rm cormorant_wp_core
	rm -rf tmp
	# TODO: remove images optionally
