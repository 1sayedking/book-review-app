@extends('layouts.app')

@section('main')
<div class="container">
    <div class="row my-5">
        <!-- Sidebar -->
        <div class="col-12 col-md-3 mb-4 mb-md-0">
            @include('layouts.sidebar')                
        </div>

        <!-- Main Content -->
        <div class="col-12 col-md-9">
            @include('layouts.message')

            <div class="card border-0 shadow">
                <!-- Card Header -->
                <div class="card-header bg-primary text-white">
                    <i class="fa fa-star-half-alt"></i> Reviews
                </div>

                <!-- Card Body -->
                <div class="card-body pb-0"> 
                    <!-- Search Form -->
                    <div class="d-flex justify-content-end mb-3">
                        <form action="" method="GET">
                            <div class="d-flex">
                            <input type="text" class="form-control" name="keyword" 
                                   value="{{ Request::get('keyword') }}" placeholder="Search By Title">
                            <button type="submit" class="btn btn-primary ms-2">Search</button>
                            <a href="{{ route('account.reviews') }}" class="btn btn-secondary ms-2">Clear</a>
                        </div>
                        </form>
                    </div>

                    <!-- Reviews Table -->
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>Review</th>
                                    <th>Book</th>
                                    <th>Rating</th>
                                    <th>Created At</th>
                                    <th>Status</th>                                  
                                    <th width="100">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($reviews->isNotEmpty())
                                    @foreach ($reviews as $review)
                                        <tr>
                                            <td class="text-break">
                                                {{ $review->review }} 
                                                <br>
                                                <strong>{{ $review->user->name }}</strong>
                                            </td>                            
                                            <td>{{ $review->book->title }}</td>
                                            <td>{{ $review->rating }}</td>
                                            <td>{{ $review->created_at->format('d M, Y') }}</td>
                                            <td>
                                                @if ($review->status == 1)
                                                    <span class="text-success">Active</span>
                                                @else
                                                    <span class="text-danger">Blocked</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('account.reviews.edit', $review->id) }}" 
                                                   class="btn btn-primary btn-sm">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </a>
                                                <form action="{{ route('account.reviews.deleteReview', $review->id) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" 
                                                            onclick="return confirm('Are you sure you want to delete this Review?')">
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

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-3">
                        {{ $reviews->links() }}
                    </div>
                </div>
            </div>                
        </div>
    </div>       
</div>
@endsection
