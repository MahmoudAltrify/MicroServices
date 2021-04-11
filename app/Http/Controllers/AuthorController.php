<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthorController extends Controller
{
    use ApiResponser;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Display a listing of the resource.
     * Illuminate\Http\Response
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(){
        return $this->successResponse(Author::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * Illuminate\Http\Response
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request){
        $rules = [
            'name' => 'required|max:255',
            'country' => 'required|max:255',
            'gender' => 'required|in:male,female'
        ];
        $this-> validate($request,$rules);
        $author = Author::create($request->all());

        return $this->successResponse($author, Response::HTTP_CREATED);
    }

    /**
     * show the specified resource in storage.
     *
     * Illuminate\Http\Response
     * @param $author
     */
    public function show($author){
        $author = Author::findOrFail($author);
        return $this->successResponse($author);
    }

    /**
     * Update the specified resource in storage.
     *
     * Illuminate\Http\Response
     * @param Request $request
     * @param $author
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request,$author){
        $rules = [
            'name' => 'required|max:255',
            'country' => 'required|max:255',
            'gender' => 'required|in:male,female'
        ];
        $this-> validate($request,$rules);
        $author = Author::findOrFail($author);
        $author->fill($request->all());
        if($author->isClean()){
            return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $author->save();
        return $this->successResponse($author);

    }

    /**
     * Remove the specified resource from storage.
     *
     * Illuminate\Http\Response
     * @param $author
     */
    public function destroy($author){
        $author = Author::findOrFail($author);
        $author->delete();
        return $this->successResponse($author);//i can call $author because it's still in the memory
    }
}
