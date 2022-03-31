.PHONY: up
up:
	docker-compose up -d
	docker-compose logs -f wp-cli composer

	# Add local and wp IPs to Postfix authorized networks. This allows emails
	# to be forwarded to other mail services. But many public mail services,
	# such as Gmail, may block unauthorized IPs.
	$(eval WP_IP=`docker-compose exec wp hostname -I`)
	docker-compose exec smtp postconf \
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
	- docker volume rm cormorant_db
	- docker volume rm cormorant_smtp_mail
	- docker volume rm cormorant_imap_mail
	- docker volume rm cormorant_imap_etc
	- docker volume rm cormorant_webmail_html
	- docker volume rm cormorant_webmail_config
	- docker volume rm cormorant_webmail_db
	- docker volume rm cormorant_webmail_tmp
	- docker volume rm cormorant_wp_core

.PHONY: clean
clean: down clean-volumes
	rm -rf tmp
	# TODO: remove images optionally
