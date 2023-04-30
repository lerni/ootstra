<?php

namespace Deployer;

use Symfony\Component\Console\Input\InputOption;
require 'recipe/common.php';
require 'deploy/config.php';
require 'deploy/recipe/silverstripe.php';

// Server address/ip
set('alias', function () {
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
set('keep_releases', 5);

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
    'public/_graphql',
    'silverstripe-cache',
    'graphql-generated/'
]);

set('allow_anonymous_stats', false);

// also set specified php version for composer
// https://stackoverflow.com/a/65850204/1938738
set('bin/composer', function () {
    return '{{bin/php}} ~/bin/composer.phar';
});

// set('composer_options', '--no-dev --verbose --prefer-dist --optimize-autoloader --no-interaction');
set('http_user', DEP_SERVER_USER);
set('default_timeout', 6000); // default is 300 - sspak sometimes needs more. With this we at least see the truncated (size-limit) error :(

// Server user
set('remote_user', function () {
    if (!defined('DEP_SERVER_USER')) {
        writeln("<error>Please define DEP_SERVER_USER in deploy/config.php</error>");
        exit;
    }

    return DEP_SERVER_USER;
});

host('live')
    ->set('labels', ['stage' => 'live'])
    ->set('hostname', DEP_SERVER)
    ->set('remote_user', DEP_SERVER_USER)
    // ->set('branch', 'live')
    ->set('git_ssh_command', 'ssh') // https://github.com/deployphp/deployer/issues/2908#issuecomment-1022748724 - we mount ~/.ssh/known_hosts
    ->set('writable_mode', 'chmod')
    ->set('deploy_path', function () {
        if (defined('DEP_DEPLOY_LIVE_PATH')) {
            return DEP_DEPLOY_LIVE_PATH;
        }
        return '/home/{{remote_user}}/public_html/0live';
    });

host('test')
    ->set('labels', ['stage' => 'test'])
    ->set('hostname', DEP_SERVER)
    ->set('remote_user', DEP_SERVER_USER)
    // ->set('branch', 'test')
    ->set('git_ssh_command', 'ssh') // https://github.com/deployphp/deployer/issues/2908#issuecomment-1022748724 - we mount ~/.ssh/known_hosts
    ->set('writable_mode', 'chmod')
    ->set('deploy_path', function () {
        if (defined('DEP_DEPLOY_TEST_PATH')) {
            return DEP_DEPLOY_TEST_PATH;
        }
        return '/home/{{user}}/public_html/0test';
    });

Deployer::get()->tasks->remove('deploy');
desc('Deploy your project');
task('deploy', function () {
    invoke('deploy:prepare');
    invoke('silverstripe:installtools');
    // invoke('deploy:release');
    invoke('deploy:update_code');
    invoke('silverstripe:create_dotenv');
    invoke('deploy:shared');
    invoke('deploy:writable');
    invoke('deploy:vendors');
    invoke('silverstripe:vendor_expose');
    invoke('silverstripe:remote_dump');
    invoke('silverstripe:htaccessperstage');
    invoke('silverstripe:dev_build');
    invoke('deploy:clear_paths');
    invoke('deploy:symlink');
    invoke('pkill');
    invoke('deploy:unlock');
    invoke('deploy:cleanup');
    invoke('deploy:success');
});

// [Optional] If deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');
