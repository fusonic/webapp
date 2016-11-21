<?php

namespace Fusonic\WebApp\Members;

use Fusonic\WebApp\AppConfiguration;

final class PlatformTraitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \Fusonic\WebApp\Members\PlatformTrait::getPlatform
     */
    public function testInitialValueOfGetPlatform()
    {
        /** @var PlatformTrait $traitMock */
        $traitMock = $this->getMockForTrait(PlatformTrait::class);

        $this->assertNull($traitMock->getPlatform());
    }

    /**
     * @covers \Fusonic\WebApp\Members\PlatformTrait::getPlatform
     * @covers \Fusonic\WebApp\Members\PlatformTrait::setPlatform
     */
    public function testPlatformGetterAndSetter()
    {
        /** @var PlatformTrait $traitMock */
        $traitMock = $this->getMockForTrait(PlatformTrait::class);
        $traitMock
            ->setPlatform(AppConfiguration::PLATFORM_ANDROID);

        $this->assertSame(AppConfiguration::PLATFORM_ANDROID, $traitMock->getPlatform());

        /** @var PlatformTrait $traitMock */
        $traitMock = $this->getMockForTrait(PlatformTrait::class);
        $traitMock
            ->setPlatform(AppConfiguration::PLATFORM_IOS)
            ->setPlatform(AppConfiguration::PLATFORM_WEB);

        $this->assertSame(AppConfiguration::PLATFORM_WEB, $traitMock->getPlatform());
    }
}
