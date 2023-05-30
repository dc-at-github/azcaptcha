<?php 
session_start();
require 'config.php';

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
    echo "<pre>";
    print_r($response);
    $_SESSION['captcha_id'] = $response->request;
    die;
} catch (Exception $ex) {
    echo $ex->getMessage();
}

die;
?>