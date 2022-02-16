# Cormorant

Flamingo add-on for email confirmation.

See `cormorant/README.txt` for more info about the plugin.

## Runnig with Docker

See `.env` file for settings.

`make up` and wait till the WP CLI service tells you that 
"Wordpress is ready on http://127.0.0.1:8000". Do not worry about some DB 
errors at the beginning: WP CLI waits for DB to be ready up to 60 seconds. 
Also you can see PHP Composer's outputs at first run.

`make test` - TODO: soon

`make stop` - stop services.

`make down` - stop services and remove containers.

`make clean` - down services, then remove volumes and `composer` dir.
