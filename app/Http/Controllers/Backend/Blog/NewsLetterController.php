<?php

namespace App\Http\Controllers\Backend\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Portfolio\CreateNewsLetterRequest;
use App\Http\Requests\Backend\Portfolio\UpdateNewsLetterRequest;
use App\Services\Auth\AuthenticatedSessionService;
use App\Services\Backend\Blog\NewsLetterService;
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
 * Class NewsLetterController
 * @package App\Http\Controllers\Backend\Blog
 */
class NewsLetterController extends Controller
{
    /**
     * @var AuthenticatedSessionService
     */
    private $authenticatedSessionService;

    /**
     * @var NewsLetterService
     */
    private $newsLetterService;

    /**
     * PostController Constructor
     *
     * @param AuthenticatedSessionService $authenticatedSessionService
     * @param NewsLetterService $newsLetterService
     */
    public function __construct(
        AuthenticatedSessionService $authenticatedSessionService,
        NewsLetterService $newsLetterService
    )
    {
        $this->authenticatedSessionService = $authenticatedSessionService;
        $this->newsLetterService = $newsLetterService;
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
        $newsLetters = $this->newsLetterService->newsLetterPaginate($filters);

        return view('backend.blog.newsletter.index', [
            'newsLetters' => $newsLetters
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Exception
     */
    public function create()
    {
        $enables = [];
        foreach (Constant::ENABLED_OPTIONS as $field => $label):
            $enables[$field] = __('common.' . $label);
        endforeach;

        return view('backend.blog.newsletter.create', [
            'enables' => $enables,
            'states' => $this->stateService->getStateDropdown(['enabled' => Constant::ENABLED_OPTION, 'type' => 'district', 'sort' => ((session()->get('locale') == 'bd') ? 'native' : 'name'), 'direction' => 'asc'], (session()->get('locale') == 'bd')),
            'surveys' => $this->surveyService->getSurveyDropDown(['enabled' => Constant::ENABLED_OPTION]),
            'genders' => $this->catalogService->getCatalogDropdown(['type' => Constant::CATALOG_TYPE['GENDER']], 'bn'),
            'exam_dropdown' => $this->examLevelService->getExamLevelDropdown(['id' => [1, 2, 3, 4]]),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateNewsLetterRequest $request
     * @return RedirectResponse
     * @throws Exception|Throwable
     */
    public function store(CreateNewsLetterRequest $request): RedirectResponse
    {
        $inputs = $request->except('_token');

        $confirm = $this->newsLetterService->storeNewsLetter($inputs);

        if ($confirm['status'] == true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);
            return redirect()->route('backend.portfolio.newsLetters.index');
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
        if ($newsLetter = $this->newsLetterService->getNewsLetterById($id)) {
            return view('backend.blog.newsletter.show', [
                'certificate' => $newsLetter,
                'timeline' => Utility::modelAudits($newsLetter)
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
        if ($newsLetter = $this->newsLetterService->getNewsLetterById($id)) {
            $enables = [];
            foreach (Constant::ENABLED_OPTIONS as $field => $label):
                $enables[$field] = __('common.' . $label);
            endforeach;

            return view('backend.blog.newsletter.edit', [
                'certificate' => $newsLetter,
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
     * @param CreateNewsLetterRequest $request
     * @param  $id
     * @return RedirectResponse
     * @throws Throwable
     */
    public function update(UpdateNewsLetterRequest $request, $id): RedirectResponse
    {
        $inputs = $request->except('_token', 'submit', '_method');
        $confirm = $this->newsLetterService->updateNewsLetter($inputs, $id);

        if ($confirm['status'] == true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);
            return redirect()->route('backend.portfolio.newsLetters.index');
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
            $confirm = $this->newsLetterService->destroyNewsLetter($id);

            if ($confirm['status'] == true) {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            } else {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            }
            return redirect()->route('backend.portfolio.newsLetters.index');
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
            $confirm = $this->newsLetterService->restoreNewsLetter($id);

            if ($confirm['status'] == true) {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            } else {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            }
            return redirect()->route('backend.portfolio.newsLetters.index');
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
        $newsLetterExport = $this->newsLetterService->exportNewsLetter($filters);
        $filename = 'Post-' . date('Ymd-His') . '.' . ($filters['format'] ?? 'xlsx');
        return $newsLetterExport->download($filename, function ($newsLetter) use ($newsLetterExport) {
            return $newsLetterExport->map($newsLetter);
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

        $newsLetters = $this->newsLetterService->getAllNewsLetters($filters);

        if (count($newsLetters) > 0):
            foreach ($newsLetters as $index => $newsLetter) :
                $newsLetters[$index]->update_route = route('backend.portfolio.newsLetters.update', $newsLetter->id);
        $newsLetters[$index]->survey_id = $newsLetter->surveys->pluck('id')->toArray();
        $newsLetters[$index]->prev_post_state_id = $newsLetter->previousPostings->pluck('id')->toArray();
        $newsLetters[$index]->future_post_state_id = $newsLetter->futurePostings->pluck('id')->toArray();
        unset($newsLetters[$index]->surveys, $newsLetters[$index]->previousPostings, $newsLetters[$index]->futurePostings);
        endforeach;

        $jsonReturn = ['status' => true, 'data' => $newsLetters]; else :
            $jsonReturn = ['status' => false, 'data' => []];
        endif;

        return response()->json($jsonReturn, 200);
    }
}
