# Status - WIP
**This was published as part of a lightning talk at virtual StripeCon 2020. Unfortunately it wasn't ready at the time of the conference and still is work in progress. As much as I like it to be finished product - so far its not. Time will tell how things progress.**

# Setup, Requirements & install

This project is inspired from [Bigfork’s quickstart recipe](https://github.com/bigfork/silverstripe-recipe) for [Silverstripe](https://www.silverstripe.org/). It's an opinionated set of tools for a ready to run, build & deploy CMS instance in a minimal amount of time. To get it up and running you'll need [GIT](https://git-scm.com/), [Docker](https://www.docker.com/), [NPM](https://nodejs.org/) preferred with [nvm](https://github.com/nvm-sh/nvm) and for deployment a server with [SSH](https://de.wikipedia.org/wiki/Secure_Shell) access. It utilizes [dnadesign/silverstripe-elemental](https://github.com/dnadesign/silverstripe-elemental) for a block/element based CMS experience and comes with the following set of elements:

    - ElementContent
    - ElementForm               (userforms)
    - ElementVirtual
    - ElementHero               (Slider, YouTube Video)
    - ElementMaps               (Google)
    - ElementPerso              (URLs Perso, vCard)
    - ElementPersoCFA
    - ElementContentSection     (accordion)
    - ElementCounter
    - ElementLogo               (partner/sponsor)
    - ElementGallery            (lightbox)
    - ElementTeaser
    - ElementFeedTeaser         (holder concept per element with tags)
    - ElementTextImage

    Optional - module in project:
    - ElementJobs              (schema.org & sitemap.xml)
    - ElementPodcast           (https://github.com/lerni/podcast)

Other features:

    - DSGVO GDPR ready Cookie Consent with klaro!
    - Multilingual ready in minutes
    - Blog - elemental based
    - schema.org integration
    - Meta & OpenGraph integration
    - depending on content ~90+ close to 100% Google PageSpeed Score
    - Google Analytics & Tagmanager, Microsoft Clarity, sitemap.xml, robots.txt
    - etc.

## Getting started
As editor/IDE [VSCode](https://code.visualstudio.com/) with [Silverstripe](https://marketplace.visualstudio.com/items?itemName=adrianhumphreys.silverstripe) extension is recommended. There are further settings under `.vscode/settings.json` for extensions like , [PHP Intelephense](https://marketplace.visualstudio.com/items?itemName=bmewburn.vscode-intelephense-client), [PHP Debug](https://marketplace.visualstudio.com/items?itemName=xdebug.php-debug) and [Log Viewer](https://marketplace.visualstudio.com/items?itemName=berublan.vscode-log-viewer) allowing an even smoother experience. Zsh with [agnoster.zsh-theme](https://github.com/agnoster/agnoster-zsh-theme) is used in the docker container. This needs [Powerline font](https://github.com/powerline/fonts) to be installed on the host machine to shine in it's full beauty.


### clone or fork lerni/ootstra
```bash
    git clone git@github.com:lerni/ootstra.git "PROJECT"
```
On the first Request the database structure (tables) 'll automatically be generated - it runs a `dev/build`. Before you do so, set the correct default locale in `app/_config.php` like:
```php
    i18n::set_locale('de_CH');
```
### npm
Node/npm runs locally. There is an `.nvmrc` file in `themes/default/`. If [nvm](https://github.com/nvm-sh/nvm) is set up, npm version should switch automatically when changing directory into `themes/default/`.
```bash
    cd PROJECT/themes/default
    npm install
```
### Docker dev-env
For development purpose the project comes with a Dockerfile for Apache/PHP/MySQL/phpMyAdmin/MailHog. Obviously [docker](https://www.docker.com/) needs to be installed. Run the commands bellow in the project directory:
```bash
    cd PROJECT/
    docker build --tag silverstripe:refined .
    docker-compose up
 ```
### Docker zsh, composer
```bash
    cd PROJECT/
    docker-compose exec silverstripe zsh
    composer install
```
### Laravel Mix watch & build
[Laravel Mix](https://github.com/JeffreyWay/laravel-mix) ([webpack](https://webpack.js.org/) based) is used as build environment. In `themes/default/webpack.mix.js` vhost is set and 'll be proxied to http://localhost:3000/ in order to run browsersync.
```bash
    cd themes/default && npm run watch
or
    cd themes/default && npm run production
```

This should make a local webserver available on [http://localhost:8080/](http://localhost:8080/) or [http://localhost:3000/](http://localhost:3000/) if the watcher is running. `phpMyAdmin` you'll find under [http://localhost:8081/](http://localhost:8081/), MailHog under [http://localhost:8025/](http://localhost:8025/). Default login into `/admin` is `admin` & `password`. **ATM `.env` isn't used with docker - env-var are set in `docker-compose.yml` when running per docker.**

With `docker ps` you can get the <CONTAINER ID> of running instances. To run a shell in a container do either `docker exec -it <CONTAINER_NAME> zsh` or just `docker-compose exec silverstripe zsh`.

With other webserver setups, point your vhost document root of your dev-env to `/project/public` and adjust `proxy` in `themes/default/webpack.mix.js`. Database, credentials etc. are provided per environment Variables. See also:

https://www.silverstripe.org/learn/lessons/v4/up-and-running-setting-up-a-local-silverstripe-dev-environment-1

https://docs.silverstripe.org/en/4/getting_started/environment_management/#core-environment-variables

Example `.env`-file in webroot for local development could look like:

```
# For a complete list of core environment variables see
# https://docs.silverstripe.org/en/4/getting_started/environment_management/#core-environment-variables

# Environment dev/stage/live
SS_ENVIRONMENT_TYPE="dev"

# SS_DEFAULT_ADMIN_USERNAME=""
# SS_DEFAULT_ADMIN_PASSWORD=""

SS_ERROR_EMAIL=""
SS_ADMIN_EMAIL=""

## Database {#database}
# SS_DATABASE_NAME=""
SS_DATABASE_CHOOSE_NAME=true
SS_DATABASE_CLASS="MySQLDatabase"
SS_DATABASE_USERNAME=""
SS_DATABASE_PASSWORD=""
SS_DATABASE_SERVER="127.0.0.1"

SS_ERROR_LOG="silverstripe.log"

GHOSTSCRIPT_PATH="/usr/local/bin/gs"
```

For your PHP-CLI-Setup, it might be helpful, to set `sys_temp_dir = "/tmp"` in `php.ini` for `sspak`.

# Hosting & Deployment

You need to [add your public key on the remote server](https://www.google.com/search?q=add+public+key+to+server) in ~/.ssh/authorized_keys. You can use [ssh-copy-id](https://www.ssh.com/ssh/copy-id) on nix-based systems. Deployment is based on [Deployer](https://deployer.org/) - a php based cli-tool. It uses symlinks to the current release. It's easy to use, offers zero downtime deployments and rollback. `/assets`, `.env` are shared resources, this means they are symlinked into each release-folder.

```
~/public_html/0live        or ~/public_html/0stage
|
|--.dep
|  |--releases             deployers internal notes
|
|--current              -> ~/public_html/0live/releases/3 for example
|  |--public               actual webroot but symlinked per parent-dir (current)
|  |  |--assets         -> ~/public_html/0live/shared/assets
|  |  |--...
|
|--releases
|  |--1
|  |  |--.env           -> ~/public_html/0live/shared/.env
|  |  |--...
|  |
|  |--2
|  |  |--.env           -> ~/public_html/0live/shared/.env
|  |  |...
|  |
|  |--...                  as many as defined in keep_releases
|
|--shared
   |--public/assets
   |--.env

```

[Deployer](https://deployer.org/) is included as dev-requirement per `composer.json`. An alias in you rc-files makes it available in thee project directory, so you just can use `dep` instead of prefixing it with `./vendor/bin/...` all the time.
```bash
alias dep="./vendor/bin/dep"
```

To transfer assets and database [ssbak](https://github.com/axllent/ssbak) (GO) is used over [sspak](https://github.com/silverstripe/sspak/) (PHP). Run deployer task like `dep silverstripe:installtools live` to install it on a remote linux servers in `~/bin`. You can set `ssXak_local_path` and `ssXak_path` in `deployer.php`.

```bash
curl -sS https://silverstripe.github.io/sspak/install | php -- /usr/local/bin
```

## Configuration

Rename `config.example.php` to `deploy/config.php` and configure things to your needs. Usually `.htaccess` in public comes from the repo but if needed, it can also be overwritten with a stage specific version. Just create `./deploy/stage.htaccess` or `./deploy/live.htaccess`, which than 'll overwrite the file from the repo during deployment, depending on stage.

# Deploy

```bash
    ./vendor/bin/dep deploy stage
```

or

```bash
    ./vendor/bin/dep deploy live
```

`stage` is default for all `dep` commands and can be omitted. For example with `dep ssh` you'll end up on your stage server with `dep ssh live` - well on live.

The first time you deploy to a given stage, you’ll be asked to provide database credentials used to populate `.env`.

## Deploy a branch/tag/revison

```
# Deploy the dev branch to stage
dep deploy --revision=ca5fcd330910234f63bf7d5417ab6835e5a57b81

# Deploy the dev branch to stage
dep deploy --branch=dev

# Deploy tag 1.0.1 to live
dep deploy live --tag=1.0.1
```

## Uploading/downloading database & assets manually
ssbak is a cli tool for managing Silverstipe database & assets. It's also used in the deployment-process for backup purpose. Unlink sspak, does ssbak not support transfer between environment (like directly bellow) but wrapped with deployer it's possible - see a bit further down.

To get assets and a DB-Dump from the server you can run:
```bash
    ./vendor/bin/sspak save USER@SERVER.TLD:/home/USER/public_html/0live/current ./SOMENAME.tar.gz
```
### Transfer with Docker - Update pending
```bash
    docker-compose exec -T database mysql DBNAME < database.sql
```


## Download assets
```bash
dep silverstripe:download_assets
```

## Download database
```bash
dep silverstripe:download_database
```

## Download assets from live
```bash
dep silverstripe:download_assets live
```

## Download database from live
```bash
dep silverstripe:download_database live
```

# Manual dev/build

DevelopmentAdmin over HTTP in Live-Mode is disabled per yml-config. You can use the following deployer-tasks.


## dev/build on stage
```bash
dep silverstripe:dev_build
```
## dev/build on live
```bash
dep silverstripe:dev_build live
```
