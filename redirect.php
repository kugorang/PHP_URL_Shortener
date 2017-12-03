<?php
require_once 'Shortener.php';

if(isset($_GET['code']))
{
  $s = new Shortener;

  if($url = $s->getUrl($_GET['code']))
  {
    header("Location: {$url}");
    die();
  }
}

header('Location: index.php');
 ?>
