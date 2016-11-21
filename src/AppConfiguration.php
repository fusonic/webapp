<?php

/*
 * This file is part of the fusonic/webapp package.
 *
 * (c) Fusonic GmbH <office@fusonic.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fusonic\WebApp;

use Fusonic\WebApp\Generators\ManifestGenerator;
use Fusonic\WebApp\Generators\TagGenerator;
use Fusonic\WebApp\Objects\Image;

/**
 * Contains all data of a web application to create different assets and/or tags.
 *
 * @package Fusonic\WebApp
 *
 * @see ManifestGenerator
 * @see TagGenerator
 */
final class AppConfiguration
{
    const DIRECTION_LEFT_TO_RIGHT = "ltr";
    const DIRECTION_RIGHT_TO_LEFT = "rtl";
    const DIRECTION_AUTO = "auto";

    const DISPLAY_FULLSCREEN = "fullscreen";
    const DISPLAY_STANDALONE = "standalone";
    const DISPLAY_MINIMAL_UI = "minimal-ui";
    const DISPLAY_BROWSER = "browser";

    const ORIENTATION_ANY = "any";
    const ORIENTATION_NATURAL = "natural";
    const ORIENTATION_LANDSCAPE = "landscape";
    const ORIENTATION_LANDSCAPE_PRIMARY = "landscape-primary";
    const ORIENTATION_LANDSCAPE_SECONDARY = "landscape-secondary";
    const ORIENTATION_PORTRAIT = "portrait";
    const ORIENTATION_PORTRAIT_PRIMARY = "portrait-primary";
    const ORIENTATION_PORTRAIT_SECONDARY = "portrait-secondary";

    const PLATFORM_ANDROID = "android";
    const PLATFORM_IOS = "ios";
    const PLATFORM_WEB = "web";

    private $backgroundColor;
    private $description;
    private $direction;
    private $display;
    private $icons = [ ];
    private $language;
    private $name;
    private $orientation;
    private $scope;
    private $shortName;
    private $startUrl;
    private $themeColor;

    private $manifestUrl;

    /**
     * Returns the manifest URL.
     *
     * @return  string
     */
    public function getManifestUrl()
    {
        if ($this->manifestUrl === null) {
            throw new \LogicException("Manifest URL cannot be null.");
        }

        return $this->manifestUrl;
    }

    /**
     * Sets the manifest URL. You MUST set one for proper deployment.
     *
     * @param   string              $url
     *
     * @return  AppConfiguration
     */
    public function setManifestUrl($url)
    {
        $this->manifestUrl = $url;
        return $this;
    }

    /**
     * Returns the expected background color for the web application.
     *
     * @return  string|null
     */
    public function getBackgroundColor()
    {
        return $this->backgroundColor;
    }

    /**
     * Sets the expected background color for the web application. Will also be used by Chrome 47 and later to
     * auto-generate a splash screen.
     *
     * <p>
     * This value repeats what is already available in the application stylesheet, but can be used by browsers to draw
     * the background color of a web application when the manifest is available before the style sheet has loaded.
     *
     * <p>
     * This creates a smooth transition between launching the web application and loading the application's content.
     *
     * @param   string              $backgroundColor
     *
     * @return  AppConfiguration
     *
     * @see https://www.w3.org/TR/appmanifest/#background_color-member
     */
    public function setBackgroundColor($backgroundColor)
    {
        $this->backgroundColor = $backgroundColor;
        return $this;
    }

    /**
     * Returns the general description of what the web application does.
     *
     * @return  string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets a general description of what the web application does.
     *
     * @param   string              $description
     *
     * @return  AppConfiguration
     *
     * @see https://www.w3.org/TR/appmanifest/#description-member
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Returns the primary text direction for the {@link $name}, {@link $shortName}, and {@link $description} members.
     *
     * @return  string|null
     */
    public function getDirection()
    {
        return $this->direction;
    }

