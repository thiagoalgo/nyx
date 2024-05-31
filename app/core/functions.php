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

function get_plugin_folders(): array
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

function load_plugins($plugin_folders): bool
{
    global $APP;
    $loaded = false;

    foreach ($plugin_folders as $folder) {
        $file = 'plugins' . DS . $folder . DS . 'config.json';
        if (file_exists($file)) {
            $json = json_decode(file_get_contents($file));
            if (is_object($json) && isset($json->id)) {
                if (!empty($json->active)) {
                    $file = 'plugins' . DS . $folder . DS . 'plugin.php';
                    if (file_exists($file) && valid_route($json)) {
                        $json->index_file = $file;
                        $json->path = 'plugins' . DS . $folder . DS;
                        $json->http_path = ROOT . DS . $json->path;
                        $APP['plugins'][] = $json;
                    }
                }
            }
        }
    }

    if (!empty($APP['plugins'])) {
        foreach ($APP['plugins'] as $json) {
            if (file_exists($json->index_file)) {
                require_once $json->index_file;
                $loaded = true;
            }
        }
    }

    return $loaded;
}

function valid_route(object $json): bool
{
    global $APP;

    if (!empty($json->routes->off) && is_array($json->routes->off)) {
        if (in_array(page(), $json->routes->off)) {
            return false;
        }
    }

    if (!empty($json->routes->on) && is_array($json->routes->on)) {
        if ($json->routes->on[0] === 'all') {
            return true;
        }

        if (in_array(page(), $json->routes->on)) {
            return true;
        }
    }

    return false;
}

function add_action(string $hook, Closure $func, $priority = 10): bool
{
    global $ACTIONS;

    while (!empty($ACTIONS[$hook][$priority])) {
        if ($priority >= 10) {
            $priority++;
        } else {
            $priority--;
        }
    }

    $ACTIONS[$hook][$priority] = $func;

    return true;
}

function do_action(string $hook, array $data = []): void
{
    global $ACTIONS;

    if (!empty($ACTIONS[$hook])) {
        ksort($ACTIONS[$hook]);
        foreach ($ACTIONS[$hook] as $func) {
            $func($data);
        }
    }
}

function page()
{
    return URL(0);
}

function redirect(string $url): void
{
    header('Location: ' . ROOT . '/' . $url);
    die;
}

function dump(): void
{

    echo '<pre style="margin: 0"><div style="background-color: steelblue; padding: 10px 10px; margin-top: 1px; color: white">';
    foreach (func_get_args() as $arg) {
        print_r($arg);
    }
    echo '</div></pre>';
}

function dd()
{
    dump(...func_get_args());
    die;
}