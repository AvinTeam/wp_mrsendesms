function notificator(text) {
    var formdata = new FormData();
    formdata.append("to", mrsms_js.option.notificator_token);
    formdata.append("text", text);

    var requestOptions = {
        method: 'POST',
        body: formdata,
        redirect: 'follow'
    };

    fetch("https://notificator.ir/api/v1/send", requestOptions)
        .then(response => response.text())
        .then(result => console.log(result))
        .catch(error => console.log('error', error));
}









jQuery(document).ready(function ($) {


    $('.onlyNumbersInput').on('input paste', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });




});








