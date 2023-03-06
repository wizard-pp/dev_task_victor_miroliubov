DIRECTORY STRUCTURE
-------------------

      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      mail/               contains view files for e-mails
      models/             contains model classes
      runtime/            contains files generated during runtime
      services/           contains services for controllers
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources



REQUIREMENTS
------------

The minimum requirement by this project template that your Web server supports PHP 8.2.


INSTALLATION
------------

```
composer install
docker-compose up -d
docker-compose exec php php yii migrate
```

CONFIG
------
1. Set database connection at ```/config/db.php```.
2. Set docker local ip at ```/config/web.php``` at section ```modules.gii.allowedIPs``` if you wanna use gii.
3. Profit!