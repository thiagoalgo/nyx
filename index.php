<?php

session_start();

$minPHPVersion = '8.3.0';
if (version_compare(PHP_VERSION, $minPHPVersion, '<')) {
    die("You need PHP version $minPHPVersion or higher to run this application.");
}

const DS = DIRECTORY_SEPARATOR;
const ROOTPATH = __DIR__.DS;

require 'config.php';
require 'app'.DS.'core'.DS.'init.php';

DEBUG ? ini_set('display_errors', 1) : ini_set('display_errors', 0);

$ACTIONS = [];
$FILTERS = [];
$APP['URL'] = split_url($_GET['url'] ?? 'home');

$PLUGINS = get_plugin_folders();
if (!load_plugins($PLUGINS)) {
    die('No plugins were found. Please put at least one plugin in the plugins folder.');
}


$app = new \Core\App();
$app->index();