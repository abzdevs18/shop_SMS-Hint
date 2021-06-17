<?php

  $shop = $_GET['shop'];
  $api_key = "4edc516cbc0190cec0636c6a4c83f07f";
  $scope = "read_orders, write_orders, read_products, write_products, read_themes, write_themes, read_script_tags, write_script_tags";
  $redirect_uri = "https://shopifyduma.000webhostapp.com/token.php";

  $install_url = "https://".$shop."/admin/oauth/authorize?client_id=".$api_key."&scope=".$scope."&redirect_uri=".urlencode($redirect_uri);

  header("Location: ".$install_url);
  die();
 ?>
