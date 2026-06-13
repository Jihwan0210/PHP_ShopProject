<?php
include "common.php";

// 쿠키 복원
$cart = isset($_COOKIE["cart"]) ? unserialize($_COOKIE["cart"]) : [];
$n_cart = isset($_COOKIE["n_cart"]) ? $_COOKIE["n_cart"] : 0;

$kind = $_REQUEST["kind"];

// 바로 구매 시 기존 cart 초기화
if ($kind == "order") {
    $cart = [];
    $n_cart = 0;
}

if ($kind == "insert") {
    $id = $_REQUEST["id"];
    $num = $_REQUEST["num"];
    $opts1 = $_REQUEST["opts1"];
    $opts2 = $_REQUEST["opts2"];

    $found = false;
    for ($i = 0; $i < $n_cart; $i++) {
        if (!$cart[$i]) continue;
        list($cid, $cnum, $copts1, $copts2) = explode("^", $cart[$i]);

        if ($cid == $id && $copts1 == $opts1 && $copts2 == $opts2) {
            $cnum += $num;  // 수량 증가
            $cart[$i] = "$id^$cnum^$opts1^$opts2";
            $found = true;
            break;
        }
    }

    if (!$found) {
        $cart[$n_cart] = "$id^$num^$opts1^$opts2";
        $n_cart++;
    }
}

if ($kind == "delete") {
    $pos = $_REQUEST["pos"];
    $cart[$pos] = ""; // 삭제 처리
}

if ($kind == "update") {
    $pos = $_REQUEST["pos"];
    $num = $_REQUEST["num"];
    list($id, , $opts1, $opts2) = explode("^", $cart[$pos]);
    $cart[$pos] = "$id^$num^$opts1^$opts2"; // 수량만 갱신
}

if ($kind == "deleteall") {
    $cart = [];
    $n_cart = 0;
}

// 쿠키 저장
setcookie("cart", serialize($cart), time() + 3600, "/");
setcookie("n_cart", $n_cart, time() + 3600, "/");

if ($kind == "order") {
    echo("<script>location.href='order.php'</script>");
} else {
    echo("<script>location.href='cart.php'</script>");
}
?>
