<?php 
session_start();
require 'config.php';
unset($_SESSION['auth']);
include_once "TextToImage.php";

function random_strings($length_of_string)
{

    // String of all alphanumeric character
    $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

    // Shuffle the $str_result and returns substring
    // of specified length
    return substr(str_shuffle($str_result), 0, $length_of_string);
}

$text = random_strings(6);
$captchaImg = $text.".png";
$img = new TextToImage;
$img->createImage($text);
$img->saveAsPng($text,'images/');

try {
    $headers = array("Content-Type:multipart/form-data");
    $file = __DIR__ . DIRECTORY_SEPARATOR . "images/" . $captchaImg;
    $cf = new CURLFile($file);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $inApi);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, [
        "file" => $cf,
        "method" => 'post',
        'key' => $API,
        'json' => 1
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);

    $response = json_decode($result);
    $_SESSION['captcha_id'] = $response->request;
    
    echo json_encode([
        'error' => false,
        'image' => $text.".png"
    ]);

} catch (Exception $ex) {
    echo json_encode([
        'error' => $ex->getMessage(),
        'image' => false
    ]);
}

exit();