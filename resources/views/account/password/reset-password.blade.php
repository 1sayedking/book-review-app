@extends('layouts.app')

@section('main')
<div class="container">
    <div class="row my-5">
        <div class="col-md-6 offset-md-3">
            @include('layouts.message')
            <div class="card">
                <div class="card-body">
                    <h4 class="text-center">Reset Password</h4>
                    <form action="{{ route('account.saveResetPassword') }}" method="post">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="form-group">
                            <label for="email"><i class="fa-solid fa-envelope"></i> Email Address</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" required>
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="newpassword"><i class="fa-solid fa-key"></i> New Password</label>
                            <input type="password" name="newpassword" class="form-control @error('newpassword') is-invalid @enderror" required>
                            @error('newpassword')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="newpassword_confirmation"><i class="fa-solid fa-key"></i> Confirm New Password</label>
                            <input type="password" name="newpassword_confirmation" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mt-3">Reset Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


