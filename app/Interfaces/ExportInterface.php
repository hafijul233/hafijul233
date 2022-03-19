<?php

namespace App\Interfaces;

use Box\Spout\Writer\Common\Creator\Style\BorderBuilder;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;

interface ExportInterface
{
    /**
     * Modify Output Row Cells
     *
     * @param $row
     * @return array
     */
    public function map($row): array;

    /**
     * @param BorderBuilder $borderBuilder
     * @return mixed
     */
    public function setBorderStyle(BorderBuilder $borderBuilder);

    /**
     * @param StyleBuilder $styleBuilder
     * @return mixed
     */
    public function setRowStyle(StyleBuilder $styleBuilder);

    /**
     * @param StyleBuilder $styleBuilder
     * @return mixed
     */
    public function setHeadingStyle(StyleBuilder $styleBuilder);

    /**
     * Returns all super admin columns
     * @param $row
     * @return void
     */
    public function getSupperAdminColumns($row);
}
