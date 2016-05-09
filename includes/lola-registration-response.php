<?php
class Lola_Registration_Response{
    var $resultData;
    var $status;
    var $errorMessage;
    function __construct($data,$status,$errorMessage){
        $this->resultData = $data;
        $this->status = $status;
        $this->errorMessage = $errorMessage;
    }
}?>