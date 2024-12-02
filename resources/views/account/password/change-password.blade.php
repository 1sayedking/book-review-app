@extends('layouts.app')

@section('main')
<div class="container">
    <div class="row my-5">
        <div class="col-md-3">
            @include('layouts.sidebar')
        </div>
        <div class="col-md-9">
            @include('layouts.message')
            <div class="card border border-light-subtle rounded-4">
                <div class="card-body p-3 p-md-4 p-xl-5">
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-5">
                                <h4 class="text-center"><i class="fa-solid fa-lock"></i> Change Password Here</h4>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('account.password.savechangePassword') }}" method="post">
                        @csrf
                        

                        <div class="row gy-3 d-flex justify-content-center align-items-center">
                            <div class="col-7">
                                <div class="form-floating mb-2">
                                    <input type="text" value="{{ old('email') }}" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           name="email" id="email" placeholder="name@example.com">
                                    <label for="email" class="form-label"><i class="fa-solid fa-envelope"></i> Your Email</label>
                                    @error('email')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-7">
                                <div class="form-floating mb-2">
                                    <input type="password" value="{{ old('oldpassword') }}" 
                                           class="form-control @error('oldpassword') is-invalid @enderror" 
                                           name="oldpassword" id="oldpassword" placeholder="Old Password">
                                    <label for="oldpassword" class="form-label"><i class="fa-solid fa-key"></i> Old Password</label>
                                    @error('oldpassword')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-7">
                                <div class="form-floating mb-2">
                                    <input type="password" value="{{ old('newpassword') }}" 
                                           class="form-control @error('newpassword') is-invalid @enderror" 
                                           name="newpassword" id="newpassword" placeholder="New Password">
                                    <label for="newpassword" class="form-label"><i class="fa-solid fa-key"></i> New Password</label>
                                    @error('newpassword')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-7">
                                <div class="form-floating mb-2">
                                    <input type="password" value="{{ old('newpassword_confirmation') }}" 
                                           class="form-control @error('newpassword_confirmation') is-invalid @enderror" 
                                           name="newpassword_confirmation" id="newpassword_confirmation" placeholder="Confirm New Password">
                                    <label for="newpassword_confirmation" class="form-label"><i class="fa-solid fa-key"></i> Confirm New Password</label>
                                    @error('newpassword_confirmation')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-7">
                                <div class="d-grid">
                                    <button class="btn btn-primary py-3" type="submit"><strong>Change</strong></button>
                                </div>
                                <div class="d-grid text-center">
                                    <a href="{{ route('account.forgotPasswordForm') }}">Forgot Password</a>

                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
