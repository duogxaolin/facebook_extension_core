<?php 
ini_set('max_execution_time', 0);
//token của bạn
$token = "EAAA...";
$cookies     = "c_user=100038..."; // Cookie facebook (từ 2023 phải có cookies mới có thể sử dụng api fb)
//điền id những bạn không muốn xóa
$array_avoid = ["id_1","id_2","id_3","id_4"];
$url = "https://graph.facebook.com/me/friends?limit=5000&fields=id&access_token=$token";
$array_id = array();
while(true){
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
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
	$response = curl_exec($curl);
	curl_close($curl);
	$response = json_decode($response,true);
	if(isset($response["data"]) && count($response["data"])>0){
		$array_fb = $response["data"];
	}
	else{
		break;
	}
	foreach ($array_fb as $each) {
		array_push($array_id,$each['id']);
	}
	if(!empty($response['paging']['next'])){
		$url = $response['paging']['next'];
	}
	else{
		break;
	}
}
$array_id = array_diff($array_id,$array_avoid);
foreach ($array_id as $uid) {
	$url = "https://graph.facebook.com/me/friends?uid=$uid&method=delete&access_token=$token";
    curl_setopt_array($curls, array(
        CURLOPT_URL => $url,
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
      $response = curl_exec($curl);
      curl_close($curl);
	sleep(3); //dừng 3s tránh block
}