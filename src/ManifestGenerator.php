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

/**
 * Generates an app manifest according to the W3C specification "Manifest for a web application"
 * See http://www.w3.org/TR/appmanifest/
 *
 * @package Fusonic\WebApp
 */
class ManifestGenerator
{
    public function __construct()
    { }

    /**
     * Returns the manifest data as array.
     *
     * @param AppConfiguration $configuration The configuration to create the manifest from.
     * @return array
     */
    public function get(AppConfiguration $configuration)
    {
        $manifest = [];

        if (($language = $configuration->getLanguage()) !== null) {
            $manifest["lang"] = $language;
        }

        if (($name = $configuration->getName()) !== null) {
            $manifest["name"] = $name;
        }

        if (($shortName = $configuration->getShortName()) !== null) {
            $manifest["short_name"] = $shortName;
        }

        if (($scope = $configuration->getScope()) !== null) {
            $manifest["scope"] = $scope;
        }

        if (($startUrl = $configuration->getStartUrl()) !== null) {
            $manifest["start_url"] = $startUrl;
        }

        if (($display = $configuration->getDisplay()) !== null) {
            $manifest["display"] = $display;
        }

        if (($orientation = $configuration->getOrientation()) !== null) {
            $manifest["orientation"] = $orientation;
        }

        $icons = $configuration->getIcons();
        if (count($icons) > 0) {
            $manifest["icons"] = [];

            foreach ($icons as $icon) {
                $manifest["icons"][] = $this->getImageData($icon);
            }
        }

        $splashScreens = $configuration->getIcons();
        if (count($splashScreens) > 0) {
            $manifest["splash_screens"] = [];

            foreach ($splashScreens as $splashScreen) {
                $manifest["splash_screens"][] = $this->getImageData($splashScreen);
            }
        }

        return $manifest;
    }

    private function getImageData(Image $image)
    {
        $data = [
            "src" => $image->getSrc(),
        ];

        if (($type = $image->getType()) !== null) {
            $data["type"] = $type;
        }

        if (($density = $image->getDensity()) !== null) {
            $data["density"] = $density;
        }

        if (($backgroundColor = $image->getBackgroundColor()) !== null) {
            $data["background_color"] = $backgroundColor;
        }

        $sizes = [];
        foreach ($image->getSizes() as $size) {
            $sizes[] = $size[0] . "x" . $size[1];
        }
        if (count($sizes) > 0) {
            $data["sizes"] = implode(" ", $sizes);
        }

        return $data;
    }

}
