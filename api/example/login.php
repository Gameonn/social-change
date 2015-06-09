<?php

    require_once 'instagram.class.php';
    
    $instagram = new Instagram(array(
      'apiKey'      => '0b00b7486c1f48bd82f42cb29f498bd5',
      'apiSecret'   => '6da28a880c134b09956fc6c5e426f69b',
      'apiCallback' => 'http://code-brew.com/projects/Instamigos/api/example/success.php'
    ));
    
    echo "<a href='{$instagram->getLoginUrl()}'>Login with Instagram</a>";
?>
