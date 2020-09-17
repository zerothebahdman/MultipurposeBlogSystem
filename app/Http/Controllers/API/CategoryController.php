<?php

namespace App\Http\Controllers\API;
use App\Category;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Category::orderBy('id', 'desc')->get();
    }

    public function category(){
        return Category();
    }

    public function editCategory(Request $request)
    {

        $this->validate($request, [
            'categoryName' => 'required',
            'image' => 'required',
            // 'id' => 'required',
        ]);
        return Category::where('id', $request->id)->update([
            'categoryName' => $request['categoryName'],
            'image' => $request['image'],
        ]);
        return ['message' => 'Category Updated Successfully'];
    }

    public function deleteCategory(Request $request) {
        $this->validate($request, [
            'id' => 'required',
        ]);
        return Category::where('id', $request->id)->delete();
        return ['message' => 'Category deleted Successfully'];
    }

    public function upload(Request $request){
        $this->validate($request, [
            'file' => 'required|mimes:jpeg,png,bimp',
        ]);
        $picName = time().'.'.$request->file->extension();
        $request->file->move(public_path('img/uploads'), $picName);
        return $picName;
    }
    public function deleteImage(Request $request) {
        $fileName = $request->imageName;
        $this->deleteFileFromServer($fileName);
        return 'done';
    }
    public function deleteFileFromServer($fileName){
        $filePath = public_path().'/img/uploads/'.$fileName;
        if (file_exists($filePath)) {
            @unlink($filePath);
        }
        return 'done';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate Request
        $this->validate($request, [
            'categoryName' => 'required',
            'image' => 'required',
        ]);
        return Category::create([
            'categoryName' => $request['categoryName'],
            'image' => $request['image'],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}