<?php

namespace App\Exports\Backend\Setting;

use App\Abstracts\Export\FastExcelExport;
use App\Models\Backend\Setting\ExamLevel;
use Box\Spout\Common\Exception\InvalidArgumentException;

/**
 * @class BarcodeExport
 * @package App\Exports\Backend\Setting
 */
class BarcodeExport extends FastExcelExport
{
    /**
     * BarcodeExport constructor.
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
     * @param ExamLevel $row
     * @return array
     */
    public function map($row): array
    {
        $this->formatRow = [
            '#' => $row->id,
            'Name' => $row->name,
            'Remarks' => $row->remarks,
            'Enabled' => ucfirst($row->enabled),
            'Created' => $row->created_at->format(config('app.datetime')),
            'Updated' => $row->updated_at->format(config('app.datetime'))
        ];

        $this->getSupperAdminColumns($row);

        return $this->formatRow;
    }
}

