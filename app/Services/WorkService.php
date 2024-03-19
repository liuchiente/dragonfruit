<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;


class WorkService
{
    

    
    private $_code=-1;
    private $_isdone=-1;
    private $_messsage="";

    public function __construc($is_done){
        $this->_isdone=$is_done;
    }

    public function setCode($val){
        $this->_code=$val;
    }

    public function setMessage($str){
        $this->_messsage=$str;
    }

    public function getMessage(){
        return $this->_messsage;
    }

    public function isDone(){
        return $this->_code==$this->_isdone;
    }
}