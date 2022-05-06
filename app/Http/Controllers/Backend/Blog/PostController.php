<?php

namespace App\Http\Controllers\Backend\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Portfolio\CreatePostRequest;
use App\Http\Requests\Backend\Portfolio\UpdatePostRequest;
use App\Services\Auth\AuthenticatedSessionService;
use App\Services\Backend\Blog\PostService;
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
 * @package App\Http\Controllers\Backend\Blog
 */
class PostController extends Controller
{
    /**
     * @var AuthenticatedSessionService
     */
    private $authenticatedSessionService;

    /**
     * @var PostService
     */
    private $postService;

    /**
     * PostController Constructor
     *
     * @param AuthenticatedSessionService $authenticatedSessionService
     * @param PostService $postService
     */
    public function __construct(AuthenticatedSessionService $authenticatedSessionService,
                                PostService $postService)
    {

        $this->authenticatedSessionService = $authenticatedSessionService;
        $this->postService = $postService;
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
        $posts = $this->postService->postPaginate($filters);

        return view('backend.blog.post.index', [
            'posts' => $posts
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

        return view('backend.blog.post.create', [
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
     * @param CreatePostRequest $request
     * @return RedirectResponse
     * @throws Exception|Throwable
     */
    public function store(CreatePostRequest $request): RedirectResponse
    {
        $inputs = $request->except('_token');

        $confirm = $this->postService->storePost($inputs);

        if ($confirm['status'] == true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);
            return redirect()->route('backend.portfolio.posts.index');
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
        if ($post = $this->postService->getPostById($id)) {
            return view('backend.blog.post.show', [
                'certificate' => $post,
                'timeline' => Utility::modelAudits($post)
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
        if ($post = $this->postService->getPostById($id)) {

            $enables = [];
            foreach (Constant::ENABLED_OPTIONS as $field => $label):
                $enables[$field] = __('common.' . $label);
            endforeach;

            return view('backend.blog.post.edit', [
                'certificate' => $post,
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
     * @param CreatePostRequest $request
     * @param  $id
     * @return RedirectResponse
     * @throws Throwable
     */
    public function update(UpdatePostRequest $request, $id): RedirectResponse
    {
        $inputs = $request->except('_token', 'submit', '_method');
        $confirm = $this->postService->updatePost($inputs, $id);

        if ($confirm['status'] == true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);
            return redirect()->route('backend.portfolio.posts.index');
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

            $confirm = $this->postService->destroyPost($id);

            if ($confirm['status'] == true) {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            } else {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            }
            return redirect()->route('backend.portfolio.posts.index');
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

            $confirm = $this->postService->restorePost($id);

            if ($confirm['status'] == true) {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            } else {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            }
            return redirect()->route('backend.portfolio.posts.index');
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
        $postExport = $this->postService->exportPost($filters);
        $filename = 'Post-' . date('Ymd-His') . '.' . ($filters['format'] ?? 'xlsx');
        return $postExport->download($filename, function ($post) use ($postExport) {
            return $postExport->map($post);
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

        $posts = $this->postService->getAllPosts($filters);

        if (count($posts) > 0):
            foreach ($posts as $index => $post) :
                $posts[$index]->update_route = route('backend.portfolio.posts.update', $post->id);
                $posts[$index]->survey_id = $post->surveys->pluck('id')->toArray();
                $posts[$index]->prev_post_state_id = $post->previousPostings->pluck('id')->toArray();
                $posts[$index]->future_post_state_id = $post->futurePostings->pluck('id')->toArray();
                unset($posts[$index]->surveys, $posts[$index]->previousPostings, $posts[$index]->futurePostings);
            endforeach;

            $jsonReturn = ['status' => true, 'data' => $posts];
        else :
            $jsonReturn = ['status' => false, 'data' => []];
        endif;

        return response()->json($jsonReturn, 200);
    }
}
