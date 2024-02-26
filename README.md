# Status - WIP
**This is work in progress!**

# Setup, Requirements & install

"ootstra" is inspired from [Bigfork’s quickstart recipe](https://github.com/bigfork/silverstripe-recipe) for [Silverstripe](https://www.silverstripe.org/). It's an opinionated set of tools for a ready to run, build & deploy CMS instance. To get it up and running you'll need [GIT](https://git-scm.com/), an editor like [VSCode](https://code.visualstudio.com/) (recommended) & [ddev](https://ddev.readthedocs.io/en/stable/). It utilizes [dnadesign/silverstripe-elemental](https://github.com/dnadesign/silverstripe-elemental) for a block/element based CMS experience and comes with the following set of elements:

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

Optional, separate modules/elements:
- [InstagramFeed](https://github.com/lerni/instagram-basic-display-feed-element)
- ElementJobs lerni/jobpostings (privat), schema.org & sitemap.xml integration
- lerni/simplebasket (privat), Google Shoppingfeed with local Inventory, swissQR bill and CAMT payment reconciliation or Datatrans Payments

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
Per `.vscode/extensions.json` extensions 'll be suggested. `.vscode/settings.json` makes Logviewer work and contains settings for debugging etc.
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


### clone or fork lerni/ootstra
```bash
    git clone git@github.com:lerni/ootstra.git "PROJECT"
```
On the first Request database structure 'll automatically be generated - it runs `dev/build`. Before you do so, set the correct default locale in `app/_config.php` like:
```php
    i18n::set_locale('de_CH');
```
### ddev/Docker dev-env
If the project is renamed, reflect this in `.ddev/config.yaml` and rerun `ddev config`. Run `ddev start` & `ddev composer i` in the project directory. This provides a webserver at [https://ootstra.ddev.site](https://ootstra.ddev.site), with watcher/browsersync at [https://ootstra.ddev.site:3000/](https://ootstra.ddev.site:3000/), phpMyAdmin at [https://ootstra.ddev.site:8037](https://ootstra.ddev.site:8037), and Mailpit at [https://ootstra.ddev.site:8026/](https://ootstra.ddev.site:8026/). The default login at [/admin](https://ootstra.ddev.site/admin) is `admin` & `password`.

<!-- ### ddev-ssh-agent
This setup omits `ddev-ssh-agent` and exposes `SSH_AUTH_SOCK` via environment variable and mounting per `RUN --mount=type=ssh` into the web container. To use certain files or whole directories from your hosts home directory (e.g., `~/.composer`, `~/.gitconfig`, `~/.ssh`) in ddev, create symlinks in `~/.ddev/homeadditions` in order to use your local SSH keys. For more information, refer to the [ddev documentation](https://ddev.readthedocs.io/en/stable/users/extend/in-container-configuration/). Note the path of `/home/.ssh-agent/known_hosts`. A separate/copied `~/.ddev/homeadditions/.ssh/config` as bellow seems to properly locate ssh-config.
```bash
UserKnownHostsFile=~/.ssh/known_hosts
StrictHostKeyChecking=accept-new
``` -->

### npm, Laravel Mix watch & build etc.
[Laravel Mix](https://github.com/JeffreyWay/laravel-mix) ([webpack](https://webpack.js.org/) based) is used as build environment. You need to run `ddev theme install` to install npm packages. In `themes/default/webpack.mix.js` host is set to be proxied to https://ootstra.ddev.site:3000/ for browsersync. See also scripts section in `themes/default/package.json` and [Mix CLI](https://laravel-mix.com/docs/6.0/cli). Run `ddev theme watch` or `ddev theme prod`.

### VSCode tasks - remember all the commands :information_desk_person:
There are a bunch of tasks in `.vscode/tasks.json` available per `Command+Shift+B`:
- `ddev start` (magenta)
- `ddev stop` (magenta)
- `ddev restart` (magenta)
- `composer update` (magenta)
- `composer vendor-expose` (blue)
- `ddev logs` (magenta)
- `ddev theme install` (green)
- `ddev theme watch` (green)
- `ddev theme prod` (green)
- `flush` (blue)
- `flushh` (blue - flush hard) instead of `ddev exec rm -rf ./silverstripe-cache/*`
- `dev/build` (blue) instead of `ddev php ./vendor/silverstripe/framework/cli-script.php dev/build flush`
- `dev/build` (cyan) `dev/build flush on test / live`
- `download database from live` (cyan)
- `download assets from live` (cyan)
- `ssh test / live` (cyan)
- `deploy test / live` (cyan)
- `xdebug on / off` (magenta)
- `dep releases test / live` (cyan)

Colors group tasks like:
- magenta: local ddev
- blue: local silverstripe specific
- green: local npm
- cyan: remote server

Database, credentials etc. are provided per environment Variables (`/.env` file).

## PHP Version
Current used PHP-Version is 8.2. It's set in following places:
- `.ddev/config.yaml`
- `deploy/config.php`
- `public/.htaccess` -> watch out if you maintain stage specific versions in `deploy/`
- `composer.json`
- `.vscode/settings.json`

Don't forget to `ddev restart` and update packages `ddev composer u` after changing!

# Hosting & Deployment

Deployment is based on [Deployer](https://deployer.org/), a php based cli-tool, which is included as dev-requirement per `composer.json`. It uses symlinks to the current release. It's easy to use, offers zero downtime deployments and rollback. `/assets`, `.env` are shared resources, this means they are symlinked into each release-folder. On the remote server you'll need [SSH](https://de.wikipedia.org/wiki/Secure_Shell) & git, composer, same php-version on CLI as httpd, ln, readlink, realpath, rsync, sed, & xargs.

```
~/public_html/0live     or ~/public_html/0test
|
|--.dep
|  |--releases          deployers internal notes
|
|--current              -> ~/public_html/0live/releases/3 for example
|  |--.env              -> ~/public_html/0live/shared/.env
|  |--...               all the files from repo & vendors
|  |--public            actual webroot but symlinked per parent-dir (current)
|  |  |--assets/        -> ~/public_html/0live/shared/assets
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
|  |--...               as many as defined in keep_releases
|
|--shared
   |--public/assets
   |--.env

```

You need to [add your public key on the remote server](https://www.google.com/search?q=add+public+key+to+server) in ~/.ssh/authorized_keys. On nix-based systems you can use [ssh-copy-id](https://www.ssh.com/ssh/copy-id) to do so.

## Configuration

Rename `config.example.php` to `deploy/config.php` and configure things to your needs. Usually `.htaccess` in public comes from the repo but if needed, it can be overwritten with a stage specific version. Just create `./deploy/test.htaccess` or `./deploy/live.htaccess`, which than 'll overwrite `public/.htaccess` from the repo during deployment according to the stage in use.

# Deploy

The setup uses key-forwarding, so deployment can be done from inside the ddev-web container. Before first deployment ssh into remote servers like `ddev php ./vendor/bin/dep ssh test` or `ddev php ./vendor/bin/dep ssh live` and make sure ssh-fingerprint from the git repo is accepted. You may just do a git clone into a test directory to verify things work as expected. If so, deployment is done like:
```bash
    ddev php ./vendor/bin/dep deploy test
```

or

```bash
    ddev php ./vendor/bin/dep deploy live
```
The first time you deploy to a given stage, you’ll be asked to provide database credentials etc. to populate `.env`. A file similar as bellow 'll be created.

```
# For a complete list of core environment variables see
# https://docs.silverstripe.org/en/4/getting_started/environment_management/#core-environment-variables

# Environment dev/stage/live
SS_ENVIRONMENT_TYPE='dev'
# SS_BASE_URL=''

# SS_DEFAULT_ADMIN_USERNAME=''
# SS_DEFAULT_ADMIN_PASSWORD=''

SS_ERROR_EMAIL=''
SS_ADMIN_EMAIL=''

## Database {#database}
SS_DATABASE_NAME='db'
# SS_DATABASE_CHOOSE_NAME=true
SS_DATABASE_CLASS='MySQLDatabase'
SS_DATABASE_USERNAME='db'
SS_DATABASE_PASSWORD='db'
SS_DATABASE_SERVER='db'
SS_DATABASE_PORT='3306'

SS_ERROR_LOG='silverstripe.log'

MAIL_MAILER=smtp
MAIL_HOST=localhost
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAILER_DSN='smtp://localhost:1025'

GHOSTSCRIPT_PATH='/usr/bin/gs'

SCRIPT_FILENAME=''

# APP_GOOGLE_MAPS_KEY=''
# SS_NOCAPTCHA_SITE_KEY=''
# SS_NOCAPTCHA_SECRET_KEY=''
```
See also:

https://www.silverstripe.org/learn/lessons/v4/up-and-running-setting-up-a-local-silverstripe-dev-environment-1

## Deploy a branch/tag/revison

```
# Deploy revision (git SHA) to test
ddev php ./vendor/bin/dep deploy --revision=ca5fcd330910234f63bf7d5417ab6835e5a57b81 test

# Deploy dev branch to test
ddev php ./vendor/bin/dep deploy --branch=dev test

# Deploy tag 1.0.1 to live
ddev php ./vendor/bin/dep deploy live --tag=1.0.1 live
```

## Show deployed revision
```bash
ddev php ./vendor/bin/dep releases live

task releases
+----------------------+-------------+-------- live ---+------------------------------------------+
| Date (Europe/Zurich) | Release     | Author | Target | Commit                                   |
+----------------------+-------------+--------+--------+------------------------------------------+
| 2022-11-21 16:57:41  | 1           | user   | HEAD   | 089d9397c34f0c478059a09470000006ed41e000 |
| 2022-12-01 16:06:45  | 2           | user   | HEAD   | 007300b9e054675050d0d1de7000000444918000 |
| 2022-12-02 10:41:18  | 3 (current) | user   | HEAD   | 0d2f7df3fbbc53f666366c3cf000000a392f3000 |
+----------------------+-------------+--------+--------+------------------------------------------+

... or use VSCode tasks Command+Shift+B
```

## Uploading/downloading database from live/test
```bash
# Upload database to test
ddev php ./vendor/bin/dep silverstripe:upload_database test

# Download database from live
ddev php ./vendor/bin/dep silverstripe:download_database live

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
ddev php ./vendor/bin/dep silverstripe:dev_build live -v
# dev/build on test
ddev php ./vendor/bin/dep silverstripe:dev_build test -v
```
# License
`ootstra` is licensed under the [BSD license](LICENSE). Third-party modules have different licenses like (0BSD, Apache 2.0, Apache-2.0, BSD*, BSD-2-Clause, BSD-3-Clause, CC-BY-3.0, CC-BY-4.0, CC0-1.0, GPL-2.0, GPL-3.0+, GPL-3.0-or-later, ISC, MIT, MIT*, Zlib, etc.). Check with `composer licenses`, `npx license-checker --summary` in `themes/default` and be aware of the suggested plugins for VSCode. Use implies acceptance of all licenses. Note that [@fancyapps/ui](https://fancyapps.com/) is commercial software requiring a [purchased license](https://fancyapps.com/pricing/).
