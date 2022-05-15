<?php

namespace App\Exports\Backend\Portfolio;

use App\Abstracts\Export\FastExcelExport;
use App\Models\Backend\Portfolio\Service;
use Box\Spout\Common\Exception\InvalidArgumentException;

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
            'Summary' => $row->summary,
            'Description' => $row->description,
            'Enabled' => ucfirst($row->enabled),
            'Created At' => (($row->created_at != null)
                ? $row->created_at->format(config('backend.datetime'))
                : null),
            'Updated At' => (($row->updated_at != null)
                ? $row->updated_at->format(config('backend.datetime'))
                : null),
            'Deleted At' => (($row->deleted_at != null)
                ? $row->deleted_at->format(config('backend.datetime'))
                : null),
        ];
    }
}
