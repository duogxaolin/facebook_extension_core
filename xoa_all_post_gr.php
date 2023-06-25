<!DOCTYPE html>
<html>
<head>
    <title>Delete all post</title>
</head>
<body> 
    <h4>Code xóa toàn bộ bài đăng (id group)</h4>
    <h5>Không xóa được ảnh bìa, ảnh đại diện, bài được tag</h5>
    <form method="post">
         <input type="text" name="token" value="EAABsbCS1iHgBAKBl2TqgZBFdIYkgBUkR8JITh6PGPoNDl7IyxADRn5tcbCdS3NUrDNkZCfZAVJ6RYuA9DI7ZA5rNOuAZCbjYodli7HRVsvWBDfsSbqhF4vcRfzfUPvuwFfvtGEhZBVkzQ9PxIHFBJUsRjRQIPPTfzfzixfr0oU5HAeRgKQL89U"><br>
         <input type="number" name="id" value="1323038911809756"><br>
         <input type="text" name="cookies" value="c_user=100038..."><br>
        Xóa hết<input type="radio" name="all" value="1" checked><br>
        >
        <button name="ok">OK</button>
    </form>
</body>
</html>
<?php
if(isset($_POST['ok'])){
    $token      = $_POST['token'];
    $id_can_xoa = $_POST['id'];
    $cookies    = $_POST['cookies'];
    $limit = 50;
    $link = "https://graph.facebook.com/$id_can_xoa/feed?fields=id&limit=$limit&access_token=$token"; 
    $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $link,
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
$data     = json_decode($response,true);
$i = 0;
foreach($data['data'] as $each){
    $id_post = $each['id'];
    $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://graph.facebook.com/$id_post?method=delete&access_token=$token",
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

$response2 = curl_exec($curl);

curl_close($curl);
$data2     = json_decode($response2,true);
if($data2['success']==true){
    echo $i++."Đã xóa bài viết $id_post<br>";
}
else{
    echo "Không thể xóa bài viết $id_post<br>";

}

}
}
