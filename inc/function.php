<?php
function shopify_call($token, $shop, $api_endpoint, $query = array(), $method = 'GET', $request_headers = array()){
  $url = "https://". $shop . $api_endpoint;

  if(!is_null($query) && in_array($method, array('GET', 'DELETE'))) $url = $url . '?' . http_build_query($query);

  $curl = curl_init($url);
  curl_setopt($curl, CURLOPT_HEADER, TRUE);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
  curl_setopt($curl, CURLOPT_MAXREDIRS, 3);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);

  curl_setopt($curl, CURLOPT_USERAGENT, "mY sHOPIFY aPP V.1");
  curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
  curl_setopt($curl, CURLOPT_TIMEOUT, 30);
  curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);

  $request_headers[] = "";
  if(!is_null($token)) $request_headers[] = "X-Shopify-Access-Token: " . $token;
  curl_setopt($curl, CURLOPT_HTTPHEADER,$request_headers);

  if($method != "GET" && in_array($method, array('POST','PUT'))){
    if(is_array($query)) $query = http_build_query($query);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $query);
  }

  $response = curl_exec($curl);
  $error_number = curl_errno($curl);
  $error_message = curl_error($curl);

  curl_close($curl);

  if($error_number){
    return $error_message;
  }else{
    $response = preg_split("/\r\n\r\n|\n\n|\r\r/", $response, 2);

    $headers = array();
    $headers_data = explode("\n", $response[0]);
    $headers['status'] = $headers_data[0];
    array_shift($headers_data);
    foreach($headers_data as $part){
      $h = explode(":", $part);
      $headers[trim($h[0])] = trim($h[1]);
    }

    return array('headers' => $headers, 'response' => $response[1]);
  }
}
 ?>
