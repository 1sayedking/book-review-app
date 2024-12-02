@extends('layouts.app')

@section('main')

    <div class="container mt-3 ">
        <div class="row justify-content-center d-flex mt-5">
            <div class="col-md-12">
                <a href="{{ route('home') }}" class="text-decoration-none text-dark ">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i> &nbsp; <strong>Back to books</strong>
                </a>
                <div class="row mt-4">
                    <div class="col-md-4">
                        {{-- <img src="images/book06.jpg" alt="" class="card-img-top"> --}}
                        @if ($book->image != '')
                            <img src="{{ asset('uploads/books/thumb/' . $book->image) }}" class="card-img-top"
                                alt="">
                        @else
                            <img src="https://placehold.co/900x1400?text=NO image" class="card-img-top" alt="">
                        @endif
                    </div>
                                        @php
                                            if( $book->reviews_count >0){
                                               $avgRating= $book->reviews_sum_rating/ $book->reviews_count;
                                            }else {
                                                $avgRating=0;
                                            }
                                            $avgRatingPer=($avgRating*100)/5;
                                        @endphp
                    <div class="col-md-8">
                        
                        @include('layouts.message')

                        <h3 class="h2 mb-3">{{ $book->title }}</h3>
                        <div class="h4 text-muted">By {{ $book->author }}
                            <p class="text-success">
                                @if ($book->bookpdf ?? false)
                                <!-- View PDF -->
                                <a href="{{ route('read-book', ['id' => $book->id]) }}" >Read Book</a>

                            &nbsp;&nbsp;&nbsp;
                                <!-- Download PDF -->
                                <a href="{{ route('download', $book->id) }}"><i class="fa-solid fa-download fa-1x"></i></a>
                            @endif</p>
                        </div>

                        <div class="star-rating d-inline-flex align-items-center">
                            <!-- Display Average Rating -->
                            <span class="rating-text theme-font theme-yellow">
                                {{ number_format($avgRating, 1) }}
                            </span>
                        
                            <!-- Display Star Rating -->
                            <div class="d-inline-flex mx-2" title="Rating: {{ $avgRating }}/5">
                                <div class="back-stars position-relative">
                                    <!-- Static Stars (Background) -->
                                    @for ($i = 0; $i < 5; $i++)
                                        <i class="fa fa-star text-muted" aria-hidden="true"></i>
                                    @endfor
                        
                                    <!-- Dynamic Stars (Overlay) -->
                                    <div class="front-stars position-absolute top-0 start-0" style="width: {{ $avgRatingPer }}%;">
                                        @for ($i = 0; $i < 5; $i++)
                                            <i class="fa fa-star text-warning" aria-hidden="true"></i>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        
                            <!-- Display Reviews Count -->
                            <span class="theme-font text-muted">
                                ({{ $book->reviews_count > 1 ? $book->reviews_count . ' Reviews' : $book->reviews_count . ' Review' }})
                            </span>
                        </div>
                        

                        <div class="content mt-3">
                            <div><h3>Description:</h3></div>
                            {{ $book->description }}
                        </div>

                        <div class="col-md-12 pt-2">
                            <hr>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h2 class="h3 mb-4">Readers also enjoyed</h2>
                            </div>
                            @if ($relatedbooks->isNotEmpty())
                                @foreach ($relatedbooks as $relatedbook)
                                    <div class="col-md-4 col-lg-4 mb-4">
                                        <div class="card border-0 shadow-lg">
                                            <a href="{{ route('book.detail',$relatedbook->id) }}">

                                            @if ($relatedbook->image != '')
                                                <img src="{{ asset('uploads/books/thumb/' . $relatedbook->image) }}"
                                                    class="card-img-top" alt="">
                                            @else
                                                <img src="https://placehold.co/900x1400?text=NO image" class="card-img-top"
                                                    alt="">
                                            @endif
                                            </a>
                                            
                                            @php
                                            if( $relatedbook->reviews_count >0){
                                               $avgRating= $relatedbook->reviews_sum_rating/ $relatedbook->reviews_count;
                                            }else {
                                                $avgRating=0;
                                            }
                                            $avgRatingPer=($avgRating*100)/5;
                                        @endphp
                                            <div class="card-body">
                                                <h3 class="h4 heading">
                                                    <a href="{{ route('book.detail', $relatedbook->id) }}">{{ $relatedbook->title }}</a>
                                                </h3>
                                                <p>by {{ $relatedbook->author }}</p>
                                                <p class="text-success">for detail click on image </br>
                                                    @if ($book->bookpdf ?? false)
                                                    <!-- View PDF -->
                                                    <a href="{{ route('read-book', ['id' => $book->id]) }}" ><i class="fa-solid fa-book-open"></i> Read</a>
        
                                                &nbsp;&nbsp;&nbsp;
                                                    <!-- Download PDF -->
                                                    <a href="{{ route('download', $book->id) }}"><i class="fa-solid fa-download fa-1x"></i> Download</a>
                                                @endif</p>
                                            
                                                <div class="star-rating d-inline-flex align-items-center">
                                                    <span class="rating-text theme-font theme-yellow">
                                                        {{ number_format($avgRating, 1) }}
                                                    </span>
                                            
                                                    <div class="star-rating d-inline-flex mx-2" title="Rating: {{ $avgRating }}/5">
                                                        <div class="back-stars">
                                                            @for ($i = 0; $i < 5; $i++)
                                                                <i class="fa fa-star text-secondary" aria-hidden="true"></i>
                                                            @endfor
                                                            <div class="front-stars" style="width: {{ $avgRatingPer }}%">
                                                                @for ($i = 0; $i < 5; $i++)
                                                                    <i class="fa fa-star text-warning" aria-hidden="true"></i>
                                                                @endfor
                                                            </div>
                                                        </div>
                                                    </div>
                                            
                                                    <span class="theme-font text-muted">
                                                        ({{ $relatedbook->reviews_count > 1 
                                                            ? $relatedbook->reviews_count . ' Reviews' 
                                                            : $relatedbook->reviews_count . ' Review' }})
                                                    </span>
                                                </div>
                                           
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif



                        </div>
                        <div class="col-md-12 pt-2">
                            <hr>
                        </div>
                        <div class="row pb-5">
                            <div class="col-md-12  mt-4">
                                <div class="d-flex justify-content-between">
                                    <h3>Reviews</h3>
                                    <div>

                                        @if (Auth::check())
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#staticBackdrop">
                                                Add Review
                                            </button>
                                        @else
                                            <a href="{{ route('account.login') }}" class="btn btn-primary">Add Review</a>
                                        @endif

                                    </div>
                                </div>
                @if($book->reviews->isNotEmpty())
                 @foreach ($book->reviews as $review)
                    <div class="card border-0 shadow-lg my-4">
                         <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h5 class="mb-3">{{ $review->user->name ?? 'Anonymous' }}</h4>
                                     <span class="text-muted">
                                        {{ $review->created_at->format('d M, Y') }}
                                     </span>
                    </div>
    
                    
                    <div class="mb-3">
                        <div class="star-rating d-inline-flex" title="Rating: {{ $review->rating }}">
                            <div class="back-stars">
                                @for ($i = 0; $i < 5; $i++)
                                    @if ($i < $review->rating)
                                        <i class="fa fa-star text-warning"></i>
                                    @else
                                        <i class="fa fa-star text-secondary"></i>
                                    @endif
                                @endfor

                                {{-- if you want to decimal rating like 3.4
                                @for ($i = 0; $i < 5; $i++)
                                @if ($i < floor($review->rating))
                                 <i class="fa fa-star text-warning"></i>
                                @elseif ($i < $review->rating)
                                 <i class="fa fa-star-half-alt text-warning"></i>
                                @else
                                 <i class="fa fa-star text-secondary"></i>
                                @endif
                                @endfor --}}
                            </div>
                        </div>
                    </div>
                        <div class="content">
                         <p>{{ $review->review }}</p>
                        </div>
                 </div>
             </div>
                 @endforeach
                 @else
               <div>
                Review not Found!
               </div>
                 @endif
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--*Modal* search on bootstrap 'modal'  javascript box if you want to use anywhere can copy from here---bellow---->
    <div class="modal fade " id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Review for <strong>Atomic Habits</strong>
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('book.saveReview') }}" method="POST" id="bookRivewForm" name="bookRivewForm">
                  @csrf
                  <input type="hidden" name="book_id"  value="{{ $book->id }}">
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="review" class="form-label">Review</label>
                            <textarea 
                                name="review" 
                                id="review" 
                                class="form-control @error('review') is-invalid @enderror"
                                cols="5" 
                                rows="5" 
                                placeholder="Write your review">{{ old('review') }}</textarea>
                            @error('review')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="rating" class="form-label">Rating</label>
                            <select name="rating" id="rating" class="form-control @error('rating') is-invalid @enderror">
                                <option value="1" {{ old('rating') == 1 ? 'selected' : '' }}>1</option>
                                <option value="2" {{ old('rating') == 2 ? 'selected' : '' }}>2</option>
                                <option value="3" {{ old('rating') == 3 ? 'selected' : '' }}>3</option>
                                <option value="4" {{ old('rating') == 4 ? 'selected' : '' }}>4</option>
                                <option value="5" {{ old('rating') == 5 ? 'selected' : '' }}>5</option>
                            </select>
                            @error('rating')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script to Handle Modal Opening on Validation Errors -->
    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var modal = new bootstrap.Modal(document.getElementById('staticBackdrop'), {
                    keyboard: false, // if press the esc close the modal
                    backdrop: 'static' // if click outside the modal close modal
                });
                modal.show(); // show modal if any error
            });
        </script>
    @endif

    {{-- --------------------------------------------------------------- --}}
@endsection
