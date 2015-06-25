<?php
/**
 * Created by PhpStorm.
 * User: mburtscher
 * Date: 25.06.15
 * Time: 07:40
 */

namespace Fusonic\WebApp;


class Image
{
    private $backgroundColor;
    private $density;
    private $sizes = [];
    private $src;
    private $type;

    public function __construct()
    { }

    public function getBackgroundColor()
    {
        return $this->backgroundColor;
    }

    public function setBackgroundColor($backgroundColor)
    {
        $this->backgroundColor = $backgroundColor;
    }

    public function getDensity()
    {
        return $this->density;
    }

    public function setDensity($density)
    {
        if ($density !== null) {
            if (!filter_var($density, FILTER_SANITIZE_NUMBER_FLOAT)) {
                throw new \InvalidArgumentException("Density must be a float.");
            } else if ($density <= 0) {
                throw new \InvalidArgumentException("Density must be greater than 0.");
            }
        }

        $this->density = $density;
    }

    public function getSrc()
    {
        return $this->src;
    }

    public function setSrc($src)
    {
        $this->src = $src;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function addSize($size)
    {
        $this->sizes[] = $size;
    }

    public function getSizes()
    {
        return $this->sizes;
    }
}