<?php

namespace Generators;

use Fusonic\WebApp\AppConfiguration;
use Fusonic\WebApp\Generators\ManifestGenerator;

class ManifestGeneratorTest extends \PHPUnit_Framework_TestCase
{
    public function testGenerate()
    {
        $sourceManifest = file_get_contents(__DIR__ . "/../TestData/manifest.json");
        $sourceConfig = AppConfiguration::fromManifest($sourceManifest);

        $manifest = (new ManifestGenerator())->get($sourceConfig);

        $this->assertEquals(json_decode($sourceManifest, true), $manifest);
    }
}
