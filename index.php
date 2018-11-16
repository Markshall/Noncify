<?php
require_once('Noncify.php');

define('NONCE_KEY', 'Ff411Xzs7qfki');

$nonce1 = Noncify::generate(NONCE_KEY, 5); //generate a nonce that expires after 5 mins
var_dump(Noncify::verify($nonce1, NONCE_KEY)); // >>> true


$nonce2 = Noncify::generate(NONCE_KEY, 0.25); //generate a nonce that expires after 15 seconds
sleep(16); //timeout for 16 seconds to let the nonce expire
var_dump(Noncify::verify($nonce2, NONCE_KEY)); // >>> false