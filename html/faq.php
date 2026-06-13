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

<?PHP
include "main_top.php";
?>

<!-------------------------------------------------------------------------------------------->	
<!-- 시작 : 다른 웹페이지 삽입할 부분 -->
<!-------------------------------------------------------------------------------------------->	

<div class="row m-1  mb-0 justify-content-center">
	<div class="col" align="center">

		<h4 class="mt-5">FAQ</h4>

		<hr style="height:2px" class="mb-0">
		<table class="table table-sm m-0">
			<tr height="30" class="bg-light">
				<td width="10%">번호</td>
				<td width="90%">제목</td>
			</tr>
			<tr height="35">
				<td>1</td>
				<td align="left">
					<a href="faq_read.html?id=1" style="color:#0066CC">배송 진행상황은 어디서 조회하나요?</a><br>
				</td>
			</tr>
			<tr height="35">
				<td>2</td>
				<td align="left">
					<a href="faq_read.html?id=2" style="color:#0066CC">결제방법의 종류를 알고 싶어요. </a><br>
				</td>
			</tr>
		</table>
	</div>
</div>

<br><br><br><br><br><br>

<!-------------------------------------------------------------------------------------------->	
<!-- 끝 : 다른 웹페이지 삽입할 부분 -->
<!-------------------------------------------------------------------------------------------->	

<?PHP
include "main_bottom.php";
?>


<!-------------------------------------------------------------------------------------------->	
</div>

</body>
</html>
