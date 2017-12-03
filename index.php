<?php
	// 세션이 있는지 확인한다.
	if (!isset($_SESSION))
	{
		// 세션이 존재하지 않으면 세션을 시작한다.
		session_start();
	}
 ?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>URL 단축 (URL shortening)</title>
		<!--스타일시트로 연결하며 global.css 파일과 연결한다.-->
		<link rel="stylesheet" href="./global.css"/>
	</head>

	<body>
		<div class="container">
			<h1 class="title">URL 단축 (URL shortening)<h1>
				<!--클라이언트에서는 주소(localhost) 기준으로 경로를 처리하기 때문에 /를 경로에 붙여주는 것이 좋다고 한다.-->
				<form action="./shorten.php" method="post">
					<!--URL 입력창이다. 자동완성 기능을 제거하였다.-->
					<input type="url" name="url" placeholder="URL을 여기에 입력하세요." autocomplete="off">
					<!--줄이기 버튼이다. 버튼을 누르면 shorten.php로 이동하여 로직을 수행한다.-->
					<input type="submit" value="줄이기"/>
				</form>
				<?php
				// 만약 세션 중 message가 설정되어 있다면
				if (isset($_SESSION['message']))
				{
					// message를 출력 후
					echo "<p>{$_SESSION['message']}</p>";

					// message를 unset 해준다.
					unset($_SESSION['message']);
				}
				?>
		</div>
	</body>
</html>
