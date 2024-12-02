<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Book;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    //
    public function index(Request $request){

        $books= Book::withCount('reviews')->withSum('reviews','rating')->orderBy('created_at','DESC');
        
        if(!empty($request->keyword)){
            $books->where('title','like','%'.$request->keyword.'%');
        }

        $books = $books->where('status',1)->paginate(8);
        return view('home',['books'=>$books]);
    }

    // this method will show book detail page.
    public function detail($id){
        $book= Book::with(['reviews.user','reviews' => function($query){
            $query->where('status',1);
        }])->withCount('reviews')->withSum('reviews','rating')->findOrFail($id); // the findOrFail() method means if not found the id 404 error show ka.

        if($book->status == 0){
            abort(404);// you can also create it page manwally get help from chatgpt.
        }

        $relatedbooks=Book::where('status',1)->withCount('reviews')->withSum('reviews','rating')->take(3)->where('id','!=', $id)->inRandomOrder()->get();
        return view('book-detail',['book'=>$book,'relatedbooks'=>$relatedbooks]);

    }

    public function saveReview(Request $request){

    $validator = Validator::make($request->all(), [
        'review' => 'required|string|min:10|max:400',
        'rating' => 'required|integer|min:1|max:5',
        'book_id' => 'required|exists:books,id',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // here check the condition for review.
    $countReview = Review::where('user_id',Auth::user()->id)->where('book_id',$request->book_id)->count();
    if($countReview >0){
        return redirect()->back()->with('error', 'you already submited a review!');
    }

    $review = new Review();
    $review->review = $request->review;
    $review->rating = $request->rating;
    $review->user_id = Auth::user()->id; // Ensure user is logged in
    $review->book_id = $request->book_id;
    $review->save();

    return redirect()->back()->with('success', 'Review submitted successfully!');
}
}
