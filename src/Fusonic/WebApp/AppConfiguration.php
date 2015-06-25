<?php

namespace Fusonic\WebApp;

class AppConfiguration
{
    const DISPLAY_BROWSER = "browser";
    const DISPLAY_FULLSCREEN = "fullscreen";
    const DISPLAY_MINIMAL_UI = "minimal-ui";
    const DISPLAY_STANDALONE = "standalone";

    const ORIENTATION_ANY = "any";
    const ORIENTATION_NATURAL = "natural";
    const ORIENTATION_LANDSCAPE = "landscape";
    const ORIENTATION_LANDSCAPE_PRIMARY = "landscape-primary";
    const ORIENTATION_LANDSCAPE_SECONDARY = "landscape-secondary";
    const ORIENTATION_PORTRAIT = "portrait";
    const ORIENTATION_PORTRAIT_PRIMARY = "portrait-primary";
    const ORIENTATION_PORTRAIT_SECONDARY = "portrait-secondary";

    private $language;
    private $name;
    private $shortName;
    private $scope;
    private $splashScreens = [];
    private $icons = [];
    private $display;
    private $orientation;
    private $startUrl;

    public function __construct()
    { }

    public function getDisplay()
    {
        return $this->display;
    }

    public function setDisplay($display)
    {
        if (!in_array(
            $display,
            [
                null,
                self::DISPLAY_BROWSER,
                self::DISPLAY_FULLSCREEN,
                self::DISPLAY_MINIMAL_UI,
                self::DISPLAY_STANDALONE
            ]
        )) {
            throw new \InvalidArgumentException("Use one of AppConfiguration::DISPLAY_* values.");
        }

        $this->display = $display;
        return $this;
    }

    public function getOrientation()
    {
        return $this->orientation;
    }

    public function setOrientation($orientation)
    {
        if (!in_array(
            $orientation,
            [
                null,
                self::ORIENTATION_ANY,
                self::ORIENTATION_LANDSCAPE,
                self::ORIENTATION_LANDSCAPE_PRIMARY,
                self::ORIENTATION_LANDSCAPE_SECONDARY,
                self::ORIENTATION_NATURAL,
                self::ORIENTATION_PORTRAIT,
                self::ORIENTATION_PORTRAIT_PRIMARY,
                self::ORIENTATION_PORTRAIT_SECONDARY,
            ]
        )) {
            throw new \InvalidArgumentException("Use one of AppConfiguration::ORIENTATION_* values.");
        }

        $this->orientation = $orientation;
        return $this;
    }

    public function getLanguage()
    {
        return $this->language;
    }

    public function setLanguage($language)
    {
        $this->language = $language;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getShortName()
    {
        return $this->shortName;
    }

    public function setShortName($shortName)
    {
        $this->shortName = $shortName;
        return $this;
    }

    public function getScope()
    {
        return $this->scope;
    }

    public function setScope($scope)
    {
        $this->scope = $scope;
        return $this;
    }

    public function getStartUrl()
    {
        return $this->startUrl;
    }

    public function setStartUrl($startUrl)
    {
        $this->startUrl = $startUrl;
        return $this;
    }

    public function addIcon(Image $icon)
    {
        $this->icons[] = $icon;
        return $this;
    }

    public function getIcons()
    {
        return $this->icons;
    }

    public function addSplashScreen(Image $splashScreen)
    {
        $this->splashScreens[] = $splashScreen;
        return $this;
    }

    public function getSplashScreens()
    {
        return $this->splashScreens;
    }
}