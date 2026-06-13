<?php
include "../common.php";

// 전달받은 값
$id = $_GET['id'] ?? '';
$state = $_GET['state'] ?? '';
$page = $_GET['page'] ?? 1;

// 검색 필터 값 (되돌아갈 때 사용)
$sel1 = $_GET['sel1'] ?? '';
$sel2 = $_GET['sel2'] ?? '';
$text1 = $_GET['text1'] ?? '';
$day1 = $_GET['day1'] ?? '';
$day2 = $_GET['day2'] ?? '';

// 유효성 검사
if (!$id || !$state) {
    echo "<script>alert('잘못된 접근입니다.'); history.back();</script>";
    exit;
}

// 주문 상태 업데이트
$query = "UPDATE jumun SET state = ? WHERE id = ?";
$stmt = mysqli_prepare($db, $query);
mysqli_stmt_bind_param($stmt, "ii", $state, $id);
mysqli_stmt_execute($stmt);

// 완료 후 목록 페이지로 리디렉션 (필터 유지)
$url = "jumun.php?page=$page&sel1=$sel1&sel2=$sel2&text1=$text1&day1=$day1&day2=$day2";
echo "<script>location.href='$url';</script>";
?>
