<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;

class DataController extends Controller
{

public function create(Request $request){

    $data['title'] = $request['title'];
    $data['description'] = $request['description'];
    $data['price'] = $request['price'];
    $file =  $request->file('image');
    // $data['image'] = $file->getMimeType();

 


    $validator = Validator::make($request->all(), [
        'title' => 'required|string',
        'description' => 'required',
        'price' => 'required|integer',
        'image' => 'required|max:10000|mimes:jpg,png',
    ]);

    if($validator->fails()){
            return response()->json($validator->errors(), 200 );
    }

  $data['image'] =  uniqid() .'.'. $file->getClientOriginalExtension();
      $destinationPath = 'uploads';
      $file->move( $destinationPath, $data['image'] );

   
    //may use model
    $users = DB::table('products')->insert($data);
    $msg = 'Post Create';
    return response()->json(compact('msg'),200);
}

public function post(){

    $post = DB::table('products')->get();
    return response()->json(compact('post'),200);
}
public function edit($id){

    $post = DB::table('products')->where('id', $id)->first();
    return response()->json(compact('post'),200);
}
public function edit_put(Request $request){

    $data['title'] = $request['title'];
    $data['description'] = $request['description'];
    $data['price'] = $request['price'];
    // $file =  $request->file('image');
    // $data['image'] = $file->getMimeType();


    if ( $file =  $request->file('image') ) {
       
        $data['image'] =  uniqid() .'.'. $file->getClientOriginalExtension();
        $validator = Validator::make($request->all(), [
            'image' => 'max:10000|mimes:jpg,png'
        ]);

        if($validator->fails()){
                return response()->json($validator->errors(), 200 );
        }
         $destinationPath = 'uploads';

        $old_img = DB::table('products')->where('id', $request['id'])->first();
        unlink($destinationPath .'/'. $old_img->image);

        $file->move( $destinationPath, $data['image'] );
    }
   

   
    //may use model
    $users = DB::table('products')->where('id',  $request['id'])->update($data);
    $msg = 'Post Updated';
    return response()->json(compact('data'),200);
}

public function delete($id){

    $old_img = DB::table('products')->where('id', $id)->first();
    unlink('uploads/'. $old_img->image);

   $users = DB::table('products')->where('id',  $id)->delete();
    $post = DB::table('products')->get();
    return response()->json(compact('post'),200);
}





}