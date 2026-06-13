<?php
include "../common.php";

// ID 정수형으로 안전하게 변환
$id = intval($_REQUEST["id"]);

// 이미지 파일명 조회
$query = "SELECT image1, image2, image3 FROM product WHERE id = $id";
$result = mysqli_query($db, $query);
if (!$result) exit("쿼리 오류: $query");

$row = mysqli_fetch_array($result);

// 이미지 파일 삭제
foreach (["image1", "image2", "image3"] as $imgField) {
    if (!empty($row[$imgField])) {
        $filepath = "../product/" . $row[$imgField];
        if (file_exists($filepath)) {
            unlink($filepath);
        }
    }
}

// 제품 레코드 삭제
$sql = "DELETE FROM product WHERE id = $id";
$result = mysqli_query($db, $sql);
if (!$result) {
    echo "<p><b>SQL 에러:</b> $sql</p>";
    exit("삭제 중 오류 발생");
}

// 삭제 후 목록 페이지로 이동
echo("<script>location.href='product.php';</script>");
?>
