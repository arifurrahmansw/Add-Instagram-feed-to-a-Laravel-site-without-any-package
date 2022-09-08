<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InstagramFeedController extends Controller
{
   

    public function getInstagram(){
            $data                   = [];
        $limit                  = 4;
        $token                  = env('INSTAGRAM_ACCESS_TOKEN');
        $fields                 = "id,media_type,media_url,thumbnail_url,timestamp,permalink,caption";
        $instafeeds             = $this->getInstagramPost($fields,$token,$limit);
        return view('welcome')->withRows($instafeeds);
    }

    public function getInstagramPost($fields,$token,$limit){
            $url = "https://graph.instagram.com/me/media?fields=".$fields.'&access_token='.$token.'&limit='.$limit;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 20);
            $result = curl_exec($ch);
            curl_close($ch);
            $result_decode = json_decode($result, true);
            return $result_decode;
    }

    

}
