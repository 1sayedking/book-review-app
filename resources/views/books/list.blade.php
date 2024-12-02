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
                    <i class="fa-solid fa-book fa-2x"></i> Books
                </div>
                <div class="card-body pb-0">  
                  <div class="d-flex justify-content-between">
                    <a href="{{ route('books.create')}}" class="btn btn-primary">Add Book</a>            
                    
                        <form action="{{ route('books.index') }}" method="GET">
                            <div class="d-flex">
                        <input type="text" class="form-control"  name="keyword" value="{{ Request::get('keyword') }}" placeholder="Search By title">
                        <button type="submit" class="btn btn-primary ms-2">Search</button>
                        <a href="{{ route('books.index') }}" class="btn btn-secondary ms-2" >Clear</a>
                    </div>
                    </form>
                  
                  </div>

                    <table class="table  table-striped mt-3">
                        <thead class="table-dark">
                            <tr>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Rating</th>
                                <th>Status</th>
                                <th width="150">Action</th>
                            </tr>
                            <tbody>
                                @if ($books->isNotEmpty())
                                @foreach ($books as $book )
                                @php
                                            if( $book->reviews_count >0){
                                               $avgRating= $book->reviews_sum_rating/ $book->reviews_count;
                                            }else {
                                                $avgRating=0;
                                            }
                                            $avgRatingPer=($avgRating*100)/5;
                                        @endphp
                                <tr>
                                    <td>{{ $book->title }}</td>
                                    <td>{{ $book->author }}</td>
                                    <td>{{ number_format($avgRating,1) }}({{ ($book->reviews_count>1)? $book->reviews_count.'Reviews': $book->reviews_count.'Review' }})</td>
                                    <td>
                                        @if ( $book->status ==1 )
                                        <span class="text-success">active</span>
                                        @else
                                           <span class="text-danger">Block</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            
                                            <a href="{{ route('books.edit', $book->id) }}"  class="btn btn-primary btn-sm">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </a>
                                            <a href="#"></a>
                                            <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this book?')">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                    @else
                                    <tr>
                                        <td colspan="5"> books not found</td>
                                    </tr>
                                @endif
                             
                            </tbody>
                        </thead>
                    </table>   
                    @if ($books->isNotEmpty())

                    {{ $books->links() }} {{--> to add pagination go to app/providers/AppServiceProvider.php   --}}
                    @endif
                       
                                  
                </div>
                
            </div>                
        </div>
    
    </div>       
</div>
@endsection

