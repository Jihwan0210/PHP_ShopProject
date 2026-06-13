<?php
include "../common.php";

// 입력값 보안 처리
$menu     = $_POST["menu"];
$code     = mysqli_real_escape_string($db, $_POST["code"]);
$name     = mysqli_real_escape_string($db, $_POST["name"]);
$coname   = mysqli_real_escape_string($db, $_POST["coname"]);
$price    = $_POST["price"];
$opt1     = $_POST["opt1"];
$opt2     = $_POST["opt2"];
$contents = mysqli_real_escape_string($db, $_POST["contents"]);
$status   = $_POST["status"];
$icon_new  = isset($_POST["icon_new"]) ? 1 : 0;
$icon_hit  = isset($_POST["icon_hit"]) ? 1 : 0;
$icon_sale = isset($_POST["icon_sale"]) ? 1 : 0;
$discount  = $_POST["discount"];
$regday    = $_POST["regday"];

// 이미지 업로드
$pic1 = "";
$pic2 = "";
$pic3 = "";

if ($_FILES["image1"]["error"] == 0) {
    $pic1 = basename($_FILES["image1"]["name"]);
    move_uploaded_file($_FILES["image1"]["tmp_name"], "../product/$pic1");
}
if ($_FILES["image2"]["error"] == 0) {
    $pic2 = basename($_FILES["image2"]["name"]);
    move_uploaded_file($_FILES["image2"]["tmp_name"], "../product/$pic2");
}
if ($_FILES["image3"]["error"] == 0) {
    $pic3 = basename($_FILES["image3"]["name"]);
    move_uploaded_file($_FILES["image3"]["tmp_name"], "../product/$pic3");
}

// SQL 저장
$sql = "INSERT INTO product (menu, code, name, coname, price, opt1, opt2, contents, status,
            icon_new, icon_hit, icon_sale, discount, regday, image1, image2, image3)
        VALUES ($menu, '$code', '$name', '$coname', $price, $opt1, $opt2, '$contents', $status,
            $icon_new, $icon_hit, $icon_sale, $discount, '$regday', '$pic1', '$pic2', '$pic3')";

$result = mysqli_query($db, $sql);
if (!$result) {
    echo "<p><b>SQL 에러:</b> $sql</p>";
    exit("등록 중 오류가 발생했습니다.");
}

echo("<script>location.href='product.php';</script>");
?>
