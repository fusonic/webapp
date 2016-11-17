<?php

namespace Fusonic\WebApp\Objects;

final class ImageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \Fusonic\WebApp\Objects\Image::getPurpose
     */
    public function testInitialValueOfGetPurpose()
    {
        $purpose = (new Image())->getPurpose();

        $this->assertInternalType("array", $purpose);
        $this->assertSame([ ], $purpose);
    }

    /**
     * @covers \Fusonic\WebApp\Objects\Image::getPurpose
     * @covers \Fusonic\WebApp\Objects\Image::addPurpose
     */
    public function testPurposeGetterAndSetter()
    {
        $image = (new Image())
            ->addPurpose(Image::PURPOSE_ANY)
            ->addPurpose(Image::PURPOSE_BADGE)
            ->addPurpose(Image::PURPOSE_ANY)
            ->addPurpose(Image::PURPOSE_BADGE);

        // Per specs: "The purpose member is an unordered set of unique […] tokens […]"

        $purpose = $image->getPurpose();

        $this->assertSame(2, count($purpose));
        $this->assertSame([ Image::PURPOSE_ANY, Image::PURPOSE_BADGE ], $purpose);
    }

    /**
     * @covers \Fusonic\WebApp\Objects\Image::getSizes
     */
    public function testInitialValueOfGetSizes()
    {
        $sizes = (new Image())->getSizes();

        $this->assertInternalType("array", $sizes);
        $this->assertSame([ ], $sizes);
    }

    /**
     * @covers \Fusonic\WebApp\Objects\Image::getSizes
     * @covers \Fusonic\WebApp\Objects\Image::addSize
     */
    public function testSizeGetterAndSetter()
    {
        $image = (new Image())
            ->addSize(100, 50)
            ->addSize(200, 33)
            ->addSize("100", 50)
            ->addSize(128, 128.0);

        // All sizes must be casted to integers.

        $sizes = $image->getSizes();

        $this->assertSame(4, count($sizes));
        $this->assertSame([ [ 100, 50 ], [ 200, 33 ], [ 100, 50 ], [ 128, 128 ] ], $sizes);
    }

    /**
     * @covers \Fusonic\WebApp\Objects\Image::getSrc
     */
    public function testInitialValueOfGetSrc()
    {
        $this->assertNull((new Image())->getSrc());
    }

    /**
     * @covers \Fusonic\WebApp\Objects\Image::getSrc
     * @covers \Fusonic\WebApp\Objects\Image::setSrc
     */
    public function testSrcGetterAndSetter()
    {
        $image = (new Image())
            ->setSrc("android-128.png");

        $this->assertSame("android-128.png", $image->getSrc());

        $image = (new Image())
            ->setSrc("android-256.png")
            ->setSrc("ios-256.png");

        $this->assertSame("ios-256.png", $image->getSrc());
    }

    /**
     * @covers \Fusonic\WebApp\Objects\Image::getType
     */
    public function testInitialValueOfGetType()
    {
        $this->assertNull((new Image())->getType());
    }

    /**
     * @covers \Fusonic\WebApp\Objects\Image::getType
     * @covers \Fusonic\WebApp\Objects\Image::setType
     */
    public function testTypeGetterAndSetter()
    {
        $image = (new Image())
            ->setType("image/png");

        $this->assertSame("image/png", $image->getType());

        $image = (new Image())
            ->setType("image/jpeg")
            ->setType("image/svg");

        $this->assertSame("image/svg", $image->getType());
    }
}
