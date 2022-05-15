<?php

namespace App\Exports\Backend\Portfolio;

use App\Abstracts\Export\FastExcelExport;
use App\Models\Backend\Portfolio\Service;
use Box\Spout\Common\Exception\InvalidArgumentException;
use Carbon\Carbon;

/**
 * @class ServiceExport
 * @package App\Exports\Backend\Portfolio
 */
class ServiceExport extends FastExcelExport
{
    /**
     * ServiceExport constructor.
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
     * @param Service $row
     * @return array
     */
    public function map($row): array
    {
        return [
            '#' => $row->id,
            'Name' => $row->name,
            'Image' => $row->getFirstMediaUrl('services'),
            'Summary' => $row->summary,
            'Description' => $row->description,
            'Enabled' => ucfirst($row->enabled),
            'Created At' => $row->created_at->format(config('backend.datetime')),
            'Updated At' => $row->updated_at->format(config('backend.datetime')),
            'Deleted At' => $row->deleted_at->format(config('backend.datetime')),
        ];
    }
}
