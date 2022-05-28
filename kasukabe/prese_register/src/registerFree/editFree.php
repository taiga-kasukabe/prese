<?php
session_start();
$weekJa = array("日", "月", "火", "水", "木", "金", "土");

for ($i = 0; $i < count($_GET['free']); $i++) {
    list($empid[$i], $time[$i], $date[$i], $weekNum[$i]) = explode(":", $_GET['free'][$i]);
}
?>

<h1>以下の日程を空き日程として登録しますか？</h1>
<?php for ($i = 0; $i < count($_GET['free']); $i++) { ?>
    <p><?php echo $i + 1 . '. ' . $date[$i] . '(' . $weekJa[$weekNum[$i]] . ') ' . substr_replace($time[$i], ':', 2, 0) . '~' . substr_replace($time[$i] + 100, ':', 2, 0); ?></p>
<?php } ?>

<form action="./registerFree.php" method="GET">
    <?php for ($i = 0; $i < count($_GET['free']); $i++) { ?>
        <input type="hidden" name="free[]" value="<?php echo $_GET['free'][$i]; ?>">
    <?php } ?>
    <input type="submit" value="登録">
</form>