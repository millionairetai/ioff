<?php
    $params = require(__DIR__ . '/common/config/main.php');
    header("Location: /{$params['params']['defaultPackage']}/web/index.php");

