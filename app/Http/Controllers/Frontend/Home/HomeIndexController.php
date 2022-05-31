<?php

namespace App\Http\Controllers\Frontend\Home;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Setting\CatalogRequest;
use App\Services\Backend\Blog\PostService;
use App\Services\Backend\Portfolio\ProjectService;
use App\Services\Backend\Portfolio\ServiceService;
use App\Services\Backend\Portfolio\TestimonialService;
use App\Supports\Utility;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

/**
 * Class AboutIndexController
 * @package App\Http\Controllers\Frontend
 */
class HomeIndexController extends Controller
{
    /**
     * @var ServiceService
     */
    private $serviceService;
    /**
     * @var ProjectService
     */
    private $projectService;
    /**
     * @var TestimonialService
     */
    private $testimonialService;
    /**
     * @var PostService
     */
    private $postService;

    /**
     * AboutIndexController Constructor
     * @param ServiceService $serviceService
     * @param ProjectService $projectService
     * @param TestimonialService $testimonialService
     * @param PostService $postService
     */
    public function __construct(
        ServiceService $serviceService,
        ProjectService $projectService,
        TestimonialService $testimonialService,
        PostService $postService
    ) {
        $this->serviceService = $serviceService;
        $this->projectService = $projectService;
        $this->testimonialService = $testimonialService;
        $this->postService = $postService;
    }

    /**
     *
     * @param Request $request
     * @return Application|Factory|View
     * @throws Exception
     */
    public function __invoke(Request $request)
    {
        $services = $this->serviceService->getAllServices([
            'limit' => 5
        ]);

        return view('frontend.home.index', compact('services'));
    }
}
