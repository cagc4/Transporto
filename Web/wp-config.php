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
define('DB_NAME', 'transporto');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         '.7s(R3kh*WP/w[3|SsI-/a;!u.^tm/WZ8brX8&b~KRebR$gaR)MehV;1KZ`+{R[.');
define('SECURE_AUTH_KEY',  'UFaM{q.#t4gK J8!-j[*QLKS4N7>^:8lp.-doX-iNer6+Jkf%rF[Rf)c3Oc>}+^$');
define('LOGGED_IN_KEY',    '!`GM-4wMm9nZ }g;e)3uu>8i]x=]X)$G-eJ/>#cVGVrIA_1j*V)/0%cnFO+zziI0');
define('NONCE_KEY',        '-AG(r_u5VLg&0*x(k=j<8=?zTIczqM|!4OfTEY1P*|`Hm+HYfaJq-M~?Adu-M*v<');
define('AUTH_SALT',        '%Fhoy/3DXx51|wBmh@pxFmh17UuLpRd=*:dk7nZmys6<XM+/K^tR%|6CMxF(<2YV');
define('SECURE_AUTH_SALT', 'l2Ho:_eML;<*$|k[a[U|X,~@?#_=2ta44#{# X2rh#+|wI^~phG/w^3@yt|Rj2G(');
define('LOGGED_IN_SALT',   'n.M?EO2`/3X:vOmol,-Zim]$}6|[%{|pnn~h9yszaD&Q*t)?iMEo@;^mDVS]D41W');
define('NONCE_SALT',       ')Rb-Z/td;5*S,aoX`},,bJ?Wj/,#usj> jSy`HC_3HGT_-Wr;*8lPh,,QKZf:X1P');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'cc_wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
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

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
