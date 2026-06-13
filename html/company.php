<!---------------------------------------------------------------------------------------------
	제목 : 내 손으로 만드는 PHP 쇼핑몰무 (실습용 디자인 HTML)

	소속 : 인덕대학교 컴퓨터소프트웨어학과
	이름 : 교수 윤형태 (2024.02)
---------------------------------------------------------------------------------------------->
<!doctype html>
<html lang="kr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>INDUK Mall</title>
	<link  href="css/bootstrap.min.css" rel="stylesheet">
	<link  href="css/my.css" rel="stylesheet">
	<script src="js/jquery-3.7.1.min.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container">
<!-------------------------------------------------------------------------------------------->	
<?php include "main_top.php"; ?>

<!-------------------------------------------------------------------------------------------->	
<!-- 시작 : 다른 웹페이지 삽입할 부분 -->
<!-------------------------------------------------------------------------------------------->	

<div class="row m-1 mb-0">
	<div class="col" align="center">

		<h3 class="m-3 mt-5"><b>INDUK Mall</b></h3>

		<hr size="4px" class="m-0">

		<div class="fs-6" align="center">

			<br>
			 인덕쇼핑몰은 오래전부터 현재의 모습까지 수년여의 오랜 전통과 역사를 가지고 <br>
			 소비자분들의 격려와 믿음을 바탕으로 성장해온 전문 쇼핑몰 입니다.<br>
			<br>
			...<br>
			<br>
			편안한 쇼핑시간이 되시기를...
			<br>
			감사합니다.<br>
			<br><br><br>

			<img src="images/company.png" class="img-thumbnail my-4">
			<br>
			<a href="javascript:history.back();" class="btn btn-sm btn-dark text-white">&nbsp;돌아가기&nbsp;</a>
		</div>

	</div>
</div>

<br><br><br><br><br><br>	

<!-------------------------------------------------------------------------------------------->	
<!-- 끝 : 다른 웹페이지 삽입할 부분 -->
<!-------------------------------------------------------------------------------------------->	

<?php include "main_bottom.php"; ?>
<!-------------------------------------------------------------------------------------------->	
</div>

</body>
</html>
