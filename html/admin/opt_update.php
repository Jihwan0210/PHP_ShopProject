<?php
include "../common.php";

$optNum = $_REQUEST["id"];
$optName = $_REQUEST["name"];
$query = "UPDATE opt SET name = '$optName' WHERE id = $optNum";
$exec = mysqli_query($db, $query);
if (!$exec) {
    exit("업데이트 실패<br>SQL: $query");
}
echo "<script>location.href='opt.php';</script>";
?>
