<?php

/*
 * This file is part of the fusonic/webapp package.
 *
 * (c) Fusonic GmbH <office@fusonic.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fusonic\WebApp\Members;

/**
 * Adds support for the `platform` member.
 *
 * <p>
 * There is no official list of possible values. However, the Web Platform Working Group maintains a list of known
 * platform values {@link https://github.com/w3c/manifest/wiki/Platforms in their wiki}.
 *
 * @package Fusonic\WebApp
 *
 * @see https://www.w3.org/TR/appmanifest/#platform-member
 */
trait PlatformTrait
{
    private $platform;

    /**
     * Returns the intended target platform for this object.
     *
     * @return  string|null
     */
    public function getPlatform()
    {
        return $this->platform;
    }

    /**
     * Sets the intended target platform for this object.
     *
     * @param   string              $platform
     *
     * @return  $this
     */
    public function setPlatform($platform)
    {
        $this->platform = $platform;
        return $this;
    }
}
