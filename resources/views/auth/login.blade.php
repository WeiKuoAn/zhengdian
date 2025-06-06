<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.shared/title-meta', ['title' => 'Log In'])
    @include('layouts.shared/head-css')
    @vite(['resources/scss/icons.scss'])
</head>
<style>

        body.authentication-bg-pattern {
            background-image: url("/images/bg/bg.jpg") !important;
    }
</style>

<body class="loading authentication-bg authentication-bg-pattern">

    <div class="account-pages mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-4">
                    <div class="card bg-pattern">

                        <div class="card-body p-4">

                            <div class="text-center w-75 m-auto">
                                <div class="auth-brand">
                                    <a href="#" class="logo logo-dark text-center">
                                        <span class="logo-lg">
                                            <img src="/images/LOGO.png" alt="" height="120">
                                        </span>
                                    </a>

                                    <a href="#" class="logo logo-light text-center">
                                        <span class="logo-lg">
                                            <img src="/images/LOGO.png" alt="" height="120">
                                        </span>
                                    </a>
                                </div>
                                <p class="text-muted mb-4 mt-3">請輸入您的帳號、密碼</p>
                            </div>


                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                                <br>
                            @endif
                            @if (session('success'))
                                <div class=" alert alert-success">{{ session('success') }}
                                </div>
                                <br>
                            @endif

                            @if (sizeof($errors) > 0)
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li class="text-danger">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif

                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="mb-3">
                                    <label for="emailaddress" class="form-label">帳號</label>
                                    <input class="form-control" type="text" name="email" id="emailaddress"
                                        required="" placeholder="帳號" value="">
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">密碼</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" name="password" id="password" class="form-control"
                                            placeholder="密碼" value="">
                                        <div class="input-group-text" data-password="true">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" name="remember" class="form-check-input"
                                            id="checkbox-signin" checked>
                                        <label class="form-check-label" for="checkbox-signin">記住我</label>
                                    </div>
                                </div>

                                <div class="text-center d-grid">
                                    <button class="btn btn-blue" type="submit">登入</button>
                                </div>

                            </form>

                            {{-- <div class="text-center">
                            <h5 class="mt-3 text-muted">Sign in with</h5>
                            <ul class="social-list list-inline mt-3 mb-0">
                                <li class="list-inline-item">
                                    <a href="javascript: void(0);" class="social-list-item border-primary text-primary"><i
                                            class="mdi mdi-facebook"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="javascript: void(0);" class="social-list-item border-danger text-danger"><i
                                            class="mdi mdi-google"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="javascript: void(0);" class="social-list-item border-info text-info"><i
                                            class="mdi mdi-twitter"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="javascript: void(0);"
                                       class="social-list-item border-secondary text-secondary"><i
                                            class="mdi mdi-github"></i></a>
                                </li>
                            </ul>
                        </div> --}}

                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    {{-- <div class="row mt-3">
                    <div class="col-12 text-center">
                        <p><a href="#" class="text-white-50 ms-1">Forgot your
                                password?</a></p>
                        <p class="text-white-50">Don't have an account? <a
                                href="#" class="text-white ms-1"><b>Sign
                                    Up</b></a></p>
                    </div> <!-- end col -->
                </div> --}}
                    <!-- end row -->

                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->

    <footer class="footer footer-alt">
        <script>
            document.write(new Date().getFullYear())
        </script> &copy; <a href="" class="text-white-50">錚典科技國際有限公司</a>
    </footer>

    @vite('resources/js/pages/auth.js')
</body>

</html>
