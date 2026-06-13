<?php
include "../common.php";

$name = $_REQUEST["name"];

$sql =
"INSERT INTO opt (name)
 VALUES('$name')";

$result =
    mysqli_query($db, $sql);

if (! $result)
    exit("에러 발생! <br>질문: $sql");

echo "<script>
location.href='opt.php';
</script>";
?>
