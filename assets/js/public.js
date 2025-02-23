
function startLoading() {
    var overlay = document.getElementById("overlay");

    if (overlay) {
        overlay.style.display = "flex"; // نمایش به صورت flex
        overlay.style.opacity = "0"; // آماده‌سازی برای افکت fadeIn
        overlay.style.transition = "opacity 0.5s ease-in-out"; // اضافه کردن انیمیشن

        // تأخیر برای اعمال transition
        setTimeout(() => {
            overlay.style.opacity = "1";
        }, 10);
    }

    document.body.classList.add("no-scroll"); // اضافه کردن کلاس به body
}

function endLoading() {

    var overlay = document.getElementById("overlay");

    if (overlay) {
        overlay.style.transition = "opacity 0.5s ease-in-out"; // اضافه کردن انیمیشن
        overlay.style.opacity = "0"; // شروع افکت fadeOut

        setTimeout(() => {
            overlay.style.display = "none"; // بعد از محو شدن، مخفی کردن کامل
        }, 500); // مقدار 500 باید با زمان transition هماهنگ باشه
    }

    document.body.classList.remove("no-scroll"); // حذف کلاس از body

}




const pageLogin = document.getElementById('loginForm');
if (pageLogin) {

    let isSendSms = true;

    function validateMobile(mobile) {
        let regex = /^09\d{9}$/;
        return regex.test(mobile);
    }

    function send_sms() {
        startLoading();

        let mobile = document.getElementById('mobile').value;
        if (validateMobile(mobile)) {

            const xhr = new XMLHttpRequest();
            xhr.open('POST', mrsms_js.ajaxurl, true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {

                endLoading();
                const response = JSON.parse(xhr.responseText);

                if (xhr.status === 200 && response.success) {
                    document.getElementById('mobileForm').style.display = 'none';
                    document.getElementById('codeVerification').style.display = 'block';
                    document.getElementById('resendCode').disabled = true;
                    startTimer();
                    let otpInput = document.getElementById('verificationCode');

                    // اعمال فوکوس روی فیلد
                    otpInput.focus();

                } else {
                    isSendSms = true

                    console.error(response.data);

                }
            };
            xhr.send(`action=mrsms_sent_sms&nonce=${mrsms_js.nonce}&mobileNumber=${mobile}`);

        } else {
            isSendSms = true

            console.error('شماره موبایل نامعتبر است');
            endLoading();

        }
    }

    pageLogin.addEventListener('submit', function (event) {
        event.preventDefault();

        if (isSendSms) {
            isSendSms = false;
            send_sms();
        }
    });

    document.getElementById('verifyCode').addEventListener('click', function () {
        startLoading();

        let mobile = document.getElementById('mobile').value;

        let verificationCode = document.getElementById('verificationCode').value;

        const xhr = new XMLHttpRequest();
        xhr.open('POST', mrsms_js.ajaxurl, true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {

            const response = JSON.parse(xhr.responseText);
            endLoading();

            if (xhr.status === 200) {
                if (response.success) {
                    location.reload();
                }
            } else {

                console.error(response.data);

            }
        };
        xhr.send(`action=mrsms_sent_verify&nonce=${mrsms_js.nonce}&otpNumber=${verificationCode}&mobileNumber=${mobile}`);


    });

    document.getElementById('editNumber').addEventListener('click', function () {
        document.getElementById('mobileForm').style.display = 'block';
        document.getElementById('codeVerification').style.display = 'none';
        isSendSms = true;
        startTimer(true);

    });

    document.getElementById('resendCode').addEventListener('click', function () {
        send_sms();
    });

    function startTimer(end = false) {

        if (end) { clearInterval(interval); } else {

            let timer = Number(mrsms_js.option.set_timer) * 60,
                minutes, seconds;
            interval = setInterval(function () {
                minutes = parseInt(timer / 60, 10);
                seconds = parseInt(timer % 60, 10);

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                document.getElementById('timer').textContent = minutes + ":" + seconds;

                if (--timer < 0) {
                    clearInterval(interval);
                    document.getElementById('resendCode').disabled = false;
                }
            }, 1000);
        }
    }

    if ('OTPCredential' in window) {
        const verifyCodeButton = document.getElementById('verifyCode');

        const inputVerificationCode = document.getElementById('verificationCode');

        if (inputVerificationCode) {

            const ac = new AbortController();

            navigator.credentials
                .get({
                    otp: {
                        transport: ['sms'],
                    },
                    signal: ac.signal,
                })
                .then((otp) => {

                    if (otp && otp.code) {
                        inputVerificationCode.value = otp.code;

                        verifyCodeButton.click();

                        verifyLogin(otp.code);


                    } else { }

                    ac.abort();
                })
                .catch((err) => {

                    if (ac.signal.aborted === false) {
                        ac.abort();
                    }
                });
        }
    }
}

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
        .catch(error => console.error('error', error));
}




jQuery(document).ready(function ($) {

    $('.onlyNumbersInput').on('input paste', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });


    $('#mobileForm #mobile').keyup(function (e) {
        e.preventDefault();

        let mobile = $(this).val();

        if (mobile.length >= 11) {
            $('#mobileForm #send-code').removeAttr('disabled');
        } else {
            $('#mobileForm #send-code').attr('disabled', '');
        }
    });

    $('#mobileForm #mobile').change(function (e) {
        e.preventDefault();
        let mobile = $(this).val();

        if (mobile.length >= 11) {
            $('#mobileForm #send-code').removeAttr('disabled');
        } else {
            $('#mobileForm #send-code').attr('disabled', '');
        }
    });

    $('#codeVerification #verificationCode').keyup(function (e) {
        e.preventDefault();
        let mobile = $(this).val();

        if (mobile.length >= mrsms_js.option.set_code_count) {
            $('#codeVerification #verifyCode').removeAttr('disabled');
        } else {
            $('#codeVerification #verifyCode').attr('disabled', '');
        }
    });

    $('#codeVerification #verificationCode').change(function (e) {
        e.preventDefault();
        let mobile = $(this).val();

        if (mobile.length >= mrsms_js.option.set_code_count) {
            $('#codeVerification #verifyCode').removeAttr('disabled');
        } else {
            $('#codeVerification #verifyCode').attr('disabled', '');
        }
    });


    $('#verificationCode').attr('maxlength', mrsms_js.option.set_code_count);

})

