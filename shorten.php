<?php
if (!isset($_SESSION))
{
  session_start();
}

require_once 'Shortener.php';

$s = new Shortener;

if (isset($_POST['url']))
{
  $url = $_POST['url'];
  $code = $s->makecode($url);

  if ($code)
  {
    $_SESSION['message'] = "Generated! Your short URL is: <a href=\"http://localhost/{$code}\">http://localhost/{$code}</a>";
  }
  else
  {
    // There was a problem
    $_SESSION['message'] = "There was a problem. Invalid URL, perhaps?";
  }
}

header('Location: index.php');
 ?>
