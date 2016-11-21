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
 * Generates meta/link tags.
 *
 * @package Fusonic\WebApp
 *
 * @see https://www.w3.org/TR/appmanifest/#using-a-link-element-to-link-to-a-manifest
 * @see https://developer.apple.com/library/content/documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html
 */
final class TagGenerator
{
    /**
     * Returns a string containing all meta/link tags.
     *
     * @param   AppConfiguration    $configuration      The configuration to create tags from.
     *
     * @param   bool                $standardTags       Generate standards-compliant tags?
     * @param   bool                $legacyTags         Generate tags for legacy browsers?
     * @param   bool                $appleTags          Generate proprietary tags for iOS devices?
     * @param   bool                $microsoftTags      Generate proprietary tags for Windows devices?
     *
     * @return  string
     */
    public function getTags(
        AppConfiguration $configuration,
        $standardTags = true,
        $legacyTags = true,
        $appleTags = true,
        $microsoftTags = true
    ) {
        return implode(
            "\n",
            array_map(
                function (array $tag) {
                    return $this->renderTag($tag);
                },
                $this->getData($configuration, $standardTags, $legacyTags, $appleTags, $microsoftTags)
            )
        );
    }

    private function renderTag(array $data)
    {
        $renderedHtml = "<{$data[0]}";

        foreach ($data as $key => $value) {
            if ($key === 0 || $key === 1) {
                continue;
            }

            if ($value === null) {
                continue;
            }

            $renderedHtml .= " {$key}=\"" . htmlspecialchars($value) . "\"";
        }

        if (isset($data[1])) {
            return $renderedHtml . htmlspecialchars($data[1]) . "</{$data[0]}>";
        } else {
            return $renderedHtml . ">";
        }
    }

    /**
     * Returns the data of all generated meta tags in an array in the form of
     *
     * <code>
     * [
     *     [
     *         "tag-name",
     *         "tag-content",
     *         "attribute-1-name" => "attribute-1-value",
     *         "attribute-2-name" => "attribute-2-value"
     *     ]
     * ]
     * </code>
     *
     * or
     *
     * <code>
     * [
     *     [
     *         "tag-name",
     *         "attribute-1-name" => "attribute-1-value",
     *         "attribute-2-name" => "attribute-2-value"
     *     ]
     * ]
     * </code>
     *
     * @param   AppConfiguration    $configuration
     * @param   bool                $standardTags
     * @param   bool                $legacyTags
     * @param   bool                $appleTags
     * @param   bool                $microsoftTags
     *
     * @return  array
     */
    private function getData(AppConfiguration $configuration, $standardTags, $legacyTags, $appleTags, $microsoftTags)
    {
        return array_merge(
            $standardTags ? $this->getStandardTags($configuration) : [ ],
            $legacyTags ? $this->getLegacyTags($configuration) : [ ],
            $appleTags ? $this->getAppleTags($configuration) : [ ],
            $microsoftTags ? $this->getMicrosoftTags($configuration) : [ ]
        );
    }

    private function getStandardTags(AppConfiguration $configuration)
    {
        $tags = [ ];

        // Manifest
        // https://www.w3.org/TR/appmanifest/#using-a-link-element-to-link-to-a-manifest
        $tags[] = [
            "link",
            "rel" => "manifest",
            "href" => $configuration->getManifestUrl(),
        ];

        return $tags;
    }

    private function getLegacyTags(AppConfiguration $configuration)
    {
        $tags = [ ];

        // Application name
        // https://html.spec.whatwg.org/multipage/semantics.html#meta-application-name
        if (($shortName = $configuration->getShortName()) !== null) {
            $tags[] = [
                "meta",
                "name" => "application-name",
                "content" => $shortName,
            ];
        }

        // Theme color
        // https://html.spec.whatwg.org/multipage/semantics.html#meta-theme-color
        if (($themeColor = $configuration->getThemeColor()) !== null) {
            $tags[] = [
                "meta",
                "name" => "theme-color",
                "content" => $themeColor,
            ];
        }

        // Icons
        // https://html.spec.whatwg.org/multipage/semantics.html#rel-icon
        foreach ($configuration->getIcons() as $icon) {
            if (in_array($icon->getPlatform(), [ null, Image::PLATFORM_WEB ])) {
                $sizes = array_map(
                    function (array $size) {
                        return "{$size[0]}x{$size[1]}";
                    },
                    $icon->getSizes()
                );

                $tags[] = [
                    "link",
                    "rel" => "icon",
                    "href" => $icon->getSrc(),
                    "sizes" => count($sizes) > 0 ? implode(" ", $sizes) : null,
                ];
            }
        }

        return $tags;
    }

    private function getAppleTags(AppConfiguration $configuration)
    {
        $tags = [ ];

        // format-detection
        // https://developer.apple.com/library/content/documentation/AppleApplications/Reference/SafariHTMLRef/Articles/MetaTags.html#//apple_ref/doc/uid/TP40008193-SW5
        $tags[] = [
            "meta",
            "name" => "format-detection",
            "content" => "telephone=no",
        ];

        // Application name
        if (($shortName = $configuration->getShortName()) !== null) {
            $tags[] = [
                "meta",
                "name" => "apple-mobile-web-app-title",
                "content" => $shortName,
            ];
        }

        // Icons
        // https://developer.apple.com/library/content/documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html#//apple_ref/doc/uid/TP40002051-CH3-SW4
        foreach ($configuration->getIcons() as $icon) {
            if (in_array($icon->getPlatform(), [ null, Image::PLATFORM_IOS ])) {
                $sizes = array_map(
                    function (array $size) {
                        return "{$size[0]}x{$size[1]}";
                    },
                    $icon->getSizes()
                );

                $tags[] = [
                    "link",
                    "rel" => "apple-touch-icon",
                    "href" => $icon->getSrc(),
                    "sizes" => count($sizes) > 0 ? implode(" ", $sizes) : null,
                ];
            }
        }

        // apple-mobile-web-app-capable
        // apple-mobile-web-app-status-bar-style
        // https://developer.apple.com/library/content/documentation/AppleApplications/Reference/SafariHTMLRef/Articles/MetaTags.html
        if ($configuration->getDisplay() == AppConfiguration::DISPLAY_FULLSCREEN ||
            $configuration->getDisplay() == AppConfiguration::DISPLAY_STANDALONE
        ) {
            $tags[] = [
                "meta",
                "name" => "apple-mobile-web-app-capable",
                "content" => "yes",
            ];

            $tags[] = [
                "meta",
                "name" => "apple-mobile-web-app-status-bar-style",
                "content" => $configuration->getDisplay() == AppConfiguration::DISPLAY_FULLSCREEN ? "black-translucent" : "default",
            ];
        }

        return $tags;
    }

    private function getMicrosoftTags(AppConfiguration $configuration)
    {
        $tags = [ ];

        // Start URL
        // https://msdn.microsoft.com/en-us/library/gg491732(v=vs.85).aspx#msapplication-starturl
        if (($startUrl = $configuration->getStartUrl()) !== null) {
            $tags[] = [
                "meta",
                "name" => "msapplication-starturl",
                "content" => $startUrl,
            ];
        }

        // Theme color
        // https://msdn.microsoft.com/en-us/library/gg491732(v=vs.85).aspx#msapplication-navbutton-color
        if (($themeColor = $configuration->getThemeColor()) !== null) {
            $tags[] = [
                "meta",
                "name" => "msapplication-navbutton-color",
                "content" => $themeColor,
            ];
        }

        return $tags;
    }
}
