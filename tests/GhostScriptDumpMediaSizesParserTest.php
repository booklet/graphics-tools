<?php
class GhostScriptDumpMediaSizesParserTest extends \CustomPHPUnitTestCase
{
    public $skip_database_clear_before = ['all'];

    public function testParserSample1()
    {
        $data = file_get_contents('tests/fixtures/ghost_script_pdf_info_outputs/sample_01.txt');

        $gs_parser = new GhostScriptDumpMediaSizesParser($data);
        $pdf_media_sizes = $gs_parser->parse();

        $this->assertEquals(count($pdf_media_sizes), 65);
        $this->assertEquals($pdf_media_sizes[0]['media_box'], [0.0, 0.0, 595.32, 841.92]);
        $this->assertEquals($pdf_media_sizes[0]['bleed_box'], null);
        $this->assertEquals($pdf_media_sizes[0]['crop_box'], null);
        $this->assertEquals($pdf_media_sizes[0]['trim_box'], null);
        $this->assertEquals($pdf_media_sizes[0]['art_box'], null);
    }

    public function testParserSample2()
    {
        $data = file_get_contents('tests/fixtures/ghost_script_pdf_info_outputs/sample_02.txt');

        $gs_parser = new GhostScriptDumpMediaSizesParser($data);
        $pdf_media_sizes = $gs_parser->parse();

        $this->assertEquals(count($pdf_media_sizes), 3);
        $this->assertEquals($pdf_media_sizes[0]['media_box'], [0.0, 0.0, 96.3786, 153.069]);
        $this->assertEquals($pdf_media_sizes[0]['bleed_box'], [0.0, 0.0, 96.3786, 153.069]);
        $this->assertEquals($pdf_media_sizes[0]['crop_box'], null);
        $this->assertEquals($pdf_media_sizes[0]['trim_box'], [5.6693, 5.6693, 90.7093, 147.399]);
        $this->assertEquals($pdf_media_sizes[0]['art_box'], [5.6693, 5.6693, 90.7093, 147.399]);
    }

    public function testParserSample3()
    {
        $data = file_get_contents('tests/fixtures/ghost_script_pdf_info_outputs/sample_03.txt');

        $gs_parser = new GhostScriptDumpMediaSizesParser($data);
        $pdf_media_sizes = $gs_parser->parse();

        $this->assertEquals(count($pdf_media_sizes), 1);
        $this->assertEquals($pdf_media_sizes[0]['media_box'], [-1.0, -1.0, 1248.81104, 625.189]);
        $this->assertEquals($pdf_media_sizes[0]['bleed_box'], null);
        $this->assertEquals($pdf_media_sizes[0]['crop_box'], [-1.0, -1.0, 1248.81104, 625.189]);
        $this->assertEquals($pdf_media_sizes[0]['trim_box'], [-1.0, -1.0, 1248.81104, 625.189]);

        $this->assertEquals($pdf_media_sizes[0]['art_box'], null);
    }

    public function testParserSample5()
    {
        $data = file_get_contents('tests/fixtures/ghost_script_pdf_info_outputs/sample_05.txt');

        $gs_parser = new GhostScriptDumpMediaSizesParser($data);
        $pdf_media_sizes = $gs_parser->parse();

        $this->assertEquals(count($pdf_media_sizes), 3);
        $this->assertEquals($pdf_media_sizes[0]['media_box'], [0.0, 0.0, 153.069, 153.069]);
        $this->assertEquals($pdf_media_sizes[0]['bleed_box'], [0.0, 0.0, 153.069, 153.069]);
        $this->assertEquals($pdf_media_sizes[0]['crop_box'], null);
        $this->assertEquals($pdf_media_sizes[0]['trim_box'], [5.66928, 5.66928, 147.399, 147.399]);
        $this->assertEquals($pdf_media_sizes[0]['art_box'], [35.5363, 42.8105, 98.0332, 115.828]);

        $this->assertEquals($pdf_media_sizes[1]['media_box'], [0.0, 0.0, 294.803, 294.803]);
        $this->assertEquals($pdf_media_sizes[1]['bleed_box'], [0.0, 0.0, 294.803, 294.803]);
        $this->assertEquals($pdf_media_sizes[1]['crop_box'], [0.0, 0.0, 294.803, 294.803]);
        $this->assertEquals($pdf_media_sizes[1]['trim_box'], [5.66928, 5.66928, 289.134, 289.134]);
        $this->assertEquals($pdf_media_sizes[1]['art_box'], [32.9073, 77.4304, 238.547, 261.917]);

        $this->assertEquals($pdf_media_sizes[2]['media_box'], [0.0, 0.0, 578.268, 578.268]);
        $this->assertEquals($pdf_media_sizes[2]['bleed_box'], [0.0, 0.0, 578.268, 578.268]);
        $this->assertEquals($pdf_media_sizes[2]['crop_box'], [0.0, 0.0, 578.268, 578.268]);
        $this->assertEquals($pdf_media_sizes[2]['trim_box'], [5.66928, 5.66928, 572.598, 572.598]);
        $this->assertEquals($pdf_media_sizes[2]['art_box'], [177.639, 179.139, 381.129, 489.124]);
    }

