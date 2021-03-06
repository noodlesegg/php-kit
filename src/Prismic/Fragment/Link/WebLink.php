<?php
/**
 * This file is part of the Prismic PHP SDK
 *
 * Copyright 2013 Zengularity (http://www.zengularity.com).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Prismic\Fragment\Link;

/**
 * This class embodies a web link; it is what is retrieved from the API when
 * a link is created towards a media file.
 * LinkInterface objects can be found in two occasions: as the "$link" variable of a HyperlinkSpan object
 * (which happens when the link is a hyperlink in a StructuredText fragment), or the LinkInterface
 * can also be its own fragment (e.g. for a "related" fragment, that links to a related document).
 */
class WebLink implements LinkInterface
{
    /**
     * @var string the URL of the resource we're linking to online
     */
    private $url;
    /**
     * @var string the target, if known
     */
    private $target;
    /**
     * @var string the content type, if known
     */
    private $maybeContentType;

    /**
     * Constructs a media link.
     *
     * @param string $url              the URL of the resource we're linking to online
     * @param string $target           the target, if known
     * @param string $maybeContentType the content type, if known
     */
    public function __construct($url, $target = null, $maybeContentType = null)
    {
        $this->url = $url;
        $this->target = $target;
        $this->maybeContentType = $maybeContentType;
    }

    /**
     * Builds an HTML version of the raw link, pointing to the right URL,
     * and with the resource's URL as the hypertext.
     *
     * 
     *
     * @param \Prismic\LinkResolver $linkResolver the link resolver
     *
     * @return string the HTML version of the link
     */
    public function asHtml($linkResolver = null)
    {
        $target = $this->target ? ' target="' . $this->target . '" rel="noopener"' : '';
        return '<a href="' . $this->url . '"' . $target . '>' . $this->url . '</a>';
    }

    /**
     * Builds an unformatted text version of the raw link: simply, the URL.
     *
     * 
     *
     * @return string an unformatted text version of the raw link
     */
    public function asText()
    {
        return $this->getUrl();
    }

    /**
     * Returns the URL of the resource we're linking to online
     *
     * 
     *
     * @param \Prismic\LinkResolver $linkResolver the link resolver (read prismic.io's API documentation to learn more)
     *
     * @return string the URL of the resource we're linking to online
     */
    public function getUrl($linkResolver = null)
    {
        return $this->url;
    }

    /**
     * Returns the target, if known
     *
     * 
     *
     * @return string the target, if known
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Returns the content type, if known
     *
     * 
     *
     * @return string the content type, if known
     */
    public function getContentType()
    {
        return $this->maybeContentType;
    }

    /**
     * Parses a proper bit of unmarshalled JSON into a WebLink object.
     * This is used internally during the unmarshalling of API calls.
     *
     * @param \stdClass $json the raw JSON that needs to be transformed into native objects.
     *
     * @return WebLink the new object that was created form the JSON.
     */
    public static function parse($json)
    {
        $target = property_exists($json, "target") ? $json->target : null;
        return new WebLink($json->url, $target);
    }
}
