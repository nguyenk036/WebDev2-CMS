<?php

  define('ADMIN_LOGIN','admin');

  define('ADMIN_PASSWORD','testadmin1');

  if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])

      || ($_SERVER['PHP_AUTH_USER'] != ADMIN_LOGIN)

      || ($_SERVER['PHP_AUTH_PW'] != ADMIN_PASSWORD)) {

    header('HTTP/1.1 401 Unauthorized');

    exit("Access Denied: Username and password required.");

  }

?>