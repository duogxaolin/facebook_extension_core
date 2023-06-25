<!DOCTYPE html>
<html>
<head>
    <title>Download video Facebook</title>
</head>
<body> 
    <h4>Code tải video Facebook</h4>
    <h3>Nhớ tạo thư mục tên là "download" cùng thư mục với file code này</h3>
    <form method="post">
        <h3><a href="https://fb.com/me" target="_blank">Cách lấy token: Ấn vào đây => Ctrl U => Ctrl F => Tìm EAAA... (copy đoạn EAAA dài nhất)</a></h3>
        <input type="text" name="token" placeholder="Nhập token vào đây"><br>
        <input type="text" name="cookies" placeholder="Nhập cookies vào đây"><br>
        <input type="text" name="id" placeholder="Nhập ID người dùng (hoặc nhóm, hoặc trang) muốn tải"><br>
        <button name="ok">OK</button>
    </form>
</body>
</html>
<?php
if(isset($_POST['ok'])){
    ini_set('max_execution_time', 0);
    $token = $_POST['token'];
    $id    = $_POST['id'];
    $cookies    = $_POST['cookies'];
// Gửi yêu cầu GET để lấy thông tin về video
$url = 'https://graph.facebook.com/' . $id . '?fields=source&access_token=' . $token;
$curl = curl_init();
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
//echo $response;
$video_data = json_decode($response, true);

if (isset($video_data['source'])) {
    $video_source = $video_data['source'];

    // Tải video xuống máy tính
    $file = fopen('download/video.mp4', 'w');
    $ch = curl_init($video_source);
    curl_setopt($ch, CURLOPT_FILE, $file);
    curl_exec($ch);
    curl_close($ch);
    fclose($file);

    echo 'Video đã được tải xuống thành công!';
} else {
    echo 'Không tìm thấy video hoặc không có quyền truy cập!';
}

 /*   $link  = "https://graph.facebook.com/$id/videos?fields=source&limit=1&access_token=$token"; 
    while (true) {
       $curl    = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $link,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_HTTPHEADER => array(
                'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36',
                'Cookie: '.$cookies
              ),
        ));
        $response = curl_exec($curl);
        echo $response;
        curl_close($curl);
        $data     = json_decode($response,JSON_UNESCAPED_UNICODE);
        $datas    = $data["data"];
        if(count($datas)==0) break;
        foreach($datas as $each){
            $id    = $each['id'];
            $fp    = fopen("/download/$id.mp4", 'w+');
            $links = $each['source'];
            $curls = curl_init();
            curl_setopt_array($curls, array(
                CURLOPT_URL => $links,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_FILE => $fp
            ));
            curl_exec($curls);
            curl_close($curls);
            fclose($fp);
        }
        if(!empty($data["paging"]["next"])){
            $link = $data["paging"]["next"];
        }
        else{
            break;
        }
    }
    */
}

?>