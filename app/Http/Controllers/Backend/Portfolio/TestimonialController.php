<?php

namespace App\Http\Controllers\Backend\Portfolio;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Portfolio\TestimonialRequest;
use App\Services\Auth\AuthenticatedSessionService;
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
 * @class TestimonialController
 * @package App\Http\Controllers\Backend\Portfolio
 */
class TestimonialController extends Controller
{
    /**
     * @var AuthenticatedSessionService
     */
    private $authenticatedSessionService;

    /**
     * @var TestimonialService
     */
    private $testimonialService;

    /**
     * CommentController Constructor
     *
     * @param AuthenticatedSessionService $authenticatedSessionService
     * @param TestimonialService $testimonialService
     */
    public function __construct(AuthenticatedSessionService $authenticatedSessionService,
                                TestimonialService $testimonialService)
    {

        $this->authenticatedSessionService = $authenticatedSessionService;
        $this->testimonialService = $testimonialService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Application|Factory|View
     * @throws Exception
     */
    public function index(Request $request)
    {
        $filters = $request->except('page');
        $testimonials = $this->testimonialService->testimonialPaginate($filters);

        return view('backend.portfolio.testimonial.index', [
            'testimonials' => $testimonials
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('backend.portfolio.testimonial.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TestimonialRequest $request
     * @return RedirectResponse
     * @throws Exception|Throwable
     */
    public function store(TestimonialRequest $request): RedirectResponse
    {
        $confirm = $this->testimonialService->storeTestimonial($request->except('_token'));
        if ($confirm['status'] == true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);
            return redirect()->route('backend.portfolio.testimonials.index');
        }

        notify($confirm['message'], $confirm['level'], $confirm['title']);
        return redirect()->back()->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return Application|Factory|View
     * @throws Exception
     */
    public function show($id)
    {
        if ($testimonial = $this->testimonialService->getTestimonialById($id)) {
            return view('backend.portfolio.testimonial.show', [
                'testimonial' => $testimonial,
                'timeline' => Utility::modelAudits($testimonial)
            ]);
        }

        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return Application|Factory|View
     * @throws Exception
     */
    public function edit($id)
    {
        if ($testimonial = $this->testimonialService->getTestimonialById($id)) {
            return view('backend.portfolio.testimonial.edit', [
                'testimonial' => $testimonial
            ]);
        }

        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TestimonialRequest $request
     * @param  $id
     * @return RedirectResponse
     * @throws Throwable
     */
    public function update(TestimonialRequest $request, $id): RedirectResponse
    {
        $confirm = $this->testimonialService->updateTestimonial($request->except('_token', 'submit', '_method'), $id);

        if ($confirm['status'] == true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);
            return redirect()->route('backend.portfolio.testimonials.index');
        }

        notify($confirm['message'], $confirm['level'], $confirm['title']);
        return redirect()->back()->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @param Request $request
     * @return RedirectResponse
     * @throws Throwable
     */
    public function destroy($id, Request $request)
    {
        if ($this->authenticatedSessionService->validate($request)) {

            $confirm = $this->testimonialService->destroyTestimonial($id);

            if ($confirm['status'] == true) {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            } else {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            }
            return redirect()->route('backend.portfolio.testimonials.index');
        }
        abort(403, 'Wrong user credentials');
    }

    /**
     * Restore a Soft Deleted Resource
     *
     * @param $id
     * @param Request $request
     * @return RedirectResponse|void
     * @throws Throwable
     */
    public function restore($id, Request $request)
    {
        if ($this->authenticatedSessionService->validate($request)) {

            $confirm = $this->testimonialService->restoreTestimonial($id);

            if ($confirm['status'] == true) {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            } else {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            }
            return redirect()->route('backend.portfolio.testimonials.index');
        }
        abort(403, 'Wrong user credentials');
    }

    /**
     * Display a listing of the resource.
     *
     * @return string|StreamedResponse
     * @throws Exception
     */
    public function export(Request $request)
    {
        $filters = $request->except('page');

        $testimonialExport = $this->testimonialService->exportTestimonial($filters);

        $filename = 'Comment-' . date('Ymd-His') . '.' . ($filters['format'] ?? 'xlsx');

        return $testimonialExport->download($filename, function ($testimonial) use ($testimonialExport) {
            return $testimonialExport->map($testimonial);
        });

    }

    /**
     * Return an Import view page
     *
     * @return Application|Factory|View
     */
    public function import()
    {
        return view('backend.portfolio.testimonialimport');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     * @throws Exception
     */
    public function importBulk(Request $request)
    {
        $filters = $request->except('page');
        $testimonials = $this->testimonialService->getAllTestimonials($filters);

        return view('backend.portfolio.testimonialindex', [
            'testimonials' => $testimonials
        ]);
    }

    /**
     * Display a detail of the resource.
     *
     * @return StreamedResponse|string
     * @throws Exception
     */
    public function print(Request $request)
    {
        $filters = $request->except('page');

        $testimonialExport = $this->testimonialService->exportTestimonial($filters);

        $filename = 'Comment-' . date('Ymd-His') . '.' . ($filters['format'] ?? 'xlsx');

        return $testimonialExport->download($filename, function ($testimonial) use ($testimonialExport) {
            return $testimonialExport->map($testimonial);
        });

    }
}
