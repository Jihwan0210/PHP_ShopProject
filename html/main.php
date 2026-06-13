<!doctype html>
<html lang="kr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>침착맨 굿즈샵</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/my.css" rel="stylesheet">
	<script src="js/jquery-3.7.1.min.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>
	<style>
		.icon-container {
			display: flex;
			align-items: center;
			justify-content: center;
		}
		.discount-percent {
			color: red;
			font-size: 14px;
			font-weight: bold;
			margin-left: 5px;
		}
		.section-title {
			font-size: 36px;
			font-weight: 600;
			text-align: center;
			color: #333;
			margin-top: 60px;
			margin-bottom: 40px;
			position: relative;
			font-family: 'Segoe UI', sans-serif;
		}
		.section-title::after {
			content: "";
			width: 80px;
			height: 4px;
			background: #007bff;
			position: absolute;
			bottom: -10px;
			left: 50%;
			transform: translateX(-50%);
			border-radius: 2px;
		}
		/* 카드 틀 제거 */
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
</head>
<body>

<div class="container">
<?php include "main_top.php"; ?>

<!-- New Products 제목 -->
<div class="row">
  <div class="col">
    <div class="section-title">New Products</div>
  </div>
</div>

<!-- 상품 출력 -->
<div class="row">
<?php
include "common.php";
$sql = "SELECT * FROM product WHERE icon_new=1 ORDER BY rand() LIMIT 8"; 
$result = mysqli_query($db, $sql);
while ($row = mysqli_fetch_array($result)) { 
	$id = $row['id'];
	$name = $row['name'];
	$image = $row['image1'];
	$price = number_format($row['price']);
	$discount = $row['discount'];
	$sale_price = number_format(round($row['price'] * (100 - $discount) / 100));
	$discount_percent = $discount; 
?>
  <!-- 상품 1 -->
  <div class="col-sm-3 mb-5 text-center">
    <a href="product.php?id=<?=$id?>">
      <img src="product/<?=$image?>" height="306" class="img-fluid mb-2">
    </a>
    <div class="card-title">
      <a href="product.php?id=<?=$id?>" class="text-dark text-decoration-none"><?=$name?></a>
    </div>

    <div class="icon-container mt-1">
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
      <?php if ($row['icon_sale']): ?>
        <small><strike><?=$price?> 원</strike></small>
        <b style="font-size:15px;"> <?=$sale_price?> 원</b>
      <?php else: ?>
        <b style="font-size:15px;"><?=$price?> 원</b>
      <?php endif; ?>
    </div>
  </div>
<?php } ?>
</div>

<?php include "main_bottom.php"; ?>
</div>

</body>
</html>
