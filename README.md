# Cormorant

Flamingo add-on for email confirmation.

See `cormorant/README.txt` for more info about the plugin.

## Runnig with Docker Compose

See `.env` file for settings.

`make up` and wait while WP CLI configures the Wordpress and PHP Composer 
installs required test suite. Don't worry about some DB errors from WP CLI at 
the beginning: it waits for DB to be ready, see `utils/wp-cli/db-wait.sh`.

After the WP CLI tells that "Wordpress is ready on http://127.0.0.1:8000", 
you can access it. The webmail is listening on http://127.0.0.1:8080.

After the PHP Composer is done, you can `make test`.

To see more debug info from Docker services, run `docker-compose up` instead.

### Next steps

`make test` - run tests with PHPUnit when services are running.

`make stop` - stop services.

`make down` - stop services and remove containers.

`make clean` - down services, then remove volumes and `tmp` dir.
