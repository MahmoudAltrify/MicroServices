<?php

namespace App\Http\Controllers;

use App\Services\AuthorService;
use App\Services\BookService;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class BookController extends Controller
{
    use ApiResponser;

    /**
     * The service to consume the book microservice
     * @var
     */
    public $bookService;
    /**
     * The service to consume the author microservice
     * @var
     */
    public $authorService;

    /**
     * BookController constructor.
     * @param BookService $bookService
     * @param AuthorService $authorService
     */
    public function __construct(BookService $bookService,AuthorService $authorService)
    {
        $this->bookService = $bookService;
        $this->authorService = $authorService;
    }

    /**
     * Display a listing of the resource.
     * Illuminate\Http\Response
     * @return JsonResponse
     */
    public function index()
    {
        return $this->successResponse($this->bookService->obtainBooks());
    }

    /**
     * Store a newly created resource in storage.
     *
     * Illuminate\Http\Response
     * @param Request $request
     */
    public function store(Request $request)
    {
        $this->authorService->obtainAuthor($request->author_id);
        return $this->successResponse($this->bookService->createBook($request->all(), Response::HTTP_CREATED));
    }

    /**
     * show the specified resource in storage.
     *
     * Illuminate\Http\Response
     * @param $book
     */
    public function show($book)
    {
        return $this->successResponse($this->bookService->obtainBook($book));
    }

    /**
     * Update the specified resource in storage.
     *
     * Illuminate\Http\Response
     * @param Request $request
     * @param $book
     * @throws ValidationException
     */
    public function update(Request $request, $book)
    {
        return $this->successResponse($this->bookService->editBook($request->all(),$book));

    }

    /**
     * Remove the specified resource from storage.
     *
     * Illuminate\Http\Response
     * @param $book
     */
    public function destroy($book)
    {
        return $this->successResponse($this->bookService->deleteBook($book));
    }
}
