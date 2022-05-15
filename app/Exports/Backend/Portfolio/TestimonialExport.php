<?php

namespace App\Exports\Backend\Portfolio;

use App\Abstracts\Export\FastExcelExport;
use App\Models\Backend\Portfolio\Testimonial;
use Box\Spout\Common\Exception\InvalidArgumentException;

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
     * @param Testimonial $row
     * @return array
     */
    public function map($row): array
    {
        return [
            '#' => $row->id,
            'Client' => $row->client,
            'Feedback' => $row->feedback,
            'Enabled' => ucfirst($row->enabled),
            'Created At' => (($row->created_at != null)
                ? $row->created_at->format(config('backend.datetime'))
                : null),
            'Updated At' => (($row->updated_at != null)
                ? $row->updated_at->format(config('backend.datetime'))
                : null),
            'Deleted At' => (($row->deleted_at != null)
                ? $row->deleted_at->format(config('backend.datetime'))
                : null)
        ];

    }
}
