<?php

add_action('controller', function ($data) {
    // dump('this is from the controller hook in basic-auth plugin');
});

add_action('view', function ($data) {
    // dump('this is from the view hook in basic-auth plugin');
});
