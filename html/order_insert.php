<?php
include "common.php";
error_reporting(E_ALL);
ini_set("display_errors", 1);

// 장바구니 쿠키 복원
$cart = isset($_COOKIE["cart"]) ? unserialize($_COOKIE["cart"]) : [];
$n_cart = isset($_COOKIE["n_cart"]) ? $_COOKIE["n_cart"] : 0;

// 주문번호 생성
$today_short = date("ymd");
$sql = "SELECT MAX(jumun_id) as max_id FROM jumuns WHERE LEFT(jumun_id,6) = '$today_short'";
$result = mysqli_query($db, $sql);
$row = mysqli_fetch_array($result);
if ($row["max_id"]) {
    $count = substr($row["max_id"], 6, 4) + 1;
    $jumun_id = $today_short . sprintf("%04d", $count);
} else {
    $jumun_id = $today_short . "0001";
}

// 초기화
$sum = 0;
$product_names_arr = [];
$product_nums = 0;

for ($i = 0; $i < $n_cart; $i++) {
    if (!empty($cart[$i])) {
        list($product_id, $num, $opts1, $opts2) = explode("^", $cart[$i]);

        $sql = "SELECT * FROM product WHERE id = $product_id";
        $result = mysqli_query($db, $sql);
        $row = mysqli_fetch_array($result);

        $price = $row["price"];
        $discount = $row["discount"];
        $dc = $price * (100 - $discount) / 100;
        $total = $dc * $num;

        $opts1 = is_numeric($opts1) ? $opts1 : 0;
        $opts2 = is_numeric($opts2) ? $opts2 : 0;

        $sql = "INSERT INTO jumuns (jumun_id, product_id, num, price, prices, discount, opts_id1, opts_id2)
                VALUES ('$jumun_id', $product_id, $num, $price, $total, $discount, $opts1, $opts2)";
        mysqli_query($db, $sql);

        $sum += $total;
        $product_nums++;
        $product_names_arr[] = $row["name"];
    }
}

// 배송비
$baesongbi = isset($_POST["baesong"]) ? (int)$_POST["baesong"] : 0;
$sum += $baesongbi;

if ($baesongbi > 0 && $sum - $baesongbi < 50000) {
    $sql = "INSERT INTO jumuns (jumun_id, product_id, num, price, prices, discount, opts_id1, opts_id2)
            VALUES ('$jumun_id', 0, 1, $baesongbi, $baesongbi, 0, 0, 0)";
    mysqli_query($db, $sql);
}

// 회원 여부
$member_id = $_COOKIE["cookie_id"] ?? "0";

// 주문자 정보
$o_name  = mysqli_real_escape_string($db, $_POST["o_name"] ?? "");
$o_tel = preg_replace("/[^0-9]/", "", ($_POST["o_tel1"] ?? "") . ($_POST["o_tel2"] ?? "") . ($_POST["o_tel3"] ?? ""));
$o_email = mysqli_real_escape_string($db, $_POST["o_email"] ?? "");
$o_zip   = mysqli_real_escape_string($db, $_POST["o_zip"] ?? "");
$o_juso  = mysqli_real_escape_string($db, $_POST["o_juso"] ?? "");

// 수령자 정보
$r_name  = mysqli_real_escape_string($db, $_POST["r_name"] ?? "");
$r_tel = preg_replace("/[^0-9]/", "", ($_POST["r_tel1"] ?? "") . ($_POST["r_tel2"] ?? "") . ($_POST["r_tel3"] ?? ""));
$r_email = mysqli_real_escape_string($db, $_POST["r_email"] ?? "");
$r_zip   = mysqli_real_escape_string($db, $_POST["r_zip"] ?? "");
$r_juso  = mysqli_real_escape_string($db, $_POST["r_juso"] ?? "");
$memo    = mysqli_real_escape_string($db, $_POST["memo"] ?? "");

// 결제 정보
$pay_kind    = isset($_POST["pay_kind"]) ? (int)$_POST["pay_kind"] : 0;
$card_no1    = $_POST["card_no1"] ?? "";
$card_no2    = $_POST["card_no2"] ?? "";
$card_no3    = $_POST["card_no3"] ?? "";
$card_no4    = $_POST["card_no4"] ?? "";
$card_okno   = mysqli_real_escape_string($db, $card_no1 . $card_no2 . $card_no3 . $card_no4);

$card_halbu  = isset($_POST["card_halbu"]) ? (int)$_POST["card_halbu"] : 0;
$card_kind   = isset($_POST["card_kind"]) ? (int)$_POST["card_kind"] : 0;
$bank_kind   = isset($_POST["bank_kind"]) ? (int)$_POST["bank_kind"] : 0;
$bank_sender = mysqli_real_escape_string($db, $_POST["bank_sender"] ?? "");

// 상품 이름 문자열
$product_names = mysqli_real_escape_string($db, implode(", ", $product_names_arr));

// 주문 저장
$sql = "INSERT INTO jumun (
    id, member_id, jumunday,
    product_names, product_nums,
    o_name, o_tel, o_email, o_zip, o_juso,
    r_name, r_tel, r_email, r_zip, r_juso, memo,
    pay_kind, card_okno, card_halbu, card_kind,
    bank_kind, bank_sender, totalprice, state
) VALUES (
    '$jumun_id', '$member_id', NOW(),
    '$product_names', $product_nums,
    '$o_name', '$o_tel', '$o_email', '$o_zip', '$o_juso',
    '$r_name', '$r_tel', '$r_email', '$r_zip', '$r_juso', '$memo',
    $pay_kind, '$card_okno', $card_halbu, $card_kind,
    $bank_kind, '$bank_sender', $sum, 1
)";
mysqli_query($db, $sql);

// 장바구니 비우기
setcookie("cart", "", time() - 3600, "/");
setcookie("n_cart", "", time() - 3600, "/");

// 완료 페이지 이동
echo "<script>location.href='order_ok.php?jumun_id=$jumun_id';</script>";
?>
