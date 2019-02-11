<?php
class PDFToolsTest extends \CustomPHPUnitTestCase
{
    public $skip_database_clear_before = ['all'];

    public function testSplitPdfMultiplePage()
    {
        $pdf_tools = new PDFTools('tests/fixtures/files/12-pages.pdf');
        $paths = $pdf_tools->splitPdfToPath('tests/temp');

        for ($i = 1; $i < 13; ++$i) {
            $file_path = 'tests/temp/12-pages_page' . sprintf('%02d', $i) . '.pdf';
            $this->assertEquals(file_exists($file_path), true);
            unlink($file_path);
        }

        $this->assertEquals(count($paths), 12);
        $this->assertEquals($paths[0], 'tests/temp/12-pages_page01.pdf');
        $this->assertEquals($paths[11], 'tests/temp/12-pages_page12.pdf');
    }

    public function testSplitPdfOnePage()
    {
        $pdf_tools = new PDFTools('tests/fixtures/files/client-test-file-09.pdf');
        $paths = $pdf_tools->splitPdfToPath('tests/temp');

        $file_path = 'tests/temp/client-test-file-09.pdf';
        $this->assertEquals(file_exists($file_path), true);
        unlink($file_path);

        $this->assertEquals(count($paths), 1);
        $this->assertEquals($paths[0], 'tests/temp/client-test-file-09.pdf');
    }

    public function testSplitPdfMultiplePageWithCustomFileName()
    {
        $pdf_tools = new PDFTools('tests/fixtures/files/12-pages.pdf');
        $paths = $pdf_tools->splitPdfToPath('tests/temp', 'prefix nazwy pliku ze spacjami.pdf');

        for ($i = 1; $i < 13; ++$i) {
            $file_path = 'tests/temp/prefix-nazwy-pliku-ze-spacjami_page' . sprintf('%02d', $i) . '.pdf';
            $this->assertEquals(file_exists($file_path), true);
            unlink($file_path);
        }

        $this->assertEquals(count($paths), 12);
        $this->assertEquals($paths[0], 'tests/temp/prefix-nazwy-pliku-ze-spacjami_page01.pdf');
        $this->assertEquals($paths[11], 'tests/temp/prefix-nazwy-pliku-ze-spacjami_page12.pdf');
    }

    public function testConvertToJpg()
    {
        $pdf_tools = new PDFTools('tests/fixtures/files/client-test-file-01.pdf');
        $jpg_path = 'tests/temp/convert_to_jpg.jpg';
        $pdf_tools->convertToJpg($jpg_path);

        $this->assertEquals(file_exists($jpg_path), true);

        $image = new Imagick($jpg_path);
        $d = $image->getImageGeometry();

        $this->assertEquals($d['width'], 1146);
        $this->assertEquals($d['height'], 319);

        unlink($jpg_path);
    }
}
