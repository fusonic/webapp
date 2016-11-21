<?php

/*
 * This file is part of the fusonic/webapp package.
 *
 * (c) Fusonic GmbH <office@fusonic.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fusonic\WebApp\Generators;

use Fusonic\WebApp\AppConfiguration;
use Fusonic\WebApp\Objects\Image;

/**
 * Generates an app manifest according to the W3C specification "Web App Manifest".
 *
 * @package Fusonic\WebApp
 *
 * @see https://www.w3.org/TR/appmanifest/
 */
final class ManifestGenerator
{
    /**
     * Returns the manifest data as an array.
     *
     * @param   AppConfiguration    $configuration      The configuration to create the manifest from.
     *
     * @return  array
     */
    public function get(AppConfiguration $configuration)
    {
        $manifest = [ ];

        if (($backgroundColor = $configuration->getBackgroundColor()) !== null) {
            $manifest["background_color"] = $backgroundColor;
        }

        if (($description = $configuration->getDescription()) !== null) {
            $manifest["description"] = $description;
        }

        if (($direction = $configuration->getDirection()) !== null) {
            $manifest["dir"] = $direction;
        }

        if (($display = $configuration->getDisplay()) !== null) {
            $manifest["display"] = $display;
        }

        if (count($icons = $configuration->getIcons()) > 0) {
            $manifest["icons"] = [ ];

            foreach ($icons as $icon) {
                $manifest["icons"][] = $this->getImageData($icon);
            }
        }

        if (($language = $configuration->getLanguage()) !== null) {
            $manifest["lang"] = $language;
        }

        if (($name = $configuration->getName()) !== null) {
            $manifest["name"] = $name;
        }

        if (($orientation = $configuration->getOrientation()) !== null) {
            $manifest["orientation"] = $orientation;
        }

        if (($scope = $configuration->getScope()) !== null) {
            $manifest["scope"] = $scope;
        }

        if (($shortName = $configuration->getShortName()) !== null) {
            $manifest["short_name"] = $shortName;
        }

        if (($startUrl = $configuration->getStartUrl()) !== null) {
            $manifest["start_url"] = $startUrl;
        }

        if (($themeColor = $configuration->getThemeColor()) !== null) {
            $manifest["theme_color"] = $themeColor;
        }

        return $manifest;
    }

    private function getImageData(Image $image)
    {
        $data = [
            "src" => $image->getSrc(),
        ];

        if (($platform = $image->getPlatform()) !== null) {
            $data["platform"] = $platform;
        }

        if (count($purpose = $image->getPurpose()) > 0) {
            $data["purpose"] = implode(" ", $purpose);
        }

        if (($type = $image->getType()) !== null) {
            $data["type"] = $type;
        }

        if (count($sizes = $image->getSizes()) > 0) {
            $data["sizes"] = implode(
                " ",
                array_map(
                    function (array $size) {
                        return "{$size[0]}x{$size[1]}";
                    },
                    $sizes
                )
            );
        }

        return $data;
    }

}
