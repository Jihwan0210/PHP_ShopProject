<!---------------------------------------------------------------------------------------------
	제목 : 내 손으로 만드는 PHP 쇼핑몰 (실습용 디자인 HTML)
	소속 : 인덕대학교 컴퓨터소프트웨어학과
	이름 : 교수 윤형태 (2024.02)
---------------------------------------------------------------------------------------------->
<!doctype html>
<html lang="kr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>INDUK Mall</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/my.css" rel="stylesheet">
	<script src="js/jquery-3.7.1.min.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>
	<style>
		.login-box {
			max-width: 400px;
			margin: 80px auto;
			padding: 30px;
			border: 1px solid #ddd;
			border-radius: 10px;
			background-color: #fdfdfd;
			box-shadow: 0 0 10px rgba(0,0,0,0.05);
		}
	</style>
</head>
<body>

<div class="container">
<?php include "main_top.php"; ?>

<script>
	function Check_Value() {
		if (!form2.uid.value) {
			alert("아이디를 입력하세요.");	form2.uid.focus();	return;
		}
		if (!form2.pwd.value) {
			alert("암호를 입력하세요.");	form2.pwd.focus();	return;
		}
		form2.submit();
	}
</script>

<form name="form2" method="post" action="member_check.php">
	<div class="login-box">
		<h3 class="text-center mb-4">Login</h3>

		<div class="mb-3">
			<label for="uid" class="form-label">아이디</label>
			<input type="text" class="form-control" name="uid" id="uid" tabindex="1">
		</div>

		<div class="mb-4">
			<label for="pwd" class="form-label">암호</label>
			<input type="password" class="form-control" name="pwd" id="pwd" tabindex="2">
		</div>

		<div class="d-grid mb-3">
			<button type="button" onclick="Check_Value();" tabindex="3" class="btn btn-dark">로그인</button>
		</div>

		<div class="text-center">
			<a href="member_idpw.php" class="btn btn-sm btn-outline-secondary">아이디 / 암호 찾기</a>
		</div>
	</div>
</form>

<br><br><br><br>

<?php include "main_bottom.php"; ?>
</div>

</body>
</html>
