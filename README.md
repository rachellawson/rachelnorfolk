This repo builds Drupal 10 based blog website for rachelnorfolk.me. It uses the "Drupal Core" Composer project.

Drupal is a flexible and extensible PHP-based CMS framework. Read more about it at www.drupal.org

## Platform.sh

This repo is based on a template that builds Drupal 10 using the "Drupal Core" Composer project. It is pre-configured to use MariaDB and Redis for caching. The Drupal installer will skip asking for database credentials as they are already provided by Platform.sh

## Implementation Notes

* The `.platform.app.yaml`, `.platform/services.yaml`, and `.platform/routes.yaml` files have been added.  These provide Platform.sh-specific configuration and are present in all projects on Platform.sh.  You may customize them as you see fit.
* An additional Composer library, [`platformsh/config-reader`](https://github.com/platformsh/config-reader-php), has been added.  It provides convenience wrappers for accessing the Platform.sh environment variables.
* Drush and Drupal Console have been pre-included in `composer.json`.  You are free to remove one or both if you do not wish to use them.  (Note that the default cron and deploy hooks make use of Drush commands, however.)
* The build hook uses the included [`install-redis.sh`](install-redis.sh) script to custom compile the Redis extension at a specified version and enable it through a `php.ini` file.
* The Drupal Redis module comes pre-installed.  The placeholder module is not pre-installed, but it is enabled via `settings.platformsh.php` out of the box.
* The `settings.platformsh.php` file contains Platform.sh-specific code to map environment variables into Drupal configuration. You can add to it as needed. See the documentation for more examples of common snippets to include here.  It uses the Config Reader library.
* The `settings.php` file has been heavily customized to only define those values needed for both Platform.sh and local development.  It calls out to `settings.platformsh.php` if available.  You can add additional values as documented in `default.settings.php` as desired.  It is also setup such that when you install Drupal on Platform.sh the installer will not ask for database credentials as they will already be defined.
* The `/.devcontainer` folder will allow us to use this project in GitHub codespaces. It's not perfect but, in conjunction with DDEV, it's good enough for me!
* The `/.ddev` folder defines how we will use ddev within the codespaces environment. Basically, once the container is up and running, the environment is created with a `ddev start`. From then, it's just like using any other DDEV setup, just remotely. Even on my iPad...

## References

* [Drupal](https://www.drupal.org/)
* [Drupal on Platform.sh](https://docs.platform.sh/frameworks/drupal8.html)
* [PHP on Platform.sh](https://docs.platform.sh/languages/php.html)
