# Status - WIP
**This was published as part of a lightning talk at virtual StripeCon 2020. Unfortunately it wasn't ready at the time of the conference and still is work in progress. As much as I like it to be finished product - so far its not. Time will tell, how things progress.**

# Setup, Requirements & install

This project is inspired from [Bigfork’s quickstart recipe](https://github.com/bigfork/silverstripe-recipe) for [Silverstripe](https://www.silverstripe.org/). It's an opinionated set of tools for a ready to run, build & deploy CMS instance in a minimal amount of time. To get it up and running you'll need [GIT](https://git-scm.com/), [Docker](https://www.docker.com/) (for local development), [NPM](https://nodejs.org/) preferred with [nvm](https://github.com/nvm-sh/nvm) and for deployment a server with [SSH](https://de.wikipedia.org/wiki/Secure_Shell) & git. It utilizes [dnadesign/silverstripe-elemental](https://github.com/dnadesign/silverstripe-elemental) for a block/element based CMS experience and comes with the following set of elements:

- ElementContent
- ElementForm               (userforms)
- ElementVirtual
- ElementHero               (Slider, YouTube Video)
- ElementMaps               (Google)
- ElementPerso              (URLs Perso, vCard)
- ElementPersoCFA
- ElementContentSection     (accordion with FAQ schema)
- ElementCounter
- ElementLogo               (partner/sponsor)
- ElementGallery            (lightbox, slider)
- ElementTeaser
- ElementFeedTeaser         (holder concept per element with tags)
- ElementTextImage

Optional, separate modules:
- [InstagramFeed](https://github.com/lerni/instagram-basic-display-feed-element)
- EMail-/LinkDownload (not yet published), Contact collector
- [ElementPodcast](https://github.com/lerni/podcast)
- ElementJobs (privat), schema.org & sitemap.xml integration
- EasyShop (privat), Google Shoppingfeed with local Inventory & Omnipay

Other features:
- [DSGVO GDPR ready, Cookie Consent with klaro!](https://github.com/lerni/klaro-cookie-consent)
- Multilingual ready in minutes with [fluent](https://github.com/tractorcow-farm/silverstripe-fluent)
- Elemental based [Blog](https://github.com/silverstripe/silverstripe-blog)
- [schema.org](https://schema.org/) integration with [spatie/schema-org](https://github.com/spatie/schema-org)
- Meta & OpenGraph integration & MetaOverviewPage
- depending on content ~90+ close to 100% Google PageSpeed Score
- [Google Analytics & Tagmanager, Microsoft Clarity](https://github.com/lerni/googleanalytics), sitemap.xml, robots.txt
- etc.

## Getting started
As editor/IDE [VSCode](https://code.visualstudio.com/) is recommended. Per `.vscode/extensions.json` extensions 'll be suggested and `.vscode/settings.json` contains settings for debugging, making Logviewer work out of the box etc.
- [Silverstripe](https://marketplace.visualstudio.com/items?itemName=adrianhumphreys.silverstripe)
- [PHP Intelephense](https://marketplace.visualstudio.com/items?itemName=bmewburn.vscode-intelephense-client)
- [PHP Debug](https://marketplace.visualstudio.com/items?itemName=xdebug.php-debug)
- [Log Viewer](https://marketplace.visualstudio.com/items?itemName=berublan.vscode-log-viewer)
- [Debugger for Firefox](https://marketplace.visualstudio.com/items?itemName=firefox-devtools.vscode-firefox-debug)
- [EditorConfig for Visual Studio Code](https://marketplace.visualstudio.com/items?itemName=EditorConfig.EditorConfig)
- [Prettier - Code formatter](https://marketplace.visualstudio.com/items?itemName=esbenp.prettier-vscode)
- [Quokka.js](https://marketplace.visualstudio.com/items?itemName=WallabyJs.quokka-vscode)
- [Auto Rename Tag](https://marketplace.visualstudio.com/items?itemName=formulahendry.auto-rename-tag)
- [npm Intellisense](https://marketplace.visualstudio.com/items?itemName=christian-kohler.npm-intellisense)
- [ESLint](https://marketplace.visualstudio.com/items?itemName=dbaeumer.vscode-eslint)
- [Sass](https://marketplace.visualstudio.com/items?itemName=Syler.sass-indented)

Zsh with [agnoster.zsh-theme](https://github.com/agnoster/agnoster-zsh-theme) is used in the docker container. This needs [Powerline font](https://github.com/powerline/fonts) -> `Droid Sans Mono for Powerline` to be installed on the host machine to shine in it's full beauty.


### clone or fork lerni/ootstra
```bash
    git clone git@github.com:lerni/ootstra.git "PROJECT"
```
On the first Request database structure (tables) 'll automatically be generated - it runs `dev/build`. Before you do so, set the correct default locale in `app/_config.php` like:
```php
    i18n::set_locale('de_CH');
```
### npm
Node/npm runs locally. There is an `.nvmrc` file in `themes/default/`. If [nvm](https://github.com/nvm-sh/nvm) is set up, npm version switches automatically when changing directory into `themes/default/`.
```bash
    cd PROJECT/themes/default
    npm install
```
### Docker dev-env
For development ootstra comes with a Docker-Setup with Apache/PHP/MySQL/phpMyAdmin/MailHog. Run the commands bellow in the project directory:
```bash
    cd PROJECT/
    docker build --tag silverstripe:refined80 .
    docker-compose up
 ```
### Docker zsh, composer
```bash
    cd PROJECT/
    docker-compose exec silverstripe zsh
    composer install
```
### Laravel Mix watch & build
[Laravel Mix](https://github.com/JeffreyWay/laravel-mix) ([webpack](https://webpack.js.org/) based) is used as build environment. In `themes/default/webpack.mix.js` host is set to be proxied to http://localhost:3000/ for browsersync. See also scripts section in `themes/default/package.json` and [Mix CLI](https://laravel-mix.com/docs/6.0/cli).
```bash
    cd themes/default && npm run watch
or
    cd themes/default && npm run production
```

Docker makes a local webserver available on [http://localhost:8080/](http://localhost:8080/), watcher/browsersync runs on [http://localhost:3000/](http://localhost:3000/), `phpMyAdmin` on [http://localhost:8081/](http://localhost:8081/), MailHog on [http://localhost:8025/](http://localhost:8025/). Default login into [/admin](http://localhost:8080/admin) is `admin` & `password`.

`docker ps` shows `<CONTAINER IDs>` for all running instances. To run a shell in a container do either `docker exec -it <CONTAINER_ID> zsh` or `docker-compose exec silverstripe zsh` -> containers are named in `docker-compose.yml`. You may add an alias to your rcfile (`~/.zshrc` on Mac) like: `alias dshell="docker-compose exec silverstripe zsh"` to just type `dshell` in order to run `zsh` in the silverstripe container.

Database, credentials etc. are provided per environment Variables. **For local development with docker no `.env` file is needed! EnvVars are set in `docker-compose.yml`.**

The first time you deploy to a given stage, you’ll be asked to provide database credentials etc. to populate `.env`. A file similar as bellow 'll be created.

```
# For a complete list of core environment variables see
# https://docs.silverstripe.org/en/4/getting_started/environment_management/#core-environment-variables

# Environment dev/stage/live
SS_ENVIRONMENT_TYPE="dev"
# SS_BASE_URL=""

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

# SS_NOCAPTCHA_SITE_KEY=""
# SS_NOCAPTCHA_SECRET_KEY=""
```
See also:

https://www.silverstripe.org/learn/lessons/v4/up-and-running-setting-up-a-local-silverstripe-dev-environment-1



## Debugging
In order to use Xdebug with this setup, a browser-extensions like [Xdebug Helper for Firefox](https://addons.mozilla.org/de/firefox/addon/xdebug-helper-for-firefox/) or [Xdebug helper](https://chrome.google.com/webstore/detail/xdebug-helper/eadndfjplgieldjbigjakmdgkmoaaaoc) is needed to control/trigger debugging behaviour.

To debug JS inside VSCode with Firefox [Debugger for Firefox](https://marketplace.visualstudio.com/items?itemName=firefox-devtools.vscode-firefox-debug) is used. With Chrome & Edge you may need to tweak config in `.vscode/launch.json` :shrug:

## PHP Version
Current used PHP-Version is 8.0. It's set in following places:
- `Dockerfile`
- `deploy/config.php`
- `public/.htaccess` -> watch out if you maintain stage specific versions in `deploy/`
- `composer.json`
- `docker-compose.yml` -> custom.php.ini
Don't forget to rebuild/restart docker and reinstall vendors per composer after changing!

# Hosting & Deployment

Deployment is based on [Deployer](https://deployer.org/), a php based cli-tool, which is included as dev-requirement per `composer.json`. It uses symlinks to the current release. It's easy to use, offers zero downtime deployments and rollback. `/assets`, `.env` are shared resources, this means they are symlinked into each release-folder.

```
~/public_html/0live        or ~/public_html/0test
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

You need to [add your public key on the remote server](https://www.google.com/search?q=add+public+key+to+server) in ~/.ssh/authorized_keys. On nix-based systems you can use [ssh-copy-id](https://www.ssh.com/ssh/copy-id) to do so.

There are a few aliases in silverstripe docker container:
- `dep` instead `$DOCUMENT_ROOT/vendor/bin/dep` (Deployer)
- `flush` instead `$DOCUMENT_ROOT/vendor/silverstripe/framework/sake flush`
- `flushh` (flush hard) instead `rm -rf $DOCUMENT_ROOT/silverstripe-cache/*`
- `dbuild` instead `$DOCUMENT_ROOT/vendor/silverstripe/framework/sake dev/build`

## Configuration

Rename `config.example.php` to `deploy/config.php` and configure things to your needs. Usually `.htaccess` in public comes from the repo but if needed, it can be overwritten with a stage specific version. Just create `./deploy/test.htaccess` or `./deploy/live.htaccess`, which than 'll overwrite `public/.htaccess` from the repo during deployment according to the stage in use.

# Deploy

The setup uses key-forwarding, so deployment can be done from inside the silverstripe docker container. Before first deployment ssh into remote servers like `dep ssh test` or `dep ssh live` and make sure ssh-fingerprint from the git repo are accepted. You may just do a git clone into a test directory to verify things work as expected. If so, deployment is than done like:
```bash
    ./vendor/bin/dep deploy test
```

or

```bash
    ./vendor/bin/dep deploy live
```


## Deploy a branch/tag/revison

```
# Deploy the dev branch to test
dep deploy --revision=ca5fcd330910234f63bf7d5417ab6835e5a57b81

# Deploy the dev branch to test
dep deploy --branch=dev test

# Deploy tag 1.0.1 to live
dep deploy live --tag=1.0.1 live
```

## Download assets from live/test utilizing rsync
```bash
dep silverstripe:download_assets live/test
```

## Download database from live/test
```bash
dep silverstripe:download_database live/test
```

## Download assets from live utilizing rsync
```bash
dep silverstripe:download_assets live
```

## Download database from live
```bash
dep silverstripe:download_database live
```

# Manual remove dev/build

DevelopmentAdmin over HTTP in Live-Mode is disabled per yml-config. Following deployer-tasks does it.


## dev/build on test
```bash
dep silverstripe:dev_build test
```
## dev/build on live
```bash
dep silverstripe:dev_build live
```
