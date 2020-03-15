<?php

header('Content-type: text/plain; charset=utf-8');

// DECRYPT

$encrypted = <<<ENC
OFRSmOJWQBAuuNpQP7nXbTMqzcmfmbSynNnB8+YIeN2qAbnEtSK8B2je/RTwkJiWe19zERCHnsHpptiP2aVpoc9yykfvQYDu1GAe7taZxlW0R/F1aJvBCMH53s+cTT/Z6qfEVdJuHsnfnsBTklKkF7VZ6FKTWh9FmBg9b60Yz8IX39tqbjY1c3hQpRrX8jv7fayzXiQAOXHEpDigW3ufHheXbMYWH6Dl1sSgpjdf6hUaUt8jF9G10BAZ1yPiY2FmPDoqFIIPsqwr3Z69SXN9U7083fLzVCdaIYuX/wB5BKyEFsOd/4vXJ/Fk4Ba31V0h9+PvHQPo6PPyVDXouPSu6g==
ENC;

$privKey = openssl_pkey_get_private(file_get_contents(__DIR__ . '/crypto.pem'));
var_dump($privKey);

var_dump(openssl_private_decrypt(base64_decode(trim($encrypted)), $decrypted, $privKey));
var_dump(openssl_error_string());
var_dump($decrypted);

echo "\n\n";

// ENCRYPT

$input = "Oele boele\nbla bla!";

$pubKey = openssl_pkey_get_public(openssl_pkey_get_details($privKey)['key']);
var_dump($pubKey);
var_dump(openssl_public_encrypt($input, $encrypted, $pubKey, OPENSSL_NO_PADDING));
var_dump(openssl_error_string());
echo "\n" . base64_encode($encrypted) . "\n\n";
