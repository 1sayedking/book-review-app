@extends('layouts.app')

@section('main')
<div class="container">
    <div class="row my-5">
        <div class="col-md-3">
            @include('layouts.sidebar')                
        </div>
        <div class="col-md-9">
            
            <div class="card border-0 shadow">
                <div class="card-header  text-white">
                    Edit Review
                </div>
                <div class="card-body pb-3"> 
                    <form action="{{ route('account.myReviews.updateReview', $review->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="book" class="form-label">Book</label>
                            <div>
                                <strong>{{ $review->book->title }}</strong>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="Review" class="form-label">Review</label>
                            <textarea name="review" placeholder="Edit review here" class="form-control @error('review') is-invalid @enderror" id="review" cols="30" rows="10">
                                {{ old('review', $review->review) }}
                            </textarea>
                            @error('review')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    
                        <div class="mb-3">
                            <label for="rating" class="form-label">Rating</label>
                            <select name="rating" id="rating" class="form-control @error('rating') is-invalid @enderror">
                                <option value="1" {{ $review->rating == 1 ? 'selected' : '' }}>1</option>
                                <option value="2" {{ $review->rating == 2 ? 'selected' : '' }}>2</option>
                                <option value="3" {{ $review->rating == 3 ? 'selected' : '' }}>3</option>
                                <option value="4" {{ $review->rating == 4 ? 'selected' : '' }}>4</option>
                                <option value="5" {{ $review->rating == 5 ? 'selected' : '' }}>5</option>
                            
                            </select>
                            @error('rating')
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