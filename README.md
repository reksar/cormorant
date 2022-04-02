# Cormorant

Flamingo add-on for email confirmation.

See `cormorant/README.txt` for more info about the plugin.

## Runnig with Docker Compose

See `.env` file for settings.

`make up` and wait while WP CLI configures the Wordpress and PHP Composer 
installs required test suite. Don't worry about some DB errors from WP CLI at 
the beginning: it waits for DB to be ready, see `utils/wp-cli/db-wait.sh`.

After the WP CLI tells that "Wordpress is ready on http://127.0.0.1:8000", 
you can access it.

After the PHP Composer is done, you can `make test`.

### Next steps

`make test` - run tests with PHPUnit when services are running.

`make stop` - stop services.

`make down` - stop services and remove containers.

`make clean` - down services, then remove volumes and `tmp` dir.

### Webmail

Listening on http://127.0.0.1:8080.

#### email / password

- admin@mail.my / admin
- user@mail.my / pass

User DB stored in `utils/imap/passwd`. SHA1 hash can be generated from a 
password with `doveadm pw -s sha1` inside `imap` container.
