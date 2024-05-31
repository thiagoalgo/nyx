<?php
add_action('controller', function ($data) {
    // dump('this is from the controller hook in home-page plugin');
});

add_action('view', function ($data) {
    echo '<div style="text-align: center">';
    echo 'This is from the view hook in home-page plugin';
    echo '</div>';
});
