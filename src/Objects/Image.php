<?php

/*
 * This file is part of the fusonic/webapp package.
 *
 * (c) Fusonic GmbH <office@fusonic.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fusonic\WebApp\Objects;

/**
 * Defines an image according to the W3C specification "Manifest for a web application".
 * See http://www.w3.org/TR/appmanifest/#image-object-and-its-members
 *
 * @package Fusonic\WebApp
 */
class Image
{
    private $sizes = [];
    private $src;
    private $type;

    public function __construct()
    { }

    /**
     * Returns the src of the file or null if no value is set.
     *
     * @return string|null
     */
    public function getSrc()
    {
        return $this->src;
    }

    /**
     * Sets the src of this image. May be null.
     *
     * @param string|null $src The src of the image.
     */
    public function setSrc($src)
    {
        $this->src = $src;
    }

    /**
     * Returns the mime type of the file or null if no value is set.
     *
     * @return string|null
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Returns the mime type of this image. Must be a valid mime type or null.
     *
     * @param string|null $type The mime type of the image.
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Adds an additional size contained in this file.
     *
     * @param int $width The width of the image.
     * @param int $height The height of the image.
     * @return $this;
     */
    public function addSize($width, $height)
    {
        $this->sizes[] = [ (int)$width, (int)$height ];
        return $this;
    }

    /**
     * Returns an array of sizes contained in this file.
     *
     * @return array[]
     */
    public function getSizes()
    {
        return $this->sizes;
    }
}
