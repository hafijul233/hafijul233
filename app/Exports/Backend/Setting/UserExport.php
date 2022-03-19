<?php

namespace App\Exports\Backend\Setting;

use App\Abstracts\Export\FastExcelExport;
use App\Models\Backend\Setting\User;
use Box\Spout\Common\Exception\InvalidArgumentException;
use Illuminate\Database\Eloquent\Collection;
use function config;


class UserExport extends FastExcelExport
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
     * @param User $row
     * @return array
     */
    public function map($row): array
    {
        $this->formatRow = [
            '#' => $row->id,
            'Full Name' => $row->name,
            'Username' => $row->username,
            'Email' => $row->email,
            'Mobile' => $row->email,
            'Role(s)' => $this->mergeRoles($row->roles),
            'Remarks' => $row->remarks,
            'Enabled' => ucfirst($row->enabled),
            'Created' => $row->created_at->format(config('backend.datetime')),
            'Updated' => $row->updated_at->format(config('backend.datetime'))
        ];
        $this->getSupperAdminColumns($row);
        return $this->formatRow;
    }

    protected function mergeRoles(Collection $roles): string
    {
        $roles = $roles->pluck('name')->toArray();

        if (count($roles) > 0) {
            return implode(', ', $roles);
        }

        return 'Not Assigned';
    }
}
