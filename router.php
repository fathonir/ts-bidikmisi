<?php

/**
 * CodeIgniter Router Script
 * @author Paul Irwin <https://gist.github.com/paulirwin>
 * @see https://gist.githubusercontent.com/paulirwin/d08dd528f2068053a11bd53d4629c8d8/raw/012fbcf451c325933d7465b4ec9e4a49139ca7d6/routing.php
 */

if (file_exists(__DIR__ . '/' . $_SERVER['REQUEST_URI'])) {
    return false; // serve the requested resource as-is.
} else {
    // this is the important part!
    $_SERVER['SCRIPT_NAME'] = '/index.php';
    
    include_once (__DIR__ . '/index.php');
}