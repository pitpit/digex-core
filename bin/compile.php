#!/usr/bin/env php
<?php

require_once __DIR__.'/../autoload.php';

use Digex\Compiler;

$compiler = new Compiler();
$compiler->compile(__DIR__.'/../../digex.phar');