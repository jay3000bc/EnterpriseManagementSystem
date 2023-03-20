<?php

    require_once 'simple_html_dom.php';

    function scrap($url){

       // $url="https://assamtribune.com/assam"; 
        $ch = curl_init(); 
        curl_setopt ($ch, CURLOPT_URL, $url); 
        curl_setopt ($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT,10);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
        
        $result = curl_exec ($ch); 
        //echo $result;  
        curl_close($ch);
        
        $oDom = new simple_html_dom();
        
        $result = $oDom->load($result);

        return $result;

    }


?>