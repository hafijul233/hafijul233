<?php

namespace App\Abstracts\Export;

use App\Interfaces\ExportInterface;
use App\Services\Auth\AuthenticatedSessionService;
use Box\Spout\Common\Entity\Style\Border;
use Box\Spout\Common\Entity\Style\CellAlignment;
use Box\Spout\Common\Entity\Style\Color;
use Box\Spout\Common\Exception\InvalidArgumentException;
use Box\Spout\Writer\Common\Creator\Style\BorderBuilder;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
use Rap2hpoutre\FastExcel\FastExcel;

abstract class FastExcelExport extends FastExcel implements ExportInterface
{
    /**
     * @var BorderBuilder $border
     */
    protected $borderStyle = null;

    /**
     * @var StyleBuilder
     */
    protected $headingStyle = null;

    /**
     * @var StyleBuilder
     */
    protected $rowStyle = null;

    /**
     * @var array $formatRow
     */
    public $formatRow = [];

    /**
     * Modify Output Row Cells
     *
     * @param $row
     * @return array
     */
    public abstract function map($row): array;

    /**
     * Export Constructor
     *
     * @throws InvalidArgumentException
     */
    public function __construct()
    {
        parent::__construct();

        $this->setHeadingStyle((new StyleBuilder())
            ->setFontBold()
            ->setFontSize(12)
            ->setFontColor(Color::WHITE)
            ->setShouldWrapText()
            ->setBackgroundColor(Color::BLACK)
            ->setCellAlignment(CellAlignment::CENTER));

        $this->setBorderStyle((new BorderBuilder())
            ->setBorderTop(Color::BLACK, Border::WIDTH_MEDIUM)
            ->setBorderRight(Color::BLACK, Border::WIDTH_MEDIUM)
            ->setBorderBottom(Color::BLACK, Border::WIDTH_MEDIUM)
            ->setBorderLeft(Color::BLACK, Border::WIDTH_MEDIUM));

        $this->setRowStyle((new StyleBuilder())
            ->setFontSize(12)
            ->setShouldWrapText()
            ->setCellAlignment(CellAlignment::LEFT));

    }

    /**
     * @param BorderBuilder $borderBuilder
     * @return FastExcelExport
     */
    public function setBorderStyle(BorderBuilder $borderBuilder): self
    {
        $this->borderStyle = $borderBuilder;
        return $this;
    }

    /**
     * @param StyleBuilder $styleBuilder
     * @return FastExcelExport
     */
    public function setRowStyle(StyleBuilder $styleBuilder): self
    {
        //add Border Style for excel and ods
        if ($this->borderStyle instanceof BorderBuilder) {
            $borderStyle = $this->borderStyle->build();
            $styleBuilder->setBorder($borderStyle);
        }

        $style = $styleBuilder->build();

        $this->rowsStyle($style);

        return $this;
    }

    /**
     * @param StyleBuilder $styleBuilder
     * @return FastExcelExport
     */
    public function setHeadingStyle(StyleBuilder $styleBuilder): self
    {
        //add Border Style for excel and ods
        if ($this->borderStyle instanceof BorderBuilder) {
            $borderStyle = $this->borderStyle->build();
            $styleBuilder->setBorder($borderStyle);
        }

        $style = $styleBuilder->build();

        $this->headerStyle($style);
        return $this;
    }

    /**
     * Returns all super admin columns
     *
     * @param $row
     */
    public function getSupperAdminColumns($row)
    {
        if (AuthenticatedSessionService::isSuperAdmin()):
            $this->formatRow['Deleted'] = ($row->deleted_at != null)
                ? $row->deleted_at->format(config('backend.datetime'))
                : null;

            $this->formatRow['Creator'] = ($row->createdBy != null)
                ? $row->createdBy->name
                : null;

            $this->formatRow['Editor'] = ($row->updatedBy != null)
                ? $row->updatedBy->name
                : null;
            $this->formatRow['Destructor'] = ($row->deletedBy != null)
                ? $row->deletedBy->name
                : null;
        endif;
    }
}
