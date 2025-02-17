const pageLogin = document.getElementById('loginForm');
if (pageLogin) {


    let isSendSms = true;

    function validateMobile(mobile) {
        let regex = /^09\d{9}$/;
        return regex.test(mobile);
    }
    function send_sms() {
        let mobile = document.getElementById('mobile').value;
        if (validateMobile(mobile)) {

            const xhr = new XMLHttpRequest();
            xhr.open('POST', mrsms_js.ajaxurl, true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {

                const response = JSON.parse(xhr.responseText);

                if (xhr.status === 200) {
                    if (response.success) {
                        document.getElementById('mobileForm').style.display = 'none';
                        document.getElementById('codeVerification').style.display = 'block';
                        document.getElementById('resendCode').disabled = true;
                        startTimer();
                        let otpInput = document.getElementById('verificationCode');

                        // اعمال فوکوس روی فیلد
                        otpInput.focus();
                    }
                } else {

                    let loginAlert = document.getElementById('login-alert');

                    loginAlert.classList.remove('d-none');
                    loginAlert.textContent = response.data;
                }
            };
            xhr.send(`action=mrsms_sent_sms&nonce=${mrsms_js.nonce}&mobileNumber=${mobile}`);

        } else {

            let loginAlert = document.getElementById('login-alert');
            isSendSms = true

            loginAlert.classList.remove('d-none');
            loginAlert.textContent = 'شماره موبایل نامعتبر است';

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
        let mobile = document.getElementById('mobile').value;

        let verificationCode = document.getElementById('verificationCode').value;

        const xhr = new XMLHttpRequest();
        xhr.open('POST', mrsms_js.ajaxurl, true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {

            const response = JSON.parse(xhr.responseText);

            if (xhr.status === 200) {
                if (response.success) {
                    location.reload();
                }
            } else {

                let loginAlert = document.getElementById('login-alert');

                loginAlert.classList.remove('d-none');
                loginAlert.textContent = response.data;
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
        .catch(error => console.log('error', error));
}



jQuery(document).ready(function ($) {




})

