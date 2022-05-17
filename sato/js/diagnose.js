// 質問の遷移
// 次に表示する部分のidを指定する配列を定義
var orderArray = ['q1','q2','q3'];
// 現在の配列の要素を意味する変数を定義
var n=0;
// クリックされた部分に用いる関数を定義
function OnClick() {
    // 現在の質問を表す配列の要素をidにもつElementのクラスにis_openがあれば削除，なければ追加する
    document.getElementById(orderArray[n]).classList.toggle('is_open');
    // 表示する要素を次のにする
    n++;
    // 次の質問を表示させる
    document.getElementById(orderArray[n]).classList.toggle('is_open');
}
//.nextというクラスセレクタにマッチする要素をすべて取得し配列にする．
//この配列のすべての項目に対して以下の処理を行う．
Array.from(document.querySelectorAll('.next')).forEach((next) => {
    next.addEventListener('click', OnClick)
  })


//　バリデーションチェック
// .nextに一致する要素（次へボタン）を無効にする．
Array.from(document.querySelectorAll(".next")).forEach((button) => {
    button.disabled = true;
})
// data-q属性を持つ要素にイベントリスナーを設定．
Array.from(document.querySelectorAll("[data-q]")).forEach((input) => {
    input.addEventListener('change', isCheck);
})
// data-q属性を持つ要素にchangeイベントが発生したときの関数を定義
function isCheck(e) {
    // イベントが発生した要素のdata-q属性の値を取得
    const dataQ = e.currentTarget.dataset.q;
    // dataQと同じ値をもつ要素を取得
    const arr_checkBoxes = document.querySelectorAll("[data-q="+dataQ+"]");
    // 要素の数だけループを回して，chckedになっている要素の数を数える
    var count = 0;
    for (var i=0; i<arr_checkBoxes.length; i++) {
        if(arr_checkBoxes[i].checked) {
            count++;
        }
    }
    if (count > 0) {
        // １以上あれば，dataQと同じ値をdata-bottun属性にもつボタンを有効にする．
        Array.from(document.querySelectorAll(".next")).forEach((button) => {
            if(button.getAttribute("data-button") === dataQ){
                button.disabled = false;
            }
        })
    } else {
        // １つもなければ，dataQと同じ値をdata-bottun属性にもつボタンを有効にする．
        Array.from(document.querySelectorAll(".next")).forEach((button) => {
            if(button.getAttribute("data-button") === dataQ){
                button.disabled = true;
            }
        })
    }
}

// function stateHandle(e) {
//     const dataQ = e.currentTarget.dataset.q;
//     Array.from(document.querySelectorAll(".next")).forEach((button) => {
//         if(button.getAttribute("data-button") === dataQ){
//             button.disabled = false;
//         }
//     })  
// }
