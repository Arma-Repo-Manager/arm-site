# Arma Repository Manager Site
This repo is for the website of the Arma Repository Manager

### Installation

You need to install Composer: https://getcomposer.org/download/

You need to install Yarn: https://yarnpkg.com/en/docs/install

`git clone`

`composer install`

`yarn install`

You can now go to your localserver or you can start the build in server.
To do that you can run this command(in the root folder of the project)

`php bin/console server:run`

### Commands

`php bin/console doctrine:database:create`

`php bin/console make:entity`

`php bin/console make:migration`

`php bin/console doctrine:migrations:migrate`

`php bin/console make:entity`

`php bin/console doctrine:migrations:migrate`