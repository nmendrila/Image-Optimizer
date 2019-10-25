<?php

require_once('vendor/autoload.php');

$config = include('config/config.php');

$optimizer = new ImageOptimizer($config['api-key']);
$optimizer->processImages();