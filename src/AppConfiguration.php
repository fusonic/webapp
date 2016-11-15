<?php

namespace Fusonic\WebApp;

/**
 * Contains all data of a web application to create different assets and/or tags.
 *
 * @package Fusonic\WebApp
 */
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
    private $manifestUrl;
    private $themeColor;

    public function __construct()
    { }

    /**
     * Returns the display mode or null if no value is set.
     *
     * @return string|null
     */
    public function getDisplay()
    {
        return $this->display;
    }

    /**
     * Set the preferred display mode. Must be one of AppConfiguration::DISPLAY_* or null.
     *
     * @param string|null $display Preferred display mode.
     * @return $this
     */
    public function setDisplay($display)
    {
        $display = strtolower(trim($display));

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

    /**
     * Returns the default device orientation or null if no value is set.
     *
     * @return string|null
     */
    public function getOrientation()
    {
        return $this->orientation;
    }

    /**
     * Sets the default device orientation. Must be one of AppConfiguration::ORIENTATION_* or null.
     *
     * @param string|null $orientation The default device orientation.
     * @return $this
     */
    public function setOrientation($orientation)
    {
        $orientation = strtolower(trim($orientation));

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

    /**
     * Returns the application's language or null if no value is set.
     *
     * @return string|null
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Sets the application's language. Must be a RFC5646 compliant string or null.
     *
     * @param string|null $language The application's language.
     * @return $this
     */
    public function setLanguage($language)
    {
        $this->language = $language;
        return $this;
    }

    /**
     * Returns the application's name or null if no value is set.
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the application's name.
     *
     * @param string|null $name The application's name.
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Returns the application's short name or null if no value is set.
     *
     * @return string|null
     */
    public function getShortName()
    {
        return $this->shortName;
    }

    /**
     * Sets the application's short name.
     *
     * @param string|null $shortName The application's short name.
     * @return $this
     */
    public function setShortName($shortName)
    {
        $this->shortName = $shortName;
        return $this;
    }

    /**
     * Returns the application's scope or null if no value is set.
     *
     * @return string|null
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * Sets the application's scope.
     *
     * @param string|null $scope The application's scope.
     * @return $this
     */
    public function setScope($scope)
    {
        $this->scope = $scope;
        return $this;
    }

    /**
     * Returns the application's start URL or null if no value is set.
     *
     * @return string|null
     */
    public function getStartUrl()
    {
        return $this->startUrl;
    }

    /**
     * Sets the application's start URLR.
     *
     * @param string|null $startUrl The application's start URL.
     * @return $this
     */
    public function setStartUrl($startUrl)
    {
        $this->startUrl = $startUrl;
        return $this;
    }

    /**
     * Adds an application icon.
     *
     * @param Image $icon The additional application icon.
     * @return $this
     */
    public function addIcon(Image $icon)
    {
        $this->icons[] = $icon;
        return $this;
    }

    /**
     * Returns an array of all application icons.
     *
     * @return Image[]
     */
    public function getIcons()
    {
        return $this->icons;
    }

    /**
     * Adds an application splash screen.
     *
     * @param Image $splashScreen The additional application splash screen.
     * @return $this
     */
    public function addSplashScreen(Image $splashScreen)
    {
        $this->splashScreens[] = $splashScreen;
        return $this;
    }

    /**
     * Returns an array of all application splash screens.
     *
     * @return Image[]
     */
    public function getSplashScreens()
    {
        return $this->splashScreens;
    }

    /**
     * Sets the manifest URL.
     *
     * @param string $url URL to the manifest file.
     * @return $this
     */
    public function setManifestUrl($url)
    {
        $url = trim($url);

        $this->manifestUrl = $url;
        return $this;
    }

    /**
     * Returns the manifest URL or null if no value is set.
     *
     * @return string|null
     */
    public function getManifestUrl()
    {
        return $this->manifestUrl;
    }

    /**
     * Sets the theme color. Must be a hex color code without alpha value or null.
     *
     * @param string $color The color code.
     * @return $this
     */
    public function setThemeColor($color)
    {
        if ($color !== null && !preg_match("/^#[A-Fa-f0-9]{3,6}$/", trim($color))) {
            throw new \InvalidArgumentException("Theme color must be a hex color code.");
        }

        $this->themeColor = $color;
        return $this;
    }

    /**
     * Returns the theme color or null if no value is set.
     *
     * @return string|null
     */
    public function getThemeColor()
    {
        return $this->themeColor;
    }

    /**
     * Creates as instance fothe AppConfiguration class based on the values in the provided manifest file. Use method
     * fromManifest() to use JSON string as source.
     *
     * @param string $path Path to a file containing a application manifest compatible with the W3C document "Manifest
     *     for a web application".
     * @return AppConfiguration
     */
    public static function fromManifestFile($path)
    {
        return self::fromManifest(file_get_contents($path));
    }

    /**
     * Creates an instance of the AppConfiguration class based on the values in the provided JSON string. Use method
     * fromManifestFile() to use a file as source.
     *
     * @param string $json A JSON string that is compatible with the W3C document "Manifest for a web application".
     * @return AppConfiguration
     */
    public static function fromManifest($json)
    {
        $data = json_decode($json, true);
        $app = new AppConfiguration();

        if (isset($data["name"])) {
            $app->setName($data["name"]);
        }

        if (isset($data["short_name"])) {
            $app->setShortName($data["short_name"]);
        }

        if (isset($data["lang"])) {
            $app->setLanguage($data["lang"]);
        }

        if (isset($data["display"])) {
            $app->setDisplay($data["display"]);
        }

        if (isset($data["orientation"])) {
            $app->setOrientation($data["orientation"]);
        }

        if (isset($data["scope"])) {
            $app->setScope($data["scope"]);
        }

        if (isset($data["start_url"])) {
            $app->setStartUrl($data["start_url"]);
        }

        if (isset($data["icons"])) {
            foreach ($data["icons"] as $icon) {
                $app->addIcon(self::imageFromData($icon));
            }
        }

        if (isset($data["splash_screens"])) {
            foreach ($data["splash_screens"] as $splashScreen) {
                $app->addSplashScreen(self::imageFromData($splashScreen));
            }
        }

        return $app;
    }

    private static function imageFromData(array $data)
    {
        $image = new Image();

        if (isset($data["src"])) {
            $image->setSrc($data["src"]);
        }

        if (isset($data["density"])) {
            $image->setDensity($data["density"]);
        }

        if (isset($data["background_color"])) {
            $image->setBackgroundColor($data["background_color"]);
        }

        if (isset($data["type"])) {
            $image->setType($data["type"]);
        }

        if (isset($data["sizes"])) {
            $sizes = [];
            if (preg_match_all("/(\d+)x(\d+)/", $data["sizes"], $sizes)) {
                for ($i = 0; $i < count($sizes[0]); $i++) {
                    $image->addSize($sizes[1][$i], $sizes[2][$i]);
                }
            }
        }

        return $image;
    }
}