<?php

declare(strict_types=1);

/*
 * This file is part of TYPO3 CMS-based extension "de_slash" by b13.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace B13\DeSlash\Service;

class UriCleaner
{
    /**
     * Remove trailing slash from the path segment of a URL, preserving query parameters and fragments.
     * Returns the modified URL, or the original if no trailing slash in path.
     */
    public function removeTrailingSlashFromPath(string $url): string
    {
        if ($url === '') {
            return $url;
        }

        $parts = parse_url($url);
        if (empty($parts['path']) || trim($parts['path'], '/') === '' || !str_ends_with($parts['path'], '/')) {
            return $url;
        }

        $newPath = rtrim($parts['path'], '/');
        $newUrl = isset($parts['scheme']) ? $parts['scheme'] . '://' : (str_starts_with($url, '//') ? '//' : '');
        if (isset($parts['user'])) {
            $newUrl .= $parts['user'];
            if (isset($parts['pass'])) {
                $newUrl .= ':' . $parts['pass'];
            }
            $newUrl .= '@';
        }
        $newUrl .= $parts['host'] ?? '';
        if (isset($parts['port'])) {
            $newUrl .= ':' . $parts['port'];
        }
        $newUrl .= $newPath;
        if (isset($parts['query'])) {
            $newUrl .= '?' . $parts['query'];
        }
        if (isset($parts['fragment'])) {
            $newUrl .= '#' . $parts['fragment'];
        }

        return $newUrl;
    }
}
