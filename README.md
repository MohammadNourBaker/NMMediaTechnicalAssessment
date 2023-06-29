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
    - Migrate
        ```bash
        docker compose run --rm spark migrate
        ```

[//]: # (    - Test)

[//]: # (        ```bash)

[//]: # (        docker compose run --rm spark test)

[//]: # (        ```)

- PHP Pint Fixer
    ```bash
    docker compose run --rm php ./vendor/bin/php-cs-fixer fix --verbose
    ```
- SQL init
    ```mysql
    CREATE DATABASE NMCHAT;
    CREATE USER 'homestead'@'%' IDENTIFIED BY 'secret';
    GRANT ALL PRIVILEGES ON * . * TO 'homestead'@'%';
    FLUSH PRIVILEGES;
    ```
