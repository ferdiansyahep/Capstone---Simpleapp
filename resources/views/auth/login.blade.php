@extends('layouts.app')

@section('content')
<div class="container-fluid vh-100">
    <div class="row h-100">
        <!-- Left Side -->
        <div class="col-md-6 d-none d-md-flex bg-image justify-content-end align-items-center bg-primary-dashboard">
            <img src="https://i.ibb.co.com/7CLwYyy/image-5.png" alt="" class="w-75">
        </div>

        <!-- Right Side -->
        <div class="col-md-6 d-flex align-items-center justify-content-center">
            <div class="w-75 ">
                <div class="logo-img text-center my-5">
                    <img src="{{ asset('img/logo-blue.png') }}" class="w-50">
                </div>
                <form method="POST" action="{{ route('login') }}" class="shadow-lg p-4 bg-body rounded">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('NIP / NISN / Email') }}</label>
                        <input id="email" type="text" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror" name="password" required
                            autocomplete="current-password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <!-- <input type="checkbox" class="form-check-input" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>
                            
                        <label class="form-check-label" for="remember">{{ __('Remember Me') }}</label> -->
                        @if (Route::has('password.request'))
                        <a class="btn btn-link text-decoration-none"
                            href="{{ route('password.request') }}" style="color: #00000099;">{{ __('Lupa Password?') }}</a>
                        @endif
                    </div>

                    <div class="d-flex justify-content-center align-items-center">
                        <button type="submit" class="btn bg-secondary-custom w-50">{{ __('Masuk') }}</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection