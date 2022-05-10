<?php

namespace App\Http\Controllers\Backend\Resume;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Resume\ExperienceRequest;
use App\Services\Auth\AuthenticatedSessionService;
use App\Services\Backend\Resume\ExperienceService;
use App\Supports\Constant;
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
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

/**
 * @class PostController
 * @package App\Http\Controllers\Backend\Resume
 */
class ExperienceController extends Controller
{
    /**
     * @var AuthenticatedSessionService
     */
    private $authenticatedSessionService;

    /**
     * @var ExperienceService
     */
    private $experienceService;

    /**
     * PostController Constructor
     *
     * @param AuthenticatedSessionService $authenticatedSessionService
     * @param ExperienceService $experienceService
     */
    public function __construct(AuthenticatedSessionService $authenticatedSessionService,
                                ExperienceService $experienceService)
    {

        $this->authenticatedSessionService = $authenticatedSessionService;
        $this->experienceService = $experienceService;
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
        $experiences = $this->experienceService->experiencePaginate($filters);

        return view('backend.resume.experience.index', [
            'experiences' => $experiences
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
        return view('backend.resume.experience.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ExperienceRequest $request
     * @return RedirectResponse
     * @throws Throwable
     */
    public function store(ExperienceRequest $request): RedirectResponse
    {
        $inputs = $request->except('_token');

        $confirm = $this->experienceService->storeEnumerator($inputs);

        if ($confirm['status'] == true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);
            return redirect()->route('backend.portfolio.experiences.index');
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
        if ($experience = $this->experienceService->getEnumeratorById($id)) {
            return view('backend.resume.experience.show', [
                'certificate' => $experience,
                'timeline' => Utility::modelAudits($experience)
            ]);
        }

        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return Application|Factory|View
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Exception
     */
    public function edit($id)
    {
        if ($experience = $this->experienceService->getEnumeratorById($id)) {

            $enables = [];
            foreach (Constant::ENABLED_OPTIONS as $field => $label):
                $enables[$field] = __('common.' . $label);
            endforeach;

            return view('backend.resume.experience.edit', [
                'certificate' => $experience,
                'enables' => $enables,
                'states' => $this->stateService->getStateDropdown(['enabled' => Constant::ENABLED_OPTION, 'type' => 'district', 'sort' => ((session()->get('locale') == 'bd') ? 'native' : 'name'), 'direction' => 'asc'], (session()->get('locale') == 'bd')),
                'surveys' => $this->surveyService->getSurveyDropDown(),
                'genders' => $this->catalogService->getCatalogDropdown(['type' => Constant::CATALOG_TYPE['GENDER']], 'bn'),
                'exam_dropdown' => $this->examLevelService->getExamLevelDropdown(['id' => [1, 2, 3, 4]]),
            ]);
        }

        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ExperienceRequest $request
     * @param  $id
     * @return RedirectResponse
     * @throws Throwable
     */
    public function update(ExperienceRequest $request, $id): RedirectResponse
    {
        $inputs = $request->except('_token', 'submit', '_method');
        $confirm = $this->experienceService->updateEnumerator($inputs, $id);

        if ($confirm['status'] == true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);
            return redirect()->route('backend.portfolio.experiences.index');
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

            $confirm = $this->experienceService->destroyEnumerator($id);

            if ($confirm['status'] == true) {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            } else {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            }
            return redirect()->route('backend.portfolio.experiences.index');
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

            $confirm = $this->experienceService->restoreEnumerator($id);

            if ($confirm['status'] == true) {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            } else {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            }
            return redirect()->route('backend.portfolio.experiences.index');
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
        $experienceExport = $this->experienceService->exportEnumerator($filters);
        $filename = 'Post-' . date('Ymd-His') . '.' . ($filters['format'] ?? 'xlsx');
        return $experienceExport->download($filename, function ($experience) use ($experienceExport) {
            return $experienceExport->map($experience);
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

        $experiences = $this->experienceService->getAllEnumerators($filters);

        if (count($experiences) > 0):
            foreach ($experiences as $index => $experience) :
                $experiences[$index]->update_route = route('backend.portfolio.experiences.update', $experience->id);
                $experiences[$index]->survey_id = $experience->surveys->pluck('id')->toArray();
                $experiences[$index]->prev_post_state_id = $experience->previousPostings->pluck('id')->toArray();
                $experiences[$index]->future_post_state_id = $experience->futurePostings->pluck('id')->toArray();
                unset($experiences[$index]->surveys, $experiences[$index]->previousPostings, $experiences[$index]->futurePostings);
            endforeach;

            $jsonReturn = ['status' => true, 'data' => $experiences];
        else :
            $jsonReturn = ['status' => false, 'data' => []];
        endif;

        return response()->json($jsonReturn, 200);
    }
}
