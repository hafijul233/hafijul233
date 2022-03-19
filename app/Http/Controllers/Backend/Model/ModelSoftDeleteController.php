<?php

namespace App\Http\Controllers\Backend\Model;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Model\ModelSoftDeleteRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class ModelSoftDeleteController extends Controller
{
    /**
     * ModelSoftDeleteController constructor.
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
     * @param ModelSoftDeleteRequest $request
     * @return Application|Factory|View
     */
    public function __invoke($route, $id, ModelSoftDeleteRequest $request)
    {
        if ($request->user()->can($route . '.destroy')) {
            return view('backend.model.soft-delete', [
                'route' => [$route . '.destroy', $id],
                'method' => 'delete'
            ]);
        }
        abort(403);
    }
}
