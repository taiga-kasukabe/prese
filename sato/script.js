'use strict'
{
    // 要素を取得しつつ定数に入れる？
    const open = document.getElementById('open');
    const close = document.getElementById('close');
    const modal = document.getElementById('modal');
    const mask = document.getElementById('mask');

    // openにクリックイベントを付けてhiddenクラスが外れて表示されるようにする
    open.addEventListener('click', function() {
        modal.classList.remove('hidden');
        mask.classList.remove('hidden');
    });

    // closeにもクリックイベントを付けてhiddenクラスを付与できるようにする
    close.addEventListener('click', function () {
        modal.classList.add('hidden');
        mask.classList.add('hidden');
    });

    // マスク部分を押しても非表示にできたほうが便利なのでmaskにもクリックイベントを付ける
    mask.addEventListener('click', function() {
        modal.classList.add('hidden');
        mask.classList.add('hidden');
    });

}