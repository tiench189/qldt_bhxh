<?php
namespace App;

class MoodleRest
{
    const METHOD_GET = "GET";
    const METHOD_POST = "POST";
    const LMS_SERVICE_URL = "http://hoctap.vn/webservice/rest/server.php?wstoken=4a4ff68f618b715f951ec5c7ee49b0f2&wsfunction={wsfunction}&moodlewsrestformat=json";

    public static function call($method, $wsfunction = null, $params = null, $url = null)
    {
        if($url == null){
            $url = MoodleRest::LMS_SERVICE_URL;
        }
        if($wsfunction != null) $url = str_replace(array('{wsfunction}'),array($wsfunction), $url);
        $postData = '';
        if($params != null){
            foreach($params as $k => $v) $postData .= $k . '='.$v.'&';
            $postData = rtrim($postData, '&');
        }
        $ch = curl_init();
        if($method == MoodleRest::METHOD_GET){
            if(strlen($postData)>0) $url .= "&$postData";
        }
        else{
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_POST, count($postData));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        }
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //  curl_setopt($ch,CURLOPT_HEADER, false);
        $output = curl_exec($ch);
        curl_close($ch);
        //echo $url;die;
        return $output;
    }

}