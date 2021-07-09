# Budget

![GitHub latest release](https://img.shields.io/github/v/release/range-of-motion/budget?include_prereleases)
![GitHub downloads](https://img.shields.io/github/downloads/range-of-motion/budget/total)
[![Build status](https://travis-ci.com/range-of-motion/budget.svg?branch=master)](https://travis-ci.com/range-of-motion/budget)
[![codecov](https://codecov.io/gh/range-of-motion/budget/branch/master/graph/badge.svg)](https://codecov.io/gh/range-of-motion/budget)
[![GitHub license](https://img.shields.io/github/license/range-of-motion/budget.svg)](https://github.com/range-of-motion/budget/blob/master/LICENSE)

Budget is an open-source web application that helps you keep track of your finances.

You can use Budget by hosting it yourself, or using [the instance hosted by us](https://budgethq.com).

![Product](https://user-images.githubusercontent.com/9268822/46098425-a8877300-c1c4-11e8-9293-f43ceb9d6f97.png)

## Features

* Insertion and management of transactions
* Ability to organize transactions using tags
* Facilitate uploading and organizing of receipts
* Support for importing transactions (CSV format)
* Reports that visualize financials (showing weekly balance and most expensive tags, for example)
* Supports multiple currencies
* Available in multiple languages
* Weekly summary available through e-mail

## Requirements

* PHP 7.3 or higher
* HTTP server (for example Apache or NGINX)
* MySQL
* Composer
* Node.js

## Installation

* Clone the repository (`git clone https://github.com/range-of-motion/budget.git`)
    * You should always check out a tag, since the `master` branch might not always be stable (`git checkout TAG`)
* Install dependencies (`composer install --no-dev -o`)
* Run installation command (`php artisan budget:install`)
* Configure additional services in `.env` (database or mail, for example)
* Run migrations for database (`php artisan migrate`)
* Head over to your list of crons (`crontab -e`) and add `* * * * * cd /path-to-budget && php artisan schedule:run >> /dev/null 2>&1`

*Note that in order for certain features to work properly, the jobs queue needs to be watched. This can be done by either running `php artisan queue:work` or using [Supervisor](https://laravel.com/docs/7.x/queues#supervisor-configuration).*

## Updating

Use the command below to update to the latest version.

```
php artisan budget:update
```

## Docker

You can get set-up with Budget using Docker.

### Do it yourself

If you just want an environment that takes care of the webserver, PHP and database, you should use this option. It will spin up the services required to run Budget, but not do any of the setting up for the application (activities such as installing Composer dependencies or generating an application key).

`docker-compose up -d`

### Automatic

If you want everything to be installed and set-up from start to finish, you should use this option. By providing the `BUDGET_SETUP` environment variable, a script will run that does everything you need–whether it's installing Composer dependencies or compiling front-end assets.

It may take a few minutes before the process is completed and you're able to use Budget.

`BUDGET_SETUP=1 docker-compose up -d`

## Contact

* [Discord](https://discord.gg/QFQdvy3)
