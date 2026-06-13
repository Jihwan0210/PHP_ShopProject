<?php
// 로그아웃할 때도 같은 경로로 쿠키 삭제
setcookie("cookie_id", "", time() - 3600, "/");  
header("Location: main.php");  // 또는 index.html 등 원하는 페이지로 이동
exit;
?>
