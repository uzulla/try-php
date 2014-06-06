<?php
namespace Pph;
use \Pph\Error\EvalError;
class EvalResult
{
    /** @var string */
    protected $status = null; // ok or ng
    /** @var \Pph\Error\EvalError */
    protected $error = null;
    /** @var string */
    protected $output = null;

    public function setStatus($status) {$this->status = $status;}
    public function getStatus() {return $this->status;}
    public function setError($error) {$this->error = $error;}
    public function getError() {return $this->error;}
    public function setOutput($output) {$this->output = $output;}
    public function getOutput() {return $this->output;}

    public function buildResponseHash(){
        $res = [];
        $res['status'] = $this->getStatus();
        $res['error'] = [
            'line'=>$this->error->getRawLine(),
            'message'=>$this->error->getMessage(),
            'more_message'=>$this->error->getMoreMessage()
        ];
        $res['output'] = $this->getOutput();
        return $res;
    }

    public function instantSetError(\Exception $e, $moreMessage){
        $this->error = EvalError::getInstant($e, $moreMessage);
        $this->setStatus('ng');
    }
}