<?php
header('Content-Type: application/json');

$aResult = array();

if (!isset($_POST['functionname'])) {
    $aResult['error'] = 'No function name!';
}

if (!isset($_POST['arguments'])) {
    $aResult['error'] = 'No function arguments!';
}

if (!isset($aResult['error'])) {

    switch ($_POST['functionname']) {
        case 'encrypt':
            if (!is_array($_POST['arguments']) || (count($_POST['arguments']) < 2)) {
                $aResult['error'] = 'Error in arguments!';
            } else {
                $aResult['result'] = encrypt($_POST['arguments'][0], $_POST['arguments'][1]);
            }
            break;

        case 'decrypt':
            if (!is_array($_POST['arguments']) || (count($_POST['arguments']) < 2)) {
                $aResult['error'] = 'Error in arguments!';
            } else {
                $aResult['result'] = decrypt($_POST['arguments'][0], $_POST['arguments'][1]);
            }
            break;

        default:
            $aResult['error'] = 'Not found function ' . $_POST['functionname'] . '!';
            break;
    }
}


echo json_encode($aResult);

function encrypt($data, $encryption_key)
{

    $simple = $data . "\n";
    $options = 0;
    // Non-NULL Initialization Vector for encryption
    $encryption_iv = '1234567891011121';
    // Store the cipher method
    $ciphering = "AES-128-CTR";

    // Use openssl_encrypt() function to encrypt the data
    $encryption = openssl_encrypt($simple, $ciphering, $encryption_key, $options, $encryption_iv);
    $encoded_encryption = base64_encode($encryption);
    //echo '<script>console.log("Data: {$data} and Encryption key : {$encryption_key}"); </script>';
    return $encoded_encryption;
}


function decrypt($data, $encryption_key)
{
    // Non-NULL Initialization Vector for decryption
    $decryption_iv = '1234567891011121';
    // Store the cipher method
    $ciphering = "AES-128-CTR";
    $options = 0;

    $encryptedData = base64_decode($data);
    // Use openssl_decrypt() function to decrypt the data
    $decryption = openssl_decrypt($encryptedData, $ciphering, $encryption_key, $options, $decryption_iv);
    //echo '<script>console.log("Data: {$data} and Encryption key : {$encryption_key}"); </script>';
    return $decryption;
}
?>