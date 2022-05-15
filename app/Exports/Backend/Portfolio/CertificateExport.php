<?php

namespace App\Exports\Backend\Portfolio;

use App\Abstracts\Export\FastExcelExport;
use App\Models\Backend\Portfolio\Certificate;
use Box\Spout\Common\Exception\InvalidArgumentException;

/**
 * @class CertificateExport
 * @package App\Exports\Backend\Portfolio
 */
class CertificateExport extends FastExcelExport
{
    /**
     * CertificateExport constructor.
     *
     * @param null $data
     * @throws InvalidArgumentException
     */
    public function __construct($data = null)
    {
        parent::__construct();

        $this->data($data);
    }

    /**
     * @param Certificate $row
     * @return array
     */
    public function map($row): array
    {
        return [
            '#' => $row->id,
            'Name' => $row->name,
            'Organization' => $row->organization,
            'Issue Date' => $row->issue_date->format('Y-m-d'),
            'Expire Date' => $row->expire_date->format('Y-m-d'),
            'Credential' => $row->credential,
            'Verify URL' => $row->verify_url,
            'Description' => $row->description,
            'Enabled' => ucfirst($row->enabled),
            'Created At' => $row->created_at->format(config('backend.datetime')),
            'Updated At' => $row->updated_at->format(config('backend.datetime')),
            'Deleted At' => $row->deleted_at->format(config('backend.datetime')),

        ];
    }
}
