<?php

namespace Fusonic\WebApp;

use Fusonic\Linq\Linq;

/**
 * Generates various meta/link tags.
 *
 * @package Fusonic\WebApp
 */
class MetaTagGenerator
{
    private $generateTitleTag = false;

    public function getData(AppConfiguration $configuration)
    {
        return array_merge(
            $this->getAppleTags($configuration),
            $this->getMicrosoftTags($configuration),
            $this->getGoogleTags($configuration)
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
            $renderedTag = '<' . $tag["tag"];
            foreach ($tag as $key => $value) {
                if ($key == 'tag' || $key == 'text') {
                    continue;
                }
                $renderedTag .= ' ' . $key . '="' . addslashes($value) . '"';
            }
            $renderedTag .= '>';

            if (isset($tag["text"])) {
                $renderedTag .= htmlspecialchars($tag["text"]) . '</' . $tag["tag"] . '>';
            }

            $tags .= $renderedTag . "\n";
        }
        return $tags;
    }

    /**
     * https://developer.apple.com/library/safari/documentation/AppleApplications/Reference/SafariHTMLRef/Articles/MetaTags.html
     * https://developer.apple.com/library/ios/documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html
     *
     * @param AppConfiguration $configuration
     * @return array
     */
    private function getAppleTags(AppConfiguration $configuration)
    {
        $tags = [
            [
                "tag" => "meta",
                "name" => "apple-mobile-web-app-capable",
                "content" => "yes",
            ]
        ];

        foreach ($configuration->getIcons() as $icon) {
            $tags[] = [
                "tag" => "link",
                "rel" => "apple-touch-icon",
                "sizes" => implode(" ", $icon->getSizes()),
                "href" => $icon->getSrc(),
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
                "tag" => "link",
                "rel" => "apple-touch-startup-image",
                "href" => $splashScreen->getSrc(),
            ];
        }

        // TODO
        // - meta: apple-mobile-web-app-status-bar-style
        // - meta: format-detection

        return $tags;
    }

    private function getMicrosoftTags(AppConfiguration $configuration)
    {
        return [];
    }

    private function getGoogleTags(AppConfiguration $configuration)
    {
        return [];
    }

    private function getStandardTags(AppConfiguration $configuration)
    {
        // TODO
        // - meta: viewport
        $tags = [];

        if ($this->generateTitleTag) {
            if (($title = $configuration->getName()) !== null) {
                return [
                    "tag" => "title",
                    "text" => $title,
                ];
            }
        }

        return [];
    }
}