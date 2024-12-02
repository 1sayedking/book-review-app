@extends('layouts.app')

@section('main')
<div class="container">
    <div class="row my-5">
        <div class="col-12 col-md-3">
           @include('layouts.sidebar')                
        </div>
        <div class="col-12 col-md-9">
            @include('layouts.message')
            <div class="card border-0 shadow">
                <div class="card-header bg-primary text-white">
                    <i class="fa fa-star-half-alt"></i> My Reviews
                </div>
                <div class="card-body pb-0">
                    <div class="d-flex justify-content-end">
                        <form action="" method="GET">
                            <div class="d-flex">
                            <input type="text" class="form-control" name="keyword" value="{{ Request::get('keyword') }}" placeholder="Search By Title">
                            <button type="submit" class="btn btn-primary ms-2">Search</button>
                            <a href="{{ route('account.myReview') }}" class="btn btn-secondary ms-2">Clear</a>
                        </div>
                        </form>
                    </div>
                    <div class="table-responsive mt-3">
                        <table class="table table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>Book</th>
                                    <th>Review</th>
                                    <th>Rating</th>
                                    <th>Status</th>
                                    <th width="100">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($reviews->isNotEmpty())
                                    @foreach ($reviews as $review)
                                        <tr>
                                            <td>{{ $review->book->title }}</td>
                                            <td class="text-break">{{ $review->review }}</td>
                                            <td>{{ $review->rating }}</td>
                                            <td>
                                                @if ($review->status == 1)
                                                    <span class="text-success">Active</span>
                                                @else
                                                    <span class="text-danger">Block</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('account.myReviews.editReview', $review->id) }}" class="btn btn-primary btn-sm">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </a>
                                                <form action="{{ route('account.myReview.deleteReview', $review->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this Review?')">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach  
                                    @else
                                    <tr>
                                        <td colspan="6" class="text-center">No reviews found!</td>
                                    </tr>
                               
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center">
                        {{ $reviews->links() }}
                    </div>
                </div>
            </div>                
        </div>
    </div>       
</div>
@endsection
