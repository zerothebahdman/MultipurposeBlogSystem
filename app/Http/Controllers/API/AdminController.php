<?php

namespace App\Http\Controllers\API;

use App\Tag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Tag::orderBy('id', 'desc')->get();
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
            'tagName' => 'required'
        ]);
        return Tag::create([
            'tagName' => $request['tagName'],
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
    public function update(Request $request, $id)
    {
        // $tag = Tag::findOrFail($id);
         // Validate Request
        // $this->validate($request, [
        //     'tagName' => 'required'
        // ]);
        // $tag->update($request->all());
        // $this->validate($request, [
        //     'tagName' => 'required',
        //     'id' => 'required',
        //     ]);
        //     return Tag::where('id', $request->id)->update([
        //         'tagName' => $request->tagName
        //         ]);
        //         return ['message' => 'Tag Updated Successfully'];
    }

    public function editTag(Request $request) {
        $this->validate($request, [
            'tagName' => 'required',
            'id' => 'required',
            ]);
            return Tag::where('id', $request->id)->update([
                'tagName' => $request->tagName
                ]);
                return ['message' => 'Tag Updated Successfully'];
    }

    public function deleteTag(Request $request) {
        $this->validate($request, [
            'id' => 'required',
            ]);
            return Tag::where('id', $request->id)->delete();
                return ['message' => 'Tag deleted Successfully'];
    }

    // public function fileUpload(Request $request) {
    //     return $picName = time().'.'.$request->file->extension();
    // }

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
