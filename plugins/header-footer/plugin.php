<?php
add_action('controller', function ($data) {
    dump($_POST);
});

add_action('before_view', function ($data) {
    echo '<header style="text-align: center; background-color: mediumvioletred; margin: 0; padding: 10px; color: white">';
    echo '<a href="/" style="color: white;">Home</a>';
    echo ' | <a href="/about" style="color: white;">About us</a>';
    echo ' | <a href="/contact" style="color: white;">Contact us</a>';
    echo '</header>';
});

add_action('view', function ($data) {
    echo '<form action="/login" method="post" style="text-align: center; margin: 50px auto; max-width: 400px">';
    echo '<h4>Login</h4>';
    echo '<input type="text" name="email" placeholder="Email" style="padding: 5px; margin: 5px; width: 200px;">';
    echo '<input type="password" name="password" placeholder="Password" style="padding: 5px; margin: 5px; width: 200px;">';
    echo '<button type="submit" style="padding: 5px; margin: 5px; width: 200px;">Login</button>';
    echo '</form>';
});

add_action('after_view', function ($data) {
    echo '<header style="text-align: center; background-color: mediumvioletred; margin: 0; padding: 10px; color: white;">';
    echo 'Copyright &copy; ' . date('Y');
    echo '</header>';
});
