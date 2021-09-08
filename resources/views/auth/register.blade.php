<!doctype html>
<html lang="vi">

<head>
    <title>Đăng ký</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <style>
        body {
            min-height: 100vh;
            background: rgba(0, 0, 0, 0.4) url("{{ asset('images/login-bg.jpg') }}");
            background-blend-mode: overlay;
        }
    </style>
</head>

<body class="img js-fullheight">
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center mb-5">
                    <h2 class="heading-section">Đăng ký tài khoản</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="login-wrap p-0">
                        <form action="{{ route('auth.saveRegister') }}" class="signin-form" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Tên người dùng"
                                            name="full_name" value="{{ old('full_name') }}">

                                        @error('full_name')
                                        <p
                                            style="color: whitesmoke; font-weight: bold; padding-left: 20px; font-size: 14px;">
                                            {{$message}}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Email" name="email"
                                            value="{{ old('email') }}">

                                        @error('email')
                                        <p
                                            style="color: whitesmoke; font-weight: bold; padding-left: 20px; font-size: 14px;">
                                            {{$message}}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Tên tài khoản"
                                            name="acc_name" value="{{ old('acc_name') }}">

                                        @error('acc_name')
                                        <p
                                            style="color: whitesmoke; font-weight: bold; padding-left: 20px; font-size: 14px;">
                                            {{$message}}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Số điện thoại"
                                            name="mobile" value="{{ old('mobile') }}">

                                        @error('mobile')
                                        <p
                                            style="color: whitesmoke; font-weight: bold; padding-left: 20px; font-size: 14px;">
                                            {{$message}}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input id="password-field" type="password" class="form-control"
                                            placeholder="Mật khẩu" name="password">
                                        <span toggle="#password-field"
                                            class="fa fa-fw fa-eye field-icon toggle-password"></span>

                                        @error('password')
                                        <p
                                            style="color: whitesmoke; font-weight: bold; padding-left: 20px; font-size: 14px;">
                                            {{$message}}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input id="password-field-confirm" type="password" class="form-control"
                                            placeholder="Nhập lại mật khẩu" name="password_confirmation">
                                        <span toggle="#password-field-confirm"
                                            class="fa fa-fw fa-eye field-icon toggle-password-confirm"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-8 offset-2">
                                <button type="submit" class="form-control btn btn-primary submit px-3">Đăng
                                    ký</button>
                            </div>
                            <div class="form-group d-md-flex">
                                <div class="w-50 text-md-left">
                                    <a href="{{ route('auth.login') }}" style="color: #fff">Đăng nhập</a>
                                </div>
                                <div class="w-50 text-md-right">
                                    <a href="#" style="color: #fff">Quên mật khẩu</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script>
        (function ($) {
            "use strict";
            $(".toggle-password").click(function () {

                $(this).toggleClass("fa-eye fa-eye-slash");
                let input = $($(this).attr("toggle"));
                if (input.attr("type") == "password") {
                    input.attr("type", "text");
                } else {
                    input.attr("type", "password");
                }
            });

            $(".toggle-password-confirm").click(function () {

                $(this).toggleClass("fa-eye fa-eye-slash");
                let input = $($(this).attr("toggle"));
                if (input.attr("type") == "password") {
                    input.attr("type", "text");
                } else {
                    input.attr("type", "password");
                }
            });
        })(jQuery);
    </script>

</body>

</html>
