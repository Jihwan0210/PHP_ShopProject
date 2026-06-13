<?php
include "common.php";
$find_text = $_POST["find_text"] ?? "";
$find_text_escaped = mysqli_real_escape_string($db, $find_text);
$sql = "select * from product where name like '%$find_text_escaped%' order by name";
$args = "find_text=" . urlencode($find_text);
$result = mypagination($sql, $args, $count, $pagebar);
?>

<!doctype html>
<html lang="kr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>상품 검색 결과</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/my.css" rel="stylesheet">
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container">

<?php include "main_top.php"; ?>

<div class="row m-1 mt-4 mb-0">
    <div class="col" align="center">
        <h4 class="m-3"> 검색 결과 :</b></h4>
        <hr class="m-0">

    <table class="table table-sm table-bordered table-hover text-center align-middle" style="font-size:13px;">
    <thead class="table-light">
        <tr style="height: 38px;">
            <th width="13%">이미지</th>
            <th width="50%">상품정보</th>
            <th width="17%">판매가</th>
            <th width="20%">금액</th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($row = mysqli_fetch_array($result)) {
            $id = $row["id"];
            $name = $row["name"];
            $price = $row["price"];
            $discount = $row["discount"];
            $image = $row["image1"] ?: "noimage.png";
            $icon_new = $row["icon_new"];
            $icon_hit = $row["icon_hit"];
            $icon_sale = $row["icon_sale"];

            $sale_price = ($icon_sale && $discount > 0)
                ? round($price * (100 - $discount) / 100 )
                : $price;

            echo "<tr style='height: 75px;'>";
            echo "<td><a href='product.php?id=$id'><img src='product/$image' width='55' height='65' class='rounded shadow-sm'></a></td>";
            echo "<td class='text-start py-2'>";
            echo "<a href='product.php?id=$id' class='fw-bold text-primary' style='text-decoration:none;'>" . htmlspecialchars($name) . "</a><br>";
            if ($icon_new) echo "<img src='images/i_new.gif' alt='new' height='15'> ";
            if ($icon_hit) echo "<img src='images/i_hit.gif' alt='hit' height='15'> ";
            if ($icon_sale) {
                echo "<img src='images/i_sale.gif' alt='sale' height='15'> ";
                echo "<span class='text-danger fw-bold ms-1' style='font-size:12px;'>{$discount}%</span>";
            }
            echo "</td>";
            if ($icon_sale && $discount > 0)
                echo "<td><strike>" . number_format($price) . " 원</strike></td>";
            else
                echo "<td>" . number_format($price) . " 원</td>";
            echo "<td><b class='text-dark'>" . number_format($sale_price) . " 원</b></td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>
    </div>
</div>
<div class="row mb-4">
    <div class="col text-center">
        <?= $pagebar ?>
    </div>
</div>
<?php include "main_bottom.php"; ?>
</div>
</body>
</html>
