<?php
class PdfFileAnalyzer
{
    private $file_path;

    public function __construct($file_path)
    {
        $this->file_path = $file_path;
    }

    public function analyze()
    {
        $pages_sizes = $this->getFileData();

        $data = [
            'pages_count' => count($pages_sizes),
            'pages' => [],
        ];

        foreach ($pages_sizes as $index => $page_size) {
            foreach ($page_size as $box_name => $values) {
                $data['pages'][$index + 1][$box_name] = [
                    'width_in_pt' => $values[2] - $values[0],
                    'height_in_pt' => $values[3] - $values[1],
                    'width_in_mm' => $this->ptToMm($values[2] - $values[0]),
                    'height_in_mm' => $this->ptToMm($values[3] - $values[1]),
                ];
            }
        }

        // spot colors
        $spot_colors = $this->getSpotColors();
        foreach ($data['pages'] as &$page) {
            $page['spot_colors'] = [];

            foreach ($spot_colors as $color_name) {
                $page['spot_colors'][] = [
                    'name' => $color_name,
                ];
            }
        }

        // Overprint
        // Informacja o overprint jest dla calego dokumnetu
        // nie mozemy sprawdzic na ktorch stronach jest lub go nie ma
        $overprint = $this->hasOverprint();
        if (is_bool($overprint)) {
            foreach ($data['pages'] as &$page) {
                $page['has_visible_overprint'] = $overprint;
            }
        }

        return $data;
    }

    private function getFileData()
    {
        $toolbin_pdf_info_path = __DIR__ . '/../lib/ghost_script/toolbin_pdf_info.ps';

        $pdf_info_data = shell_exec('gs -dNODISPLAY -q -sFile="' . $this->file_path . '"' .
            ' -dDumpMediaSizes ' . $toolbin_pdf_info_path);

        $gs_parser = new GhostScriptDumpMediaSizesParser($pdf_info_data);

        return $gs_parser->parse();
    }

    private function pagesCount()
    {
        $pages_count = shell_exec('gs -q -dNODISPLAY -c "(' . $this->file_path . ') (r) file runpdfbegin pdfpagecount = quit"');

        return intval($pages_count);
    }

    private function getSpotColors()
    {
        $file_info_data = shell_exec($this->getIdentifyPath() . ' -verbose ' . $this->file_path . ' 2>&1');

        if (StringUntils::isInclude($file_info_data, 'command not found')) {
            throw new Exception('Missing imagemagick identify library.');
        }

        $lines = explode("\n", $file_info_data);
        $spots_colors = [];
        foreach ($lines as $line) {
            if (StringUntils::isInclude($line, 'pdf:SpotColor-')) {
                $i = explode(' ', $line);
                $spots_colors[] = end($i);
            }
        }

        return array_unique($spots_colors);
    }

    private function hasOverprint()
    {
        $file_info_data = shell_exec($this->getIdentifyPath() . ' -verbose ' . $this->file_path . ' 2>&1');

        if (StringUntils::isInclude($file_info_data, 'command not found')) {
            throw new Exception('Missing imagemagick identify library.');
        }

        $lines = explode("\n", $file_info_data);

        foreach ($lines as $line) {
            if (StringUntils::isInclude($line, 'HasVisibleOverprint')) {
                $i = explode(' ', $line);
                if (end($i) == 'True') {
                    return true;
                } else {
                    return false;
                }
            }
        }

        return null;
    }

    private function getIdentifyPath()
    {
        if (`which identify`) {
            return 'identify';
        }

        if (`which /usr/local/bin/identify`) {
            return '/usr/local/bin/identify';
        }

        throw new Exception('Missing imagemagick identify library.');
    }

    private function ptToMm($points)
    {
        // 1 pt = 0.352778 mm.
        $precision = 2;

        return round(($points * 0.352778), $precision);
    }
}
