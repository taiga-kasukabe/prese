<!DOCTYPE html>
<html lang="ja">
<head>
    <title>簡易診断</title>
    <meta charset="UTF-8">
    <script src="./script.js"></script>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <h1>簡易診断</h1>
    <p>面談相手におすすめの社員を診断します！</p>
    <br><br>
    <div id="main">
        <div id="question_area">
            <div id="q1" class="txt_display">質問A（Yesだと質問Bに、Noだと質問Cに行くよ）</div>
            <div id="q2" class="txt_hide">質問B（Yesだと質問Cに、Noだと質問Dに行くよ）</div>
            <div id="q3" class="txt_hide">質問C（Yesだと質問Dに、Noだと回答Cに行くよ）</div>
            <div id="q4" class="txt_hide">質問D（Yesだと回答Aに、Noだと回答Bに行くよ）</div>
        </div>
        <div id="result_area" class="txt_hide">
            <p>診断結果は、、、</p>
            <div id="a1" class="txt_hide">
                <h2>回答A</h2>
                <p>ひとつめの回答です</p>
            </div>
            <div id="a2" class="txt_hide">
                <h2>回答B</h2>
                <p>ふたつめの回答です</p>
            </div>
            <div id="a3" class="txt_hide">
                <h2>回答C</h2>
                <p>みっつめの回答です</p>
            </div>
            <a href="javaScript:OnAgainClick();">もう1回診断する</a>
        </div>
        <div id="btn_area" class="txt_display">
            <a href="javascript:OnYesClick();" id="btn_yes">Yes</a>
            <a href="javascript:OnNoClick();" id="btn_no">No</a>
        </div>
    </div>
</body>
<html>