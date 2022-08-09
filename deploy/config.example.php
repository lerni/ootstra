<?php

// application/site name - repo name
define('DEP_APPLICATION', 'APPLICATION');

// user
define('DEP_SERVER_USER', 'USER');

// IP
define('DEP_SERVER', 'IP.IP.IP.IP');

// WEBDIR - just use if it fits to suggested DEP_DEPLOY_PATH & DEP_DEPLOY_TEST_PATH
define('DEP_WEBDIR', 'public_html');

// PHP Version/Path
define('DEP_PHP_PATH', '/usr/local/bin/php74');

// PHP TIMEZONE
define('DEP_TIMEZONE', 'Europe/Zurich');

// The repository URL for this project
if (!defined('DEP_REPOSITORY')) {
    // define('DEP_REPOSITORY', 'git@bitbucket.org:YOURORG/' . DEP_APPLICATION . '.git');
    define('DEP_REPOSITORY', 'git@github.com:YOURORG/' . DEP_APPLICATION . '.git');
}

// The live deploy path - optional, defaults to /home/' . DEP_SERVER_USER . '/' . DEP_WEBDIR . '/0live
if (!defined('DEP_DEPLOY_LIVE_PATH')) {
    define('DEP_DEPLOY_LIVE_PATH', '/home/' . DEP_SERVER_USER . '/' . DEP_WEBDIR . '/0live');
}

// The stage deploy path - optional, defaults to /home/{{user}}/' . DEP_WEBDIR . '/0test
if (!defined('DEP_DEPLOY_TEST_PATH')) {
    define('DEP_DEPLOY_TEST_PATH', '/home/' . DEP_SERVER_USER . '/' . DEP_WEBDIR . '/0test');
}
