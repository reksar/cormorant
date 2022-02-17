.PHONY: up
up:
	docker-compose up -d
	docker-compose logs -f wp-cli
	docker-compose exec test /opt/utils/init.sh

.PHONY: test
test:
	docker-compose exec test /opt/utils/test.sh

.PHONY: stop
stop:
	docker-compose stop

.PHONY: down
down:
	docker-compose down

.PHONY: clean
clean: down
	- docker volume rm cormorant_db_data
	- docker volume rm cormorant_wp_data
	rm -rf tmp
	# TODO: remove images optionally
