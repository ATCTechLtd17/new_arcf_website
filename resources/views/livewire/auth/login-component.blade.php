<div id="loginForm" class="row align-items-center justify-content-center">
    @include('components.loading-indecator')
    <div class="col-xl-6 col-lg-7 col-sm-12 col-12 fxt-bg-color">
        <div class="ms-bar-login"style="z-index:99;">
            <div></div>
        </div>
        <div class="fxt-content ms-blur-bg">
            <div class="fxt-header">
                <a href="/" class="fxt-logo">
                    <img class="m-auto" src="{{ asset('logo.jpg') }}" alt="Logo" style="width: 150px;"></a>
                <p>
                    @if ($show_verification_page == false)
                        Login into your account
                    @else
                        Verify Your Account
                    @endif
                </p>
            </div>
            <div class="fxt-form">
                @if ($show_verification_page == false)
                    <form method="POST" wire:submit.prevent="login">
                        @csrf
                        <div class="form-group">
                            <div class="fxt-transformY-50 fxt-transition-delay-1">
                                <input type="number" id="phone" class="form-control" wire:model.defer="phone"
                                    placeholder="Phone">
                            </div>
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="fxt-transformY-50 fxt-transition-delay-2">
                                <input id="password" type="password" class="form-control" wire:model.defer="password"
                                    placeholder="Password">
                                <i toggle="#password" class="fa fa-fw fa-eye toggle-password field-icon"></i>
                            </div>
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="fxt-transformY-50 fxt-transition-delay-4">
                                <button type="submit" class="fxt-btn-fill btn-login-admin" id="btn-login-admin"
                                    style="background-color: #ec7b23!important;">Log in</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="fxt-transformY-50 fxt-transition-delay-3">
                                <div class="fxt-checkbox-area">
                                    <a href="{{ route('password.showPage') }}" class="switcher-text">Forgot Password</a>
                                </div>
                            </div>
                        </div>
                    </form>
                @else
                    <form method="POST" wire:submit.prevent="verifyOtp">
                        @csrf
                        <div class="form-group">
                            <div class="fxt-transformY-50 fxt-transition-delay-1">
                                <input type="number" id="otp" class="form-control" wire:model.defer="otp"
                                    placeholder="Enter Otp Here">
                            </div>
                            @error('otp')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="fxt-transformY-50 fxt-transition-delay-4">
                                <button type="submit" class="fxt-btn-fill btn-login-admin" id="btn-login-admin"
                                    style="background-color: #ec7b23!important;">Verify</button>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
