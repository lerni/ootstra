<?php

namespace Deployer;

use Symfony\Component\Console\Input\InputOption;

require 'recipe/common.php';
require 'deploy/config.php';
require 'deploy/recipe/silverstripe.php';

// Server user
set('user', function () {
    if (!defined('DEP_SERVER_USER')) {
        writeln("<error>Please define DEP_SERVER_USER in deploy/config.php</error>");
        exit;
    }

    return DEP_SERVER_USER;
});

// Server address/ip
set('hostname', function () {
    if (!defined('DEP_SERVER')) {
        writeln("<error>Please define DEP_SERVER in deploy/config.php</error>");
        exit;
    }

    return DEP_SERVER;
});

// Project name
set('application', function () {
    if (!defined('DEP_APPLICATION')) {
        writeln("<error>Please define DEP_APPLICATION in deploy/config.php</error>");
        exit;
    }

    return DEP_APPLICATION;
});

// Project repository
set('repository', function () {
    if (!defined('DEP_REPOSITORY')) {
        writeln("<error>Please define DEP_REPOSITORY in deploy/config.php</error>");
        exit;
    }

    return DEP_REPOSITORY;
});

// Server PHP-Version
set('bin/php', function () {
    if (!defined('DEP_PHP_PATH')) {
        writeln("<error>Please define DEP_PHP_PATH in deploy/config.php</error>");
        exit;
    }
    return DEP_PHP_PATH;
});

// TZ for relevant deployment timestamps
set('timezone', function () {
    if (!defined('DEP_TIMEZONE')) {
        writeln("<error>Please define DEP_TIMEZONE in deploy/config.php</error>");
        exit;
    }
    return DEP_TIMEZONE;
});

// Number of releases to keep
set('keep_releases', 10);

// [Optional] Allocate tty for git clone. Default value is false
set('git_tty', true);

// Shared files/dirs between deploys
set('shared_files', [
    '.env',
    'silverstripe.log'
]);
set('shared_dirs', [
    'public/assets'
]);

// Writable dirs by web server
set('writable_dirs', [
    'public/assets',
    'silverstripe-cache'
]);
set('allow_anonymous_stats', false);

// Hosts
set('default_stage', 'stage');

set('bin/composer', '~/bin/composer.phar');
set('composer_options', 'install --no-dev --verbose --prefer-dist --optimize-autoloader --no-interaction');
set('http_user', DEP_SERVER_USER);

// Production aliases
foreach (['production', 'prod', 'live'] as $alias) {
    host($alias)
        ->stage($alias)
        ->hostname(DEP_SERVER)
        ->user(DEP_SERVER_USER)
        ->set('deploy_path', function () {
            if (defined('DEP_DEPLOY_PATH')) {
                return DEP_DEPLOY_PATH;
            }
            return '/home/{{user}}/public_html/0live';
        });
}

// Staging aliases
foreach (['staging', 'stage', 'test'] as $alias) {
    host($alias)
        ->stage($alias)
        ->hostname(DEP_SERVER)
        ->user(DEP_SERVER_USER)
        ->set('deploy_path', function () {
            if (defined('DEP_DEPLOY_STAGE_PATH')) {
                return DEP_DEPLOY_STAGE_PATH;
            }
            return '/home/{{user}}/public_html/0stage';
        });
}

desc('Deploy your project');
task('deploy', function () {
    invoke('deploy:info');
    invoke('deploy:prepare');
    invoke('silverstripe:installtools');
    invoke('deploy:lock');
    invoke('deploy:release');
    invoke('deploy:update_code');
    invoke('silverstripe:create_dotenv');
    invoke('silverstripe:create_cache_dir');
    invoke('deploy:shared');
    //    invoke('deploy:writable');
    invoke('deploy:vendors');
    invoke('silverstripe:vendor_expose');
    invoke('silverstripe:remote_dump');
    invoke('silverstripe:dev_build');
    invoke('deploy:clear_paths');
    invoke('deploy:symlink');
    invoke('pkill');
    invoke('deploy:unlock');
    invoke('cleanup');
    invoke('success');
});

// [Optional] If deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');
