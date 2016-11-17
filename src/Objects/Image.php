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
 * Represents an <b>image object</b>.
 *
 * @package Fusonic\WebApp
 *
 * @see https://www.w3.org/TR/appmanifest/#image-object-and-its-members
 */
final class Image
{
    const PURPOSE_BADGE = "badge";
    const PURPOSE_ANY = "any";

    private $purpose = [ ];
    private $sizes = [ ];
    private $src;
    private $type;

    /**
     * Returns the image's intended purpose.
     *
     * @return  string[]
     */
    public function getPurpose()
    {
        return array_values($this->purpose);
    }

    /**
     * Adds a purpose for this image.
     *
     * @param   string              $purpose            One of of Image::PURPOSE_* constants.
     *
     * @return  Image
     *
     * @see https://www.w3.org/TR/appmanifest/#purpose-member
     */
    public function addPurpose($purpose)
    {
        $this->purpose[$purpose] = $purpose;
        return $this;
    }

    /**
     * Returns an array of sizes contained in this file.
     *
     * @return  array[]
     */
    public function getSizes()
    {
        return $this->sizes;
    }

    /**
     * Adds an additional size contained in this file.
     *
     * @param   int                 $width
     * @param   int                 $height
     *
     * @return  Image
     *
     * @see https://www.w3.org/TR/appmanifest/#sizes-member
     */
    public function addSize($width, $height)
    {
        $this->sizes[] = [ (int)$width, (int)$height ];
        return $this;
    }

    /**
     * Returns the source path of this file.
     *
     * @return  string|null
     */
    public function getSrc()
    {
        return $this->src;
    }

    /**
     * Sets the source path of this file.
     *
     * @param   string              $src
     *
     * @return  Image
     *
     * @see https://www.w3.org/TR/appmanifest/#src-member
     */
    public function setSrc($src)
    {
        $this->src = $src;
        return $this;
    }

    /**
     * Returns the MIME type of this file.
     *
     * @return  string|null
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets the MIME type of this file.
     *
     * @param   string              $type
     *
     * @return  Image
     *
     * @see https://www.w3.org/TR/appmanifest/#type-member
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }
}
