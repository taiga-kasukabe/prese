<link rel="stylesheet" href="./css/popup.css">

<?php
session_start();

// 変数定義
include('../conf/db_conf.php');
$employee = array();
$temp = 0;

if (!empty($_POST)) {
    $temp = $_POST['emp_num'];
}
$_POST = array(); //初期化
var_dump($temp);

try {
    $options = array(
        // SQL実行失敗時には例外をスローしてくれる
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        // カラム名をキーとする連想配列で取得する．これが一番ポピュラーな設定
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        // バッファードクエリを使う(一度に結果セットをすべて取得し、サーバー負荷を軽減)
        // SELECTで得た結果に対してもrowCountメソッドを使えるようにする
        PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
    );
    $dbh = new PDO($dsn, $db_username, $db_password, $options);
} catch (PDOException $e) {
    $msg = $e->getMessage();
}
$id = $_SESSION['id'];

$sql = "SELECT * FROM users_table WHERE id = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':id', $id);
$stmt->execute();
$member = $stmt->fetch();

$sql = "SELECT * FROM empDB";
$stmt = $dbh->prepare($sql);
$stmt->execute();
$employee = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!-- ここからページ表示 -->
<p>こんにちは，<?php echo $member['username']; ?>さん</p>

<a href="./mypage.php">マイページへ</a><br>
<a href="./diagnose_form.php">簡易診断へ</a>

<h2>
    社員リスト
</h2>

<div>
    <!-- 社員数だけループ -->
    <?php for ($n = 0; $n < count($employee); $n++) { ?>
        <h3><?php echo $employee[$n]['empname']; ?></h3>
        <img src="../images/<?php echo $employee[$n]['empimg_id']; ?>" alt="社員画像" height="300">
        <p>年次：<?php echo $employee[$n]['empyear']; ?>年目</p>
        <p>役職：<?php echo $employee[$n]['empjob']; ?></p>
        <p>職種：<?php echo $employee[$n]['empcareer']; ?></p>
        <form name="myForm" method="POST">
            <input type="hidden" name="emp_num" value="<?php echo $n; ?>">
            <input type="submit" value="詳細はこちこち">
        </form>

        <!-- <input type="button" value="詳細はこちら" onclick="return modal_onclick_open()"> -->
    <?php } ?>
</div>
<h2>社員リストはここまで</h2>


<!-- popup -->
<script type="text/javascript">
    function modal_onclick_open() {

        // ポップアップ表示
        document.getElementById('modal-content').style.display = "block";
        document.getElementById('modal-overlay').style.display = "block";

        return false;
    }

    function modal_onclick_close() {
        document.getElementById("modal-content").style.display = "none";
        document.getElementById("modal-overlay").style.display = "none";
    }

    const myFormElm = document.forms.myForm; // フォーム要素を取得

    myFormElm.addEventListener('submit', (e) => { // 送信ボタンが押されたら実行
        e.preventDefault();
        modal_onclick_open(); //popupウインドウ表示
        console.log("ウインドウON");
        const formData = new FormData(myFormElm); // フォームオブジェクト作成

        fetch('home.php', { // 第1引数に送り先
                method: 'POST', // メソッド指定
                // Content-Typeは指定しない
                body: formData // bodyにそのまま添付
            })
            .then(response => response.json()) // 返ってきたレスポンスをjsonで受け取って次のthenへ渡す
            .then(res => {
                console.log(res); // やりたい処理
            })
            .catch(error => {
                console.log(error); // エラー表示
            });
    });
</script>

<!-- モーダルウィンドウここから -->
<!-- 一番上に表示されるモーダルウィンドウ -->
<div id="modal-content">
    <h3><?php echo $employee[$temp]['empname']; ?></h3>
    <img src="../images/<?php echo $employee[$temp]['empimg_id']; ?>" alt="社員画像" height="300">
    <p>年次：<?php echo $employee[$temp]['empyear']; ?>年目</p>
    <p>役職：<?php echo $employee[$temp]['empjob']; ?></p>
    <p>職種：<?php echo $employee[$temp]['empcareer']; ?></p>
    <p>趣味：<?php echo $employee[$temp]['emphobby']; ?></p>
    <!-- 社員同士の区切りは改行2つ -->
    <input type="button" value="閉じる" onclick="modal_onclick_close()">
</div>
<!-- 2番目に表示されるモーダル（オーバーウェイ）半透明な膜 -->
<div id="modal-overlay"></div>
<!-- モーダルウィンドウここまで -->