
<!doctype html>
<html lang="en">
<head>

        <meta charset="utf-8" />
        <title>Aris Bali Explorer | Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Place to book favorite tourist destinations in Bali!" name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{asset('assets/images/logo.jpg')}}" type="image/png" />

        <!-- Bootstrap Css -->
        <link href="{{asset('assets/styles/css/login/auth/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{asset('assets/styles/css/login/auth/icons.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{asset('assets/styles/css/login/auth/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />

        <style>
            body {
                background-image: url('https://indonesia.go.id/resources/album/albmig/1537326322_jatiluwih_2.jpg');
                background-repeat: no-repeat;
                background-size: cover;
                background-position: center;
            }
        </style>

    </head>

    <body>
        <div class="account-pages my-5 pt-sm-5">
            <div class="container mt-5 pt-5">
                <div class="row justify-content-center mt-5">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card overflow-hidden">
                            <div class="bg-primary bg-soft">
                                <div class="row">
                                    <div class="col-7">
                                        <div class="text-primary p-4">
                                            <h5 class="text-primary">ARIS BALI EXPLORER</h5>
                                            <p>Log in with your identity</p>
                                        </div>
                                    </div>
                                    <div class="col-5 align-self-end">
                                        <img src="{{asset('assets/images/logo.jpg')}}" alt="" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="auth-logo">
                                    <a href="{{route('login')}}" class="auth-logo-light">
                                        <div class="avatar-md profile-user-wid mb-4">
                                            <span class="avatar-title rounded-circle bg-light">
                                                <img src="{{asset('assets/images/logo.jpg')}}" alt="" class="rounded-circle" height="72">
                                            </span>
                                        </div>
                                    </a>

                                    <a href="{{route('login')}}" class="auth-logo-dark">
                                        <div class="avatar-md profile-user-wid mb-4">
                                            <span class="avatar-title rounded-circle bg-light">
                                                <img src="{{asset('assets/images/logo.jpg')}}" alt="" class="rounded-circle" height="72">
                                            </span>
                                        </div>
                                    </a>
                                </div>
                                <div class="p-2">
                                    <form role="form" action="{{route('login')}}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="text" class="form-control @error('email') is-invalid @enderror" placeholder="masukkan email" name="email" id="email" value="{{ old('email') }}">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
                                            <div class="input-group auth-pass-inputgroup">
                                                <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter password" name="password" aria-label="Password" aria-describedby="password-addon">
                                                <button class="btn btn-light " type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                            </div>
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="text-end">
                                            <a href="{{route('register.main')}}">
                                                <p class="text-small text-muted">Don't have an acoount? Register</p>
                                            </a>
                                        </div>

                                        <div class="mt-3 d-grid">
                                            <button class="btn btn-primary waves-effect waves-light" type="submit">Log In</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- end account-pages -->

        <!-- JAVASCRIPT -->
        <script src="{{asset('assets/styles/css/login/auth/jquery.min.js')}}"></script>
        <script src="{{asset('assets/styles/css/login/auth/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('assets/styles/css/login/auth/metisMenu.min.js')}}"></script>
        <script src="{{asset('assets/styles/css/login/auth/simplebar.min.js')}}"></script>
        <script src="{{asset('assets/styles/css/login/auth/waves.min.js')}}"></script>

        <!-- App js -->
        <script src="{{asset('assets/styles/css/login/auth/app.js')}}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.2.1/dist/sweetalert2.all.min.js"></script>

        <script>
            $(document).ready(function () {
                @if (session('status'))
                Swal.fire(
                    "{{session('title')}}",
                    "{{session('message')}}",
                    "{{session('status')}}"
                )
                @endif
            });
        </script>
    </body>
</html>
