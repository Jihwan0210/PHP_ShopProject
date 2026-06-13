<?php
include "../common.php";

$id = $_GET['id'] ?? "";

if ($id) {
    $id = intval($id);
    $query = "DELETE FROM jumun WHERE id = $id";
    $result = mysqli_query($db, $query);

    if ($result) {
        // 삭제 성공 후 메시지 없이 바로 목록으로 이동
        header("Location: jumun.php");
        exit;
    } else {
        echo "<script>alert('삭제 중 오류가 발생했습니다.'); history.back();</script>";
        exit;
    }
} else {
    echo "<script>alert('잘못된 접근입니다.'); history.back();</script>";
    exit;
}
?>
