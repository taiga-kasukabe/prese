const mailCopy = function(e) {
    const dataMailCopy = e.currentTarget.dataset.mailCopy;

    Array.from(document.querySelectorAll('.copy-text')).forEach((e, i) => {
        if(e.getAttribute('data-mail') === dataMailCopy) {
            let copyText = e.textContent;
            navigator.clipboard.writeText(copyText).then(() => {
                // true
                const btn = document.querySelector('[data-mail-copy="'+dataMailCopy+'"]');
                btn.textContent = 'コピーしました';
                }, () => {
                // false
                alert("コピーできていません");
                });
        }
    })
}

Array.from(document.querySelectorAll('.copy-btn')).forEach((copyBtn) => {
    copyBtn.addEventListener('click', mailCopy);
})