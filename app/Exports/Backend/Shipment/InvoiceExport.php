<?php

namespace App\Exports\Backend\Shipment;

use App\Abstracts\Export\FastExcelExport;
use App\Models\Backend\Shipment\Invoice;
use Box\Spout\Common\Exception\InvalidArgumentException;

/**
 * @class InvoiceExport
 * @package App\Exports\Backend\Shipment
 */
class InvoiceExport extends FastExcelExport
{
    /**
     * InvoiceExport constructor.
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
     * @param Invoice $row
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

