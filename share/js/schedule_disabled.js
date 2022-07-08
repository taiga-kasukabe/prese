// submit_btnというidを持つ要素をdisabledにする
const submit_btn = document.getElementById('submit_btn');
submit_btn.disabled = true;

// inputのtype属性がcheckboxの要素にイベントリスナーを設定
Array.from(document.querySelectorAll("#checkbox")).forEach((checkbox) => {
    checkbox.addEventListener('change', isCheck);
})

// id=checkboxの要素にchangeイベントが発生したときの関数(isCheck)を定義
function isCheck() {
    // id=checkboxの要素をすべて取得
    const arr_input = document.querySelectorAll("#checkbox");

    // 要素の数だけループを回してcheckedになっている要素の数を数える
    var count = 0;
    for (var i=0; i<arr_input.length; i++) {
        if(arr_input[i].checked) {
            count++;
        }
    }
    // 1つ以上あれば，submit_btnを有効にする．
    if (count > 0) {
        submit_btn.disabled = false;
    } else {
        // 1つもなければ，submit_btnを有効にする．
        submit_btn.disabled = true;
    }
}