<?php

add_action('view', function ($data) {
    //dump('this is a action in hook basic-auth');
});

add_action('controller', function ($data) {
    //dump('this is a controller in hook basic-auth');
});