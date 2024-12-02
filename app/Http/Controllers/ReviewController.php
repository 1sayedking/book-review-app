<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    //
    // this method will show review in bakend.
    public function index(Request $request){
        $reviews = Review::with('book','user')->orderBy('created_at','DESC');

        if(!empty($request->keyword)){
           $reviews= $reviews->where('review','like','%'.$request->keyword.'%');
        }
        
        $reviews=$reviews->paginate(8);
        return view('account.reviews.list',['reviews'=>$reviews]);
    }

    // this method will show edit review page
    public function edit($id){
        $review = Review::findOrFail($id);
        return view('account.reviews.edit', ['review' => $review]);
    }

    // this method will upadate a review.
    public function updateReview(Request $request, $id) {
        $review = Review::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'review' => 'required|string|min:10|max:400',
            'status' => 'required|max:10',
        ]);
    
        if ($validator->fails()) {
            return redirect()
                ->route('account.reviews.edit', $id)
                ->withErrors($validator)
                ->withInput();
        } else {
            $review->review = $request->review;
            $review->status = $request->status;
            $review->save();
    
            session()->flash('success', 'Review updated successfully');
            return redirect()->route('account.reviews');
        }
    }

    // this method will delete the review.
    public function deleteReview($id){

        $review=Review::find($id);
        if($review==null){
            session()->flash('error', 'Review not found');
            return redirect()->route('account.reviews');
        }
        else{
            $review->delete($id);
            session()->flash('success', 'Review Deleted successfully');
                return redirect()->route('account.reviews');
        }
       
    }
}
