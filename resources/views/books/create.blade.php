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
                        Add Book
                    </div>
                    <div class="card-body">
                        <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
                           @csrf
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    placeholder="Title" name="title" id="title" value="{{ old('title') }}" />
                                @error('title')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="author" class="form-label">Author</label>
                                <input type="text" class="form-control @error('author') is-invalid @enderror"
                                    placeholder="Author" name="author" id="author" value="{{ old('author') }}" />
                                @error('author')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description"  id="description" class="form-control @error('description') is-invalid @enderror" placeholder="Description" cols="30"
                                    rows="5">{{ old('description') }}</textarea>
                                    @error('description')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="Image" class="form-label">Book Image <i class="fa-solid fa-upload"></i></label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror"
                                    name="image" id="image" />
                                @error('image')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            {{-- .............................  --}}

                            <div class="mb-3">
                                <label for="bookpdf" class="form-label">Book.Pdf <i class="fa-solid fa-upload"></i></label>
                                <input type="file" class="form-control @error('bookpdf') is-invalid @enderror" name="bookpdf" id="bookpdf" accept="application/pdf" />
                                @error('bookpdf')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                            {{-- .........................................  --}}

                            <div class="mb-3">
                                <label for="author" class="form-label">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Block</option>
                                </select>
                            </div>


                            <button class="btn btn-primary mt-2">Create</button>
                        </form>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection
