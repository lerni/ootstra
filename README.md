# Status - WIP
**This is work in progress!**

# Setup, Requirements & Install

"ootstra" is inspired by [Bigfork's quickstart recipe](https://github.com/bigfork/silverstripe-recipe) for [Silverstripe](https://www.silverstripe.org/). It's an opinionated set of tools for a ready to run, build & deploy CMS instance. To get it up and running you'll need [GIT](https://git-scm.com/), [VSCode](https://code.visualstudio.com/) (recommended) & [DDEV](https://ddev.readthedocs.io/en/stable/). It utilizes [dnadesign/silverstripe-elemental](https://github.com/dnadesign/silverstripe-elemental) for a block/element based CMS experience and comes with the following set of elements:

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
- ElementPDFDocument        PDF Download with preview & description

Optional, separate modules/elements:
- [InstagramFeed](https://github.com/lerni/instagram-basic-display-feed-element)
- ElementJobs lerni/jobpostings (privat), schema.org & sitemap.xml integration
- lerni/simplebasket (privat), Google Shoppingfeed with local Inventory, swissQR bill and CAMT payment reconciliation or Datatrans Payments

Other features:
- [DSGVO, GDPR, nDSG ready, Cookie Consent with klaro!](https://github.com/lerni/klaro-cookie-consent)
- Multilingual ready in minutes with [fluent](https://github.com/tractorcow-farm/silverstripe-fluent)
- Elemental based [Blog](https://github.com/silverstripe/silverstripe-blog)
- [schema.org](https://schema.org/) integration with [spatie/schema-org](https://github.com/spatie/schema-org)
- Meta & OpenGraph integration & MetaOverviewPage
- depending on content close to 100 Google PageSpeed Score
- [Google Analytics & Tagmanager, Microsoft Clarity](https://github.com/lerni/googleanalytics), sitemap.xml, robots.txt
- etc.

## Getting started

This project supports **VSCode with devcontainer** (recommended). VSCode extensions run inside DDEV's web container, providing a complete development environment. Of course, it can also be used without devcontainer, utilizing standard DDEV CLI commands like `ddev start` etc.

**Without devcontainer:** Clone the project and run `ddev start`. Prefix all commands with `ddev` (e.g., `ddev composer install`, `ddev sake dev/build`, `ddev npm --prefix themes/default run dev` or shorthand `ddev theme dev`). See [DDEV documentation](https://ddev.readthedocs.io/en/stable/users/usage/commands/) for details.

**Local setup (on your host machine):**
- `ms-vscode-remote.remote-containers` extension will be suggested and is needed for devcontainers to work
- All other extensions (PHP Intelephense, Biome, Log Viewer, Xdebug, etc.) are automatically installed inside the container

**How it works:**
- Open the workspace in VS Code and use Command Palette (`Cmd+Shift+P` / `Ctrl+Shift+P`) → **"Dev Containers: Reopen in Container"**
- The devcontainer automatically starts DDEV (`ddev start` via `initializeCommand`) and runs `npm install` in `themes/default` (`postCreateCommand`)
- Editor extensions and settings are configured inside the container, keeping your host lean
- `.vscode/settings.json` contains in-container settings (Intelephense, log viewer, debug config)
- Ports are forwarded automatically: Vite (5173), Mailpit (8025), Apache (80, 443), MariaDB (3306)

### 1. Clone or fork lerni/ootstra
```bash
git clone git@github.com:lerni/ootstra.git "PROJECT"
```
The folder name is used as project name (recommended because `.vscode/launch.json` uses `${workspaceFolderBasename}` and DDEV also uses folder name by default as "name").

### 2. Open in devcontainer
```bash
cd "PROJECT"
code .
```
In VS Code, open the Command Palette (`Cmd+Shift+P` / `Ctrl+Shift+P`) and run:
**"Dev Containers: Reopen in Container"**

The devcontainer will automatically start DDEV and run `npm install` in `themes/default`.

### 3. Install PHP dependencies (inside the container)
All commands now run inside the devcontainer terminal:
```bash
composer install
```
### 4. Build the database
On dev/build, database structure will be generated. With fluent (Multilingual-Setup), comment out the locale setting as fluent handles language configuration:
```php
i18n::set_locale('de_CH');
```
```bash
php ./vendor/bin/sake dev/build
```
Or use the VS Code task: `Command+Shift+B` → `dev/build - local`

### 5. Populate default content
```bash
php ./vendor/bin/sake dev/tasks/PopulateTask
```

This provides:
- Webserver at [https://PROJECTNAME.ddev.site](https://PROJECTNAME.ddev.site)
- phpMyAdmin at [https://PROJECTNAME.ddev.site:8037](https://PROJECTNAME.ddev.site:8037)
- Mailpit at [https://PROJECTNAME.ddev.site:8026/](https://PROJECTNAME.ddev.site:8026/)

Default CMS-Login at [/admin](https://PROJECTNAME.ddev.site/admin) is `admin` & `password`.

### ssh forwarding, ddev-ssh-agent
This setup omits `ddev-ssh-agent` and exposes `SSH_AUTH_SOCK` from the host system into the web container in order to use local SSH keys. To make that work, key files from `~/.ssh` or the whole directories must be exposed into ddev by creating symlinks in `~/.ddev/homeadditions`. On macOS, the option `IgnoreUnknown UseKeychain` in `~/.ssh/config` causes `Bad configuration option` in the container, so symlinking individual files from `~/.ssh/` into `~/.ddev/homeadditions` and having a separate/copy of `~/.ddev/homeadditions/.ssh/config` worked for me ;)
For more information, refer to the [ddev documentation](https://ddev.readthedocs.io/en/stable/users/extend/in-container-configuration/) & [OpenSSH updates in macOS](https://developer.apple.com/library/archive/technotes/tn2449/_index.html), [DDEV issue](https://github.com/ddev/ddev/issues/1904)
```bash
UserKnownHostsFile=~/.ssh/known_hosts
StrictHostKeyChecking=accept-new
Host *
    ForwardAgent yes
```
To use `ddev-ssh-agent` instead, following configuration in `.ddev/config.yaml` can be removed and `.ddev/docker-compose.ssh-agent.yaml` can be deleted.
```yaml
omit_containers: [ddev-ssh-agent]
webimage_extra_packages: [openssh-client]
web_environment:
    - SSH_AUTH_SOCK=/run/host-services/ssh-auth.sock
```

### npm, Vite watch & build etc.
[Laravel's Vite components](https://laravel.com/docs/12.x/vite) are used as the frontend build environment. 

**With devcontainer:** The `postCreateCommand` automatically runs `npm install`. Use `npm --prefix themes/default run dev` for watch mode or VS Code task "npm watch". Production: `npm --prefix themes/default run build` or task "npm prod".

**Without devcontainer:** Prefix commands with `ddev`, e.g., `ddev npm --prefix themes/default run dev`.

See scripts in `themes/default/package.json` for all available commands.

### VSCode tasks (inside devcontainer)
Tasks in `.vscode/tasks.json` are available via `Command+Shift+B` and run inside the devcontainer. **Note:** Without devcontainer, use equivalent `ddev` commands (e.g., `ddev sake dev/build` instead of just `sake dev/build`).

Common tasks include:

**Silverstripe (blue):**
- `dev/build - local` - rebuild DB schema (`php ./vendor/bin/sake db:build`)
- `SilverStripe Shell` - interactive ssshell for debugging
- `composer install` / `composer update`
- `composer vendor-expose`

**Frontend npm/frontend (green):**
- `npm watch` - Vite dev server
- `npm prod` - production build
- `npm install & update update-browserslist-db`
- `clean '/hot' (Vite watcher)` - remove hot reload file

**DDEV/Debugging (magenta):**
- `logs` - tail Apache/PHP logs
- `DDEV: Enable Xdebug` / `DDEV: Disable Xdebug`

**Deployment / remote server (cyan):**
- `deploy test` / `deploy live`
- `download database from live` / `download assets from live`
- `ssh test` / `ssh live`
- `dep releases test` / `dep releases live`
- `deploy:unlock test` / `deploy:unlock live`

Database, credentials etc. are provided as environment-variables from `.ddev/config.yaml` and are populated in `/.env` during DDEV-start. Project specific / sensitive env-vars should be set in `/.env` and won't land in GIT. For example you do not have to setup DB credentials for local dev environment to work, but you need to set `APP_GOOGLE_MAPS_KEY`, `SS_NOCAPTCHA_SITE_KEY` & `SS_NOCAPTCHA_SECRET_KEY` in `.env` to make Google Maps & reCaptcha work.

## PHP Version
Currently 8.4.x is used. It's set in following places:
- `.ddev/config.yaml`
- `deploy/config.php`
- `public/.htaccess` -> watch out if stage specific versions are maintained in `deploy/`
- `composer.json`
- `.vscode/settings.json`

Don't forget to `ddev restart` and update packages `ddev composer u` after changing!

# Hosting & Deployment

Deployment is based on [Deployer](https://deployer.org/), a php based cli-tool, which is included as dev-requirement per `composer.json`. It uses symlinks to the current release. It's easy to use, offers zero downtime deployments and rollback. `public/assets`, `.env` are shared resources, this means they are symlinked into each release-folder. On remote servers you'll need [SSH](https://de.wikipedia.org/wiki/Secure_Shell) & git, composer, same php-version on CLI as httpd, ln, readlink, realpath, rsync, sed & xargs.

```
/var/www/html
|
|--.ddev/                               # ddev config
|--.graphql-generated/                  # not in repo, generated by graphql
|--.vscode/                             # vscode settings, config, tasks
|
|-- app/
|  |-- _config/                         # YML-config
|  |-- lang/                            # Localization
|  |-- src/                             # PHP code
|  |-- templates                        # App Templates
|  |-- _config.php
|
|-- deploy/                             # Deployment scripts & config
|                                       # Stage specific .htaccess files
|-- public/
|  |-- assets/                          # Assets
|  |-- index.php                        # Silverstripe entrypoint
|  |-- .htaccess                        # .htaccess
|
|-- silverstripe-cache/                 # Not in repo, generated by Silverstripe
|
|-- themes/                             # Themes
|  |-- default/                         # Default theme
|     |-- dist/assets                   # Assets build for distribution (CSS, JS, images, fonts)
|     |-- node_modules/                 # Node packages
|     |-- src/                          # Sourcefolder for build
|     |-- templates                     # Templates
|     |-- vite.config.js                # Vite config
|     |-- package.json                  # Node package file
|
|-- vendor/                             # Composer packages
|
|-- .env
|
|-- composer.json                       # Composer package file
|-- deploy.php
|-- README.md
|-- silverstripe.log                    # Logfile

```

## Structure on Remote Server - Symlinked with Deployer
```
~/public_html/0live or ~/public_html/0test
|
|-- .dep                                # Deployer's internal "notes"
|
|-- releases
|  |-- 1
|  |  |-- .env                          # Symlinked to shared/.env
|  |  |-- public            
|  |      |-- assets/                   # Symlinked to shared/assets/
|  |      |-- index.php
|  |
|  |-- 2
|  |  |...
|  |
|  |-- 3
|     |...                              # As many as defined in keep_releases
|
|-- shared
|   |-- public/assets
|   |-- .env                            # Environment config
|
|-- current/                            # Webroot symlinked to latest release

```

## SSH Key Setup
Public SSH keys [must be added to the remote servers](https://www.google.com/search?q=add+public+key+to+server) in `~/.ssh/authorized_keys`. On nix-based systems, use [ssh-copy-id](https://www.ssh.com/ssh/copy-id).

## Configuration
Rename `deploy/config.example.php` to `deploy/config.php` and configure as needed. The `.htaccess` file in `/public` is typically used, but can be overridden with stage-specific versions by creating `./deploy/test.htaccess` or `./deploy/live.htaccess`.

# Deploy
Key-forwarding is used, allowing deployment to be done from inside the ddev-web container. Read [ddev-ssh-agent](#ssh-forwarding-ddev-ssh-agent) above. Before first deployment, SSH into remote servers like `ddev php ./vendor/bin/dep ssh test` or `ddev php ./vendor/bin/dep ssh live` and ensure the SSH fingerprint from the git-repo is accepted. You can check like `ssh -T git@bitbucket.org` or may just `git clone ...` into a test directory to verify everything works as expected. If so, deployment is done as follows:

```bash
    ddev php ./vendor/bin/dep deploy test
```

or

```bash
    ddev php ./vendor/bin/dep deploy live
```
The first deployment to each stage will prompt for database credentials to populate an `.env` file. The resulting file will be similar to:
```
# For a complete list of core environment variables see
# https://docs.silverstripe.org/en/6/getting_started/environment_management/#core-environment-variables

# Environment dev/test/live
SS_ENVIRONMENT_TYPE='dev'
# SS_BASE_URL=''
SS_ALLOWED_HOSTS='*'

# SS_DEFAULT_ADMIN_USERNAME=''
# SS_DEFAULT_ADMIN_PASSWORD=''

SS_ERROR_EMAIL=''
SS_ADMIN_EMAIL=''
# MAILER_DSN=''
# SS_SEND_ALL_EMAILS_FROM=''

## Database {#database}
SS_DATABASE_NAME='db'
# SS_DATABASE_CHOOSE_NAME=true
SS_DATABASE_CLASS='MySQLDatabase'
SS_DATABASE_USERNAME='db'
SS_DATABASE_PASSWORD='db'
SS_DATABASE_SERVER='db'
SS_DATABASE_PORT='3306'

SS_ERROR_LOG='silverstripe.log'

GHOSTSCRIPT_PATH='/usr/bin/gs'

# Maps key from: 
# https://console.cloud.google.com/apis/library
# APP_GOOGLE_MAPS_KEY=''
# reCAPTCHA key from: https://www.google.com/recaptcha/admin/create
# SS_NOCAPTCHA_SITE_KEY=''
# SS_NOCAPTCHA_SECRET_KEY=''

SCRIPT_FILENAME=''
```
## Mailer Setup
Without setting `MAILER_DSN`, `sendmail` is used by default, typically using `SS_ADMIN_EMAIL` as sender. To use SMTP or other mailers, the `MAILER_DSN` variable should be set in the `.env`. When `MAILER_DSN` is configured, setting `SS_SEND_ALL_EMAILS_FROM` may also be appropriate. Silverstripe utilizes [Symfony Mailer](https://symfony.com/doc/current/mailer.html), which supports a variety of transport methods. With `php ./vendor/bin/sake tasks:App-Tasks-TestEmailTask --to=user@domain.tld` a Test-Mail can be sent. Be aware, Mailpit catches all emails for local development with DDEV.

## Deploy a branch/tag/revision

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
`ootstra` is licensed under [BSD-3-Clause license](LICENSE). Third-party modules have different licenses:

**PHP/Composer packages:** MIT, BSD-3-Clause, BSD-2-Clause, Apache-2.0, Artistic-1.0, CC0-1.0, GPL-2.0-only, GPL-3.0-only, GPL-3.0-or-later

**NPM packages:** MIT, BSD-2-Clause, BSD-3-Clause, ISC, Apache-2.0, MIT-0, CC0-1.0, CC-BY-4.0, GPL-3.0-or-later, 0BSD, MIT OR Apache-2.0

Check with `composer licenses` and `npx license-checker --summary` in `themes/default` for detailed licensing information. Be aware of the licenses of suggested VSCode plugins. Use implies acceptance of all licenses. Note that [@fancyapps/ui](https://fancyapps.com/) is commercial software requiring a [purchased license](https://fancyapps.com/pricing/).
