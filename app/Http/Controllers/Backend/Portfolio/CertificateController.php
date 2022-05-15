<?php

namespace App\Http\Controllers\Backend\Portfolio;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Portfolio\CertificateRequest;
use App\Services\Auth\AuthenticatedSessionService;
use App\Services\Backend\Portfolio\CertificateService;
use App\Supports\Utility;
use Box\Spout\Common\Exception\InvalidArgumentException;
use Box\Spout\Common\Exception\IOException;
use Box\Spout\Common\Exception\UnsupportedTypeException;
use Box\Spout\Writer\Exception\WriterNotOpenedException;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

/**
 * @class CertificateController
 * @package App\Http\Controllers\Backend\Portfolio
 */
class CertificateController extends Controller
{
    /**
     * @var AuthenticatedSessionService
     */
    private $authenticatedSessionService;

    /**
     * @var CertificateService
     */
    private $certificateService;

    /**
     * CertificateController Constructor
     *
     * @param AuthenticatedSessionService $authenticatedSessionService
     * @param CertificateService $certificateService
     */
    public function __construct(
        AuthenticatedSessionService $authenticatedSessionService,
        CertificateService $certificateService
    )
    {
        $this->authenticatedSessionService = $authenticatedSessionService;
        $this->certificateService = $certificateService;
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
        $certificates = $this->certificateService->certificatePaginate($filters);

        return view('backend.portfolio.certificate.index', [
            'certificates' => $certificates
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('backend.portfolio.certificate.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return RedirectResponse
     * @throws Exception|Throwable
     */
    public function store(CertificateRequest $request): RedirectResponse
    {
        $confirm = $this->certificateService->storeCertificate($request->except('_token'));
        if ($confirm['status'] == true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);
            return redirect()->route('backend.portfolio.certificates.index');
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
        if ($certificate = $this->certificateService->getCertificateById($id)) {
            return view('backend.portfolio.certificate.show', [
                'certificate' => $certificate,
                'timeline' => Utility::modelAudits($certificate)
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
        if ($certificate = $this->certificateService->getCertificateById($id)) {
            return view('backend.portfolio.certificate.edit', [
                'certificate' => $certificate
            ]);
        }

        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CertificateRequest $request
     * @param  $id
     * @return RedirectResponse
     * @throws Throwable
     */
    public function update(CertificateRequest $request, $id): RedirectResponse
    {
        $confirm = $this->certificateService->updateCertificate($request->except('_token', 'submit', '_method'), $id);

        if ($confirm['status'] == true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);
            return redirect()->route('backend.portfolio.certificates.index');
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
            $confirm = $this->certificateService->destroyCertificate($id);

            if ($confirm['status'] == true) {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            } else {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            }
            return redirect()->route('backend.portfolio.certificates.index');
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
            $confirm = $this->certificateService->restoreCertificate($id);

            if ($confirm['status'] == true) {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            } else {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            }
            return redirect()->route('backend.portfolio.certificates.index');
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
     */
    public function export(Request $request)
    {
        $filters = $request->except('page');

        $certificateExport = $this->certificateService->exportCertificate($filters);

        $filename = 'Certificates-' . date(config('backend.export_datetime')) . '.' . ($filters['format'] ?? 'xlsx');

        return $certificateExport->download($filename, function ($certificate) use ($certificateExport) {
            return $certificateExport->map($certificate);
        });
    }

    /**
     * Return an Import view page
     *
     * @return Application|Factory|View
     */
    public function import()
    {
        return view('backend.portfolio.certificateimport');
    }
}
