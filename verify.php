<?php 
session_start();
require 'config.php';

try {
    $captchaId = $_SESSION['captcha_id'];
    $timeout = 5;
    do {
        $info = @file_get_contents($outApi . '?key=' . $API . '&action=get&id=' . $captchaId.'&json=1');
        if ($info == 'CAPCHA_NOT_READY'){
            sleep($timeout);
        }
    } while ($info == 'CAPCHA_NOT_READY');
    $userInput = $_POST['captcha_text'];
    $info = json_decode($info);
    if($info->request == strtolower($userInput)) {
        $_SESSION['auth'] = true;
        echo json_encode([
            'verify' => true
        ]);
    } else {
        echo json_encode([
            'verify' => false
        ]);
    }

} catch (Exception $ex) {
    
    echo json_encode([
        'verify' => false
    ]);
}
exit();