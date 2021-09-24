# Status - WIP
**This project was published as part of a lightning talk at virtual StripeCon 2020. Unfortunately it wasn't ready at the time of the conference and still is work in progress. As much as I like it to be finished product - so far its not. Time will tell how things progress.**

# Setup, Requirements & install

This project is inspired from [Bigfork’s quickstart recipe](https://github.com/bigfork/silverstripe-recipe) for [Silverstripe](https://www.silverstripe.org/). It's an opinionated set of tools for a ready to run, build & deploy CMS instance in a minimal amount of time. To get it up and running you'll need [GIT](https://git-scm.com/), [Docker](https://www.docker.com/), [composer](https://getcomposer.org/download/), [NPM](https://nodejs.org/) and a server with [SSH](https://de.wikipedia.org/wiki/Secure_Shell). It utililizes [dnadesign/silverstripe-elemental](https://github.com/dnadesign/silverstripe-elemental) for a block/element based CMS experience and commes with the following set of elements:

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
    - Analytics, Tagmanager, sitemap.xml, robots.txt
    - etc.

## VCS, source repo

```bash
    git clone git@github.com:lerni/ootstra.git "PROJECT"
```

## PHP, composer

```bash
    cd PROJECT/
    composer install
```

### Running local dev-env

This project comes with a Dockerfile for Apache/PHP/MySQL. For this you need to install [docker](https://www.docker.com/) and than run the commands bellow in your project:

 - `docker build --tag silverstripe:refined .`
 - `docker-compose up`

It than should be available on [http://localhost:8080/](http://localhost:8080/). With docker no `.env` file is needed. Default login is `admin` & `password`. With other webserver setups, point your vhost document root to `project/public`. Database, credentials etc. are provided per environment Variables. See also:

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

GHOSTSCRIPT_PATH="/usr/local/bin/gs"
```

## npm

```bash
    cd PROJECT/themes/default
    npm install
```

This project uses [Laravel Mix](https://github.com/JeffreyWay/laravel-mix) ([webpack](https://webpack.js.org/) based) as build environment. Your vhost 'll be proxied per http://localhost:3000/ in order to run it with browsersync.

```bash
    npm run watch
```

```bash
    npm run production
```

# Hosting & Deployment

You need to [add your public key on the remote server](https://www.google.com/search?q=add+public+key+to+server) in ~/.ssh/authorized_keys. You can use [ssh-copy-id](https://www.ssh.com/ssh/copy-id) on nix-based systems. Deployment is based on [Deployer](https://deployer.org/) - a php based cli-tool. It uses symlinks to the current release. It's easy to use, offers zero downtime deployments and rollback. `/assets`, `.env` are shared resources, this means they are also symlinked into each release-folder.

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

[Deployer](https://deployer.org/) is included in this project as dev-requirement per `composer.json` but can also be installed globally like:

```bash
curl -LO https://deployer.org/deployer.phar
mv deployer.phar /usr/local/bin/dep
chmod +x /usr/local/bin/dep
```

To transfer assets and database [ssbak](https://github.com/axllent/ssbak) (GO) is used over [sspak](https://github.com/silverstripe/sspak/) (PHP). Run deployer task like `dep silverstripe:installtools live` to install it on a remote linux servers in `~/bin`. You can set `ssXak_local_path` and `ssXak_path` in `deployer.php`.


## Configuration

Rename `config.example.php` to `deploy/config.php` and configure things to your needs.

## Deploying a site

```bash
    ./vendor/bin/dep deploy stage
```

or

```bash
    ./vendor/bin/dep deploy live
```

`stage` is default for all `dep` commands and can be omitted. For example with `dep ssh` you'll end up on your stage server with `dep ssh live` - well on live.

The first time you deploy to a given stage, you’ll be asked to provide database credentials used to populate `.env`.

### Deploy a branch/tag/revison
```
# Deploy the dev branch to stage
dep deploy --revision=ca5fcd330910234f63bf7d5417ab6835e5a57b81

# Deploy the dev branch to stage
dep deploy --branch=dev

# Deploy tag 1.0.1 to live
dep deploy live --tag=1.0.1
```

### Uploading/downloading database & assets manually
ssbak is a cli tool for managing Silverstipe database & assets. It's also used in the deployment-process for backup purpose. Unlink sspak, does ssbak not support transfer between environment (like directly bellow) but wrapped with deployer it's possible - see a bit further down.
https://github.com/silverstripe/sspak
To get assets and a DB-Dump from the server you can run:
```
./vendor/bin/sspak save USER@SERVER.TLD:/home/USER/public_html/0live/current ./SOMENAME.tar.gz
```

```
docker-compose exec -T database mysql DBNAME < database.sql
```

```
# Upload assets
dep silverstripe:upload_assets

# Upload database
dep silverstripe:upload_database

# Download assets
dep silverstripe:download_assets

# Download database
dep silverstripe:download_database

# Upload assets to live
dep silverstripe:upload_assets live

# Upload database to live
dep silverstripe:upload_database live

# Download assets from live
dep silverstripe:download_assets live

# Download database from live
dep silverstripe:download_database live
```

## Manual dev/build

DevelopmentAdmin over HTTP in Live-Mode is disabled per yml-config, but you an use the following deployer-tasks.

```
# dev/build on stage
dep silverstripe:dev_build

# dev/build on live
dep silverstripe:dev_build live
```
