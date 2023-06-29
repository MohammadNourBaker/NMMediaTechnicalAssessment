# NM-Media-Technical-Assessment

NM-Media-Technical-Assessment

# Documentation:

- Docker Compose
    - UP
        ``` bash
        docker compose up -d 
        ```
    - Down
        ``` bash
        docker compose down
        ```
    - Build
        ```bash
        docker compose up -d --build
        ```
    - Update
        ```bash
        docker compose run --rm composer update
        ```
    - npm run Dev
        ```bash
        docker compose run --rm npm run dev
        ```
    - Migrate
        ```bash
        docker compose run --rm artisan migrate
        ```
    - Test
        ```bash
        docker compose run --rm artisan test
        ```

- Documentation Generate
    ```bash
    docker compose run --rm artisan enum:docs  && docker compose run --rm artisan scribe:generate --force
    ```
- IDE Helper Generate
    ```bash
    docker compose run --rm artisan enum:annotate && docker compose run --rm artisan migrate:fresh && docker compose run --rm artisan ide-helper:generate && docker compose run --rm artisan ide-helper:models --write --reset --write-mixin && docker compose run --rm artisan ide-helper:meta
    ```
- PHP Pint Fixer
    ```bash
    docker compose run --rm php ./vendor/bin/pint
    docker compose run --rm php ./vendor/bin/pint --test
    ```
- SQL init
    ```mysql
    CREATE DATABASE DONATION;
    CREATE USER 'homestead'@'%' IDENTIFIED BY 'secret';
    GRANT ALL PRIVILEGES ON * . * TO 'homestead'@'%';
    FLUSH PRIVILEGES;
    ```
