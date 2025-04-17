<?php

namespace Deployer;

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

// Remote composer path
set('bin/composer', function () {
    if (!defined('DEP_COMPOSER_PATH')) {
        writeln("<error>Please define DEP_COMPOSER_PATH in deploy/config.php</error>");
        exit;
    }
    // also set specified php version for composer
    // https://stackoverflow.com/a/65850204/1938738
    return '{{bin/php}} ' . DEP_COMPOSER_PATH;
});

// PHP process name
set('php_process', function () {
    if (!defined('DEP_PHP_PROCESS')) {
        return 'lsphp';
    }
    return DEP_PHP_PROCESS;
});

// Server user
set('remote_user', function () {
    if (!defined('DEP_SERVER_USER')) {
        writeln("<error>Please define DEP_SERVER_USER in deploy/config.php</error>");
        exit;
    }
    return DEP_SERVER_USER;
});

// Number of releases to keep
set('keep_releases', 3);

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

set('clear_paths', [
    '.ddev/',
    '.dockerignore',
    '.editorconfig',
    '.gitignore',
    '.vscode/',
    'deploy.php',
    'deploy/'
]);

// prevent sending usage statistics
set('allow_anonymous_stats', false);

// set('composer_options', '--no-dev --verbose --prefer-dist --optimize-autoloader --no-interaction');
set('http_user', DEP_SERVER_USER);
set('default_timeout', 600); // default is 300 - asset transfer can take some more time

host('live')
    ->set('labels', ['stage' => 'live'])
    ->set('hostname', DEP_SERVER)
    ->set('remote_user', DEP_SERVER_USER)
    ->set('port', DEP_SERVER_PORT)
    // ->set('branch', 'live')
    ->set('git_ssh_command', 'ssh') // https://github.com/deployphp/deployer/issues/2908#issuecomment-1022748724 - we mount ~/.ssh/known_hosts
    ->set('writable_mode', 'chmod')
    ->set('deploy_path', function () {
        if (defined('DEP_DEPLOY_LIVE_PATH')) {
            return DEP_DEPLOY_LIVE_PATH;
        }
    });

host('test')
    ->set('labels', ['stage' => 'test'])
    ->set('hostname', DEP_SERVER)
    ->set('remote_user', DEP_SERVER_USER)
    ->set('port', DEP_SERVER_PORT)
    // ->set('branch', 'test')
    ->set('git_ssh_command', 'ssh') // https://github.com/deployphp/deployer/issues/2908#issuecomment-1022748724 - we mount ~/.ssh/known_hosts
    ->set('writable_mode', 'chmod')
    ->set('deploy_path', function () {
        if (defined('DEP_DEPLOY_TEST_PATH')) {
            return DEP_DEPLOY_TEST_PATH;
        }
    });

Deployer::get()->tasks->remove('deploy');
desc('Deploy project');
task('deploy', function () {
    $stage = get('labels')['stage'] ?? '';
    if (in_array($stage, ['live'])) {
        if (!askConfirmation("Are you sure you want to deploy to {$stage}?")) {
            echo "🚀\n";
            exit;
        }
    }

    invoke('silverstripe:installtools');
    invoke('silverstripe:create_dotenv');
    invoke('deploy:prepare');
    invoke('deploy:vendors');
    invoke('silverstripe:vendor_expose');
    invoke('silverstripe:remote_dump');
    invoke('silverstripe:htaccessperstage');
    invoke('silverstripe:dev_build');
    invoke('deploy:clear_paths');
    invoke('deploy:symlink');
    invoke('silverstripe:set_script_filename');
    invoke('pkill');
    invoke('deploy:unlock');
    invoke('deploy:cleanup');
    invoke('deploy:success');
});

// [Optional] If deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');
