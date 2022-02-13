.PHONY: up
up:
	docker-compose up

.PHONY: clean
clean:
	docker rm cormorant_db
	docker rm cormorant_wp
	docker volume rm cormorant_db
	docker volume rm cormorant_wp
	# TODO: clean images optionally
