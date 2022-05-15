<?php

namespace App\Exports\Backend\Portfolio;

use App\Abstracts\Export\FastExcelExport;
use App\Models\Backend\Portfolio\Post;
use Box\Spout\Common\Exception\InvalidArgumentException;
use Carbon\Carbon;

/**
 * @class TestimonialExport
 * @package App\Exports\Backend\Portfolio
 */
class TestimonialExport extends FastExcelExport
{
    /**
     * TestimonialExport constructor.
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
     * @param Post $row
     * @return array
     */
    public function map($row): array
    {
        $this->formatRow = [
            '#' => $row->id,
            trans('Name (in English)', [], 'en') => $row->name ?? null,
            trans('Name(Bangla)', [], 'en') => $row->name_bd ?? null,
            trans('Gender', [], 'en') => $row->gender->name ?? null,
            trans('Date of Birth', [], 'en') => isset($row) ? Carbon::parse($row->dob)->format('d/m/Y') : null,
            trans('Father Name', [], 'en') => $row->father ?? null,
            trans('Mother Name', [], 'en') => $row->mother ?? null,
            trans('NID Number', [], 'en') => $row->nid ?? null,
            trans('Present Address', [], 'en') => $row->present_address ?? null,
            trans('Permanent Address', [], 'en') => $row->permanent_address ?? null,
            trans('Education', [], 'en') => $row->examLevel->name ?? null,
            trans('Mobile 1', [], 'en') => $row->mobile_1 ?? null,
            trans('Mobile 2', [], 'en') => $row->mobile_2 ?? null,
            trans('Email', [], 'en') => $row->email ?? null,
            trans('Whatsapp Number', [], 'en') => $row->whatsapp ?? null,
            trans('Facebook ID', [], 'en') => $row->facebook ?? null,
            'Enabled' => ucfirst(($row->enabled ?? '')),
            'Created' => $row->created_at->format(config('backend.datetime'))
        ];

        /*$this->getSupperAdminColumns($row);*/

        return $this->formatRow;
    }
}
