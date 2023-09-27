# Installation
Fire up the php/nginx setup

```bash
docker-compose up -d
```
Run composer install
```bash
docker run -it --rm -v `pwd`/code:/app composer install
```
# Run cli command

```bash
docker exec -it mm_php /bin/bash -c "cd /code && php run.php count_by_vendor_id 35"
```

# Run tests
```bash
docker exec -it mm_php /bin/bash -c "cd /code && bash /code/vendor/bin/phpunit /code/tests/ --colors
```