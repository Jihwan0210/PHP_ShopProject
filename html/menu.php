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
		.icon-container {
			display: flex;
			align-items: center;
			justify-content: center;
			margin-top: 5px;
		}
		.discount-percent {
			color: red;
			font-size: 14px;
			font-weight: bold;
			margin-left: 5px;
		}
		.card {
			border: none !important;
			box-shadow: none !important;
		}
		.card-body {
			background-color: transparent !important;
			padding: 0;
		}
		.card-title {
			font-size: 18px;
			font-weight: 500;
			text-align: center;
			margin-top: 10px;
		}
	</style>
	<script>
		window.addEventListener("beforeunload", function () {
			sessionStorage.setItem("scrollPosition", window.scrollY);
		});
		window.addEventListener("load", function () {
			const scrollY = sessionStorage.getItem("scrollPosition");
			if (scrollY) {
				window.scrollTo(0, scrollY);
			}
		});
	</script>
</head>
<body>
<div class="container">
<?php
include "main_top.php";

$sort = $_GET['sort'] ?? 1;
$menu = $_GET['menu'] ?? 0;
$page = $_GET['page'] ?? 1;

$order = "order by id desc";
$extra_condition = ""; 
switch ($sort) {
	case 2: $order = "order by id desc"; $extra_condition = " and icon_hit = 1"; break;
	case 3: $order = "order by name"; break;
	case 4: $order = "order by price"; break;
	case 5: $order = "order by price desc"; break;
	case 1: default: $order = "order by id desc"; break;
}

$condition = ($menu > 0) ? "where menu = $menu" : "where 1";
$condition .= $extra_condition;

$sql = "select * from product $condition $order";
$args = "sort=$sort&menu=$menu";
$result = mypagination($sql, $args, $total, $pagebar);
?>

<!-- 카테고리 제목 -->
<div class="row mt-5">
	<div class="col text-center">
		<h2><?= $menu > 0 ? $a_menu[$menu] : "전체 상품" ?></h2>
	</div>
</div>

<!-- 상품 개수 및 정렬 옵션 -->
<div class="row mt-3 mb-2 align-items-center">
	<div class="col-md-6 text-start" style="font-size:15px">
		Total <b><?=$total?></b> items
	</div>
	<div class="col-md-6 text-end" style="font-size:12px">
		<a href="menu.php?menu=<?=$menu?>&sort=1" class="me-2 <?= $sort == 1 ? 'fw-bold text-dark' : '' ?>">신상품</a>
		<a href="menu.php?menu=<?=$menu?>&sort=2" class="me-2 <?= $sort == 2 ? 'fw-bold text-dark' : '' ?>">인기상품</a>
		<a href="menu.php?menu=<?=$menu?>&sort=3" class="me-2 <?= $sort == 3 ? 'fw-bold text-dark' : '' ?>">상품명</a>
		<a href="menu.php?menu=<?=$menu?>&sort=4" class="me-2 <?= $sort == 4 ? 'fw-bold text-dark' : '' ?>">낮은가격</a>
		<a href="menu.php?menu=<?=$menu?>&sort=5" class="<?= $sort == 5 ? 'fw-bold text-dark' : '' ?>">높은가격</a>
	</div>
</div>
<hr class="mt-0 mb-4">

<!-- 상품 진열 -->
<div class="row">
<?php if ($total > 0): ?>
	<?php while ($row = mysqli_fetch_array($result)) {
		$id = $row['id'];
		$name = $row['name'];
		$image = $row['image1'];
		$price = number_format($row['price']);
		$discount = $row['discount'];
		$sale_price = number_format(round($row['price'] * (100 - $discount) / 100));
		$discount_percent = $discount;
	?>
		<div class="col-sm-6 col-md-4 col-lg-3 mb-5 text-center">
			<a href="product.php?id=<?=$id?>">
				<img src="product/<?=$image?>" class="img-fluid mb-2" style="height: 306px; object-fit: contain;">
			</a>
			<div class="card-title">
				<a href="product.php?id=<?=$id?>" class="text-dark text-decoration-none"><?=$name?></a>
			</div>
			<div class="icon-container">
				<?php if ($row['icon_new']) : ?>
					<span class="badge bg-success me-1">NEW</span>
				<?php endif; ?>
				<?php if ($row['icon_hit']) : ?>
					<span class="badge bg-danger me-1">HIT</span>
				<?php endif; ?>
				<?php if ($row['icon_sale']) : ?>
					<span class="badge bg-primary me-1">SALE</span>
					<span class="discount-percent"><?=$discount_percent?>%</span>
				<?php endif; ?>
			</div>
			<div style="margin-top: 5px;">
				<?php if ($row['icon_sale']) : ?>
					<small><strike><?=$price?> 원</strike></small>
					<b style="font-size:15px;"> <?=$sale_price?> 원</b>
				<?php else: ?>
					<b style="font-size:15px;"><?=$price?> 원</b>
				<?php endif; ?>
			</div>
		</div>
	<?php } ?>
<?php else: ?>
	<div class="col text-center text-muted mb-5">
		<p>해당 조건의 상품이 없습니다.</p>
	</div>
<?php endif; ?>
</div>

<!-- 페이지네이션 -->
<div class="row mb-4">
	<div class="col text-center">
		<?=$pagebar?>
	</div>
</div>

<?php include "main_bottom.php"; ?>
</div>
</body>
</html>
