.PHONY: up
up:
	docker-compose up

.PHONY: clean
clean:
	docker rm cormorant_db
	docker rm cormorant_wp
	docker rm cormorant_wp_cli
	docker volume rm cormorant_db_data
	docker volume rm cormorant_wp_data
	# TODO: clean images optionally
