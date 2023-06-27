<?php

namespace Deployer;

use Deployer\Task\Context;
use RuntimeException;
use Symfony\Component\Console\Input\InputOption;

// Tasks
desc('Populate .env file');
task('silverstripe:create_dotenv', function () {
    $stage = get('labels')['stage'];
    run("cd {{deploy_path}} && if [ ! -d shared ]; then mkdir shared; fi");
    $envPath = "{{deploy_path}}/shared/.env";
    $hasEnvFile = run("if [ -e {{deploy_path}}/shared/.env ]; then echo 'true'; fi");
    if ($hasEnvFile) {
        return;
    }

    $errorEmail = ask('Please enter error E-Mail', '');
    $adminEmail = ask('Please enter admin E-Mail', '');
    $dbServer = ask('Please enter the database server', '127.0.0.1');
    $dbUser = ask('Please enter the database username', DEP_SERVER_USER . '_' . $stage);
    $dbName = ask('Please enter the database name', DEP_SERVER_USER . '_' . substr($stage, 0, 8));
    $dbPass = str_replace("'", "\\'", askHiddenResponse('Please enter the database password'));
    $type = in_array($stage, ['test', 'stage', 'staging']) ? 'test' : 'live';
    $cmsDefaultUser = ask('Please enter a CMS default username', 'admin');
    $cmsDefaultPass = str_replace("'", "\\'", askHiddenResponse('Please enter the CMS password'));

    $contents = <<<ENV
# Environment dev/stage/live
SS_ENVIRONMENT_TYPE='{$type}'
# SS_BASE_URL=""

SS_DEFAULT_ADMIN_USERNAME='{$cmsDefaultUser}'
SS_DEFAULT_ADMIN_PASSWORD='{$cmsDefaultPass}'

SS_ERROR_EMAIL='{$errorEmail}'
SS_ADMIN_EMAIL='{$adminEmail}'

## Database
SS_DATABASE_CLASS='MySQLDatabase'
SS_DATABASE_USERNAME='{$dbUser}'
SS_DATABASE_PASSWORD='{$dbPass}'
SS_DATABASE_SERVER='{$dbServer}'
SS_DATABASE_NAME='{$dbName}'

SS_ERROR_LOG='silverstripe.log'

GHOSTSCRIPT_PATH='/usr/bin/gs'

# SS_NOCAPTCHA_SITE_KEY=""
# SS_NOCAPTCHA_SECRET_KEY=""
# MAIL_HOST=""
# MAIL_USERNAME=""
# MAIL_PASSWORD=""
ENV;

// heredoc is a mess with this setup
// most probable .editorconfig adds some carriage return after EOL, which make it fail!
// $command = <<<BASH
// cat >{$envPath} <<EOL
// $contents
// EOL
// BASH;

    run('echo "'. $contents .'" &> '. $envPath);

});


desc('install composer & sspak in ~/bin');
task('silverstripe:installtools', function () {
    $hasComposer = run("if [ -e ~/bin/composer.phar ]; then echo 'true'; fi");
    if ('true' != $hasComposer) {
        // run('curl https://getcomposer.org/composer-1.phar --create-dirs -o ~/bin/composer.phar');
        run('curl https://getcomposer.org/composer-stable.phar --create-dirs -o ~/bin/composer.phar');
        run('chmod +x ~/bin/composer.phar');
    }
});


desc('Run composer vendor-expose');
task('silverstripe:vendor_expose', function () {
    run('cd {{release_path}} && {{bin/composer}} vendor-expose');
});


// Reset lsphp/php-fpm process on server (symlink-caching)
// todo: probable a better fix:
// https://deployer.org/docs/7.x/avoid-php-fpm-reloading
desc('Run pkill to reset php process');
task('pkill', function () {
    try {
        run('pkill lsphp');
    } catch (\Exception $ex) {
        writeln($ex->getMessage());
    }

    // set('env', [
    //     'SCRIPT_FILENAME' => '{{release_path}}'
    // ]);
});


desc('Run dev/build');
task('silverstripe:dev_build', function () {
    run('cd {{release_or_current_path}} && {{bin/php}} ./vendor/silverstripe/framework/cli-script.php dev/build flush');
    // run("php {{release_path}}/vendor/bin/sake dev/build flush");
});


task('silverstripe:htaccessperstage', function() {
    $stage = get('labels')['stage'];
	// upload htaccess, if a specific version for the current stage exist
    if(file_exists('deploy/' . $stage . '.htaccess')) {
        writeln('Overwriting .htaccess with deploy/' . $stage . '.htaccess');
        upload('deploy/' . $stage . '.htaccess', "{{release_path}}/public/.htaccess", ['delete' => true]);
    }
})->desc('upload/replace .htaccess stage specific');


desc('Running Task Hydrate the focuspoint extension image size cache');
task('silverstripe:focu_hydrate', function () {
//     run('cd {{release_path}} && {{bin/php}} ./vendor/silverstripe/framework/cli-script.php dev/tasks/HydrateFocusPointTask "flush=1"');
    run('cd {{release_path}} && ./vendor/bin/sake dev/tasks/HydrateFocusPointTask "flush=1"');
});


desc('Create directory for sspak dumps');
task('silverstripe:create_dump_dir', function () {
    run("cd {{deploy_path}} && if [ ! -d dumps ]; then mkdir dumps; fi");
});


desc('Upload assets');
task('silverstripe:upload_assets', function () {
    $stage = get('labels')['stage'];
    if (!askConfirmation("Are you sure you want to overwrite the {$stage} assets?")) {
        echo "🐔\n";
        exit;
    }
    upload('public/assets/', '{{deploy_path}}/shared/public/assets', [
        'options' => [
            "--exclude={'error-*.html','_tinymce','.htaccess','.DS_Store','._*'}",
            "--delete"
        ]
    ]);
});
// after('silverstripe:upload_assets', 'deploy:writable');


