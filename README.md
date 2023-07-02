# NM Media Real Time Chat Application using Codeigniter4 and Socket.io

NM Media Real Time Chat Application using Codeigniter4 and Socket.io

# How To Run:
- Install Docker and Docker compose
- Clone the project
- copy `env` to `.env` and put it in the same folder
- Open the project folder from terminal
####  Now From Terminal run the following:
1. `docker compose up -d --build`
2. `docker compose run --rm composer install`
3. `docker compose run --rm spark migrate --all`
4. `docker compose run --rm spark db:seed DatabaseSeeder`
5. `docker compose exec php php ./public/index.php Websocket Websocket index`
6. Important Note:
- For linux/ubuntu users you must run this too `chmod -R 777 ./writable/`
7. You can access this link: `http://localhost:8080/`

# Now every thing is ready, there is three clients accounts:
1. email: `client1@chat.realtime,` password: `Aa112233`
2. email: `client2@chat.realtime,` password: `Aa112233`
3. email: `client3@chat.realtime,` password: `Aa112233`
- Note: you can register your own email but you have to verify it.

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
        docker compose run --rm spark migrate --all
        ```
    - Run Websocket service
        ```bash
        docker compose exec php php ./public/index.php Websocket Websocket index
        ```

- SQL init
    ```mysql
    CREATE DATABASE NMCHAT;
    CREATE USER 'homestead'@'%' IDENTIFIED BY 'secret';
    GRANT ALL PRIVILEGES ON * . * TO 'homestead'@'%';
    FLUSH PRIVILEGES;
    ```
