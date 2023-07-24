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
- ElementPersoCFA           (linked persos)
- ElementContentSection     (accordion with FAQ schema)
- ElementCounter
- ElementLogo               (partner/sponsor)
- ElementGallery            (lightbox, slider)
- ElementTeaser
- ElementFeedTeaser         (holder concept with multiple parents & filtering per tags)
- ElementTextImage

Optional, separate modules:
- [InstagramFeed](https://github.com/lerni/instagram-basic-display-feed-element)
- ElementJobs lerni/jobpostings (privat), schema.org & sitemap.xml integration
- EasyShop lerni/simplebasket (privat), Google Shoppingfeed with local Inventory, swissQR bill or Omnipay

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
As editor/IDE [VSCode](https://code.visualstudio.com/) is recommended. Per `.vscode/extensions.json` extensions 'll be suggested. `.vscode/settings.json` makes Logviewer work and contains settings for debugging etc.
- [Silverstripe](https://marketplace.visualstudio.com/items?itemName=adrianhumphreys.silverstripe)
- [PHP Intelephense](https://marketplace.visualstudio.com/items?itemName=bmewburn.vscode-intelephense-client)
- [PHP Debug](https://marketplace.visualstudio.com/items?itemName=xdebug.php-debug)
- [Log Viewer](https://marketplace.visualstudio.com/items?itemName=berublan.vscode-log-viewer) Side-Bar Debug -> Log Viewer
- [Debugger for Firefox](https://marketplace.visualstudio.com/items?itemName=firefox-devtools.vscode-firefox-debug)
- [EditorConfig for Visual Studio Code](https://marketplace.visualstudio.com/items?itemName=EditorConfig.EditorConfig)
- [Prettier - Code formatter](https://marketplace.visualstudio.com/items?itemName=esbenp.prettier-vscode)
- [Auto Rename Tag](https://marketplace.visualstudio.com/items?itemName=formulahendry.auto-rename-tag)
- [npm Intellisense](https://marketplace.visualstudio.com/items?itemName=christian-kohler.npm-intellisense)
- [ESLint](https://marketplace.visualstudio.com/items?itemName=dbaeumer.vscode-eslint)
- [Sass](https://marketplace.visualstudio.com/items?itemName=Syler.sass-indented)

Zsh with [agnoster.zsh-theme](https://github.com/agnoster/agnoster-zsh-theme) is used in the docker container. This needs [Powerline font](https://github.com/powerline/fonts) -> `Droid Sans Mono for Powerline` installed on the host machine to shine in it's full beauty.


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
For development ootstra comes with a Docker-Setup with Apache/PHP/MySQL/phpMyAdmin/MailHog. For a proper user-mapping (same uid gid inside docker), it's recommended to export those in your rc-file. In case of zsh, add below to `~/.zshrc`:
```bash
    export UID=$(id -u)
    export GID=$(id -g)
```
To build & start docker run commands bellow in the project directory:
```bash
    cd PROJECT/
    docker build --tag silverstripe:refined81 .
    docker-compose up # or use VSCode tasks `docker-compose up` per Command+Shift+B
```
### Docker zsh, composer
```bash
    cd PROJECT/
    docker-compose exec silverstripe zsh # or use VSCode tasks `dshell` per Command+Shift+B
    composer install
```

Docker makes a local webserver available on [http://localhost:8080/](http://localhost:8080/), watcher/browsersync runs on [http://localhost:3000/](http://localhost:3000/), `phpMyAdmin` on [http://localhost:8081/](http://localhost:8081/), MailHog on [http://localhost:8025/](http://localhost:8025/). Default login into [/admin](http://localhost:8080/admin) is `admin` & `password`.

`docker ps` shows `<CONTAINER IDs>` for all running instances. To run a shell in a container do either `docker exec -it <CONTAINER_ID> zsh` or `docker-compose exec silverstripe zsh` -> containers are named in `docker-compose.yml`. To stop all containers use `docker-compose down`. There are a few aliases in the silverstripe docker container and a bunch of tasks in `.vscode/tasks.json` available per `Command+Shift+B`:
- `docker-compose up` (magenta)
- `docker-compose down` (magenta)
- `npm watch` (green)
- `npm prod` (green)
- `download database from live` (cyan)
- `download assets from live` (cyan)
- `flush` (blue) -> `flush` instead of `$DOCUMENT_ROOT/vendor/silverstripe/framework/sake flush`
- `flushh` (blue) -> `flushh` (flush hard) instead of `rm -rf $DOCUMENT_ROOT/silverstripe-cache/*`
- `dev/build` (blue) -> `dbuild` instead of `$DOCUMENT_ROOT/vendor/silverstripe/framework/sake dev/build`
- -> `dep` instead `$DOCUMENT_ROOT/vendor/bin/dep` (Deployer)

Database, credentials etc. are provided per environment Variables. **For local development with docker no `.env` file is needed! EnvVars are set in `docker-compose.yml`.**

### Laravel Mix watch & build
[Laravel Mix](https://github.com/JeffreyWay/laravel-mix) ([webpack](https://webpack.js.org/) based) is used as build environment. In `themes/default/webpack.mix.js` host is set to be proxied to http://localhost:3000/ for browsersync. See also scripts section in `themes/default/package.json` and [Mix CLI](https://laravel-mix.com/docs/6.0/cli).
```bash
    cd themes/default && npm run watch # or use VSCode tasks `npm watch` per Command+Shift+B
or
    cd themes/default && npm run production # or use VSCode tasks `npm prod` per Command+Shift+B
```

## Debugging
In order to use Xdebug with this setup, a browser-extensions like [Xdebug Helper for Firefox](https://addons.mozilla.org/de/firefox/addon/xdebug-helper-for-firefox/) or [Xdebug helper](https://chrome.google.com/webstore/detail/xdebug-helper/eadndfjplgieldjbigjakmdgkmoaaaoc) is needed to control/trigger debugging behaviour.

To debug JS inside VSCode with Firefox [Debugger for Firefox](https://marketplace.visualstudio.com/items?itemName=firefox-devtools.vscode-firefox-debug) is used. With Chrome & Edge you may need to tweak config in `.vscode/launch.json` :shrug:

## PHP Version
Current used PHP-Version is 8.1. It's set in following places:
- `Dockerfile`
- `deploy/config.php`
- `public/.htaccess` -> watch out if you maintain stage specific versions in `deploy/`
- `composer.json`
- `docker-compose.yml` -> path custom.php.ini
- `.vscode/settings.json`

Don't forget to rebuild/restart docker and reinstall packages in vendors per composer after changing!

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

## Configuration

Rename `config.example.php` to `deploy/config.php` and configure things to your needs. Usually `.htaccess` in public comes from the repo but if needed, it can be overwritten with a stage specific version. Just create `./deploy/test.htaccess` or `./deploy/live.htaccess`, which than 'll overwrite `public/.htaccess` from the repo during deployment according to the stage in use.

# Deploy

The setup uses key-forwarding, so deployment can be done from inside the silverstripe docker container. Before first deployment ssh into remote servers like `dep ssh test` or `dep ssh live` and make sure ssh-fingerprint from the git repo is accepted. You may just do a git clone into a test directory to verify things work as expected. If so, deployment is done like:
```bash
    dep deploy test
```

or

```bash
    dep deploy live
```
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
# MAIL_HOST=""
# MAIL_USERNAME=""
# MAIL_PASSWORD=""
```
See also:

https://www.silverstripe.org/learn/lessons/v4/up-and-running-setting-up-a-local-silverstripe-dev-environment-1

## Deploy a branch/tag/revison

```
# Deploy revision (git SHA) to test
dep deploy --revision=ca5fcd330910234f63bf7d5417ab6835e5a57b81 test

# Deploy dev branch to test
dep deploy --branch=dev test

# Deploy tag 1.0.1 to live
dep deploy live --tag=1.0.1 live
```

## Show deployed revision
```bash
dep releases live

task releases
+----------------------+-------------+-------- live ---+------------------------------------------+
| Date (Europe/Zurich) | Release     | Author | Target | Commit                                   |
+----------------------+-------------+--------+--------+------------------------------------------+
| 2022-11-21 16:57:41  | 1           | user   | HEAD   | 089d9397c34f0c478059a09470000006ed41e000 |
| 2022-12-01 16:06:45  | 2           | user   | HEAD   | 007300b9e054675050d0d1de7000000444918000 |
| 2022-12-02 10:41:18  | 3 (current) | user   | HEAD   | 0d2f7df3fbbc53f666366c3cf000000a392f3000 |
+----------------------+-------------+--------+--------+------------------------------------------+
```

## Uploading/downloading database from live/test
```bash
# Upload database to test
dep silverstripe:upload_database test

# Download database from live
dep silverstripe:download_database live

etc.
or use VSCode tasks Command+Shift+B
```
## Uploading/downloading assets from live/test utilizing rsync
```bash
# Download assets from live
dep silverstripe:download_assets live

# Upload assets to test
dep silverstripe:upload_assets test

etc.
or use VSCode tasks Command+Shift+B
```

# Manual remote dev/build
DevelopmentAdmin over HTTP is disabled in Live-Mode per yml-config. Following deployer-tasks 'll do.
```bash
# dev/build on live
dep silverstripe:dev_build live
# dev/build on test
dep silverstripe:dev_build test
```
