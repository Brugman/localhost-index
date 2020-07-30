<?php

/**
 * Projects path.
 * Where is the projects folder?
 */

define( 'APP_PROJECTS_PATH', dirname( __FILE__, 3 ).'/' );

/**
 * Wildcard DNS TLD.
 * What TLD should be used in the URLs?
 * Example: http://project.dev.10.10.10.11.[TLD]
 * Options: .xip.io, .nip.io
 */

define( 'APP_WILDCARD_DNS_TLD', '.nip.io' );

/**
 * Extensions.
 * Every extension should be mapped to a specific web root.
 * Example: http://project.[Extension].10.10.10.11.nip.io
 */

define( 'APP_EXT', '.dev' );
define( 'APP_EXT_WP', '.dev' );
define( 'APP_EXT_LARAVEL', '.lar' );

/**
 * IP override.
 * When you have multiple network adapters we may grab the wrong IP.
 * Use this setting to manually set your IP.
 * Example: http://project.dev.[IP].nip.io
 * Options: 192.168.x.x, 10.10.x.x
 */

define( 'APP_IP_OVERRIDE', '192.168.5.220' );

