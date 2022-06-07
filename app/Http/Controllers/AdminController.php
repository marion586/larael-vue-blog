<?php

namespace App\Http\Controllers;

use App\Category;
use App\Tag;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function addTag (Request $request) {
        //validate
        $this->validate($request , [
            'tagName' => 'required'
        ]);
        return Tag::create([
            'tagName' => $request->tagName 
        ]);
    }

    public function editTag (Request $request) {
        //validate
        $this->validate($request , [
            'tagName' => 'required',
            'id' => 'required'
        ]);
        return Tag::where('id' , $request->id)->update([
            'tagName' => $request->tagName
        ]);
    }


    public function deleteTag (Request $request) {
        //validate
        $this->validate($request , [
            'id' => 'required'
        ]);
        return Tag::where('id' , $request->id)->delete();
    }

    public function getTag(){
        return Tag::orderby('id' , 'desc')->get();
    }

    public function upload(Request $request) {

            $this->validate($request , [
            'file' => 'required|mimes:jpeg,jpg,png',
           
        ]);
             $picName = time().'.'.$request->file->extension();
            //  it gonna create a upload directory to the public
            $request->file->move(public_path('uploads') , $picName);
            return $picName;
            // concatenation;
    }

   
    public function deleteImage(Request $request) {
        $filename = $request->imageName;
        $this->deleteFileFromServer($filename);
        return 'done';
    }
    
     public function deleteFileFromServer($filename) {
        $filePath = public_path().'/uploads/'.$filename;
        echo $filePath;
        if(file_exists($filePath)){
            @unlink($filePath);
            // it's gonnga delete file from it's directory
        }
        return ;
    }

    public function addCategory(Request $request){
          //validate
        $this->validate($request , [
            'categoryName' => 'required',
            'iconImage' => 'required'
        ]);
        $ert = new Category();
    
        return Category::create([
            'categoryName' => $request->categoryName ,
            'iconImage' => $request->iconImage
        ]);
    }

    public function getCategory() {
        return Category::orderBy('id' , 'desc')->get();
    }
}
