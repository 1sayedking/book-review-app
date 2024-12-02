@extends('layouts.app')

@section('main')
    <div class="container mt-3 pb-5">
        <div class="row justify-content-center d-flex mt-5">
            <div class="col-md-12">
                <div class="d-flex justify-content-between">
                    <h2 class="mb-3">Books</h2>
                    <div class="mt-2">
                        <a href="{{ route('home') }}" class="btn btn-secondary ms-2">Clear Search</a>
                    </div>
                </div>
                <div class="card shadow-lg border-0">
                    <form action="" method="GET">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-11 col-md-11">
                                    <input type="text" value="{{ Request::get('keyword') }}" name="keyword"
                                        class="form-control form-control-lg" placeholder="Search by title">
                                </div>
                                <div class="col-lg-1 col-md-1">
                                    <button class="btn btn-primary btn-lg w-100"><i
                                            class="fa-solid fa-magnifying-glass"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="row mt-4">
                    @if ($books->isNotEmpty())
                        @foreach ($books as $book)
                            <div class="col-md-4 col-lg-3 mb-4">
                                <div class="card border-0 shadow-lg">

                                    <a href="{{ route('book.detail', $book->id) }}">
                                        @if ($book->image != '')
                                            <img src="{{ asset('uploads/books/thumb/' . $book->image) }}" alt=""
                                                class="card-img-top">
                                        @else
                                            {{-- search on google 'placeholder image' than open 'Placehold | A simple, fast and free image placeholder service'  --}}
                                            <img src="https://placehold.co/495x700?text=No Image" alt=""
                                                class="card-img-top">
                                        @endif

                                    </a>
                                    <div class="card-body">
                                        <h3 class="h4 heading">
                                            <a href="#">{{ $book->title }}</a>
                                        </h3>
                                        <p>by <strong>{{ $book->author }}</strong>
                                        <p class="text-success">for detail click on image </br>
                                            @if ($book->bookpdf ?? false)
                                            <!-- View PDF -->
                                            <a href="{{ route('read-book', ['id' => $book->id]) }}" ><i class="fa-solid fa-book-open"></i> Read</a>

                                        &nbsp;&nbsp;&nbsp;
                                            <!-- Download PDF -->
                                            <a href="{{ route('download', $book->id) }}"><i class="fa-solid fa-download fa-1x"></i> Download</a>
                                        @endif</p>


                                        @php
                                            $avgRating =
                                                $book->reviews_count > 0
                                                    ? $book->reviews_sum_rating / $book->reviews_count
                                                    : 0;
                                            $avgRatingPer = ($avgRating * 100) / 5;
                                        @endphp

                                        <div class="star-rating d-inline-flex align-items-center">
                                            <span class="rating-text theme-font theme-yellow">
                                                {{ number_format($avgRating, 1) }}
                                            </span>
                                            <div class="star-rating d-inline-flex mx-2" title="{{ $avgRating }}/5">
                                                <div class="back-stars">
                                                    @for ($i = 0; $i < 5; $i++)
                                                        <i class="fa fa-star text-secondary " aria-hidden="true"></i>
                                                    @endfor
                                                    <div class="front-stars" style="width: {{ $avgRatingPer }}%">
                                                        @for ($i = 0; $i < 5; $i++)
                                                            <i class="fa fa-star text-warning" aria-hidden="true"></i>
                                                        @endfor
                                                    </div>
                                                </div>
                                            </div>
                                            <span class="theme-font text-muted">
                                                ({{ $book->reviews_count > 1 ? $book->reviews_count . ' Reviews' : $book->reviews_count . ' Review' }})
                                            </span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    @endif

                    {{ $books->links() }}

                </div>
            </div>
        </div>
    </div>
@endsection
