<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookController extends Controller
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
        return $this->successResponse(Book::all());
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
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'price' => 'required|min:1',
            'author_id' => 'required|min:1'
        ];
        $this-> validate($request,$rules);
        $author = Book::create($request->all());

        return $this->successResponse($author, Response::HTTP_CREATED);
    }

    /**
     * show the specified resource in storage.
     *
     * Illuminate\Http\Response
     * @param $book
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($book){
        $book = Book::findOrFail($book);
        return $this->successResponse($book);
    }

    /**
     * Update the specified resource in storage.
     *
     * Illuminate\Http\Response
     * @param Request $request
     * @param $book
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request,$book){
        $rules = [
            'title' => 'max:255',
            'description' => 'max:255',
            'price' => 'min:1',
            'author_id' => 'min:1'
        ];
        $this-> validate($request,$rules);
        $book = Book::findOrFail($book);
        $book->fill($request->all());
        if($book->isClean()){
            return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $book->save();
        return $this->successResponse($book);
    }

    /**
     * Remove the specified resource from storage.
     *
     * Illuminate\Http\Response
     * @param $book
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($book){
        $book = Book::findOrFail($book);
        $book->delete();
        return $this->successResponse($book);//i can call $author because it's still in the memory
    }
    //
}
