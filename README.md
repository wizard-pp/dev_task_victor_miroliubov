DIRECTORY STRUCTURE
-------------------

      application/assets/             contains assets definition
      application/commands/           contains console commands (controllers)
      application/config/             contains application configurations
      application/controllers/        contains Web controller classes
      application/mail/               contains view files for e-mails
      application/models/             contains model classes
      application/runtime/            contains files generated during runtime
      application/services/           contains services for controllers
      application/tests/              contains various tests for the basic application
      application/vendor/             contains dependent 3rd-party packages
      application/views/              contains view files for the Web application
      application/web/                contains the entry script and Web resources
      migrations/                     contains all of the migrations
      docker/                         contains docker config files



REQUIREMENTS
------------

The minimum requirement by this project template that your Web server supports PHP 8.2.


INSTALLATION
------------

```
cd application
composer install
cd ../docker
docker-compose up -d
docker-compose exec php php application/yii migrate
```

CONFIG
------
1. Set database connection at ```/application/config/db.php```.
2. Set docker local ip at ```/application/config/web.php``` at section ```modules.gii.allowedIPs``` if you wanna use gii.
3. Apply database migrations.
4. Profit!