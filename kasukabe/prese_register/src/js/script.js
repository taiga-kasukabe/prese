window.addEventListener('DOMContentLoaded', function () {
    // 戻るボタンを制御
    history.pushState(null, null, location.href);
    window.addEventListener('popstate', (e) => {
        history.go(1);
    });
});

//jQuery