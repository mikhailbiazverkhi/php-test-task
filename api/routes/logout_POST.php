<?php

Flight::route('POST /logout', function () {
    session_unset();
    session_destroy();

    Flight::json(['status' => 'logged out']);
});