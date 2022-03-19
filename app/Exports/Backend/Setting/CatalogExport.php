<?php

namespace App\Exports\Backend\Setting;

use App\Abstracts\Export\FastExcelExport;
use App\Models\Setting\Catalog;
use App\Models\Setting\Permission;
use Box\Spout\Common\Exception\InvalidArgumentException;
use function config;

/**
 * @class CatalogExport
 * @package App\Exports\Setting
 */
class CatalogExport extends FastExcelExport
{
    /**
     * CatalogExport constructor.
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
     * @param Catalog $row
     * @return array
     */
    public function map($row): array
    {
        $this->formatRow = [
            '#' => $row->id,
            'Name' => $row->name,
            'Remarks' => $row->remarks,
            'Enabled' => ucfirst($row->enabled),
            'Created' => $row->created_at->format(config('backend.datetime')),
            'Updated' => $row->updated_at->format(config('backend.datetime'))
        ];

        $this->getSupperAdminColumns($row);

        return $this->formatRow;
    }
}

