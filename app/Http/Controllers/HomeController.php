<?php

namespace App\Http\Controllers;


use App\Http\Responses\ErrorResponse;
use App\Http\Responses\SuccessResponse;
use App\Repositories\HomeRepository;

class HomeController extends Controller
{

    /**
     * @var string
     */
    protected $viewPath = 'home';

    /**
     * @var string
     */
    protected $baseRoute = 'home';

    /**
     * @var HomeRepository
     */
    protected $repository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->repository = new HomeRepository();
    }


    /**
     * @return ErrorResponse|SuccessResponse
     */
    public function index()
    {
        try {
            $lessons = $this->repository->index(20);
            return new SuccessResponse($this->viewPath, ['lessons' => $lessons]);
        } catch (\Exception $exception) {
            return new ErrorResponse($exception);
        }

    }
}
