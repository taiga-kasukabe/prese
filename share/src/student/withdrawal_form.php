<!--退会フォーム-->
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>退会</title>
</head>

<div>
    <h2>退会する場合にはこちらのボタンをクリック<h2>
            <button type="button" id="btn">退会</button>
            <script type="text/javascript">
                let btn = document.getElementById('btn');
                btn.addEventListener('click', function() {
                    let result = window.confirm('本当に退会しますか？');

                    if (result) {
                        window.location.href = "./withdrawal.php";
                    } else {
                        alert("キャンセルしました");
                    }
                });
            </script>
            <p><a href="./mypage.php">戻る</a></p>
</div>