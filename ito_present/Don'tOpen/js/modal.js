// モーダルを開く

//モーダルを開く関数をmodalWrapOpenという名前を付けて定義する
const modalWrapOpen = function (e) {
    //イベントが発生した要素のdata-modal-open属性を読み取ったものをdataModalOpenと定義する．
    //つまり，現在イベントを受け取っている（クリックされている）要素のmodal-○○をdataModalOpenと定義する．
    const dataModalOpen = e.currentTarget.dataset.modalOpen;

    //クラスセレクタ（.worls_modal_wrapper）にマッチする要素をすべて取得したものを配列として生成する．
    //この配列の全ての項目に対して以下の繰り返し処理を行う．
    Array.from(document.querySelectorAll('.works_modal_wrapper')).forEach((e, i) => {

        //配列の要素のdata-modal属性の値とdataModalOpenが一致する場合，
        //つまり，クリックされたworks_modal_openのmodal-○○とworks_modal_wrapperのmodal-○○が一致する場合，
        if (e.getAttribute('data-modal') === dataModalOpen) {
            //配列の要素のクラスにis_openがあれば削除，なければ追加する．
            e.classList.toggle('is_open');
        }
    })
}

//.works_modal_openというクラスセレクタにマッチする要素をすべて取得し配列にする．
//この配列のすべての項目に対して以下の処理を行う．
Array.from(document.querySelectorAll('.works_modal_open')).forEach((modalOpenElement) => {
    //配列の項目がクリックされたとき，modalWrapOpenという関数を実行する
    modalOpenElement.addEventListener('click', modalWrapOpen);
})



//モーダルを閉じる

//モーダルを閉じる関数をmodalCloseActionという名前を付けて定義する
const modalCloseAction = function (e) {
    //現在イベントを受け取っている（クリックされてる）要素から親階層に向かって，指定されたクラスセレクタ（.works_modal_wrapper）に一致する
    //ノードが見つかるまで探索し，一致する要素をtargetModalと定義する．
    //つまり，クリックされたworks_modal_close要素を含んでいるworks_modal_wrapper要素をtargetModalと定義する．
    const targetModal = e.currentTarget.closest('.works_modal_wrapper');
    //targetModalのクラスにis_openがあれば削除，なければ追加する．
    targetModal.classList.toggle('is_open')
};

//.works_modal_closeというクラスセレクタにマッチする要素をすべて取得し配列にする．
//この配列のすべての項目に対して以下の処理を行う．
Array.from(document.querySelectorAll('.works_modal_close')).forEach((modalCloseElement) => {
    //modalCloseElementという要素がクリックされたとき，modalCloseActionという関数を実行する
    modalCloseElement.addEventListener('click', modalCloseAction)
})