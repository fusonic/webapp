<?php

namespace Fusonic\WebApp\Test;

use Fusonic\WebApp\AppConfiguration;

final class AppConfigurationTest extends \PHPUnit_Framework_TestCase
{
    public function testFromManifest_w3cSample()
    {
        $app = AppConfiguration::fromManifestFile(__DIR__ . "/TestData/manifest.json");

        $this->assertEquals("en", $app->getLanguage());
        $this->assertEquals("Super Racer 2000", $app->getName());
        $this->assertEquals("Racer2K", $app->getShortName());
        $this->assertEquals("/racer/", $app->getScope());
        $this->assertEquals("/racer/start.html", $app->getStartUrl());
        $this->assertEquals(AppConfiguration::DISPLAY_FULLSCREEN, $app->getDisplay());
        $this->assertEquals(AppConfiguration::ORIENTATION_LANDSCAPE, $app->getOrientation());

        $this->assertCount(3, $app->getIcons());
        $this->assertEquals("icon/lowres", $app->getIcons()[0]->getSrc());
        $this->assertCount(1, $app->getIcons()[0]->getSizes());
        $this->assertEquals([64, 64], $app->getIcons()[0]->getSizes()[0]);
        $this->assertEquals("image/webp", $app->getIcons()[0]->getType());
        $this->assertEquals("icon/hd_small", $app->getIcons()[1]->getSrc());
        $this->assertCount(1, $app->getIcons()[1]->getSizes());
        $this->assertEquals([64, 64], $app->getIcons()[1]->getSizes()[0]);
        $this->assertEquals("icon/hd_hi", $app->getIcons()[2]->getSrc());
        $this->assertCount(1, $app->getIcons()[2]->getSizes());
        $this->assertEquals([128, 128], $app->getIcons()[2]->getSizes()[0]);

        $this->assertCount(3, $app->getSplashScreens());
    }
}
