<?php
phpinfo();
	if(!isset($_SESSION))
	{
		session_start();
	}
 ?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>URL Shortener</title>
		<link rel="stylesheet" href="global.css"/>
	</head>

	<body>
		<div class="container">
			<h1 class="title">Shorten a URL.<h1>
				<?php
				if(isset($_SESSION['message']))
				{
					echo "<p>{$_SESSION['message']}</p>";
					unset($_SESSION['message']);
				}
				?>
				<!--클라이언트에서는 주소(localhost) 기준으로 경로를 처리하기 때문에 /를 경로에 붙여주는 것이 좋음.-->
				<form action="./shorten.php" method="post">
					<input type="url" name="url" placeholder="Enter a URL here." autocomplete="off">
					<input type="submit" value="Shorten"/>
				</form>
		</div>
</body>
</html>
