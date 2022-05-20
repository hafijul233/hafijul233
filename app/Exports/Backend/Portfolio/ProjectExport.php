<?php

namespace App\Exports\Backend\Portfolio;

use App\Abstracts\Export\FastExcelExport;
use App\Models\Backend\Portfolio\Project;
use Box\Spout\Common\Exception\InvalidArgumentException;
use Carbon\Carbon;

/**
 * @class ProjectExport
 * @package App\Exports\Backend\Portfolio
 */
class ProjectExport extends FastExcelExport
{
    /**
     * ProjectExport constructor.
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
     * @param Project $row
     * @return array
     */
    public function map($row): array
    {
        return [
            '#' => $row->id,
            'Name' => $row->name,
            'Owner' => $row->owner,
            'Start Date' => (($row->start_date != null)
                ? $row->start_date->format('Y-m-d')
                : null),
            'End Date' => (($row->end_date != null)
                ? $row->end_date->format('Y-m-d')
                : null),
            'Associate' => $row->associate  ,
            'URL' => $row->url,
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
