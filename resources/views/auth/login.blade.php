@extends('layouts.auth')

@section('content')
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth">
            <div class="row flex-grow">
                <div class="col-lg-4 mx-auto">
                <div class="auth-form-light text-left p-5">
                    <div class="brand-logo">
                    <img src="../../assets/images/logo.svg">
                    </div>
                    <h4>Hello! let's get started</h4>
                    <h6 class="font-weight-light">Sign in to continue.</h6>
                    <form class="pt-3" method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group">
                        <input type="email" 
                            name="email"
                            class="form-control form-control-lg @error('email') is-invalid @enderror"
                            placeholder="Email"
                            value="{{ old('email') }}"
                            required>

                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input type="password" 
                            name="password"
                            class="form-control form-control-lg @error('password') is-invalid @enderror"
                            placeholder="Password"
                            required>

                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="my-2 d-flex justify-content-between align-items-center">
                        <div class="form-check">
                        <label class="form-check-label text-muted">
                            <input type="checkbox" class="form-check-input"> Keep me signed in </label>
                        </div>
                        <a href="#" class="auth-link text-primary">Forgot password?</a>
                    </div>
                    <div class="mt-3 d-grid gap-2">
                        <button type="submit" 
                                class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">
                            SIGN IN
                        </button>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('auth.google') }}"
                        class="">
                            Login dengan Google
                        </a>
                    </div>
                    <div class="my-2 d-flex justify-content-between align-items-center">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="auth-link text-primary">
                                Forgot password?
                            </a>
                        @endif
                    </div>
                    <div class="text-center mt-4 font-weight-light">
                        Don't have an account?
                        <a href="{{ route('register') }}" class="text-primary">Create</a>
                    </div>
                </form>
                </div>
                </div>
            </div>
            </div>
        </div>
    </div>
@endsection

@section('script-page')
    <script src="../../assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="../../assets/js/off-canvas.js"></script>
    <script src="../../assets/js/misc.js"></script>
    <script src="../../assets/js/settings.js"></script>
    <script src="../../assets/js/todolist.js"></script>
    <script src="../../assets/js/jquery.cookie.js"></script>
    <!-- endinject -->
@endsection