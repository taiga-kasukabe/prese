window.addEventListener('DOMContentLoaded', function (e) {
    var btn = document.querySelector('#btn');
    btn.style.backgroundColor = 'red';
    btn.dataset['color'] = 'red';
    btn.addEventListener('click', function () {
        switch (btn.dataset['color']) {
            case 'red':
                btn.style.backgroundColor = 'green';
                btn.dataset['color'] = 'green';
                btn.querySelector('span').textContent = 'b';
                break;
            default:
                btn.style.backgroundColor = 'red';
                btn.dataset['color'] = 'red';
                btn.querySelector('span').textContent = 'a';
                break;
        }
    });
});

//jQuery
$(function() {
    $('.choice').on('click', function() {
        var $selected = $(this);
        $selected.toggleClass('selected');
    })
})