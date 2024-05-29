<?php

function split_url($url)
{
    return explode('/', trim($url, '/'));
}

function URL($key = '')
{
    global $APP;
    if (is_numeric($key) || !empty($key)) {
        if (!empty($APP['URL'][$key])) {
            return $APP['URL'][$key];
        }
    } else {
        return $APP['URL'];
    }

    return '';
}

function get_plugin_folders()
{
    $plugin_folders = [];
    $all_folders = scandir(ROOTPATH . 'plugins');

    foreach ($all_folders as $folder) {
        if ($folder === '.' || $folder === '..') {
            continue;
        }

        if (is_dir(ROOTPATH . 'plugins' . DS . $folder)) {
            $plugin_folders[] = $folder;
        }
    }

    return $plugin_folders;
}

function load_plugins($plugin_folders)
{
    $loaded = false;

    foreach ($plugin_folders as $folder) {
        $file = 'plugins' . DS . $folder . DS . 'plugin.php';

        if (file_exists($file)) {
            require $file;
        }

        $loaded = true;
    }

    return $loaded;
}

function add_action(string $hook, mixed $func): bool
{
    global $ACTIONS;
    $ACTIONS[$hook] = $func;

    return true;
}

function do_action(string $hook, array $data = []): void
{
    global $ACTIONS;
    if (!empty($ACTIONS[$hook])) {
        $ACTIONS[$hook]($data);
    }
}

function page() {
    return URL(0);
}

function redirect(string $url): void
{
    header('Location: ' . ROOT .'/'. $url);
    die;
}

function dump(): void
{
    echo '<pre>';
    foreach (func_get_args() as $arg) {
        print_r($arg);
    }
    echo '</pre>';
}

function dd()
{
    dump(...func_get_args());
    die;
}