    /**
     * Sets the primary text direction for the {@link $name}, {@link $shortName}, and {@link $description} members.
     *
     * @param   string              $direction          One of AppConfiguration::DIRECTION_* constants.
     *
     * @return  AppConfiguration
     *
     * @see https://www.w3.org/TR/appmanifest/#dir-member
     */
    public function setDirection($direction)
    {
        if (!in_array(
            $direction,
            [
                self::DIRECTION_LEFT_TO_RIGHT,
                self::DIRECTION_RIGHT_TO_LEFT,
                self::DIRECTION_AUTO
            ]
        )) {
            throw new \InvalidArgumentException("Use one of AppConfiguration::DIRECTION_* constants.");
        }

        $this->direction = $direction;
        return $this;
    }

    /**
     * Returns the preferred display mode.
     *
     * @return  string|null
     */
    public function getDisplay()
    {
        return $this->display;
    }

    /**
     * Sets the preferred display mode.
     *
     * @param   string              $display            One of AppConfiguration::DISPLAY_* constants.
     *
     * @return  AppConfiguration
     *
     * @see https://www.w3.org/TR/appmanifest/#display-member
     */
    public function setDisplay($display)
    {
        if (!in_array(
            $display,
            [
                self::DISPLAY_FULLSCREEN,
                self::DISPLAY_MINIMAL_UI,
                self::DISPLAY_STANDALONE,
                self::DISPLAY_BROWSER
            ]
        )) {
            throw new \InvalidArgumentException("Use one of AppConfiguration::DISPLAY_* constants.");
        }

        $this->display = $display;
        return $this;
    }

    /**
     * Returns an array of all application icons.
     *
     * @return  Image[]
     */
    public function getIcons()
    {
        return $this->icons;
    }

    /**
     * Adds an application icon.
     *
     * @param   Image               $icon
     *
     * @return  AppConfiguration
     *
     * @see https://www.w3.org/TR/appmanifest/#icons-member
     */
    public function addIcon(Image $icon)
    {
        $this->icons[] = $icon;
        return $this;
    }

    /**
     * Returns the application's language.
     *
     * @return  string|null
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Sets the application's language. Must be a RFC5646 compliant string.
     *
     * @param   string              $language
     *
     * @return  AppConfiguration
     *
     * @see https://www.w3.org/TR/appmanifest/#lang-member
     */
    public function setLanguage($language)
    {
        $this->language = $language;
        return $this;
    }

    /**
     * Returns the application's name.
     *
     * @return  string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the application's name.
     *
     * @param   string              $name
     *
     * @return  AppConfiguration
     *
     * @see https://www.w3.org/TR/appmanifest/#name-member
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Returns the default device orientation.
     *
     * @return  string|null
     */
    public function getOrientation()
    {
        return $this->orientation;
    }

    /**
     * Sets the default device orientation..
     *
     * @param   string              $orientation        One of AppConfiguration::ORIENTATION_* constants.
     *
     * @return  AppConfiguration
     *
     * @see https://www.w3.org/TR/appmanifest/#orientation-member
     */
    public function setOrientation($orientation)
    {
        if (!in_array(
            $orientation,
            [
                self::ORIENTATION_ANY,
                self::ORIENTATION_NATURAL,
                self::ORIENTATION_LANDSCAPE,
                self::ORIENTATION_LANDSCAPE_PRIMARY,
                self::ORIENTATION_LANDSCAPE_SECONDARY,
                self::ORIENTATION_PORTRAIT,
                self::ORIENTATION_PORTRAIT_PRIMARY,
                self::ORIENTATION_PORTRAIT_SECONDARY,
            ]
        )) {
            throw new \InvalidArgumentException("Use one of AppConfiguration::ORIENTATION_* constants.");
        }

        $this->orientation = $orientation;
        return $this;
    }

    /**
     * Returns the application's navigation scope.
     *
     * @return  string|null
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * Sets the application's navigation scope.
     *
     * <p>
     * This basically restricts what web pages can be viewed while the manifest is applied. If the user navigates the
     * application outside the scope, it returns to being a normal web page.
     *
     * @param   string              $scope
     *
     * @return  AppConfiguration
     *
     * @see https://www.w3.org/TR/appmanifest/#scope-member
     */
    public function setScope($scope)
    {
        $this->scope = $scope;
        return $this;
    }

