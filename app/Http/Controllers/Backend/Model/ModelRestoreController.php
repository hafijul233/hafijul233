<?php

namespace App\Http\Controllers\Backend\Model;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Model\ModelRestoreRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class ModelRestoreController extends Controller
{
    /**
     * ModelRestoreController constructor.
     *
     */
    public function __construct()
    {

    }

    /**
     * Change a model status from enabled to disabled ro vise-versa.
     *
     * @param $route
     * @param $id
     * @param ModelRestoreRequest $request
     * @return Application|Factory|View
     */
    public function __invoke($route, $id, ModelRestoreRequest $request)
    {
        if ($request->user()->can($route . '.restore')) {
            return view('backend.model.restore', [
                'route' => [$route . '.restore', $id],
                'method' => 'patch'
            ]);
        }
        abort(403);
    }
}
