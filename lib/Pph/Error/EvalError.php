<?php
namespace Pph\Error;
class EvalError extends \Exception {

    static public function getInstant(\Exception $e, $moreMessage){
        return new self($e->getMessage(), $e->getCode(), $moreMessage, $e);
    }

    public function __construct($message = '', $code = 0, $moreMessage = null, \Exception $previous = null){
        error_log($previous);
        $_e = $previous;
        while($_e){
            error_log($_e);
            if(get_class($_e)=="PHPParser_Error"){
                $this->rawLine = $_e->getRawLine();
            }
            if(get_class($_e)=='PHPSandbox\Error'){
                $trace = $_e->getTrace();
                $wtf = $trace[2]["args"][0]; // wtf
                if(method_exists($wtf, '__get')){
                    $this->rawLine = $wtf->__get("name")->getAttribute("startLine");
                }
            }
            $_e = $_e->getPrevious();
        }

        $this->moreMessage = $moreMessage;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @var mixed Error of line
     */
    protected $rawLine;
    protected $moreMessage;

    public function getRawLine(){
        return $this->rawLine;
    }

    public function getMoreMessage(){
        return $this->moreMessage;
    }

}