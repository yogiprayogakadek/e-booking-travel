
<!doctype html>
<html lang="en">

<head>

        <meta charset="utf-8" />
        <title>Aris Bali Explorer | Register</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
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
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card overflow-hidden">
                            <div class="bg-primary bg-soft">
                                <div class="row">
                                    <div class="col-7">
                                        <div class="text-primary p-4">
                                            <h5 class="text-primary">ARIS BALI EXPLORER</h5>
                                            <p>Register to use the system</p>
                                        </div>
                                    </div>
                                    <div class="col-5 align-self-end">
                                        <img src="{{asset('assets/images/logo.jpg')}}" alt="" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="auth-logo">
                                    <a href="{{route('register.main')}}" class="auth-logo-light">
                                        <div class="avatar-md profile-user-wid mb-4">
                                            <span class="avatar-title rounded-circle bg-light">
                                                <img src="{{asset('assets/images/logo.jpg')}}" alt="" class="rounded-circle" height="34">
                                            </span>
                                        </div>
                                    </a>

                                    <a href="{{route('register.main')}}" class="auth-logo-dark">
                                        <div class="avatar-md profile-user-wid mb-4">
                                            <span class="avatar-title rounded-circle bg-light">
                                                <img src="{{asset('assets/images/logo.jpg')}}" alt="" class="rounded-circle" height="34">
                                            </span>
                                        </div>
                                    </a>
                                </div>
                                <form role="form" action="{{route('register.store')}}" method="POST" id="form" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" placeholder="enter your name" name="name" id="name" autocomplete="off">
                                    </div>

                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="text" class="form-control" placeholder="enter your phone number" name="phone" id="phone" autocomplete="off">
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="text" class="form-control" placeholder="enter your email" name="email" id="email" autocomplete="off">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <div class="input-group auth-pass-inputgroup">
                                            <input type="password" class="form-control" placeholder="enter password" name="password" aria-label="Password" aria-describedby="password-addon" autocomplete="off">
                                            <button class="btn btn-light " type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Confirm Password</label>
                                        <div class="input-group auth-pass-inputgroup">
                                            <input type="password" class="form-control" placeholder="enter confirm password" name="confirm_password" aria-label="Password" aria-describedby="password-addon" autocomplete="off">
                                            <button class="btn btn-light " type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="photo" class="form-label">photo</label>
                                        <input type="file" class="form-control" placeholder="enter photo" name="photo" id="photo">
                                    </div>

                                    <div class="text-end">
                                        <a href="{{route('login')}}">
                                            <p class="text-small text-muted">Already have an acoount? Login</p>
                                        </a>
                                    </div>

                                    <div class="mt-3 d-grid">
                                        <button class="btn btn-primary waves-effect waves-light" type="submit">Register</button>
                                    </div>
                                </form>

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

        <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>

        {!! JsValidator::formRequest('App\Http\Requests\RegisterRequest', '#form') !!}

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
