<?php

$remoteProtocol = 'https';
$remoteDomain   = 'domain.ext'; // full domain including www if applicable. E.g., www.domain.ext (no protocol)

add_filter('wp_get_attachment_url', function ($url) use ($remoteProtocol, $remoteDomain) {
    return maybe_use_remote_url($url, $remoteProtocol, $remoteDomain);
});

add_filter('wp_calculate_image_srcset', function ($sources) use ($remoteProtocol, $remoteDomain) {
    foreach ($sources as &$source) {
        $source['url'] = maybe_use_remote_url($source['url'], $remoteProtocol, $remoteDomain);
    }

    return $sources;
});

/**
 * Replace local domain with remote if file is missing and not already remote.
 *
 * @param string $url
 * @param string $protocol
 * @param string $remoteDomain
 * @return string
 */
function maybe_use_remote_url(string $url, string $protocol, string $remoteDomain): string
{
    if (str_contains($url, $remoteDomain)) {
        return $url; // Already remote.
    }

    $parsedUrl = parse_url($url);

    if (empty($parsedUrl['path'])) {
        return $url; // Unexpected URL structure.
    }

    $localPath = ABSPATH . ltrim($parsedUrl['path'], '/');

    if (file_exists($localPath)) {
        return $url; // File exists locally.
    }

    $remoteUrl = sprintf('%s://%s%s', $protocol, $remoteDomain, $parsedUrl['path']);

    return $remoteUrl;
}
