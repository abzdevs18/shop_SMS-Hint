<?php
    // header('X-Content-Type-Options: sniff');

    $shopify = $_GET;
    $sql = "SELECT * FROM shops WHERE shop_url='".$shopify['shop']."' LIMIT 1";
    $check = mysqli_query($conn, $sql);
    if(mysqli_num_rows($check) < 1){
      header("Location: install.php?shop=".$shopify['shop']);
      exit();
    }else{
      $shop_row = mysqli_fetch_assoc($check);
      $shop_url = $shop_row['shop_url'];
      $token = $shop_row['access_token'];
    }
 ?>
