<?php
// Shorter.php를 포함시킨다.
require_once 'Shortener.php';

// 만약 code에 값이 있다면
if (isset($_GET['code']))
{
  // Shortener를 만든 후
  $s = new Shortener;

  // url이 있는지 확인한다.
  if ($url = $s->getUrl($_GET['code']))
  {
    // url이 있다면 그 url로 리다이렉트 후
    header("Location: {$url}");

    // 종료한다.
    die();
  }
}

// 만약 url을 못 찾았다면 index.php로 이동한다.
header('Location: ./index.php');
 ?>