    public function testParserSample8()
    {
        $data = file_get_contents('tests/fixtures/ghost_script_pdf_info_outputs/sample_08.txt');

        $gs_parser = new GhostScriptDumpMediaSizesParser($data);
        $pdf_media_sizes = $gs_parser->parse();

        $this->assertEquals(count($pdf_media_sizes), 1);
        $this->assertEquals($pdf_media_sizes[0]['media_box'], [0.0, -2.0, 238.110199, 351.496094]);
        $this->assertEquals($pdf_media_sizes[0]['bleed_box'], null);
        $this->assertEquals($pdf_media_sizes[0]['crop_box'], [0.0, -2.0, 238.110199, 351.496094]);
        $this->assertEquals($pdf_media_sizes[0]['trim_box'], [0.0, -2.0, 238.110199, 351.496094]);
        $this->assertEquals($pdf_media_sizes[0]['art_box'], null);
    }

    public function testParserSample10()
    {
        $data = file_get_contents('tests/fixtures/ghost_script_pdf_info_outputs/sample_10.txt');

        $gs_parser = new GhostScriptDumpMediaSizesParser($data);

        try {
            $pdf_media_sizes = $gs_parser->parse();
        } catch (Exception $e) {
        }

        $this->assertEquals($e->getMessage(), 'GhostScript dump media size input data error.');
    }

    public function testParserSample11()
    {
        $data = file_get_contents('tests/fixtures/ghost_script_pdf_info_outputs/sample_11.txt');

        $gs_parser = new GhostScriptDumpMediaSizesParser($data);
        $pdf_media_sizes = $gs_parser->parse();

        // /MediaBox [0.000008940697 1.0000179 300.0 601.0] - plik
        // MediaBox: [8.94069672e-06 1.00001788 300.0 601.0] - measurment report
        $this->assertEquals(count($pdf_media_sizes), 1);
        $this->assertEquals($pdf_media_sizes[0]['media_box'], [0.00000894069672, 1.00001788, 300.0, 601.0]);
        $this->assertEquals($pdf_media_sizes[0]['bleed_box'], [0.00000894069672, 1.00001788, 300.0, 601.0]);
        $this->assertEquals($pdf_media_sizes[0]['crop_box'], null);
        $this->assertEquals($pdf_media_sizes[0]['trim_box'], [0.00000894069672, 1.00001788, 300.0, 601.0]);
        $this->assertEquals($pdf_media_sizes[0]['art_box'], null);
    }

    public function testGetRotate()
    {
        $gs_parser = new GhostScriptDumpMediaSizesParser('');

        $line = 'Page 1 MediaBox: [-2.0 0.0 351.496094 238.110199]  Rotate = 270     Page contains Annotations';
        $this->assertEquals($gs_parser->getRotate($line), 270);

        $line = 'Page 1 MediaBox: [-2.0 0.0 351.496094 238.110199]  Rotate = 0     Page contains Annotations';
        $this->assertEquals($gs_parser->getRotate($line), 0);

        $line = 'Page 1 MediaBox: [-2.0 0.0 351.496094 238.110199]  Rotate = -90     Page contains Annotations';
        $this->assertEquals($gs_parser->getRotate($line), null);
    }

    public function testRotateBoxs()
    {
        $size = [
            'media_box' => [0.0, -2.0, 10, 20],
            'bleed_box' => [1.0, -2.0, 20, 40],
        ];

        $gs_parser = new GhostScriptDumpMediaSizesParser('');
        $expect_results_0 = $size;

        $this->assertEquals($gs_parser->rotateBoxs($size, 0), $expect_results_0);

        $expect_results_90 = [
            'media_box' => [-2.0, 0.0, 20, 10],
            'bleed_box' => [-2.0, 1.0, 40, 20],
        ];

        $this->assertEquals($gs_parser->rotateBoxs($size, 90), $expect_results_90);
        $this->assertEquals($gs_parser->rotateBoxs($size, 90)['media_box'], [-2.0, 0.0, 20, 10]);

        $size_with_null = [
            'media_box' => [0.0, -2.0, 10, 20],
            'bleed_box' => null,
        ];

        $expect_results_90_with_null = [
            'media_box' => [-2.0, 0.0, 20, 10],
            'bleed_box' => null,
        ];

        $this->assertEquals($gs_parser->rotateBoxs($size_with_null, 90), $expect_results_90_with_null);
    }

    public function testGetPagesFromSplitResults()
    {
        $data = file_get_contents('tests/fixtures/ghost_script_pdf_info_outputs/split_results.txt');
        $gs_parser = new GhostScriptDumpMediaSizesParser($data);
        $pages_count = $gs_parser->getPagesFromSplitResults();

        $this->assertEquals($pages_count, 12);
    }
}
