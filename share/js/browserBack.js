//画面初期表示時に遷移先nullの履歴を追加する
history.pushState(null, null, null);

//ブラウザの戻る／すすむボタンで発火するイベント
window.onpopstate = function (event) {
    //戻るボタンを押して戻った時に再度nullの履歴を追加する。
    //※この処理はalertの前に書いておく必要あり。alertの後ろだと戻るボタンを連打したときに戻れてしまう。
    history.pushState(null, null, null);
    alert("ブラウザの戻るボタンは禁止されています。");
};

