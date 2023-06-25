<?php
ini_set('max_execution_time', 0);
$token       = "EAAA..."; // Token facebook
// sb=6aJkZGzQQW7Ge7tA2g4c4Cmc; datr=6aJkZJHwZ1MLZ4NCUk1HAsbt; c_user=100054399369841; dpr=1.3499999046325684; m_page_voice=100054399369841; wd=1280x530; cppo=1; usida=eyJ2ZXIiOjEsImlkIjoiQXJ3cnNrN3Axc3h1MSIsInRpbWUiOjE2ODc2MzI2Nzl9; xs=28%3ALCkjGgJk1z6sMQ%3A2%3A1684836716%3A-1%3A6389%3A%3AAcXMJdMqHbkHcUuxsmnkEuCujbFi_hpaEz-XTdHHrkMa; fr=0ucexW0dGjH22YV3P.AWVIX7rQg1pHAtNTSPo60TkPhjQ.Bklzsx.iW.AAA.0.0.Bklzsx.AWVxCTX5h8k; presence=EDvF3EtimeF1687632708EuserFA21B54399369841A2EstateFDutF0CEchF_7bCC
$cookies     = "c_user=100038..."; // Cookie facebook (từ 2023 phải có cookies mới có thể sử dụng api fb)
$limit       = 3; //Số lượng bài viết
$array_avoid = ["id_1","id2","...."]; // id bài viết trong một nhóm bạn k muốn like, mỗi group 1 giá trị
$person_avoid = ["id_1","id2","...."]; //id người

$links = "https://graph.facebook.com/me/home?order=chronological&limit=$limit&fields=id,from&access_token=$token";
curl_setopt_array($curl, array(
    CURLOPT_URL => $links,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
      'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36',
      'Cookie: '.$cookies
    ),
  ));
$reply = curl_exec($curl);
curl_close($curl);
$data  = json_decode($reply,true);
$datas = $data['data'];
foreach($datas as $each){
    $id_person = isset($each["from"]["id"]) ? $each["from"]["id"] : "";
    if(!in_array($id_person,$person_avoid)){
        $id_lay  = $each["id"];
        $split   = explode("_", $id_lay);
        $id_post = $split[0];
        if(!in_array($id_post,$array_avoid)){
            $all_type    = ["LOVE", "HAHA", "LIKE", "ANGRY", "SAD", "WOW"];//có 6 trạng thái
            $type        = $all_type[rand(0,5)]; //bạn có thể để random từ 0 -> 5 hoặc để số thay rand()
            $links = "https://graph.facebook.com/$id_lay/reactions?type=$type&method=post&access_token=$token";
            curl_setopt_array($curls, array(
                CURLOPT_URL => $links,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                  'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36',
                  'Cookie: '.$cookies
                ),
              ));
              $response = curl_exec($curls);
            curl_close($curls);
        }
        }
    
}