// 質問のidを要素に持つ配列
var qArray = ['q1','q2','q3','q4'];
// 質問にYesと答えたときの遷移先のidを要素に持つ配列
var yesArray = ['q2','q3','q4','a1'];
// 質問にNoと答えたときの遷移先のidを要素に持つ配列
var noArray = ['q3','q4','a3','a2'];
// 現在の質問番号を示す変数。初期値はゼロ（＝1つ目の質問からスタート）
var n=0;

// 引数をyesArray[n]として関数RewriteSrcを実行する関数、OnYesClickを定義する
// （＝Yesと答えたときの遷移先を次の遷移先として関数を実行する）
function OnYesClick() {
    RewriteSrc(yesArray[n])
}

// 引数をnoArray[n]として関数RewriteSrcを実行する関数、OnNoClickを定義する
// （＝Noと答えたときの遷移先を次の遷移先として関数を実行する）
function OnNoClick() {
    RewriteSrc(noArray[n])
}
//  引数をnextIdとして関数RewriteSrcを定義する
function RewriteSrc(nextId) {
    // 与えられた引数（遷移先を示すid）が"q"から始まる（＝遷移先が質問）の場合
    if (nextId.startsWith('q')==true){
        // 全ての質問に対してループを回す
        for (i=0; i<qArray.length+1; i++) {
            // 質問を示すidが遷移先を表すidと一致した場合
            if (qArray[i]==nextId) {
                // 現在の質問を表すidをもつ要素のクラスをtxt_hideに設定する
                document.getElementById(qArray[n]).className = "txt_hide";
                // 現在の質問を示す変数nを遷移先の質問に変更する
                n=i;
                // 次の質問を表すidを持つ要素のクラスをtxt_displayに設定する
                document.getElementById(qArray[n]).className = "txt_display";
                // ループ終了
                break;
            }
        }
    // 遷移先を示すidが"q"から始まらない（＝遷移先が診断結果）の場合
    } else {
        // 現在の質問を表すidをもつ要素のクラスをtxt_hideに設定する
        document.getElementById(qArray[n]).className = "txt_hide";
        // btn_areaをidにもつ要素のクラスをtxt_hideに設定する
        document.getElementById('btn_area').className = "txt_hide";
        // result_areaをidにもつ要素のクラスをtxt_displayに設定する
        document.getElementById('result_area').className = "txt_display";
        // 遷移先を示すnextIdをidにもつ要素のクラスをtxt_displayに設定する
        document.getElementById(nextId).className = "txt_display";
    }
}

function OnAgainClick() {
    document.getElementById(yesArray[n]).className = "txt_hide";
    document.getElementById(noArray[n]).className = "txt_hide";
    n=0;
    document.getElementById(qArray[n]).className = "txt_display";
    document.getElementById('btn_area').className = "txt_display";
    document.getElementById('result_area').className = "txt_hide";
}