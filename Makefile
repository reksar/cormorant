.PHONY: up
up:
	docker-compose up -d
	docker-compose logs -f wp-cli composer

	# Add the Docker subnet to the Postfix authorized networks.
	$(eval SUBNET=`docker network inspect cormorant_default \
		| grep Subnet | grep -o '[[:digit:]\.]\+/[[:digit:]]\+'`)
	# Note: requires the mynetworks_style=subnet
	docker-compose exec smtp postconf -e mynetworks="$(SUBNET)"

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

.PHONY: log-wp
log-wp:
	@docker-compose exec wp cat wp-content/debug.log

.PHONY: rmlog-wp
rmlog-wp:
	docker-compose exec wp rm wp-content/debug.log

.PHONY: log-smtp
log-smtp:
	docker-compose logs smtp
	- @cat tmp/smtp/log/maillog

.PHONY: rmlog-smtp
rmlog-smtp:
	- rm tmp/smtp/log/maillog

.PHONY: log
log: log-wp log-smtp

.PHONY: rmlog
rmlog: rmlog-wp rmlog-smtp
