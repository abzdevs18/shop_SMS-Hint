<?php
  require_once("inc/function.php");
  require_once("inc/db.php");

  $api_key = "4edc516cbc0190cec0636c6a4c83f07f";
  $shared_secret = "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";
  $params = $_GET;
  $hmac = $_GET['hmac'];

  $params = array_diff_key($params, array('hmac' => ''));
  ksort($params);
  $computed_hmac = hash_hmac('sha256', http_build_query($params), $shared_secret);

  if(hash_equals($hmac, $computed_hmac)){
    $query = array(
      "client_id" => $api_key,
      "client_secret" => $shared_secret,
      "code" => $params['code']
    );
    $access_token_url = "https://" . $params['shop'] . "/admin/oauth/access_token";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $access_token_url);
    curl_setopt($ch, CURLOPT_POST, count($query));
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($query));

    $result = curl_exec($ch);
    curl_close($ch);

    $result =json_decode($result, true);
    $access_token = $result['access_token'];

    // echo $access_token;
    $sql = "INSERT INTO `shops`(`shop_url`, `access_token`, `install_date`) VALUES ('".$params['shop']."','".$access_token."',NOW())";

    if(mysqli_query($conn, $sql)){
      header("Location: https://".$params['shop']."/admin/apps/shopapp-38");
      exit();
    }else{
      echo "Something went wrong!";
    }

  }else{
    die("This is request not from shopify");
  }
 ?>
