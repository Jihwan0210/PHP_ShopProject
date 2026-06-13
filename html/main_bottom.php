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


<!-------------------------------------------------------------------------------------------->
<!-- 끝 : 다른 웹페이지 삽입할 부분 -->
<!-------------------------------------------------------------------------------------------->

<!-- Footer -->
<hr class="m-0">
<div class="container-fluid bg-white pt-4 pb-5">

    <!-- 본문 COMPANY INFO / CONTACT / 메뉴 + BOARD -->
    <div class="row text-start text-secondary px-5" style="font-size:13px; line-height:1.8;">

        <!-- 왼쪽 COMPANY INFO -->
        <div class="col-md-4 mb-4">
            <h6 class="fw-bold text-dark">COMPANY INFO.</h6>
            COMPANY : 인덕대학교 유컴퍼니<br>
            OWNER : 유지환<br>
            ADDRESS : 인덕대학교<br>
            CEO : 유지환 mijisoo97@naver.com</a><br>
            BUSINESS LICENSE : 856-86-01430<br>
            MAIL ORDER LICENSE : 인덕대학교
            
        </div>

        <!-- 가운데 COMPANY INFO + BANK -->
        <div class="col-md-4 mb-4">
            <h6 class="fw-bold text-dark">COMPANY INFO.</h6>
            TEL : 010.8684.0210<br>
            OPEN AM 10:00 ~ CLOSE PM 05:00 / SAT.SUN.HOLIDAY CLOSED<br>
            LUNCH PM 12:00 ~ PM 01:00<br><br>

            <h6 class="fw-bold text-dark">BANK ACCOUNT</h6>
            토스뱅크 100008398522 <br>
            예금주 주식회사 유컴퍼니
        </div>

        <!-- 오른쪽: 링크 메뉴 + BOARD -->
        <div class="col-md-4 text-center">
            <div class="mb-3">
                <a href="company.php" class="mx-2 fw-bold text-dark">회사소개</a>
                <a href="useinfo.html" class="mx-2 fw-bold text-dark">이용안내</a>
                <a href="policy.html" class="mx-2 fw-bold text-dark">개인정보정책</a>
                <a href="admin/index.html" class="mx-2 fw-bold text-dark">ADMIN</a>
            </div>

            <h6 class="fw-bold text-dark mt-4">BOARD</h6>
            <div class="d-flex justify-content-center gap-2">
                <button class="btn btn-outline-secondary btn-sm" onclick="location.href='faq.php'">FAQ</button>

                <button class="btn btn-outline-secondary btn-sm" onclick="location.href='jumun_login.php'">주문 조회</button>

                <button class="btn btn-outline-secondary btn-sm" onclick="location.href='qa.php'">Q&A</button>

            </div>
        </div>

    </div>
</div>


<!-------------------------------------------------------------------------------------------->
</div>

</body>
</html>
