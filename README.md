# Laravel-IM (Instant Messaging)
## Example Application for Instant messaging

To use the application please follow this procedure:

1. Install required packages:
    * For Composer ``composer install``
    * For npm ``npm install``
    * Install Redis server. [Visit the Redis Website](https://redis.io/download).
        (This is optional if you use Redis and Socket.io).

2. Run Database seed to seed users ``php artisan db:seed``.
    See ``database\seeds\UserSeeder`` for credentials.

3. Edit ``.env`` file
    * Change broadcast driver,
        - Pusher use ``BROADCAST_DRIVER=pusher`` or
        - Redis and Socket.io use ``BROADCAST_DRIVER=redis``

    * For Pusher add the following from your [pusher account](https://dashboard.pusher.com/apps/)
        - ``PUSHER_APP_ID=``
        - ``PUSHER_APP_KEY=``
        - ``PUSHER_APP_SECRET=``
        - ``PUSHER_APP_CLUSTER=``

4. Edit ``recources\js\bootstrap.js`` file
    * Uncomment the ``laravel-echo`` section.
        Either using it with socket.io or pusher.
    * Run ``npm run dev`` to compiler the js files to ``\public`` folder.

5. To run:
    * Start artisan server ``php arisan serve``
    * Start laravel echo server ``laravel-echo-server start``
    * Start laravel queue ``php artisan queue:work --queue=messaging``
    * When using Redis and Socket.io
        Listen on Redis-cli (optional) ``redis-cli``
        Then run ``MONITOR`` on the redis-cli i.e
        ```
            $ redis-cli
            127.0.0.1:6379> MONITOR
            OK
        ```
