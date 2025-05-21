# Media from Remote
This must-use plugin for WordPress enables the site to load media files from a remote URL, bypassing the need for syncing local media files (e.g. using rsync) in development or staging environments.

It automatically adjusts media URLs if the file is not found locally by replacing the local development domain with the production domain. This ensures images and other media assets are always accessible—even if they haven't been copied to the local server.

> 💡 This is especially useful in development environments like [Lando](https://lando.dev/) (`project.lndo.site`) where you don’t want to keep syncing media libraries.

---

## Features

- Overrides `wp_get_attachment_url()` to fallback to a remote domain.
- Updates `srcset` values from `wp_calculate_image_srcset()` to match the fallback URL.
- Eliminates the need to copy media locally during development or staging.

---

## Usage

Add this file to the `wp-content/mu-plugins/` directory of your WordPress installation.