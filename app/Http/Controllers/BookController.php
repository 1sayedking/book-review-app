<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Book;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;// when you want to delete file or image add this
use Intervention\Image\ImageManager;// to use intervention package for image manipulation
use Intervention\Image\Drivers\Gd\Driver;// to use intervention package for imag


class BookController extends Controller
{


    // This method will show books listing page
    public function index(Request $request)
    {

        $books=Book::orderBy('created_at','DESC');

        if(!empty($request->keyword)){
            $books->where('title','like','%'.$request->keyword.'%');
        }

        $books=$books->withCount('reviews')->withSum('reviews','rating')->paginate(8);

        return view('books.list',['books'=>$books]);
    }

    //...........................................................
    //this method will show create book page
    public function create(){
       

        return view('books.create');
    }
    //............................................................
    // this method will store a book in DB.
    public function store(Request $request){
        
        $rules=[
            'title'=>'required|min:4',
            'author'=>'required|min:4',
            'bookpdf' => 'required|mimes:pdf|max:8240', 
            'status'=>'required',
            
            ];

            

           
            if(!empty($request->description)){
                $rules['description']='min:5|max:1000';
            }

            if(!empty($request->image)){
                $rules['image']='image';
            }
           


        $validator= Validator::make($request->all(),$rules);
        if($validator->fails()){
            return redirect()->route('books.create')->withInput()->withErrors($validator);
        }
        
        // save book in DB
        $book = new Book();
        $book->title = $request->title;
        $book->author = $request->author;
        $book->description = $request->description;
        $book->status = $request->status;
       
        //upload book pfd file here
        //...............................................
        // direct to public folder is quick but un secure
        // $pdf=$request->bookpdf;
        // $extp=$pdf->getClientOriginalExtension();
        // $pdfName=Str::uuid() .'.'.$extp;
        // $pdf->move(public_path('uploads/bookpdf'),$pdfName);// first create folder if not exist nanwally
        // $pdfpath='uploads/bookpdf/'.$pdfName;
        // $book->bookpdf=$pdfpath;
        //.........or..with storage link........................
    // Get the uploaded file
    $pdf = $request->file('bookpdf');
   // Generate a unique file name
    $pdfName = Str::uuid() . '.' . $pdf->getClientOriginalExtension();

    // Store the file in the "public/bookpdf" directory
    $pdfPath = $pdf->storeAs('bookpdf', $pdfName, 'public');

    // Save the relative path in the database
    $book->bookpdf = $pdfPath; // Store relative path like "bookpdf/filename.pdf"

        $book->save();
        //.......................
        // upload book image here
        if(!empty($request->image)){
            $image=$request->image;
            $ext= $image->getClientOriginalExtension();
            $imageName=time().'.'.$ext;
            $image->move(public_path('uploads/books'),$imageName);

            $book->image= $imageName;
            $book->save();

            $manager = new ImageManager(Driver::class);
            $img = $manager->read(public_path('uploads/books/'.$imageName));
            
            // Force resize without keeping aspect ratio
            $img->resize(495,700, function ($constraint) {
                $constraint->aspectRatio(false); // Disable aspect ratio constraint
                });
            $img->save(public_path('uploads/books/thumb/'.$imageName));
        }
       
        
        return redirect()->route('books.index')->with('success','book added successfully');


    }
    //.......................................................................
    // read abook
    public function readBook($id)
{
    // Find the book in the database
    $book = Book::findOrFail($id);

    // Pass the PDF path to the view
    return view('read-book', ['book' => $book]);
}
    /**
     * Download the PDF file by ID.
     */
    public function download($id)
{
    // Find the book in the database
    $book = Book::findOrFail($id);

    // Get the relative file path (already stored in the 'public' disk)
    $filePath = $book->bookpdf;

    // Check if the file exists in the 'public' disk
    if (Storage::disk('public')->exists($filePath)) {
        return Storage::disk('public')->download($filePath);
    }

    // Return an error if the file does not exist
    return back()->withErrors('File not found.');
}

    //........................................................
    // this method will show edit book page
    public function edit($id){
        $book=Book::findOrFail($id);
        return view('books.edit',['book'=>$book]);

    }
// this method will upate a book
    public function update(Request $request, $id){
        $book=Book::findOrFail($id);
        $rules=[
            'title'=>'required|min:4',
            'author'=>'required|min:4',
            'status'=>'required',
    
            ];
            if(!empty($request->description)){
                $rules['description']='min:5|max:1000';
            }
            
            if(!empty($request->image)){
                $rules['image']='image';
            }
            
            $validator= Validator::make($request->all(),$rules);
            if($validator->fails()){
                return redirect()->route('books.edit',$book->id)->withInput()->withErrors($validator);
            }
            // update book in DB
        
        $book->title = $request->title;
        $book->author = $request->author;
        $book->description = $request->description;
        $book->status = $request->status;
        $book->save();

           // upload book image here
        if(!empty($request->image)){
            // this will delete old book image from books directory
            File::delete(public_path('uploads/books/'.$book->image));
            File::delete(public_path('uploads/books/thumb/'.$book->image));
         //................................................
            $image=$request->image;
            $ext=$image->getClientOriginalExtension();
            $imageName= time().'.'.$ext;
            $image->move(public_path('uploads/books'), $imageName);
            $book->image=$imageName;
            $book->save();
            //.......or..................
             // Update book details
    // $book->update([// if you use this must add  protected $fillable  in model.
    //     'title' => $request->title,
    //     'author' => $request->author,
    //     'description' => $request->description,
    //     'status' => $request->status,
    // ]);
    //.......................................................

            //generate image thumbnail here
            $manager = new ImageManager(Driver::class);
            $img = $manager->read(public_path('uploads/books/'.$imageName));
            
            // Force resize without keeping aspect ratio
            $img->resize(495, 700, function ($constraint) {
            $constraint->aspectRatio(false); // Disable aspect ratio constraint
            });
            
            $img->save(public_path('uploads/books/thumb/'.$imageName));
        }
        
        return redirect()->route('books.index')->with('success','book updated successfully');

            


    }

    // this method will delete abook from DB
    public function destroy($id){
        $book=Book::findOrFail($id);

// this will delete old book image from books directory
File::delete(public_path('uploads/books/'.$book->image));
File::delete(public_path('uploads/books/thumb/'.$book->image));

// delete book pdf file from folder
// Retrieve the file path from the database
$pdfPath = $book->bookpdf;  // For example, 'bookpdf/filename.pdf'

// Check if the file exists and delete it
if (Storage::disk('public')->exists($pdfPath)) {
    Storage::disk('public')->delete($pdfPath);
}

$book->delete();// delete book from DB.

session()->flash('success','book deleted successfully');
return redirect()->route('books.index'); 

//...............or.....with check book and image exist or not.......     
       
 // Check if the book exists
//  $book = Book::find($id);

//  if (!$book) {
//      // Flash a message if the book does not exist
//      session()->flash('error', 'Book not found.');
//      return redirect()->route('books.index');
//  }

//  // Check and delete the image files if they exist
//  $bookImagePath = public_path('uploads/books/' . $book->image);
//  $bookThumbPath = public_path('uploads/books/thumb/' . $book->image);

//  if (File::exists($bookImagePath)) {
//      File::delete($bookImagePath);
//  }

//  if (File::exists($bookThumbPath)) {
//      File::delete($bookThumbPath);
//  }

//  // Delete the book from the database
//  $book->delete();

//  // Flash a success message
//  session()->flash('success', 'Book deleted successfully.');

//  return redirect()->route('books.index');
    }


}
