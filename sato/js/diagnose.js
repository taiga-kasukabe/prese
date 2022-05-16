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
