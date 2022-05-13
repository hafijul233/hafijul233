<?php

namespace App\Http\Controllers\Backend\Portfolio;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Portfolio\AwardRequest;
use App\Http\Requests\Backend\Portfolio\UpdateServiceRequest;
use App\Services\Auth\AuthenticatedSessionService;
use App\Services\Backend\Portfolio\ServiceService;
use App\Supports\Utility;
use Box\Spout\Common\Exception\InvalidArgumentException;
use Box\Spout\Common\Exception\IOException;
use Box\Spout\Common\Exception\UnsupportedTypeException;
use Box\Spout\Writer\Exception\WriterNotOpenedException;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

/**
 * @class PostController
 * @package App\Http\Controllers\Backend\Portfolio
 */
class ServiceController extends Controller
{
    /**
     * @var AuthenticatedSessionService
     */
    private $authenticatedSessionService;
    /**
     * @var ServiceService
     */
    private $serviceService;

    /**
     * PostController Constructor
     *
     * @param AuthenticatedSessionService $authenticatedSessionService
     * @param ServiceService $serviceService
     */
    public function __construct(AuthenticatedSessionService $authenticatedSessionService, ServiceService $serviceService)
    {
        $this->authenticatedSessionService = $authenticatedSessionService;
        $this->serviceService = $serviceService;
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
        $services = $this->serviceService->servicePaginate($filters);

        return view('backend.portfolio.service.index', [
            'services' => $services
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     * @throws Exception
     */
    public function create()
    {
        return view('backend.portfolio.service.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AwardRequest $request
     * @return RedirectResponse
     * @throws Exception|Throwable
     */
    public function store(AwardRequest $request): RedirectResponse
    {
        $inputs = $request->except('_token');

        $confirm = $this->serviceService->storeService($inputs);

        if ($confirm['status'] == true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);
            return redirect()->route('backend.portfolio.services.index');
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
        if ($service = $this->serviceService->getServiceById($id)) {
            return view('backend.portfolio.service.show', [
                'service' => $service,
                'timeline' => Utility::modelAudits($service)
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
        if ($service = $this->serviceService->getServiceById($id)) {
            return view('backend.portfolio.service.edit', [
                'service' => $service]);
        }

        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AwardRequest $request
     * @param  $id
     * @return RedirectResponse
     * @throws Throwable
     */
    public function update(AwardRequest $request, $id): RedirectResponse
    {
        $inputs = $request->except('_token', 'submit', '_method');
        $confirm = $this->serviceService->updateService($inputs, $id);

        if ($confirm['status'] == true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);
            return redirect()->route('backend.portfolio.services.index');
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
            $confirm = $this->serviceService->destroyService($id);

            if ($confirm['status'] == true) {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            } else {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            }
            return redirect()->route('backend.portfolio.services.index');
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
            $confirm = $this->serviceService->restoreService($id);

            if ($confirm['status'] == true) {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            } else {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            }
            return redirect()->route('backend.portfolio.services.index');
        }
        abort(403, 'Wrong user credentials');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return string|StreamedResponse
     * @throws IOException
     * @throws InvalidArgumentException
     * @throws UnsupportedTypeException
     * @throws WriterNotOpenedException
     * @throws Exception
     */
    public function export(Request $request)
    {
        $filters = $request->except('page');
        $serviceExport = $this->serviceService->exportService($filters);
        $filename = 'Post-' . date('Ymd-His') . '.' . ($filters['format'] ?? 'xlsx');
        return $serviceExport->download($filename, function ($service) use ($serviceExport) {
            return $serviceExport->map($service);
        });
    }

    /**
     * Display a detail of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function ajax(Request $request): JsonResponse
    {
        $filters = $request->except('page');

        $services = $this->serviceService->getAllServices($filters);

        if (count($services) > 0):
            foreach ($services as $index => $service) :
                $services[$index]->update_route = route('backend.portfolio.services.update', $service->id);
        $services[$index]->survey_id = $service->surveys->pluck('id')->toArray();
        $services[$index]->prev_post_state_id = $service->previousPostings->pluck('id')->toArray();
        $services[$index]->future_post_state_id = $service->futurePostings->pluck('id')->toArray();
        unset($services[$index]->surveys, $services[$index]->previousPostings, $services[$index]->futurePostings);
        endforeach;

        $jsonReturn = ['status' => true, 'data' => $services]; else :
            $jsonReturn = ['status' => false, 'data' => []];
        endif;

        return response()->json($jsonReturn, 200);
    }
}
