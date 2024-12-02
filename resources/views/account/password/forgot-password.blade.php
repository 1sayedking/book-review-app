@extends('layouts.app')

@section('main')
<div class="container">
    <div class="row my-5">
        <div class="col-md-6 offset-md-3">
            @include('layouts.message')
            <div class="card">
                <div class="card-body">
                    <h4 class="text-center">Forgot Password</h4>
                    <form action="{{ route('account.forgotPassword') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="email"><i class="fa-solid fa-envelope"></i> Email Address</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" required>
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mt-3">Send Reset Link</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


