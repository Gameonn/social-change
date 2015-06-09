<?php

/**
 * Instagram PHP API
 * Example for using the getUserMedia() method
 * 
 * @link https://github.com/cosenary/Instagram-PHP-API
 * @author Christian Metz
 * @since 31.01.2012
 */
error_reporting(E_ALL);
require 'Inst/Instagram.php';
require 'Inst/InstagramException.php';
use MetzWeb\Instagram\Instagram;

// Initialize class
$instagram = new Instagram(array(
  'apiKey'      => 'd22e0acd30f1442aa09f6a6131845171',
  'apiSecret'   => '4ccbf331d26047d6b145c5f055d6a01d',
  'apiCallback' => 'socialchange.company/api/example/success.php'
));

// Receive OAuth code parameter
$code = $_REQUEST['instagram_token'];
$tagname=$_REQUEST['tag_name'];

// Check whether the user has granted access
if (isset($code)) {

  // Receive OAuth token object
  $data = $instagram->getOAuthToken($code);
print_r($data);
  // Store user access token
  $instagram->setAccessToken($data);

  // Now you can call all authenticated user methods
  // Get the most recent media published by a user
  $media = $instagram->getTag($tagname);

	//print_r($media);die;

}

else {

  // check whether an error occurred
  if (isset($_GET['error'])) {
    echo 'An error occurred: ' . $_GET['error_description'];
  }

}

?>