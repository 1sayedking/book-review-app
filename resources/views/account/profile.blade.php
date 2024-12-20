@extends('layouts.app')

@section('main')

<div class="container">
    <div class="row my-5">
        <div class="col-md-3">
            @include('layouts.sidebar')
        </div>
        <div class="col-md-9">
            @include('layouts.message')
            <div class="card border-0 shadow">
                <div class="card-header  text-white">
                    <i class="fa-solid fa-user"></i> Profile
                </div>
                <div class="card-body">
                    <form action="{{ route('account.updateProfile') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" value="{{ old('name',$user->name) }}" class="form-control @error('name') is-invalid @enderror" placeholder="Name" name="name" id="" />
                       @error('name')
                       <span class="invalid-feedback">{{ $message }}</span>
                           
                       @enderror
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label"><i class="fa-solid fa-envelope"></i> Email</label>
                        <input type="text" value="{{ old('email',$user->email) }}" class="form-control @error('email') is-invalid @enderror" placeholder="Email"  name="email" id="email"/>
                   @error('email')
                   <span class="invalid-feedback">{{ $message }}</span>
                       
                   @enderror
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Image <i class="fa-solid fa-upload"></i></label>
                        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror">
                        @if (Auth::user()->image !="")
                        <img src="{{ asset('uploads/profile/thumb/'.Auth::user()->image) }}" class="img-fluid mt-4" alt="sayed afzal" >
                            
                        @endif
                    @error('image')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                    </div>   
                    <button class="btn btn-primary mt-2">Update</button> 
                          </form>                    
                </div>
            </div>                
        </div>
    </div>       
</div>
@endsection
