<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();
?>

<div id="modal" class="modal">
    <span id="modal-close" class="modal-close">&times;</span>
    <img id="modal-content" class="modal-content">
    <div id="modal-caption" class="modal-caption"></div>
</div>
