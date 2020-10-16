<?php

namespace Deployer;

use Deployer\Task\Context;
use RuntimeException;

// Tasks
desc('Populate .env file');
task('silverstripe:create_dotenv', function () {
    $envPath = "{{deploy_path}}/shared/.env";
    if (test("[ -f {$envPath} ]")) {
        return;
    }

    $stage = Context::get()->getHost()->getConfig()->get('stage');
    $errorEmail = ask('Please enter error E-Mail', '');
    $dbServer = ask('Please enter the database server', 'localhost');
    $dbUser = ask('Please enter the database username', DEP_SERVER_USER . '_' . $stage);
    $dbName = ask('Please enter the database name', DEP_SERVER_USER . '_' . substr($stage, 0, 8));
    $dbPass = str_replace("'", "\\'", askHiddenResponse('Please enter the database password'));
    $type = in_array($stage, ['test', 'stage', 'staging']) ? 'test' : 'live';
    $CmsDefaultUser = ask('Please enter a CMS default username', 'admin');
    $CmsDefaultPass = str_replace("'", "\\'", askHiddenResponse('Please enter the CMS password'));

    $contents = <<<ENV
SS_DATABASE_CLASS='MySQLDatabase'
SS_DATABASE_USERNAME='{$dbUser}'
SS_DATABASE_PASSWORD='{$dbPass}'
SS_DATABASE_SERVER='{$dbServer}'
SS_DATABASE_NAME='{$dbName}'
SS_ENVIRONMENT_TYPE='{$type}'
SS_DEFAULT_ADMIN_USERNAME='{$CmsDefaultUser}'
SS_DEFAULT_ADMIN_PASSWORD='{$CmsDefaultPass}'
SS_ERROR_EMAIL='{$errorEmail}'

ENV;

    $command = <<<BASH
cat >{$envPath} <<EOL
$contents
EOL
BASH;

    run("$command");
})->setPrivate();


desc('install composer & sspak in ~/bin');
task('silverstripe:installtools', function () {
    $hasSspak = run("if [ -e ~/bin/sspak ]; then echo 'true'; fi");
    if ('true' != $hasSspak) {
        run('curl -sS https://silverstripe.github.io/sspak/install | php -- ~/bin');
    }
    $hasComposer = run("if [ -e ~/bin/composer.phar ]; then echo 'true'; fi");
    if ('true' != $hasComposer) {
        // run('curl https://getcomposer.org/composer.phar --create-dirs -o ~/bin/composer.phar');
        // run('curl https://getcomposer.org/composer-stable.phar --create-dirs -o ~/bin/composer.phar');
        run('curl https://getcomposer.org/composer-1.phar --create-dirs -o ~/bin/composer.phar');
        run('chmod +x ~/bin/composer.phar');
    }
});


// copy paste from "deployer/recipe/deploy/vendors.php" but with php/bin
// {{bin/composer}} should include {{php/bin}} but doesn't if you set both separytely
desc('Installing vendors');
task('deploy:vendors', function () {
    if (!commandExist('unzip')) {
        writeln('<comment>To speed up composer installation setup "unzip" command with PHP zip extension https://goo.gl/sxzFcD</comment>');
    }
    run('cd {{release_path}} && {{bin/php}} {{bin/composer}} {{composer_options}}');
});


desc('Run composer vendor-expose');
task('silverstripe:vendor_expose', function () {
    run('cd {{release_path}} && {{bin/composer}} vendor-expose');
});


desc('Create silverstripe-cache directory');
task('silverstripe:create_cache_dir', function () {
    run("cd {{release_path}} && if [ ! -d silverstripe-cache ]; then mkdir silverstripe-cache; fi");
})->setPrivate();


// Reset php process on lightspeed server (symlink-caching)
desc('Run pkill to reset php process on cyon server');
task('pkill', function () {
    try {
        run('pkill lsphp');
    } catch (\Exception $ex) {
        writeln($ex->getMessage());
    }
});


desc('Run dev/build');
task('silverstripe:dev_build', function () {
    run('cd {{release_path}} && {{bin/php}} ./vendor/silverstripe/framework/cli-script.php dev/build flush');
    // run("php {{release_path}}/vendor/bin/sake dev/build flush");
});


desc('Create directory for sspak dumps');
task('silverstripe:create_dump_dir', function () {
    run("cd {{deploy_path}} && if [ ! -d dumps ]; then mkdir dumps; fi");
})->setPrivate();


