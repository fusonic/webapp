<?php

namespace Fusonic\WebApp;

use Fusonic\Linq\Linq;

/**
 * Generates various meta/link tags.
 *
 * @package Fusonic\WebApp
 */
class TagGenerator
{
    private $generateTitleTag = false;
    private $generateAppleSpecificTags = true;
    private $generateMicrosoftSpecificTags = true;
    private $generateStandardTags = true;

    /**
     * Returns the data of all generated meta tags. Array in the form of
     * [
     *     [
     *         "tag-name",
     *         "tag-content",
     *         "attribute-1-name" => "attribute-1-value",
     *         "attribute-2-name" => "attribute-2-value"
     *     ]
     * ]
     *
     * @param AppConfiguration $configuration The configuration to create tags from.
     * @return array
     */
    public function getData(AppConfiguration $configuration)
    {
        return array_merge(
            $this->generateStandardTags ? $this->getStandardTags($configuration) : [],
            $this->generateAppleSpecificTags ? $this->getAppleTags($configuration) : [],
            $this->generateMicrosoftSpecificTags ? $this->getMicrosoftTags($configuration) : []
        );
    }

    /**
     * Returns a string containing all meta/link tags.
     *
     * @param AppConfiguration $configuration The configuration to create tags from.
     * @return string
     */
    public function getTags(AppConfiguration $configuration)
    {
        $data = $this->getData($configuration);

        $tags = '';
        foreach ($data as $tag) {
            $renderedTag = '<' . $tag[0];
            foreach ($tag as $key => $value) {
                if ($key === 0 || $key === 1) {
                    continue;
                }
                $renderedTag .= ' ' . $key . '="' . addslashes($value) . '"';
            }
            $renderedTag .= '>';

            if (isset($tag[1])) {
                $renderedTag .= htmlspecialchars($tag[1]) . '</' . $tag[0] . '>';
            }

            $tags .= $renderedTag . "\n";
        }
        return $tags;
    }

    /**
     * https://developer.apple.com/library/ios/documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html
     *
     * @param AppConfiguration $configuration
     * @return array
     */
    private function getAppleTags(AppConfiguration $configuration)
    {
        $tags = [
            // <meta name="apple-mobile-web-app-capable" content="yes">
            // https://developer.apple.com/library/safari/documentation/AppleApplications/Reference/SafariHTMLRef/Articles/MetaTags.html
            [
                "meta",
                "name" => "apple-mobile-web-app-capable",
                "content" => "yes",
            ],
            // <meta name="format-detection" content="telephone=no">
            // https://developer.apple.com/library/safari/documentation/AppleApplications/Reference/SafariHTMLRef/Articles/MetaTags.html
            [
                "meta",
                "name" => "format-detection",
                "content" => "telephone=no",
            ]
        ];

        // Icons
        // <link rel="apple-touch-icon" sizes="..." href="...">
        foreach ($configuration->getIcons() as $icon) {
            $tags[] = [
                "link",
                "rel" => "apple-touch-icon",
                "sizes" => implode(" ", $icon->getSizes()),
                "href" => $icon->getSrc(),
            ];
        }

        // Theme color
        // https://developer.apple.com/library/safari/documentation/AppleApplications/Reference/SafariHTMLRef/Articles/MetaTags.html
        if (($themeColor = $configuration->getThemeColor()) !== null) {
            $tags[] = [
                "meta",
                "name" => "apple-mobile-web-app-status-bar-style",
                "content" => $themeColor,
            ];
        }

        // Startup image must be 320x480 and in portrait mode
        $splashScreen = Linq::from($configuration->getSplashScreens())
            ->firstOrNull(
                function (Image $img) {
                    return Linq::from($img->getSizes())
                        ->any(
                            function ($size) {
                                return $size == "320x480";
                            }
                        );
                }
            );
        if ($splashScreen !== null) {
            $tags[] = [
                "link",
                "rel" => "apple-touch-startup-image",
                "href" => $splashScreen->getSrc(),
            ];
        }

        return $tags;
    }

    /**
     * https://developers.google.com/web/fundamentals/device-access/stickyness/additional-customizations?hl=en
     *
     * @param AppConfiguration $configuration
     * @return array
     */
    private function getMicrosoftTags(AppConfiguration $configuration)
    {
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

        return [];
    }

    private function getStandardTags(AppConfiguration $configuration)
    {
        $tags = [];

        // Title
        // http://www.w3.org/TR/html5/document-metadata.html#the-title-element
        if ($this->generateTitleTag) {
            if (($title = $configuration->getName()) !== null) {
                $tags[] = [
                    "title",
                    $title,
                ];
            }
        }

        // Application name
        // http://www.w3.org/TR/html5/document-metadata.html#meta-application-name
        if (($name = $configuration->getName()) !== null) {
            $tags[] = [
                "meta",
                "name" => "application-name",
                "content" => $name,
            ];
        }

        // Theme color
        // https://github.com/whatwg/meta-theme-color
        if (($themeColor = $configuration->getThemeColor()) !== null) {
            $tags[] = [
                "meta",
                "name" => "theme-color",
                "content" => $themeColor,
            ];
        }

        // Manifest
        // http://www.w3.org/TR/appmanifest/#using-a-link-element-to-link-to-a-manifest
        if (($manifestUrl = $configuration->getManifestUrl()) !== null) {
            $tags[] = [
                "link",
                "rel" => "manifest",
                "href" => $manifestUrl,
            ];
        }

        // Icons
        // http://www.w3.org/TR/html5/links.html#rel-icon
        foreach ($configuration->getIcons() as $icon) {
            $tags[] = [
                "link",
                "rel" => "icon",
                "sizes" => implode(" ", $icon->getSizes()),
                "href" => $icon->getSrc(),
            ];
        }

        return [];
    }
}