<!---------------------------------------------------------------------------------------------
	제목 : 내 손으로 만드는 PHP 쇼핑몰 (실습용 디자인 HTML)
	소속 : 인덕대학교 컴퓨터소프트웨어학과
	이름 : 교수 윤형태 (2024.02)
---------------------------------------------------------------------------------------------->
<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include "common.php";

// POST 데이터 받기
$uid = $_POST["uid"] ?? "";
$pwd = $_POST["pwd"] ?? "";
$name = $_POST["name"] ?? "";
$tel = ($_POST["tel1"] ?? "") . ($_POST["tel2"] ?? "") . ($_POST["tel3"] ?? "");
$zip = $_POST["zip"] ?? "";
$juso = $_POST["juso"] ?? "";
$email = $_POST["email"] ?? "";
$birthday = ($_POST["birthday1"] ?? "") . "-" . ($_POST["birthday2"] ?? "") . "-" . ($_POST["birthday3"] ?? "");

// 필수 항목 체크
if (!$uid || !$pwd || !$name) {
	echo "<script>alert('필수 항목이 누락되었습니다.'); history.back();</script>";
	exit;
}

// 비밀번호 암호화 없이 그대로 저장
$sql = "INSERT INTO member (uid, pwd, name, tel, zip, juso, email, birthday)
        VALUES ('$uid', '$pwd', '$name', '$tel', '$zip', '$juso', '$email', '$birthday')";

$result = mysqli_query($db, $sql);
if (!$result) {
	echo "회원가입 중 오류 발생: " . mysqli_error($db);
	exit;
}

// 쿠키 설정
setcookie("cookie_id", $uid, time() + 86400, "/");
?>

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
</head>
<body>

<div class="container">
<?php include "main_top.php"; ?>

<!-- 회원가입 완료 메시지 -->
<div class="row m-5 mb-0">
	<div class="col" align="center">
		<h4>회원가입</h4>
	</div>	
</div>	

<hr size="4px" class="m-0 mx-5">

<div class="row m-3">
	<div class="col align-items-center justify-content-center" align="center">
		<br><br><br>
		<h3><b>Congratulation !!!</b></h3>
		<br><br>
		저희 쇼핑몰을 가입하여 주셔서 대단히 감사합니다.<br><br>
		저희 쇼핑몰은 항상 최선을 다할 것을 약속 드립니다.<br><br><br>
		즐거운 쇼핑이 되시길 바랍니다.
		<br><br><br><br>
		<a href="index.html" class="btn btn-sm btn-dark text-white">&nbsp;돌아가기&nbsp;</a>
	</div>
</div>

<br><br><br><br><br><br>

<?php include "main_bottom.php"; ?>
</div>

</body>
</html>
