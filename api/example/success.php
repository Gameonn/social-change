<?php

/**
 * Instagram PHP API
 * 
 * @link https://github.com/cosenary/Instagram-PHP-API
 * @author Christian Metz
 * @since 01.10.2013
 */


require_once 'instagram.class.php';

// initialize class
$instagram = new Instagram(array(
  'apiKey'      => '0b00b7486c1f48bd82f42cb29f498bd5',
  'apiSecret'   => '6da28a880c134b09956fc6c5e426f69b',
  'apiCallback' => 'http://code-brew.com/projects/Instamigos/api/example/success.php' // must point to success.php
));

// receive OAuth code parameter
$code = $_GET['code'];

// check whether the user has granted access
if (isset($code)) {

  // receive OAuth token object
  $data = $instagram->getOAuthToken($code);
  print_r($data);
  $username = $username = $data->user->username;
  
  // store user access token
  $instagram->setAccessToken($data);

  // now you have access to all authenticated user methods
  $result = $instagram->getUserMedia();
  
  //$instagram->(687581743707336346);
  
  $data=$instagram->getMedia(687581743707336346);
  
  print_r($data);
  
  //print_r($users);die; 

} else {

  // check whether an error occurred
  if (isset($_GET['error'])) {
    echo 'An error occurred: ' . $_GET['error_description'];
  }

}

?>

