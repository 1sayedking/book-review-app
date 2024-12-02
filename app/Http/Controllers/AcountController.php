<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;// when you want to delete file or image add this
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\PasswordReset;
use App\Models\User;
use App\Models\Book;
use App\Models\Review;






use Intervention\Image\ImageManager;// to use intervention package for image manipulation
use Intervention\Image\Drivers\Gd\Driver;// to use intervention package for imag




class AcountController extends Controller
{
    // this method will show register page.
    public function register(){
        
        return view('account.register');
    }

    // this method will register a user.
    public function processRegister(Request $request){
        $validator=Validator::make($request->all(),[
         'name'=>'required|min:3',
         'email'=>'required|email|unique:users',
         'password'=>'required|confirmed|min:8',// in this line code 'confirmed' property 
         'password_confirmation'=>'required',
        ]);
        if($validator->fails()){
         return redirect()->route('account.register')->withInput()->withErrors($validator);

        }
        else{
            $user=new User();
            $user->name=$request->name;
            $user->email=$request->email;
            $user->password= Hash::make($request->password);
            $user->save();
            return redirect()->route('account.login')->with('success','you have registerd sucesssfully');
        }

        }
        public function login(){
            return view('account.login');
        }

        public function authenticate(Request $request) {

            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required'
            ]);
        
            if ($validator->fails()) {
                return redirect()->route('account.login')->withErrors($validator)->withInput();
            }

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                // Login successful
                return redirect()->route('account.profile');

            }else{
                return redirect()->route('account.login')->withInput()->with('error','email or password is invalid!');
            }
        
            
        }
        // this method will show user profile page.
        public function profile(){
            $user= User::find(Auth::user()->id);//take authenticated user data 
            return view('account.profile',['user'=>$user]);// 
        }
        // this method will update user profile
        public function updateProfile(Request $request){
            $rules=[
                'name'=>'required|min:3',
                'email'=>'required|email|unique:users,email,'.Auth::user()->id.',id', //  email,'.Auth::user()->id.',id' means allowing the user to keep their current email without validation errors, means for current email that already exist for this user don't check or ignore unique email validation
            ];

            if(!empty($request->image)){
                $rules['image']='image';// Ensures the file is a valid image if provided,adds an image validation rule to the $rules array.
               }

        $validator= Validator::make($request->all(),$rules);

       

        if($validator->fails()){
            return redirect()->route('account.profile')->withInput()->withErrors($validator);
        }
        $user= User::find(Auth::user()->id);
        $user->name=$request->name;
        $user->email=$request->email;
        $user->save();

        // Here we will upload image
        if(!empty($request->image)){
            
            // delete old image here
            File::delete(public_path('uploads/profile/'.$user->image));
            File::delete(public_path('uploads/profile/thumb/'.$user->image));


        $image= $request->image;
        $ext= $image->getClientOriginalExtension();
        $imageName= time().'.'.$ext; //121212.jpg
        $image->move(public_path('uploads/profile'),$imageName);

        $user->image= $imageName; // save into database
        $user->save();

        $manager = new ImageManager(Driver::class);
        $img = $manager->read(public_path('uploads/profile/'.$imageName)); // 800 x 600
        $img->cover(150, 150);
        $img->save(public_path('uploads/profile/thumb/'.$imageName));
        } 

        return redirect()->route('account.profile')->with('success','profile updated successfully');
        }
        
        public function logout(){
            Auth::logout();
            return redirect()->route('account.login');
        }
//...........................................................................

        public function myReviews(Request $request){
            $reviews = Review::with('book')->where('user_id',Auth::user()->id);
            $reviews=$reviews->orderBy('created_at','DESC');
            if(!empty($request->keyword)){
                $reviews=$reviews->where('review','like','%'.$request->keyword.'%');
            }
            $reviews=$reviews->paginate(8);

            return view('account.my-reviews.my-reviews',['reviews'=>$reviews]);
        }

        // this method will edit review page
        public function editReviw(Request $request,$id){
         $review = Review::where([
            'id'=>$id,
            'user_id'=>Auth::user()->id,
         ])->with('book')->first();

         return view('account.my-reviews.edit-review',['review'=>$review]);
        }

        // this method will upadate a review.
    public function updateReview(Request $request, $id) {
        $review = Review::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'review' => 'required|string|min:10|max:400',
            'rating' => 'required|integer|min:1|max:5',
        ]);
    
        if ($validator->fails()) {
            return redirect()
                ->route('account.myReviews.editReview', $id)
                ->withErrors($validator)
                ->withInput();
        } else {
            $review->review = $request->review;
            $review->rating = $request->rating;
            $review->save();
    
            session()->flash('success', 'Review updated successfully');
            return redirect()->route('account.myReview');
        }
    }

    // this method will delete the review.
    public function deleteReview($id){

        $review=Review::find($id);
        if($review==null){
            session()->flash('error', 'Review not found');
            return redirect()->route('account.myReview');
        }
        else{
            $review->delete($id);
            session()->flash('success', 'Review Deleted successfully');
                return redirect()->route('account.myReview');
        }
       
    }
    //.........................................................................................
    //                      changing password:

     // Handle password change
     public function changePassword(Request $request)
     {
        $request->validate([
            'email' => 'required|email|exists:users,email', // Check if email exists in users table
            'oldpassword' => 'required', // Old password must be provided
            'newpassword' => 'required|min:8|confirmed', // Minimum 8 characters and must match confirmation
        ]);
        
 
         $user = Auth::user();
         // verify the email
         if ($request->email !== $user->email) {
            return back()->withInput()->withErrors(['email' => 'The email is incorrect.']);
        }
         // Verify the old password
         if (!Hash::check($request->oldpassword, $user->password)) {
             return back()->withInput()->withErrors(['oldpassword' => 'The old password is incorrect.']);
         }
 
         // Update the password
         $user->update(['password' => Hash::make($request->newpassword)]);
 
         return back()->with('success', 'Password changed successfully.');
     }
 

     // Send password reset email
public function sendPasswordResetEmail(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:users,email',
    ]);
       
    $user = User::where('email', $request->email)->first();

    // Generate a reset token
    $token = Str::random(64);

    // Store the token
    PasswordReset::updateOrCreate(
        ['email' => $user->email],
        ['token' => $token]
    );
    $subject="Password Reset Request";
    $msg="You requested a password reset.";

    // Send reset email with the subject and message
    Mail::to($user->email)->send(new SendMail($subject,$msg,$token));

    return back()->with('success', 'A password reset link has been sent to your email.');

}


     // Show reset password form
     public function showResetPasswordForm($token)
     {
         return view('account.password.reset-password', compact('token'));
     }
 


     // Reset the password
     public function resetPassword(Request $request)
     {
         $request->validate([
             'email' => 'required|email|exists:users,email',
             'newpassword' => 'required|min:8|confirmed',
         ]);
 
         
         // Verify token
         $passwordReset = PasswordReset::where('email', $request->email)
             ->where('token', $request->token)
             ->first();
 
         if (!$passwordReset) {
             return back()->withErrors(['token' => 'Invalid or expired token.']);
         }
 
         // Reset password
         

            $user = User::where('email', $request->email)->first();
         $user->update(['password' => Hash::make($request->newpassword)]);
 
         // Delete the token
         $passwordReset->delete();
 
         return redirect()->route('account.profile')->with('success', 'Password reset successfully.');
         }
         
         
     }

