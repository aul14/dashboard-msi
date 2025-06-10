@include('auth.layouts.head')
<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <img src="{{ asset('assets/images/logo-msi.png') }}" alt="Login Image" class="img" width="100">
                <h2 class="heading-section m-0">Sign In</h2>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="login-wrap p-0">
                    <p class="mb-2 text-center">Enter your email or username and password to sign in</p>
                    @if (isset($errors) && count($errors) > 0)
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <ul class="list-unstyled mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </ul>

                        </div>
                    @endif
                    <form action="{{ route('login.perform') }}" class="signin-form" method="POST">
                        @csrf
                        @method('POST')
                        <div class="form-group">
                            <input type="text" class="form-control" autofocus autocomplete="off"
                                placeholder="Email or username" name="username" value="{{ old('username') }}" required>
                            @error('username')
                                <p class="text-danger text-xs pt-1"> {{ $message }} </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input id="password-field" type="password" autocomplete="off" class="form-control"
                                name="password" placeholder="Password" required>
                            @error('password')
                                <p class="text-danger text-xs pt-1"> {{ $message }} </p>
                            @enderror
                            <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="form-control btn btn-primary px-3">Sign In</button>
                        </div>
                        <div class="form-group d-md-flex">
                            <div class="w-50">
                                <label class="checkbox-wrap checkbox-primary">Remember Me
                                    <input type="checkbox" name="remember" value="1" checked>
                                    <span class="checkmark"></span>
                                </label>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@include('auth.layouts.footer')
