@extends('layouts.app')
@section('main')

    <div class=" d-flex justify-content-center"> <h1>Book Name:&nbsp;&nbsp;</h1><h1 class="text-success"> {{ $book->title }}</h1></div>
    <!-- Embed the PDF in an iframe or embed tag -->
    <iframe src="{{ asset('storage/' . $book->bookpdf) }}" width="100%" height="600px"></iframe>
    
    <!-- Or you can use the embed tag -->
    <!-- <embed src="{{ asset('storage/' . $book->bookpdf) }}" width="100%" height="600px" type="application/pdf"> -->

@endsection