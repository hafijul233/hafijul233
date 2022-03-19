<?php

namespace App\Exports\Backend\Setting;

use App\Abstracts\Export\FastExcelExport;
use App\Models\Setting\Permission;
use Box\Spout\Common\Exception\InvalidArgumentException;
use function config;

class PermissionExport extends FastExcelExport
{
    /**
     * @param null $data
     * @throws InvalidArgumentException
     */
    public function __construct($data = null)
    {
        parent::__construct();

        $this->data($data);
    }

    /**
     * @param Permission $row
     * @return array
     */
    public function map($row): array
    {
        $this->formatRow = [
            '#' => $row->id,
            'Display Name' => $row->display_name,
            'System Name' => $row->name,
            'Guard' => ucfirst($row->guard_name),
            'Remarks' => $row->remarks,
            'Enabled' => ucfirst($row->enabled),
            'Created' => $row->created_at->format(config('backend.datetime')),
            'Updated' => $row->updated_at->format(config('backend.datetime'))
        ];

        $this->getSupperAdminColumns($row);

        return $this->formatRow;
    }
}
