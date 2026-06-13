<!---------------------------------------------------------------------------------------------
	제목 : 내 손으로 만드는 PHP 쇼핑몰무 (실습용 디자인 HTML)
---------------------------------------------------------------------------------------------->
<!doctype html>
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
<?PHP include "common.php"; ?>

<!-- Title과 메뉴 -->
<div class="row">
	<div class="col fs-3" align="left">
		<a href="index.html">
			<img src=https://ecimg.cafe24img.com/pg1186b26175459011/playwin1/web/upload/images/logo.png
			     alt="침착맨" height="40" style="vertical-align:middle; margin-right:5px;">
			<font color="#7773217"></font>
		</a>
	</div>
	<div class="col mt-3" align="right" style="font-size:12px;">
		<a href="index.html">Home</a>&nbsp;|&nbsp;
	<?php
		$cookie_id = $_COOKIE["cookie_id"] ?? "";
		if (!$cookie_id) {
			echo'<a href="member_login.php">Login</a>&nbsp;|&nbsp;';
			echo'<a href="member_join.php">회원가입</a>&nbsp;|&nbsp;';
		} else {
			echo'<a href="member_logout.php">로그아웃</a>&nbsp;|&nbsp;';
			echo'<a href="member_edit.php">회원정보수정</a>&nbsp;|&nbsp;';
		}
	?>
		<a href="cart.php">장바구니</a>&nbsp;|&nbsp; 
	<?php
		if (!$cookie_id) {
			echo '<a href="jumun_login.php">주문조회</a>&nbsp;|&nbsp;';
		} else {
			echo '<a href="jumun.php">주문조회</a>&nbsp;|&nbsp;';
		}
	?>
		<a href="qa.php">Q & A</a>&nbsp;|&nbsp;
		<a href="faq.html">FAQ</a>&nbsp;&nbsp;
	</div>
</div>

<!-- 슬라이드 스타일 -->
<style>
.carousel-item img {
	height: 800px;
	object-fit: cover;
	border-radius: 20px;
}
.carousel-inner {
	border: 1px solid #ddd;
	border-radius: 20px;
	overflow: hidden;
}
.carousel-caption h1 {
	font-size: 22px;
}
</style>

<!-- 슬라이드 이미지 -->
<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
	<div class="carousel-indicators">
		<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
		<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
	</div>
	<div class="carousel-inner">
		<div class="carousel-item active">
			<img src="https://ecimg.cafe24img.com/pg1186b26175459011/playwin1/web/upload/images/1.jpg" class="d-block w-100" alt="New Fashion 1">
		</div>
		<div class="carousel-item">
			<img src="https://ecimg.cafe24img.com/pg1186b26175459011/playwin1/web/upload/images/3.jpg" class="d-block w-100" alt="New Fashion 3">
			<div class="carousel-caption d-none d-md-block">
			</div>
		</div>
		
	</div>
	<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
		<span class="carousel-control-prev-icon" aria-hidden="true"></span>
		<span class="visually-hidden">Previous</span>
	</button>
	<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
		<span class="carousel-control-next-icon" aria-hidden="true"></span>
		<span class="visually-hidden">Next</span>
	</button>
</div>

<!-- 상품 Category 메뉴 + 검색창 (하단 선만 있는 버전) -->
<div style="border-bottom: 1px solid #ddd; margin-bottom: 10px;">
  <div class="row py-2 fs-6">
    <div class="col d-flex justify-content-between align-items-center">

      <!-- 카테고리 메뉴 -->
      <ul class="nav mb-0">
        <?php
          for ($i = 1; $i < $n_menu; $i++) {
            $name = $a_menu[$i];
            echo "<li class='nav-item zoom_a me-3'><a class='nav-link' href='menu.php?menu=$i'>$name</a></li>";
          }
        ?>
      </ul>

      <!-- 검색창 -->
      <form name="form1" method="post" action="product_search.php"
            class="d-flex align-items-center" onsubmit="return check_findproduct();">
        <input type="text" name="find_text"
               value="<?= htmlspecialchars($_POST['find_text'] ?? '') ?>"
               class="form-control form-control-sm me-2"
               style="border: none; border-bottom: 1px solid #ccc; background-color: transparent; font-size:13px;"
               placeholder="상품검색">
        <button type="submit" class="btn btn-sm"
                style="border: none; background: none; font-size:13px; color: #555;">
          Search
        </button>
      </form>

    </div>
  </div>
</div>

<script>
function check_findproduct() {
  if (!form1.find_text.value.trim()) {
    alert('검색어를 입력하세요');
    return false;
  }
  return true;
}
</script>

