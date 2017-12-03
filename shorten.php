<?php
if (!isset($_SESSION))
{
  // 세션이 설정되어 있지 않다면 세션을 시작한다.
  session_start();
}

// Shortener.php를 포함시킨다.
require_once 'Shortener.php';

// Shortener 클래스를 생성한다.
$s = new Shortener;

// 만약 post로 온 인자 중 url이 있다면
if (isset($_POST['url']))
{
  // url로 코드를 만든다.
  $code = $s->makecode($_POST['url']);

  // 만약 코드를 검사했을 때
  if ($code)
  {
    // 코드가 있다면 message에 성공을 알리고 줄인 url도 표시한다.
    $_SESSION['message'] = "생성 완료! 줄인 URL은<br/><a href=\"http://localhost/{$code}\">http://localhost/{$code}</a> 입니다.";
  }
  else
  {
    // 코드가 없다면 문제가 생겼으므로 message에 실패를 담는다.
    $_SESSION['message'] = "생성에 실패했습니다.<br/>올바른 URL인지 확인해주세요.";
  }
}

// index.php로 돌아간다.
header('Location: index.php');
 ?>
