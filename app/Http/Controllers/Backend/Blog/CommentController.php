<?php

namespace App\Http\Controllers\Backend\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Organization\CommentRequest;
use App\Services\Auth\AuthenticatedSessionService;
use App\Services\Backend\Blog\CommentService;
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
 * @class CommentController
 * @package App\Http\Controllers\Backend\Blog
 */
class CommentController extends Controller
{
    /**
     * @var AuthenticatedSessionService
     */
    private $authenticatedSessionService;

    /**
     * @var CommentService
     */
    private $commentService;

    /**
     * CommentController Constructor
     *
     * @param AuthenticatedSessionService $authenticatedSessionService
     * @param CommentService $commentService
     */
    public function __construct(AuthenticatedSessionService $authenticatedSessionService,
                                CommentService $commentService)
    {

        $this->authenticatedSessionService = $authenticatedSessionService;
        $this->commentService = $commentService;
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
        $comments = $this->commentService->commentPaginate($filters);

        return view('backend.blog.comment.index', [
            'comments' => $comments
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('backend.blog.comment.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return RedirectResponse
     * @throws Exception|Throwable
     */
    public function store(CommentRequest $request): RedirectResponse
    {
        $confirm = $this->commentService->storeComment($request->except('_token'));
        if ($confirm['status'] == true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);
            return redirect()->route('backend.portfolio.comments.index');
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
        if ($comment = $this->commentService->getCommentById($id)) {
            return view('backend.blog.comment.show', [
                'service' => $comment,
                'timeline' => Utility::modelAudits($comment)
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
        if ($comment = $this->commentService->getCommentById($id)) {
            return view('backend.blog.comment.edit', [
                'service' => $comment
            ]);
        }

        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CommentRequest $request
     * @param  $id
     * @return RedirectResponse
     * @throws Throwable
     */
    public function update(CommentRequest $request, $id): RedirectResponse
    {
        $confirm = $this->commentService->updateComment($request->except('_token', 'submit', '_method'), $id);

        if ($confirm['status'] == true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);
            return redirect()->route('backend.portfolio.comments.index');
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

            $confirm = $this->commentService->destroyComment($id);

            if ($confirm['status'] == true) {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            } else {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            }
            return redirect()->route('backend.portfolio.comments.index');
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

            $confirm = $this->commentService->restoreComment($id);

            if ($confirm['status'] == true) {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            } else {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            }
            return redirect()->route('backend.portfolio.comments.index');
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

        $commentExport = $this->commentService->exportComment($filters);

        $filename = 'Comment-' . date('Ymd-His') . '.' . ($filters['format'] ?? 'xlsx');

        return $commentExport->download($filename, function ($comment) use ($commentExport) {
            return $commentExport->map($comment);
        });

    }

    /**
     * Return an Import view page
     *
     * @return Application|Factory|View
     */
    public function import()
    {
        return view('backend.portfolio.commentimport');
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
        $comments = $this->commentService->getAllComments($filters);

        return view('backend.portfolio.commentindex', [
            'comments' => $comments
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

        $commentExport = $this->commentService->exportComment($filters);

        $filename = 'Comment-' . date('Ymd-His') . '.' . ($filters['format'] ?? 'xlsx');

        return $commentExport->download($filename, function ($comment) use ($commentExport) {
            return $commentExport->map($comment);
        });

    }
}
