@extends('layouts.admin-auth')
@section('content')
    @push('css')
        <style>
            .fxt-content {
                background: #12970b !important;
            }

            .fxt-header p {
                color: #fff !important;
            }
        </style>
    @endpush
    <div id="resetPasswordForm" class="row align-items-center justify-content-center">
        <div class="col-xl-6 col-lg-7 col-sm-12 col-12 fxt-bg-color" style="border-radius: 15px;">
            <div class="ms-bar-login"style="z-index:99;">
                <div></div>
            </div>
            <div class="fxt-content ms-blur-bg" style="border-radius: 15px;">
                <div class="fxt-header">
                    <a href="#" class="fxt-logo"><img class="m-auto" src="{{ asset('logo.jpg') }}" alt="Logo"
                            style="width: 150px;"></a>
                </div>
                <div class="fxt-form">
                    <div class="card" style="border: none;">
                        <div class="card-body">
                            <p style="font-size: 22px;">Reset Password</p>
                            <strong> Verification code has been sent.</strong>
                            <br> <br>
                            <div class="alert alert-success" style="background-color:#00ff6c8c;" role="alert">
                                Check your device: <strong id="last3DigitPhone"></strong>
                            </div>
                        </div>
                    </div>
                    <form method="POST" id="resetConfirmForm" action="{{ route('password.reset.code.confirm') }}">
                        @csrf
                        <input type="hidden" name="type" value="{{ $type }}">
                        @if ($type == 'phone')
                            <input type="text" style="display: none" name="phone" id="phone"
                                value="{{ $data }}">
                        @else
                            <input type="email" style="display: none" name="email" id="email"
                                value="{{ $data }}">
                        @endif
                        <div class="form-group">
                            <div class="fxt-transformY-50 fxt-transition-delay-1">
                                <lablel style="margin-bottom: 5px;"><strong class="text-white">Enter Verification
                                        Code</strong></lablel>
                                <input type="number" id="verify_code" class="form-control" name="verify_code"
                                    placeholder="Enter 6-Digit Code" required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="fxt-transformY-50 fxt-transition-delay-1">
                                <lablel style="margin-bottom: 5px;"><strong class="text-white">Enter New Password</strong>
                                </lablel>
                                <input type="password" id="password" class="form-control" name="password"
                                    placeholder="Enter New Password" required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="fxt-transformY-50 fxt-transition-delay-4">
                                <button type="submit" class="fxt-btn-fill btn-verify-re btn-primary"
                                    id="btn-verify-re">Verify & Reset Password</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        const phone = $('#phone').val();
        $('#last3DigitPhone').text('(xxx)-xxx-' + phone.replace(/\d(?=\d{4})/g, ""));
        // validation 01
        function validationVerifyCode() {
            "" == $("#verify_code").val() ? ($("#verify_code").css("border", "2px solid red"), $("#verify_code").css(
                "background-image", "none"), Toast.fire({
                icon: "error",
                title: "Enter 6-digit verify code"
            })) : $("#verify_code").css("border", "1px solid #ced4da")
        }
        // validation 02
        function loginErrorVerify() {
            clear2(), Toast.fire({
                icon: "error",
                title: "Verify code is wrong."
            })
        }

        function clear2() {
            $(".ms-bar-login").removeClass("ms-bar"), $(".ms-blur-bg").css("filter", "blur(0px)"), document.getElementById(
                "btn-verify-admin").disabled = !1
        }

        function validation2add() {
            var password = $('#password').val();
            if (password == '') {
                $('#password').css("border", "2px solid red");
                $('#password').css("background-image", "none");
                const phone = $('#phone').val();
                if (phone != '') {
                    Toast.fire({
                        icon: 'error',
                        title: 'Enter your new password'
                    })
                }
            } else if (password.length < 8) {
                $('#password').css("border", "2px solid red");
                $('#password').css("background-image", "none");
                Toast.fire({
                    icon: 'error',
                    title: 'The password must be at least 8 characters'
                })
            } else {
                $('#password').css("border", "1px solid #ced4da");
            }
        }

        function loginerror() {
            clear();
            Toast.fire({
                icon: 'error',
                title: 'These credentials do not match.'
            })
        }

        function clear() {
            $('.ms-bar-login').removeClass("ms-bar");
            $('.ms-blur-bg').css("filter", "blur(0px)");
            document.getElementById("btn-login-admin").disabled = false;
            $('.invalid-feedback3').css("display", "inline-block");
        }

        // $('.btn-verify-re').click(function() {
        //     var phone = $('#phone').val();
        //     var password = $('#password').val();
        //     var verifyCode = $('#verify_code').val();
        //     if (phone == '') {} else if (verifyCode == '') {
        //         validationVerifyCode();
        //     } else if (password == '' || password.length < 8) {
        //         validation2add();
        //     } else {
        //         validationVerifyCode();
        //         validation2add();
        //         // login submit
        //         $('.ms-bar-login').addClass("ms-bar");
        //         $('.ms-blur-bg').css("filter", "blur(5px)");
        //         document.getElementById("btn-verify-re").disabled = true;
        //         $('.invalid-feedback3').css("display", "none");
        //         document.getElementById('resetConfirmForm').submit();
        //     }
        // });
    </script>
@endpush
