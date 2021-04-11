<?php

namespace App\Http\Controllers;

use App\Services\AuthorService;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class AuthorController extends Controller
{
    use ApiResponser;

    /**
     * The service to consume the author microservice
     * @var
     */
    public $authorService;

    /**
     * AuthorController constructor.
     * @param AuthorService $authorService
     */
    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }

    /**
     * Display a listing of the resource.
     * Illuminate\Http\Response
     * @return JsonResponse
     */
    public function index()
    {
        return $this->successResponse($this->authorService->obtainAuthors());
    }

    /**
     * Store a newly created resource in storage.
     *
     * Illuminate\Http\Response
     * @param Request $request
     */
    public function store(Request $request)
    {
        return $this->successResponse($this->authorService->createAuthor($request->all(), Response::HTTP_CREATED));
    }

    /**
     * show the specified resource in storage.
     *
     * Illuminate\Http\Response
     * @param $author
     */
    public function show($author)
    {
        return $this->successResponse($this->authorService->obtainAuthor($author));
    }

    /**
     * Update the specified resource in storage.
     *
     * Illuminate\Http\Response
     * @param Request $request
     * @param $author
     * @throws ValidationException
     */
    public function update(Request $request, $author)
    {
        return $this->successResponse($this->authorService->editAuthor($request->all(),$author));

    }

    /**
     * Remove the specified resource from storage.
     *
     * Illuminate\Http\Response
     * @param $author
     */
    public function destroy($author)
    {
        return $this->successResponse($this->authorService->deleteAuthor($author));
    }
}
