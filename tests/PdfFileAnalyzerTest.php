<?php
// Media Box (Pole strony) odnosi się do fizycznego medium, na którym jest wydrukowana nasza praca (width and height of the page)
// Bleed Box (Pole spadu) praca ze spadami, czyli format „brutto”.
// Trim Box (Pole przycięcia) praca po przycięciu, czyli format „netto”.
// Crop Box (Pole kadrowania) cała praca ze spadami i znacznikami drukarskimi.
// Art Box (Pole grafiki) nie potrzebujemy

class PdfFileAnalyzerTest extends \TesterCase
{
    public $skip_database_clear_before = ['all'];

    public function testAnalyze()
    {
        $file_analyzer = new PdfFileAnalyzer('tests/fixtures/files/test_file_01.pdf');
        $file_analyze = $file_analyzer->analyze();

        $expect = [
            'pages_count' => 2,
            'pages' => [
                1 => [
                    'media_box' => [
                        'width_in_pt' => 97.852,
                        'height_in_pt' => 154.715,
                        'width_in_mm' => 34.52,
                        'height_in_mm' => 54.58,
                    ],
                    'bleed_box' => [
                        'width_in_pt' => 97.852,
                        'height_in_pt' => 154.715,
                        'width_in_mm' => 34.52,
                        'height_in_mm' => 54.58,
                    ],
                    'crop_box' => [
                        'width_in_pt' => 97.852,
                        'height_in_pt' => 154.715,
                        'width_in_mm' => 34.52,
                        'height_in_mm' => 54.58,
                    ],
                    'trim_box' => [
                        'width_in_pt' => 86.51342,
                        'height_in_pt' => 143.37672,
                        'width_in_mm' => 30.52,
                        'height_in_mm' => 50.58,
                    ],
                    'art_box' => [
                        'width_in_pt' => 86.51342,
                        'height_in_pt' => 143.37672,
                        'width_in_mm' => 30.52,
                        'height_in_mm' => 50.58,
                    ],
                    'spot_colors' => [
                        [
                           'name' => 'TestSpotColor',
                        ],
                        [
                           'name' => 'CutContour',
                        ],
                    ],
                    'has_visible_overprint' => true,
                ],
                2 => [
                    'media_box' => [
                        'width_in_pt' => 97.852,
                        'height_in_pt' => 98.022,
                        'width_in_mm' => 34.52,
                        'height_in_mm' => 34.58,
                    ],
                    'bleed_box' => [
                        'width_in_pt' => 97.852,
                        'height_in_pt' => 98.022,
                        'width_in_mm' => 34.52,
                        'height_in_mm' => 34.58,
                    ],
                    'crop_box' => [
                        'width_in_pt' => 97.852,
                        'height_in_pt' => 98.022,
                        'width_in_mm' => 34.52,
                        'height_in_mm' => 34.58,
                    ],
                    'trim_box' => [
                        'width_in_pt' => 86.51342,
                        'height_in_pt' => 86.68352,
                        'width_in_mm' => 30.52,
                        'height_in_mm' => 30.58,
                    ],
                    'art_box' => [
                        'width_in_pt' => 86.51342,
                        'height_in_pt' => 86.68352,
                        'width_in_mm' => 30.52,
                        'height_in_mm' => 30.58,
                    ],
                    'spot_colors' => [
                        [
                           'name' => 'TestSpotColor',
                        ],
                        [
                           'name' => 'CutContour',
                        ],
                    ],
                    'has_visible_overprint' => true,
                ],
            ],
        ];

        Assert::expect($file_analyze)->to_equal($expect);
    }
}
