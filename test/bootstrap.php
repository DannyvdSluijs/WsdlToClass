<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @author dannyvandersluijs
 */
if (PHP_SAPI !== 'cli') {
    echo 'Warning: Composer should be invoked via the CLI version of PHP, not the '.PHP_SAPI.' SAPI'.PHP_EOL;
}

/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));

if (!$loader = include 'vendor/autoload.php') {
    die('You must set up the project dependencies.');
}
