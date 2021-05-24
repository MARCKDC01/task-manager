<?php
class GetDate{
    public function getDate(){
        $dateAndTime = date('m-d-Y h:i:s a', time());  
        return $dateAndTime;
    }
}