.PHONY: up
up:
	docker-compose up -d
	docker-compose logs -f wp-cli composer

	# Add local and wp IPs to Postfix authorized networks.
	# This allows emails from mynetworks clients to be forwarded
	# to external hosts.
	$(eval WP_IP=`docker-compose exec wp hostname -I`)
	docker-compose exec email postconf \
		-e mynetworks="127.0.0.0/8 $(WP_IP)"

.PHONY: test
test:
	docker-compose exec wp /opt/utils/test.sh

.PHONY: stop
stop:
	docker-compose stop

.PHONY: down
down:
	docker-compose down

.PHONY: clean-volumes
clean-volumes:
	- docker volume rm cormorant_db_data
	- docker volume rm cormorant_wp_core

.PHONY: clean
clean: down clean-volumes
	rm -rf tmp
	# TODO: remove network
	# TODO: remove images optionally
