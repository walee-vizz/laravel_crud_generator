<div class="login-area" style="background: darkgray;">
    <div class="container">
        <div class="login-box ptb--100">
            <form wire:submit.prevent="login" action="">
                {{-- @csrf --}}
                <div class="login-form-head">
                    <h4>Sign In</h4>
                    <p>Hello there, Sign in and start managing your Admin Panel</p>
                </div>
                <div class="login-form-body">
                    @include('partials.backend.messages')
                    <div class="form-gp">
                        <label for="exampleInputEmail1">Email address </label>
                        <input wire:model="email" type="text" id="exampleInputEmail1"
                            class="@error('email') is-invalid @enderror">
                        <i class="ti-email"></i>
                        @error('email')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-gp">
                        <label for="exampleInputPassword1">Password</label>
                        <input wire:model="password" type="password" id="exampleInputPassword1"
                            class="@error('password') is-invalid @enderror">
                        <i class="ti-lock"></i>
                        @error('password')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="row mb-4 rmber-area">
                        <div class="col-6">
                            {{-- <div class="custom-control custom-checkbox mr-sm-2">
                                <input type="checkbox" class="custom-control-input" id="customControlAutosizing"
                                    name="remember">
                                <label class="custom-control-label" for="customControlAutosizing">Remember Me</label>
                            </div> --}}
                        </div>
                        <div class="col-6 text-right">
                            <a href="{{ route('login.with.google') }}">Login with Google</a>
                        </div>
                    </div>
                    <div class="submit-btn-area">
                        <button >Sign In <i class="ti-arrow-right"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