desc('Upload assets');
task('silverstripe:upload_assets', function () {
    $filename = get('application') . '-assets-' . date('Y-m-d-H-i-s') . '.sspak';
    $local = sys_get_temp_dir() . '/' . $filename;

    // Dump assets from local copy and upload
    runLocally("./vendor/bin/sspak save --assets . $local");
    upload($local, "{{deploy_path}}/dumps/");

    // Deploy assets
    run("cd {{release_path}} && ~/bin/sspak load --assets {{deploy_path}}/dumps/{$filename}");

    // Tidy up
    runLocally("rm $local");
    run("rm {{deploy_path}}/dumps/{$filename}");
});
before('silverstripe:upload_assets', 'silverstripe:create_dump_dir');
after('silverstripe:upload_assets', 'deploy:writable');


desc('Upload database');
task('silverstripe:upload_database', function () {
    $filename = get('application') . '-db-' . date('Y-m-d-H-i-s') . '.sspak';
    $local = sys_get_temp_dir() . '/' . $filename;

    // Dump database from local copy and upload
    runLocally("./vendor/bin/sspak save --db . $local");
    upload($local, "{{deploy_path}}/dumps/");

    // Deploy database
    run("cd {{release_path}} && ~/bin/sspak load --db {{deploy_path}}/dumps/{$filename}");

    // Tidy up
    runLocally("rm $local");
    run("rm {{deploy_path}}/dumps/{$filename}");
});
before('silverstripe:upload_database', 'silverstripe:create_dump_dir');


desc('Download assets');
task('silverstripe:download_assets', function () {
    $filename = get('application') . '-assets-' . date('Y-m-d-H-i-s') . '.sspak';
    $local = sys_get_temp_dir() . '/' . $filename;

    // Dump assets from remote copy and download
    run("cd {{release_path}} && ~/bin/sspak save --assets . {{deploy_path}}/dumps/{$filename}");
    download("{{deploy_path}}/dumps/{$filename}", $local);

    // Import assets
    runLocally("./vendor/bin/sspak load --assets {$local}");

    // Tidy up
    runLocally("rm $local");
    run("rm {{deploy_path}}/dumps/{$filename}");
});
before('silverstripe:download_assets', 'silverstripe:create_dump_dir');


desc('Download database');
task('silverstripe:download_database', function () {
    $filename = get('application') . '-db-' . date('Y-m-d-H-i-s') . '.sspak';
    $local = sys_get_temp_dir() . '/' . $filename;

    // Dump database from remote copy and download
    run("cd {{release_path}} && ~/bin/sspak save --db . {{deploy_path}}/dumps/{$filename}");
    download("{{deploy_path}}/dumps/{$filename}", $local);

    // Import database
    runLocally("./vendor/bin/sspak load --db {$local}");

    // Tidy up
    runLocally("rm $local");
    run("rm {{deploy_path}}/dumps/{$filename}");
});
before('silverstripe:download_database', 'silverstripe:create_dump_dir');


desc('Creates a DB-dump in dumps-dir and delete older dumps with "auto" as prefix to to the number specified in keep_releases.');
task('silverstripe:remote_dump', function ($prefix = 'auto') {
    $stage = Context::get()->getHost()->getConfig()->get('stage');

    $releaseNo = basename(get('release_path'));

    $filename = 'auto-' . get('application') . '-' . $stage . '-' . $releaseNo . '-db-' . date('Y-m-d-H-i-s') . '.sql.gz';
    $filename = get('application') . '-' . $stage . '-' . $releaseNo . '-db-' . date('Y-m-d-H-i-s') . '.sql.gz';
    if ($prefix) {
        $filename = $prefix . '-' . $filename;
    } else {
        $filename = 'auto-' . $filename;
    }


    // delete older dumps
    run('rm -f $(ls -1t {{deploy_path}}/dumps/auto-' . get('application') . '-' . $stage . '* | tail -n +' . get('keep_releases') . ')');

    // Dump database remote DB
    run("cd {{release_path}} && ~/bin/sspak save --db . {{deploy_path}}/dumps/{$filename}");

    $dumpsdirsize = run('du -h {{deploy_path}}/dumps');
    writeln('dumps directory: ' . $dumpsdirsize);
});
before('silverstripe:remote_dump', 'silverstripe:create_dump_dir');
