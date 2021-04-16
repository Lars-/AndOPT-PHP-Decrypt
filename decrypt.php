<?php
// Change these values
$filename = __DIR__ . '/otp.json.aes';
$password = 'xxx';

//Don't change anything below this line
$data = file_get_contents($filename);

$iterations = substr($data, 0, 4);
$iterations = array_values(unpack('N', $iterations))[0];

$salt       = substr($data, 4, 12);
$data       = substr($data, 16);
$pbkdf2_key = hash_pbkdf2("sha1", $password, $salt, $iterations, 32, true);

$iv        = substr($data, 0, 12);
$crypttext = substr($data, 12, -16);
$tag       = substr($data, -16);

$decrypted = openssl_decrypt($crypttext, 'aes-256-gcm', $pbkdf2_key, OPENSSL_RAW_DATA, $iv, $tag);

echo $decrypted;