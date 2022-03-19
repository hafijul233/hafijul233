<?php

namespace App\Http\Controllers\Backend\Common;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Common\AddressBookRequest;
use App\Services\Auth\AuthenticatedSessionService;
use App\Services\Backend\Common\AddressBookService;
use App\Supports\Utility;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * @class AddressBookController
 * @package App\Http\Controllers\Backend\Common
 */
class AddressBookController extends Controller
{
    /**
     * @var AuthenticatedSessionService
     */
    private $authenticatedSessionService;
    
    /**
     * @var AddressBookService
     */
    private $addressBookService;

    /**
     * AddressBookController Constructor
     *
     * @param AuthenticatedSessionService $authenticatedSessionService
     * @param AddressBookService $addressBookService
     */
    public function __construct(AuthenticatedSessionService $authenticatedSessionService,
                                AddressBookService              $addressBookService)
    {

        $this->authenticatedSessionService = $authenticatedSessionService;
        $this->addressBookService = $addressBookService;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     * @throws Exception
     */
    public function index(Request $request)
    {
        $filters = $request->except('page');
        $addressBooks = $this->addressBookService->addressBookPaginate($filters);

        return view('backend.common.address-book.index', [
            'addressBooks' => $addressBooks
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('backend.common.address-book.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AddressBookRequest $request
     * @return RedirectResponse
     * @throws Exception|\Throwable
     */
    public function store(AddressBookRequest $request): RedirectResponse
    {
        $confirm = $this->addressBookService->storeAddressBook($request->except('_token'));
        if ($confirm['status'] == true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);
            return redirect()->route('backend.common.address-books.index');
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
        if ($addressBook = $this->addressBookService->getAddressBookById($id)) {
            return view('backend.common.address-book.show', [
                'addressBook' => $addressBook,
                'timeline' => Utility::modelAudits($addressBook)
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
        if ($addressBook = $this->addressBookService->getAddressBookById($id)) {
            return view('backend.common.address-book.edit', [
                'addressBook' => $addressBook
            ]);
        }

        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AddressBookRequest $request
     * @param  $id
     * @return RedirectResponse
     * @throws \Throwable
     */
    public function update(AddressBookRequest $request, $id): RedirectResponse
    {
        $confirm = $this->addressBookService->updateAddressBook($request->except('_token', 'submit', '_method'), $id);

        if ($confirm['status'] == true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);
            return redirect()->route('backend.common.address-books.index');
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
     * @throws \Throwable
     */
    public function destroy($id, Request $request)
    {
        if ($this->authenticatedSessionService->validate($request)) {

            $confirm = $this->addressBookService->destroyAddressBook($id);

            if ($confirm['status'] == true) {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            } else {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            }
            return redirect()->route('backend.common.address-books.index');
        }
        abort(403, 'Wrong user credentials');
    }

    /**
     * Restore a Soft Deleted Resource
     *
     * @param $id
     * @param Request $request
     * @return RedirectResponse|void
     * @throws \Throwable
     */
    public function restore($id, Request $request)
    {
        if ($this->authenticatedSessionService->validate($request)) {

            $confirm = $this->addressBookService->restoreAddressBook($id);

            if ($confirm['status'] == true) {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            } else {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            }
            return redirect()->route('backend.common.address-books.index');
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

        $addressBookExport = $this->addressBookService->exportAddressBook($filters);

        $filename = 'Address-' . date('Ymd-His') . '.' . ($filters['format'] ?? 'xlsx');

        return $addressBookExport->download($filename, function ($addressBook) use ($addressBookExport) {
            return $addressBookExport->map($addressBook);
        });

    }

    /**
     * Return an Import view page
     *
     * @return Application|Factory|View
     */
    public function import()
    {
        return view('backend.common.address-book.import');
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
        $addressBooks = $this->addressBookService->getAllAddressBooks($filters);

        return view('backend.common.address-book.index', [
            'addressBooks' => $addressBooks
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

        $addressBookExport = $this->addressBookService->exportAddressBook($filters);

        $filename = 'Address-' . date('Ymd-His') . '.' . ($filters['format'] ?? 'xlsx');

        return $addressBookExport->download($filename, function ($addressBook) use ($addressBookExport) {
            return $addressBookExport->map($addressBook);
        });

    }
}
