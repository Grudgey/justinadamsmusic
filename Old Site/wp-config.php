<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'cl44-a-wordp-c3z');

/** MySQL database username */
define('DB_USER', 'cl44-a-wordp-c3z');

/** MySQL database password */
define('DB_PASSWORD', 'sxw9NeBy!');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'iR8F23jn=ZEPv!)/XBAtyBWTBY)ypmQF3F^DEv2t81BHiy7Z_pR_dimqtyrodf1E');
define('SECURE_AUTH_KEY',  'V=kYOCmj-w8WN=uzqj062#QGU6m!7gQJjRsTW9pq(eHk0)uCw+5ebOX/WNC9A5mr');
define('LOGGED_IN_KEY',    '=tgZKnxl-1VlpF9PN8blDp0cvS/IX3kDovC5vcmDlG)(1RSwmOzt9lbus9gv!_HW');
define('NONCE_KEY',        'iSku!A2bW5Jx1DFh=EuExJvwPsv6)xY6(gorMmZLrUci+p7EnAbXykLxplnM1zqI');
define('AUTH_SALT',        'R7740pm2N3W^_CYS3J^^4oFfLMOSP9bs/6FpXa2dwkeBOEYm2cjwP)UIPu6XLQwA');
define('SECURE_AUTH_SALT', 'HKoL5^lqYe0hui=eaN(/W)DhBKdwlq#Yb0-J6J_/3-H25IxJr1Xc!d8Ll1tZPehJ');
define('LOGGED_IN_SALT',   'fF2x_o#eq_folHoWty7EgFdNmBB+Fj9pQ=f-1-m7hDkurG0bPXP=lvMo94oPBf_u');
define('NONCE_SALT',       '!bDF3/9W54da#XHCaFwPw^KYIZxJKAM#9mERos23fSi1jE3Zc6g(vgPebQ/Inx/N');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de.mo to wp-content/languages and set WPLANG to 'de' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/**
 *  Change this to true to run multiple blogs on this installation.
 *  Then login as admin and go to Tools -> Network
 */
define('WP_ALLOW_MULTISITE', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

/* Destination directory for file streaming */
define('WP_TEMP_DIR', ABSPATH . 'wp-content/');

