<?php
session_start();
$weekJa = array("日", "月", "火", "水", "木", "金", "土");

for ($i = 0; $i < count($_GET['editFree']); $i++) {
    list($empid[$i], $time[$i], $date[$i], $weekNum[$i]) = explode(":", $_GET['editFree'][$i]);
}
?>

<h1>以下の日程を空き日程から削除しますか？</h1>
<?php for ($i = 0; $i < count($_GET['editFree']); $i++) { ?>
    <p><?php echo $i + 1 . '. ' . $date[$i] . '(' . $weekJa[$weekNum[$i]] . ') ' . substr_replace($time[$i], ':', 2, 0) . '~' . substr_replace($time[$i] + 100, ':', 2, 0); ?></p>
<?php } ?>

<form action="./editFree.php" method="GET">
    <?php for ($i = 0; $i < count($_GET['editFree']); $i++) { ?>
        <input type="hidden" name="editFree[]" value="<?php echo $_GET['editFree'][$i]; ?>">
    <?php } ?>
    <input type="submit" value="削除">
</form>

<form action="./editFree_form.php" method="get">
    <input type="hidden" name="empid" value="<?php echo $empid[0]; ?>">
    <input type="hidden" name="week" value="0">
    <input type="submit" value="戻る">
</form>