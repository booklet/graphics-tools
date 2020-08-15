<?php
class FileMeasurementPDF
{
    private $file_path;
    private $pages_sizes;

    public function __construct($pdf_file_path)
    {
        $this->file_path = $pdf_file_path;
    }

    public function pagesCount()
    {
        $pages_count = shell_exec('gs -q -dNOSAFER -dNODISPLAY -c "(' . $this->file_path . ') (r) file runpdfbegin pdfpagecount = quit"');

        return intval($pages_count);
    }

    public function widthInPt(array $params = [])
    {
        return $this->getPtSize('media_box', 'with', $params);
    }

    public function widthInMm(array $params = [])
    {
        $width_in_mm = UnitConverterUntils::ptToMm($this->widthInPt($params));

        return round($width_in_mm, 2);
    }

    public function widthInPx(array $params = [])
    {
        return UnitConverterUntils::ptToPx($this->widthInPt($params), $params);
    }

    public function heightInPt(array $params = [])
    {
        return $this->getPtSize('media_box', 'height', $params);
    }

    public function heightInMm(array $params = [])
    {
        $height_in_mm = UnitConverterUntils::ptToMm($this->heightInPt($params));

        return round($height_in_mm, 2);
    }

    public function heightInPx(array $params = [])
    {
        return UnitConverterUntils::ptToPx($this->heightInPt($params), $params);
    }

    private function getPtSize($box_type, $orient, $params)
    {
        $page = $params['page'] ?? 1;

        if (!$this->pages_sizes) {
            $this->setPagesSizes();
        }

        $sizes = $this->pages_sizes[$page - 1][$box_type];

        if ($orient == 'with') {
            $size = $sizes[2] - $sizes[0]; // index 0 (x1) and 1 (y1) can be negative
        } elseif ($orient == 'height') {
            $size = $sizes[3] - $sizes[1];
        }

        return round($size, 2);
    }

    public function setPagesSizes()
    {
        $toolbin_pdf_info_path = __DIR__ . '/../lib/ghost_script/toolbin_pdf_info.ps';

        if (!file_exists($toolbin_pdf_info_path)) {
            throw new Exception('Not found toolbin_pdf_info.ps file (require for get pdf size)');
        }


        // Page 1 MediaBox: [0.0 0.0 153.069 153.069] BleedBox: [0.0 0.0 153.069 153.069] TrimBox: [5.66928 5.66928 147.399 147.399] ArtBox: [35.5363 42.8105 98.0332 115.828]
        $data = '';
        $MediaBox = shell_exec('gs -q -dNOSAFER -dNODISPLAY -sFileName="' . $this->file_path . '" -c "FileName (r) file runpdfbegin 1 1 pdfpagecount {pdfgetpage /MediaBox get {=print ( ) print} forall (\n) print} for quit"');
        $MediaBox = explode("\n", $MediaBox);
        $MediaBox = array_filter($MediaBox, 'strlen');
        foreach ($MediaBox as $index => $media_box) {
            $data .= 'Page ' . ($index+1) . ' MediaBox: [' . trim($media_box) . "]\n";
        }
        // BleedBox
        // CropBox
        // TrimBox
        // ArtBox

        // $pdf_info_data = shell_exec('gs -dNOSAFER -dNODISPLAY -q -sFile="' . $this->file_path . '"' .
        //     ' -dDumpMediaSizes ' . $toolbin_pdf_info_path);
        $gs_parser = new GhostScriptDumpMediaSizesParser($data);

        $this->pages_sizes = $gs_parser->parse();
    }
}
