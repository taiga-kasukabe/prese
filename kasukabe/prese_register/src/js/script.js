//jQuery
$(function () {
    var nowchecked = $('input[name=radio]:checked').val();
    $('input[name=radio]').click(function () {
        if ($(this).val() == nowchecked) {
            $(this).prop('checked', false);
            nowchecked = false;
        } else {
            nowchecked = $(this).val();
        }
    });
});