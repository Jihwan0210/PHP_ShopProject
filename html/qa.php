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

<div class="row m-1 mb-0 justify-content-center">
	<div class="col" align="center">

		<h4 class="mt-5 mb-3">Q & A</h4>
	
		<hr class="my-0">
		<table class="table table-sm m-0">
			<tr height="35" class="bg-light">
				<td width="10%">번호</td>
				<td width="45%">제목</td>
				<td width="15%">작성자</td>
				<td width="20%">작성일</td>
				<td width="10%">조회</td>
			</tr>
			<tr height="35">
				<td>3</td>
				<td align="left">
					<a href="qa_read.html?id=3&page=1&sel1=1&text1=" style="color:#0066CC">새소식3</a><br>
				</td>
				<td>홍길동</td>
				<td>2022-02-02</td>
				<td>32</td>
			</tr>
			<tr height="35">
				<td>4</td>
				<td align="left">
					<img src="images/i_re.gif" border="0">&nbsp;
					<a href="qa_read.html?id=4&page=1&sel1=1&text1="><font color="#4186C7">Re:새소식3</font></a>
				</td>	
				</td>
				<td>박나리</td>
				<td>2022-02-05</td>
				<td>16</td>
			</tr>
			<tr height="35">
				<td>5</td>
				<td align="left">
					&nbsp;&nbsp;<img src="images/i_re.gif" border="0">&nbsp;
					<a href="qa_read.html?id=5&page=1&sel1=1&text1="><font color="#4186C7">Re:새소식3</font></a>
				</td>	
				</td>
				<td>이길동</td>
				<td>2022-02-06</td>
				<td>14</td>
			</tr>
			<tr height="35">
				<td>2</td>
				<td align="left">
					<a href="qa_read.html?id=2&page=1&sel1=1&text1=" style="color:#0066CC">새소식2</a><br>
				</td>
				<td>박인규</td>
				<td>2022-02-01</td>
				<td>23</td>
			</tr>
			<tr height="35">
				<td>1</td>
				<td align="left">
					<a href="product.html?id=1001" style="color:#0066CC">새소식1</a><br>
				</td>
				<td>이미자</td>
				<td>2022-02-01</td>
				<td>43</td>
			</tr>
			<tr height="35">
				<td></td>
				<td align="left"></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr height="35">
				<td></td>
				<td align="left"></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		</table>

		<table class="table table-sm table-borderless mt-1 m-0">
			<tr>
				<td align="left">
					<form name="form2" method="post" action="qa.html">
						<div class="d-inline-flex">
							<div class="input-group input-group-sm">
								<span class="input-group-text myfs13">제목+내용</span>
								<input type="text" name="text1" size="10" value=""
									class="form-control bg-light myfs13">
								<button type="button" class="btn btn-sm btn-outline-secondary myfs13" 
									onClick="form2.submit();">검색</button>&nbsp;
							</div>
						</div>
					</form>
				</td>
				<td align="right">
					<a href="qa_new.html" class="btn btn-sm btn-dark text-white myfs13">새글</a>&nbsp;&nbsp;
				</td>
			</tr>
		</table>
	
	</div>
</div>

<!--  Pagination -->
<nav aria-label="Page navigation example">
	<ul class="pagination pagination-sm justify-content-center">
		<li class="page-item">
			<a class="page-link" href="#" aria-label="First">
				<span aria-hidden="true">◀</span>
			</a>
		</li>
		<li class="page-item">
			<a class="page-link" href="#" aria-label="Previous">
				<span aria-hidden="true">◁</span>
			</a>
		</li>
		<li class="page-item"><a class="page-link" href="#">1</a></li>
		<li class="page-item active" aria-current="page">
			<span class="page-link mycolor1">2</span>
		</li>
		<li class="page-item"><a class="page-link" href="#">3</a></li>
		<li class="page-item"><a class="page-link" href="#">4</a></li>
		<li class="page-item"><a class="page-link" href="#">5</a></li>
		<li class="page-item">
			<a class="page-link" href="#" aria-label="Next">
				<span aria-hidden="true">▷</span>
			</a>
		</li>
		<li class="page-item">
			<a class="page-link" href="#" aria-label="Last">
				<span aria-hidden="true">▶</span>
			</a>
		</li>
	</ul>
</nav>

<br><br><br>

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