    /**
     * Returns the application's short name.
     *
     * @return  string|null
     */
    public function getShortName()
    {
        return $this->shortName;
    }

    /**
     * Sets the application's short name.
     *
     * @param   string              $shortName
     *
     * @return  AppConfiguration
     *
     * @see https://www.w3.org/TR/appmanifest/#short_name-member
     */
    public function setShortName($shortName)
    {
        $this->shortName = $shortName;
        return $this;
    }

    /**
     * Returns the application's start URL.
     *
     * @return  string|null
     */
    public function getStartUrl()
    {
        return $this->startUrl;
    }

    /**
     * Sets the application's start URL.
     *
     * @param   string              $startUrl
     *
     * @return  AppConfiguration
     *
     * @see https://www.w3.org/TR/appmanifest/#start_url-member
     */
    public function setStartUrl($startUrl)
    {
        $this->startUrl = $startUrl;
        return $this;
    }

    /**
     * Returns the theme color.
     *
     * @return  string|null
     */
    public function getThemeColor()
    {
        return $this->themeColor;
    }

    /**
     * Sets the theme color. Will be used by Android's task switcher, for example.
     *
     * @param   string              $color
     *
     * @return  AppConfiguration
     *
     * @see https://www.w3.org/TR/appmanifest/#theme_color-member
     */
    public function setThemeColor($color)
    {
        $this->themeColor = $color;
        return $this;
    }

    /**
     * Creates an instance of the {@link AppConfiguration} class based on the values in the provided manifest file. Use
     * the {@link fromManifest} method to use a JSON string as source.
     *
     * @param   string              $path               Path to a file containing an application manifest compatible
     *                                                  with the Web App Manifest specification.
     *
     * @return  AppConfiguration
     *
     * @see https://www.w3.org/TR/appmanifest/
     */
    public static function fromManifestFile($path)
    {
        return self::fromManifest(file_get_contents($path));
    }

    /**
     * Creates an instance of the {@link AppConfiguration} class based on the values in the provided JSON string. Use
     * the {@link fromManifestFile} method to use a file as source.
     *
     * @param   string              $json               A JSON string that is compatible with the Web App Manifest
     *                                                  specification.
     *
     * @return  AppConfiguration
     *
     * @see https://www.w3.org/TR/appmanifest/
     */
    public static function fromManifest($json)
    {
        $app = new AppConfiguration();
        $data = json_decode($json, true);

        if (isset($data["background_color"])) {
            $app->setBackgroundColor($data["background_color"]);
        }

        if (isset($data["description"])) {
            $app->setDescription($data["description"]);
        }

        if (isset($data["dir"])) {
            $app->setDirection($data["dir"]);
        }

        if (isset($data["display"])) {
            $app->setDisplay($data["display"]);
        }

        if (isset($data["icons"])) {
            foreach ($data["icons"] as $icon) {
                $app->addIcon(self::imageFromData($icon));
            }
        }

        if (isset($data["lang"])) {
            $app->setLanguage($data["lang"]);
        }

        if (isset($data["name"])) {
            $app->setName($data["name"]);
        }

        if (isset($data["orientation"])) {
            $app->setOrientation($data["orientation"]);
        }

        if (isset($data["scope"])) {
            $app->setScope($data["scope"]);
        }

        if (isset($data["short_name"])) {
            $app->setShortName($data["short_name"]);
        }

        if (isset($data["start_url"])) {
            $app->setStartUrl($data["start_url"]);
        }

        if (isset($data["theme_color"])) {
            $app->setThemeColor($data["theme_color"]);
        }

        return $app;
    }

    private static function imageFromData(array $data)
    {
        $image = new Image();

        if (isset($data["src"])) {
            $image->setSrc($data["src"]);
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
