<?php
namespace Pph;
class Evaler
{
    protected  $parser = null;
    protected  $sandbox = null;
    protected  $evalResult = null;

    public function getEvalResult(){ return $this->evalResult; }

    public function __construct(){
        $this->parser = new \PHPParser_Parser(new \PHPParser_Lexer);
        $this->sandbox = new \PHPSandbox\PHPSandbox;
        $this->evalResult = new EvalResult;
    }

    public function doEval($code){
        // パースエラーがあるか確認してみる
        try {
            $this->parser->parse($code);
        } catch (\PHPParser_Error $e) {
            $this->evalResult->instantSetError($e, "文法エラー");
            return false; // 終了する
        } catch (\Exception $e) { // いらないのでは
            throw $e;
        }

        // sandbox実行する
        try {
            $output = ob_end_clean(); // TODO これでいいか？
            ob_start();
            $result_or_exception = $this->sandbox->execute($code);
            if($result_or_exception instanceof \Exception){
                throw $result_or_exception;
            }
            $output = ob_get_clean();
            $this->evalResult->setOutput($output);
            $this->evalResult->setStatus('ok');
        } catch (\PHPSandbox\Error $e) {
            //TODO もっと整理する必要がある
            if ($e->getCode() === 1) { // parse error
                $this->evalResult->instantSetError($e, "文法エラー");
            } elseif ($e->getCode() < 100) { // 0-99
                $this->evalResult->instantSetError($e, "セキュリティエラー");
            } elseif ($e->getCode() < 200) { // 100-199
                $this->evalResult->instantSetError($e, "利用不可能な機能エラー");
            } elseif ($e->getCode() < 300) { // 200-299
                $this->evalResult->instantSetError($e, "利用不可能な宣言エラー");
            } elseif ($e->getCode() < 400) { // 300-399
                $this->evalResult->instantSetError($e, "ホワイトリストエラー");
            } elseif ($e->getCode() < 500) { // 400-499
                $this->evalResult->instantSetError($e, "ブラックリストリストエラー");
            } else { // 特定できないエラーだった、異常終了
                throw $e;
            }
            return false;
        } catch (\Exception $e) { // いらないのでは
            throw $e;
        }
        return true;
    }



}