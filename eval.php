<?php
require('vendor/autoload.php');
// TODO ban invalid UTF-8
// TODO hook(log forward
// TODO White listing
// TODO black listing
// TODO Multi-language (ja/en)
// TODO check Referrer

$code = (isset($_POST['code'])) ? $_POST['code'] : '' ;
if(mb_strlen($code)>10000){
    responseJson(400, 'コードが長すぎます','');
}

try {
    $evaler = new \Pph\Evaler();
    $res = $evaler->doEval($code);
    if($res==true){
        responseJson(
            '200',
            $evaler->getEvalResult()->getStatus(),
            $evaler->getEvalResult()->getOutput()
        );
    }else{
        // TODO このあたりのエラー文字列の組み立てどうにかしたい
        $error = $evaler->getEvalResult()->getError();
        $error_message = "エラー:";
        $error_message .= $error->getMoreMessage();
        //error_log(print_r($error,1));
        if($error->getRawLine()){
            $error_message .= "\n{$error->getRawLine()}行目で発生しました";
        }
        responseJson('200', $error_message, $evaler->getEvalResult()->getOutput());
    }
} catch (\Exception $e) {
    responseJson('500', 'uncaught exception', '');
}

// Okay.

function responseJson($status_code=200, $result=null, $output=null){
    header('Content-type: application/json; charset=UTF-8');
    header('X-Content-Type-Options: nosniff');

    $res = [
        'status'=>'ok',
        'result'=>$result,
        'output'=>$output
    ];
    if($status_code!=200){
        $res['status']='ng';
    }

    echo json_encode(
        $res,
        JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP
    );
    exit;
}