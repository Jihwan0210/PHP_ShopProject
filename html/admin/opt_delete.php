<?php
include "../common.php";

$id = $_REQUEST["id"];

$sql =
"DELETE FROM opt 
 WHERE id = $id";

$result =
    mysqli_query($db, $sql);

if (!$result)
    exit("삭제 실패: $sql");

echo "<script>
location.href='opt.php';
</script>";
?>
