<!DOCTYPE html>
<html>
<head>
    <title>Get ID by link Facebook</title>
</head>
<body> 
    <h4>Code lấy ID theo link Facebook</h4>
    <form method="post">
      
        <textarea cols="50" name="token" required placeholder="Nhập token vào đây"><?php if(isset($_POST['ok'])) echo $_POST['token'] ?></textarea><br>
        <input type="text" name="cookies" placeholder="Nhập cookies vào đây"><br>
        <textarea cols="50" rows="30" name="array_id" required placeholder="Nhập link Facebook, cách nhau bởi 1 dấu xuống dòng (enter - không thừa khoảng trắng)"><?php if(isset($_POST['ok'])) echo $_POST['array_id'] ?></textarea>
        <button name="ok">OK</button>
    </form>
</body>
</html>
<?php
function print_r2($val){
        echo '<pre>';
        print_r($val);
        echo  '</pre>';
}
if(isset($_POST['ok'])){
    ini_set('max_execution_time', 0);
    $token        = $_POST['token'];
    $array_id     = $_POST['array_id'];
    $cookies    = $_POST['cookies'];
    preg_match_all('/(?<=profile\.php\?id\=)([0-9]+)|(?:(?<=\.com)|(?<=\.me)|(?<=\.co)|(?<=\.us))(?:(?:\/groups\/|\/)(?!profile\.php)([\w\.\_]+))/', $array_id, $array, PREG_SET_ORDER);
    $array_new = array();
    $array_name = array();
    foreach ($array as $key => $child_array) {
    	$array_new[end($child_array)] = 0;
    }
    $total_import    = count($array_new);
    $page_limit      = 50;
    $num_page        = ceil($total_import/$page_limit);
    for($page=0; $page<$num_page; $page++) {
		$offset  = $page*$page_limit;
		$fbmaped = array_slice($array_new, $offset, $page_limit);
		$index   = array_keys($fbmaped);
		$ids     = implode(",", $index);
		$link    = "https://graph.facebook.com/?ids=$ids&fields=id,name&access_token=$token";
		$curl    = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "$link",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => array(
                'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36',
                'Cookie: '.$cookies
              ),
            CURLOPT_SSL_VERIFYHOST => false
        ));
        $response = curl_exec($curl);
        echo $response;
        curl_close($curl);
        $data     = json_decode($response,true);
        foreach ($data as $key => $each) {
            $array_new_id[$key] = $each['id'];
            $array_name[$key]   = $each['name'];
        }
    }
    echo "<br><br><br><table width='100%' border='1'><tr><td>Tên</td><td>Link đã cấp</td><td>ID Facebook</td>";
    foreach ($array_new_id as $key => $each) {
        echo "<tr>";
        if(isset($array_name[$key])){
            echo "<td>".$array_name[$key]."</td>";
            echo "<td><a href='https:fb.com/$key' target='_blank'>$key</td>";
            echo "<td>".$each."</td>";
        }
        else{
            echo "<td></td>";
            echo "<td><a href='https:fb.com/$key' target='_blank'>$key</td>";
            echo "<td></td>";
        }
        echo "</tr>";
    }
    
}