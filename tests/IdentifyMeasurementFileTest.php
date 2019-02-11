<?php
class IdentifyMeasurementFileTest extends \CustomPHPUnitTestCase
{
    public $skip_database_clear_before = ['all'];

    public function testGestSize()
    {
        $measurement = new IdentifyMeasurementFile('tests/fixtures/files/30x50.pdf');

        $this->assertEquals($measurement->getWidth(), 96.0);
        $this->assertEquals($measurement->getHeight(), 153.0);

        $measurement = new IdentifyMeasurementFile('tests/fixtures/files/client-test-file-07.eps');

        $this->assertEquals($measurement->getWidth(), 73.0);
        $this->assertEquals($measurement->getHeight(), 83.0);

        $measurement = new IdentifyMeasurementFile('tests/fixtures/files/cloud-upload.svg');

        $this->assertEquals($measurement->getWidth(), 32.0);
        $this->assertEquals($measurement->getHeight(), 32.0);

        $measurement = new IdentifyMeasurementFile('tests/fixtures/files/client-test-file-06a.ai');

        $this->assertEquals($measurement->getWidth(), 181.0);
        $this->assertEquals($measurement->getHeight(), 125.0);

        $measurement = new IdentifyMeasurementFile('tests/fixtures/files/animal.jpg');

        $this->assertEquals($measurement->getWidth(), 640.0);
        $this->assertEquals($measurement->getHeight(), 480.0);

        $measurement = new IdentifyMeasurementFile('tests/fixtures/files/animal_22x33-444x5mm66X77_88.8x99.9.jpg');

        $this->assertEquals($measurement->getWidth(), 640.0);
        $this->assertEquals($measurement->getHeight(), 480.0);
    }
}
