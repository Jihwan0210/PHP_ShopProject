<?php
include "common.php";

// 쿠키에서 장바구니 데이터 복원
$cart = isset($_COOKIE["cart"]) ? unserialize($_COOKIE["cart"]) : [];
$n_cart = isset($_COOKIE["n_cart"]) ? $_COOKIE["n_cart"] : 0;
$sum = 0;
$baesongbi = 2500;
?>

<!doctype html>
<html lang="kr">
<head>
  <meta charset="utf-8">
  <title>INDUK Mall</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/my.css" rel="stylesheet">
  <script src="js/jquery-3.7.1.min.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container">
<?php include "main_top.php"; ?>

<script>
function cart_edit(kind, pos) {
  if (kind === "deleteall") location.href = "cart_edit.php?kind=deleteall";
  else if (kind === "delete") location.href = "cart_edit.php?kind=delete&pos=" + pos;
  else if (kind === "update") {
    var num = document.forms["form2"]["num" + pos].value;
    location.href = "cart_edit.php?kind=update&pos=" + pos + "&num=" + num;
  }
}
</script>

<form name="form2" method="post" action="">
<div class="row m-3 mb-0">
  <div class="col" align="center">
    <h4 class="my-3">장바구니</h4>
    <hr class="m-0">

    <table class="table table-sm mb-5">
      <tr class="bg-light" height="40">
        <td width="10%">이미지</td>
        <td width="35%">상품정보</td>
        <td width="10%">판매가</td>
        <td width="20%">수량</td>
        <td width="10%">금액</td>
        <td width="10%">삭제</td>
      </tr>

<?php
$hasProduct = false;

for ($i = 0; $i < $n_cart; $i++) {
    if (!$cart[$i]) continue;

    $hasProduct = true;
    list($id, $num, $opts1, $opts2) = explode("^", $cart[$i]);

    if ($opts1 == "") $opts1 = 0;
    if ($opts2 == "") $opts2 = 0;

    $result = mysqli_query($db, "SELECT * FROM product WHERE id=$id");
    if (!$result) continue;
    $row = mysqli_fetch_array($result);

    $opt1_name = "";
    $opt2_name = "";

    if ($opts1 != 0) {
        $res_opt1 = mysqli_query($db, "SELECT name FROM opts WHERE id = $opts1");
        if ($res_opt1) {
            $row_opt1 = mysqli_fetch_array($res_opt1);
            $opt1_name = $row_opt1["name"] ?? "";
        }
    }
    if ($opts2 != 0) {
        $res_opt2 = mysqli_query($db, "SELECT name FROM opts WHERE id = $opts2");
        if ($res_opt2) {
            $row_opt2 = mysqli_fetch_array($res_opt2);
            $opt2_name = $row_opt2["name"] ?? "";
        }
    }

    $price = $row["price"];
    $discount = $row["discount"];
    if ($row["icon_sale"] == 1 && $discount > 0) {
        $price = round($price * (100 - $discount) / 100, -2);
    }

    $total = $price * $num;
    $sum += $total;

    echo "<tr height='85' style='font-size:14px;'>";
    echo "<td><a href='product.php?id={$id}'><img src='product/{$row['image1']}' width='60' height='70'></a></td>";
    echo "<td align='left' valign='middle'>
            <a href='product.php?id={$id}' style='color:#0066CC'>{$row['name']}</a><br>
            <small><b>[옵션]</b> {$opt1_name} &nbsp; {$opt2_name}</small>
          </td>";
    echo "<td>" . number_format($price) . "</td>";
    echo "<td>
            <div class='d-inline-flex'>
              <input type='text' name='num{$i}' size='2' value='{$num}' class='form-control form-control-sm text-center'>
            </div>
            <a href=\"javascript:cart_edit('update','{$i}')\" class='btn btn-sm mybutton mb-1' style='color:#0066CC'>수정</a>
          </td>";
    echo "<td>" . number_format($total) . "</td>";
    echo "<td><a href=\"javascript:cart_edit('delete','{$i}')\" class='btn btn-sm mybutton' style='color:#D06404'>삭제</a></td>";
    echo "</tr>";
}

if (!$hasProduct) {
    echo "<tr height='100'><td colspan='6' align='center' style='font-size:15px; color:#999;'>장바구니에 상품을 담아주세요.</td></tr>";
}

if ($sum >= 50000) {
    $baesongbi = 0;
}

if ($hasProduct) {
    echo "<tr height='40' align='right' class='bg-light' style='font-size:14px;'>";
    echo "<td width='10%' align='center'><img src='images/cart_image1.gif' border='0'></td>";
    echo "<td width='90%' colspan='5' class='pe-4'>
            <font color='#0066CC'>총 합계금액</font> :
            상품구매금액( " . number_format($sum) . " ) + 배송비( " . number_format($baesongbi) . " )
            = <font style='font-size:16px'><b>" . number_format($sum + $baesongbi) . "</b></font>
          </td>";
    echo "</tr>";
}
?>

    </table>

<?php if ($hasProduct): ?>
    <a href="index.html" class="btn btn-sm btn-outline-secondary mx-1">계속 쇼핑하기</a>
    <a href="javascript:cart_edit('deleteall',0)" class="btn btn-sm btn-outline-secondary mx-1">장바구니 비우기</a>
    <a href="order.php" class="btn btn-sm btn-dark text-white mx-1">결제하기</a>
<?php endif; ?>
  </div>
</div>
</form>

<?php include "main_bottom.php"; ?>
</div>
</body>
</html>
