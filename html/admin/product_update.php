<?php
include "../common.php";

$id       = $_POST["id"];
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

$image1 = $_POST["imagename1"];
$image2 = $_POST["imagename2"];
$image3 = $_POST["imagename3"];

// 이미지 삭제 체크
if (isset($_POST["checkno1"]) && $image1) {
    unlink("../product/$image1");
    $image1 = "";
}
if (isset($_POST["checkno2"]) && $image2) {
    unlink("../product/$image2");
    $image2 = "";
}
if (isset($_POST["checkno3"]) && $image3) {
    unlink("../product/$image3");
    $image3 = "";
}

// 업로드된 새 이미지 처리
if ($_FILES["image1"]["error"] == 0) {
    $image1 = basename($_FILES["image1"]["name"]);
    move_uploaded_file($_FILES["image1"]["tmp_name"], "../product/$image1");
}
if ($_FILES["image2"]["error"] == 0) {
    $image2 = basename($_FILES["image2"]["name"]);
    move_uploaded_file($_FILES["image2"]["tmp_name"], "../product/$image2");
}
if ($_FILES["image3"]["error"] == 0) {
    $image3 = basename($_FILES["image3"]["name"]);
    move_uploaded_file($_FILES["image3"]["tmp_name"], "../product/$image3");
}

// SQL 업데이트
$sql = "UPDATE product SET 
    menu=$menu, code='$code', name='$name', coname='$coname', price=$price,
    opt1=$opt1, opt2=$opt2, contents='$contents', status=$status,
    icon_new=$icon_new, icon_hit=$icon_hit, icon_sale=$icon_sale,
    discount=$discount, regday='$regday',
    image1='$image1', image2='$image2', image3='$image3'
    WHERE id=$id";

$result = mysqli_query($db, $sql);
if (!$result) {
    echo "<p><b>SQL 에러:</b> $sql</p>";
    exit("수정 중 오류가 발생했습니다.");
}

echo("<script>location.href='product.php'</script>");
?>