desc('Download assets');
task('silverstripe:download_assets', function () {
    download('{{deploy_path}}/shared/public/assets/', 'public/assets', [
        'options' => [
            "--exclude={'error-*.html','_tinymce','.htaccess','.DS_Store','._*'}",
            "--omit-dir-times",
            "--delete"
        ]
    ]);
});


desc('Upload database');
task('silverstripe:upload_database', function () {
    $stage = get('labels')['stage'];
    if (!askConfirmation("Are you sure you want to overwrite the {$stage} database?")) {
        echo "🐔\n";
        exit;
    }

    invoke('silverstripe:create_dump_dir');

    if (!test('[ -f {{deploy_path}}/shared/.env ]')) {
        writeln("<error>Unable to find .env file on remote server.</error>");
        exit;
    }

    $filename = 'db-' . date('Y-m-d-H-i-s') . '.gz';
    $localPath = sys_get_temp_dir() . '/' . $filename;

    // Export database
    runLocally(getExportDatabaseCommand('.env', $localPath));

    // Upload database
    upload($localPath, "{{deploy_path}}/dumps/");

    // Import database
    run(getImportDatabaseCommand('{{deploy_path}}/shared/.env', "{{deploy_path}}/dumps/{$filename}"));

    // Tidy up
    runLocally("rm {$localPath}");
    run("rm {{deploy_path}}/dumps/{$filename}");
});


desc('Download database');
task('silverstripe:download_database', function () {
    invoke('silverstripe:create_dump_dir');

    if (!test('[ -f {{deploy_path}}/shared/.env ]')) {
        writeln("<error>Unable to find .env file on remote server.</error>");
        exit;
    }

    $filename = 'db-' . date('Y-m-d-H-i-s') . '.gz';
    $localPath = sys_get_temp_dir() . '/' . $filename;

    // Export database
    run(getExportDatabaseCommand('{{deploy_path}}/shared/.env', "{{deploy_path}}/dumps/{$filename}"));

    // Download database
    download("{{deploy_path}}/dumps/{$filename}", $localPath);

    // Import database
    runLocally(getImportDatabaseCommand('.env', $localPath));

    // Tidy up
    runLocally("rm {$localPath}");
    run("rm {{deploy_path}}/dumps/{$filename}");
});

set('mysql_default_charset', 'utf8mb4');
set(
    'mysqldump_args',
    implode(' ', [
        '--no-tablespaces',
        '--skip-opt',
        '--add-drop-table',
        '--extended-insert',
        '--create-options',
        '--quick',
        '--set-charset',
        '--default-character-set={{mysql_default_charset}}'
    ])
);

set(
    'mysql_args',
    implode(' ', [
        '--default-character-set={{mysql_default_charset}}'
    ])
);


function getExportDatabaseCommand($envPath, $destination) {
    $usernameArg = '--user=$SS_DATABASE_USERNAME';
    $passwordArg = '--password=$SS_DATABASE_PASSWORD';
    $hostArg = '--host=$SS_DATABASE_SERVER';
    $databaseArg = '$SS_DATABASE_PREFIX$SS_DATABASE_NAME';

    $loadEnvCmd = "export $(grep -v '^#' {$envPath} | xargs)";

    $exportDbCmd = "mysqldump {{mysqldump_args}} {$usernameArg} {$passwordArg} {$hostArg} {$databaseArg} | gzip > {$destination}";
    return "{$loadEnvCmd} && {$exportDbCmd}";
}


function getImportDatabaseCommand($envPath, $source) {
    $usernameArg = '--user=$SS_DATABASE_USERNAME';
    $passwordArg = '--password=$SS_DATABASE_PASSWORD';
    $hostArg = '--host=$SS_DATABASE_SERVER';
    $databaseArg = '$SS_DATABASE_PREFIX$SS_DATABASE_NAME';

    $loadEnvCmd = "export $(grep -v '^#' {$envPath} | xargs)";

    $createDbArg = "--execute='create database if not exists `'{$databaseArg}'`;'";
    $createDbCmd = "mysql {{mysql_args}} {$usernameArg} {$passwordArg} {$hostArg} {$createDbArg}";

    $importDbCmd = "gunzip < {$source} | mysql {{mysql_args}} {$usernameArg} {$passwordArg} {$hostArg} {$databaseArg}";

    return "{$loadEnvCmd} && {$createDbCmd} && {$importDbCmd}";
}


desc('Creates a DB-dump in dumps-dir and delete older dumps with "auto" as prefix to to the number specified in keep_releases.');
task('silverstripe:remote_dump', function ($prefix = 'auto') {
    $stage = get('labels')['stage'];

    invoke('silverstripe:create_dump_dir');

    $releaseNo = basename(get('release_path'));
    if($releaseNo) {

        $filename = get('application') . '-' . $stage . '-' . $releaseNo . '-db-' . date('Y-m-d-H-i-s') . '.sql.gz';
        $filename = $prefix . '-' . $filename;

        // delete older dumps
        run('rm -f $(ls -1t {{deploy_path}}/dumps/auto-' . get('application') . '-' . $stage . '* | tail -n +' . get('keep_releases') . ')');

        // Dump database remote DB
        run(getExportDatabaseCommand('{{deploy_path}}/shared/.env', "{{deploy_path}}/dumps/{$filename}"));

        $dumpsdirsize = run('du -h {{deploy_path}}/dumps');
        writeln('dumps directory size: ' . $dumpsdirsize);
    }
});
before('silverstripe:remote_dump', 'silverstripe:create_dump_dir');
