<?php

define('MY_OK', 1 << 0);
define('MY_NO', 1 << 1);
define('MY_HM', 1 << 2);

$set = MY_OK | MY_HM | MY_NO;

if ($set & MY_OK) {
    echo 'ok' . PHP_EOL;
}

if ($set & MY_NO) {
    echo 'no' . PHP_EOL;
}

if ($set & MY_HM) {
    echo 'Hm...' . PHP_EOL;
}
