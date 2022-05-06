<?php

// The application/site name - also used as the directory name (unless DEP_DEPLOY_PATH is set)
define('DEP_APPLICATION', 'APPLICATION');

// user
define('DEP_SERVER_USER', 'USER');

// IP
define('DEP_SERVER', 'IP.IP.IP.IP');

// PHP Version/Path
define('DEP_PHP_PATH', '/usr/local/bin/php80');

// PHP TIMEZONE
define('DEP_TIMEZONE', 'Europe/Zurich');

// The repository URL for this project
if (!defined('DEP_REPOSITORY')) {
    // define('DEP_REPOSITORY', 'git@bitbucket.org:YOURORG/' . DEP_APPLICATION . '.git');
    define('DEP_REPOSITORY', 'git@github.com:YOURORG/' . DEP_APPLICATION . '.git');
}


// The live deploy path - optional, defaults to /home/{{user}}/public_html/0live
if (!defined('DEP_DEPLOY_PATH')) {
    define('DEP_DEPLOY_PATH', '/home/' . DEP_SERVER_USER . '/public_html/0live');
}

// The stage deploy path - optional, detauls to /home/{{user}}/public_html/0stage
if (!defined('DEP_DEPLOY_STAGE_PATH')) {
    define('DEP_DEPLOY_STAGE_PATH', '/home/' . DEP_SERVER_USER . '/public_html/0stage');
}
