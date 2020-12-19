# Status - WIP
**This project was published as part of a lightning talk at virtual StripeCon 2020. Unfortunately it wasn't ready at the time of the conference so it's Work in Progress. As much as I like it to be finished product - so far its not. Time will tell how things progress.**


# Setup, Requirements & install

This project is inspired from [Bigfork’s quickstart recipe](https://github.com/bigfork/silverstripe-recipe) for [Silverstripe](https://www.silverstripe.org/). It's an opinionated set of tools for a ready to run, build & deploy CMS instance in a minimal amount of time. To get it up and running you'll need [GIT](https://git-scm.com/), some kinda local xAMP-setup (apache mysql php), [composer](https://getcomposer.org/download/), [NPM](https://nodejs.org/) and a server with [SSH](https://de.wikipedia.org/wiki/Secure_Shell) & [GIT](https://git-scm.com/). It utililizes [dnadesign/silverstripe-elemental](https://github.com/dnadesign/silverstripe-elemental) for a block/element based CMS experience and commes with the following set of elements:

    - ElementContent
    - ElementForm               (userforms)
    - ElementVirtual
    - ElementHero
    - ElementMaps               (Google)
    - ElementPerso
    - ElementPersoCFA
    - ElementJobs               (schema.org & sitemap.xml)
    - ElementContentSection     (accordion)
    - ElementCounter
    - ElementLogo               (partner/sponsor)
    - ElementGallery            (lightbox)
    - ElementTeaser
    - ElementFeedTeaser         (holder concept per element with tags)
    - ElementTextImage

Other features:

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

### Running on local dev-env

Point your vhost document root of your local dev-env to `/project/public`. Database, credentials etc. are provided per environment Variables. See also:

https://www.silverstripe.org/learn/lessons/v4/up-and-running-setting-up-a-local-silverstripe-dev-environment-1

https://docs.silverstripe.org/en/4/getting_started/environment_management/#core-environment-variables

Example `.env`-file in webroot for local develompment could look like:

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

For your PHP-CLI-Setup, it might be helpfull, to set `sys_temp_dir = "/tmp"` in `php.ini` for `sspak`.

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

You need to [add your public key on the remote server](https://www.google.com/search?q=add+public+key+to+server) in ~/.ssh/authorized_keys. You can use [ssh-copy-id](https://www.ssh.com/ssh/copy-id) on nix-based systems. Deployment is based on [Deployer](https://deployer.org/) - a php based cli-tool. It uses symlinks to the current release. It's easy to use, offers zero downtime deployments and rollback. `/assets`, `.env`, `silverstripe.log` are shared ressources, this means they are also symlinked into each release-folder.

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
   |--silverstripe.log

```

[Deployer](https://deployer.org/) is included in this project as dev-requirement per `composer.json` but can also be installed globally like:

```bash
curl -LO https://deployer.org/deployer.phar
mv deployer.phar /usr/local/bin/dep
chmod +x /usr/local/bin/dep
```

To transfer assets and databases [sspak](https://github.com/silverstripe/sspak/) is used. It's also included as dev-requirement in `composer.json`. Again you also can install it globally like:

```bash
curl -sS https://silverstripe.github.io/sspak/install | php -- /usr/local/bin
```

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

The first time you deploy to a given stage you’ll be asked to provide database credentials used to populate `.env`.

### Deploy a branch/tag

```
# Deploy the dev branch to staging
dep deploy --branch=dev

# Deploy tag 1.0.1 to live
dep deploy live --tag=1.0.1
```

### Uploading/downloading database & assets manually

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

DevelopmentAdmin is disabled per HTTP in Live-Mode per yml-config.

```
# dev/build on stage
dep silverstripe:dev_build

# dev/build on live
dep silverstripe:dev_build live
```
