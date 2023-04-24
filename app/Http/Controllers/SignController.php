<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\signature;
use Image;                      //  this is composer require intervention/image
use Illuminate\Support\Facades\Response;

class SignController extends Controller
{
    public function index()   // this to get all data in table
    {
        $books = signature::latest()->paginate(2);
       // return array_reverse($books);
       return response()->json($books);
    }

    public function signe()     // this to get all data in table
    {
        $books = signature::all()->toArray();
        return array_reverse($books);
    }

    function insert_image(Request $request)  // this to insert new data
    {

        $image_file = $request->user_image;
        
        $form_data = array(
           'user_image' => $image_file
        );

       

        signature::create($form_data);

        return response()
        ->json(['status' => 'successs'], 200);
    
    }

    function fetch_image($image_id)   // this to get all data in table
    {
     $image = signature::findOrFail($image_id);   // to get all image we must convert data in table to image so 

     $image_file = Image::make($image->user_image);   // so make image and use  this is composer require intervention/image

     $response = Response::make($image_file->encode('jpeg'));  // this is to response our image in frontend

     $response->header('Content-Type', 'image/jpeg');

     return $response;
    }

    public function destroy($id)  /// this function delete data
    {
        //

        $user = signature::findOrFail($id);
        $filePath = $user->image;

        if (file_exists($filePath)) {

        unlink($filePath);
        }

        $user -> delete();
        return back()->with('success', 'success delete');
    }
}
