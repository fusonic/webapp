<?php

namespace Fusonic\WebApp;

/**
 * Defines an image according to the W3C specification "Manifest for a web application".
 * See http://www.w3.org/TR/appmanifest/#image-object-and-its-members
 *
 * @package Fusonic\WebApp
 */
class Image
{
    private $backgroundColor;
    private $density;
    private $sizes = [];
    private $src;
    private $type;

    public function __construct()
    { }

    /**
     * Returns the background color or null if no value is set.
     *
     * @return string|null
     */
    public function getBackgroundColor()
    {
        return $this->backgroundColor;
    }

    /**
     * Sets the background color to use for the image. Must be a CSS3 valid color or null.
     *
     * @param string|null $backgroundColor The background color to use.
     */
    public function setBackgroundColor($backgroundColor)
    {
        $this->backgroundColor = $backgroundColor;
    }

    /**
     * Returns the pixel density or null if no value is set.
     *
     * @return float|null
     */
    public function getDensity()
    {
        return $this->density;
    }

    /**
     * Sets the density of this image file. May be null.
     *
     * @param float $density The density of this image file.
     */
    public function setDensity($density)
    {
        if ($density !== null) {
            if (!filter_var($density, FILTER_SANITIZE_NUMBER_FLOAT)) {
                throw new \InvalidArgumentException("Density must be a float.");
            } else if ($density <= 0) {
                throw new \InvalidArgumentException("Density must be greater than 0.");
            }
        }

        $this->density = (float)$density;
    }

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