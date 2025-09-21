<?php

namespace App\Support;

class Sanitizer
{
    /**
     * Sanitize limited rich HTML content.
     * - Allows a conservative set of tags
     * - Removes event handler attributes and javascript: URIs
     */
    public static function clean(?string $html): string
    {
        if ($html === null) {
            return '';
        }

        // 1) Strip all tags except a conservative allowlist
        $allowedTags = '<p><br><ul><ol><li><strong><em><b><i><u><blockquote><pre><code><h1><h2><h3><h4><a>';
        $stripped = strip_tags($html, $allowedTags);

        // 2) Remove event handlers (on*) and style attributes to avoid CSS-based tricks
        $noEvents = preg_replace('/\s*on[a-zA-Z]+\s*=\s*"[^"]*"/i', '', $stripped);
        $noEvents = preg_replace("/\s*on[a-zA-Z]+\s*='[^']*'/i", '', $noEvents);
        $noStyle  = preg_replace('/\s*style\s*=\s*"[^"]*"/i', '', $noEvents);
        $noStyle  = preg_replace("/\s*style\s*='[^']*'/i", '', $noStyle);

        // 3) Neutralize javascript: and data: URLs in href/src
        $noJsHref = preg_replace('/(href|src)\s*=\s*"\s*javascript:[^"]*"/i', '$1="#"', $noStyle);
        $noJsHref = preg_replace("/(href|src)\s*=\s*'\s*javascript:[^']*'/i", '$1="#"', $noJsHref);
        $noData   = preg_replace('/(href|src)\s*=\s*"\s*data:[^"]*"/i', '$1="#"', $noJsHref);
        $noData   = preg_replace("/(href|src)\s*=\s*'\s*data:[^']*'/i", '$1="#"', $noData);

        return $noData ?? '';
    }
}

