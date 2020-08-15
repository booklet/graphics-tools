<?php
class FileMeasurementPDFTest extends \CustomPHPUnitTestCase
{
    public $skip_database_clear_before = ['all'];

    public function testPagesCount()
    {
        $pdf_tools = new FileMeasurementPDF('tests/fixtures/files/30x50.pdf');

        $this->assertEquals($pdf_tools->pagesCount(), 3);

        $pdf_tools = new FileMeasurementPDF('tests/fixtures/files/one-page-file.pdf');

        $this->assertEquals($pdf_tools->pagesCount(), 1);

        $pdf_tools = new FileMeasurementPDF('tests/fixtures/files/client-test-file-01.pdf');

        $this->assertEquals($pdf_tools->pagesCount(), 2);
    }

    public function testWidthInPt()
    {
        $pdf_tools = new FileMeasurementPDF('tests/fixtures/files/difrent-pages-sizes.pdf');

        //die(print_r($pdf_tools));

        $this->assertEquals($pdf_tools->widthInPt(), 255.12);
        $this->assertEquals($pdf_tools->widthInPt(['page' => 2]), 340.16);
        $this->assertEquals($pdf_tools->widthInPt(['page' => 3]), 765.35);
    }

    public function testHeightInPt()
    {
        $pdf_tools = new FileMeasurementPDF('tests/fixtures/files/difrent-pages-sizes.pdf');

        $this->assertEquals($pdf_tools->heightInPt(), 198.42);
        $this->assertEquals($pdf_tools->heightInPt(['page' => 2]), 538.58);
        $this->assertEquals($pdf_tools->heightInPt(['page' => 3]), 623.62);
    }

    public function testSizesWithTrimbox()
    {
        $pdf_tools = new FileMeasurementPDF('tests/fixtures/files/55x55_bez_spadu.pdf');
        $this->assertEquals($pdf_tools->heightInPt(), 155.91);

        $pdf_tools = new FileMeasurementPDF('tests/fixtures/files/59x59.pdf');
        $this->assertEquals($pdf_tools->heightInPt(), 167.24);

        $pdf_tools = new FileMeasurementPDF('tests/fixtures/files/55x55_spady.pdf');
        $this->assertEquals($pdf_tools->heightInPt(), 167.25);
    }

    public function testWidthInMM()
    {
        $pdf_tools = new FileMeasurementPDF('tests/fixtures/files/difrent-pages-sizes.pdf');

        $this->assertEquals($pdf_tools->widthInMm(), 90.0);
        $this->assertEquals($pdf_tools->widthInMm(['page' => 2]), 120.0);
        $this->assertEquals($pdf_tools->widthInMm(['page' => 3]), 270.0);
    }

    public function testHeightInMM()
    {
        $pdf_tools = new FileMeasurementPDF('tests/fixtures/files/difrent-pages-sizes.pdf');

        $this->assertEquals($pdf_tools->heightInMm(), 70.0);
        $this->assertEquals($pdf_tools->heightInMm(['page' => 2]), 190.0);
        $this->assertEquals($pdf_tools->heightInMm(['page' => 3]), 220.0);
    }

    public function testWidthInPx()
    {
        $pdf_tools = new FileMeasurementPDF('tests/fixtures/files/difrent-pages-sizes.pdf');

        $this->assertEquals($pdf_tools->widthInPx(), 1063);
        $this->assertEquals($pdf_tools->widthInPx(['page' => 2]), 1417);
        $this->assertEquals($pdf_tools->widthInPx(['page' => 3]), 3189);
    }

    public function testHeightInPx()
    {
        $pdf_tools = new FileMeasurementPDF('tests/fixtures/files/difrent-pages-sizes.pdf');

        $this->assertEquals($pdf_tools->heightInPx(), 827);
        $this->assertEquals($pdf_tools->heightInPx(['page' => 2]), 2244);
        $this->assertEquals($pdf_tools->heightInPx(['page' => 3]), 2598);
    }
}
