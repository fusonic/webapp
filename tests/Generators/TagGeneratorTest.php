<?php

namespace Generators;

use Fusonic\WebApp\AppConfiguration;
use Fusonic\WebApp\Generators\TagGenerator;

class TagGeneratorTest extends \PHPUnit_Framework_TestCase
{
    public function testGetData_w3cSample()
    {
        $generator = new TagGenerator();

        $config = AppConfiguration::fromManifestFile(__DIR__ . "/../TestData/manifest.json");
        $config->setManifestUrl("manifest.json");

        $method = new \ReflectionMethod(TagGenerator::class, "getData");
        $method->setAccessible(true);
        $tags = $method->invoke($generator, $config, true, true, true, true);

        // URLs
        $this->assertContainsLink($tags, "manifest", "manifest.json");
        $this->assertContainsMeta($tags, "msapplication-starturl", "/racer/start.html");

        // Title
        $this->assertContainsMeta($tags, "application-name", "Racer3K");
        $this->assertContainsMeta($tags, "apple-mobile-web-app-title", "Racer3K");

        // Icons
        $this->assertContainsLink($tags, "icon", "icon/lowres.webp", "64x64");
        $this->assertContainsLink($tags, "icon", "icon/lowres.png", "64x64");
        $this->assertContainsLink($tags, "icon", "icon/hd_hi", "128x128");
        $this->assertContainsLink($tags, "apple-touch-icon", "icon/lowres.webp", "64x64");
        $this->assertContainsLink($tags, "apple-touch-icon", "icon/lowres.png", "64x64");
        $this->assertContainsLink($tags, "apple-touch-icon", "icon/hd_hi", "128x128");

        // Theme color
        $this->assertContainsMeta($tags, "theme-color", "aliceblue");
        $this->assertContainsMeta($tags, "msapplication-navbutton-color", "aliceblue");

        // Apple specific
        $this->assertContainsMeta($tags, "format-detection", "telephone=no");
        $this->assertContainsMeta($tags, "apple-mobile-web-app-capable", "yes");
        $this->assertContainsMeta($tags, "apple-mobile-web-app-status-bar-style", "black-translucent");
    }

    private function assertContainsLink($data, $rel, $href, $sizes = null)
    {
        $expected = [ "link", "rel" => $rel, "href" => $href ];

        if ($sizes) {
            $expected["sizes"] = $sizes;
        }

        $this->assertContains($expected, $data);
    }

    private function assertContainsMeta($data, $name, $content)
    {
        $this->assertContains([ "meta", "name" => $name, "content" => $content ], $data);
    }
}
