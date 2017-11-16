<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'fnbcircledev');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'Ajency#123');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'ubGf{__3C0Yb@|]Yi%DDq+3DV=8%#{v/F5ccUDa3>&M0G68(%he]?<miJ}yCQtd4');
define('SECURE_AUTH_KEY',  ' CU|+c1Zd{Daenlof9}21~RS(i?:z?j51z)Bul1UY75SVbVhK_8o9-}N`Ya[Rl}x');
define('LOGGED_IN_KEY',    'pJf|{O/p }=>4I-u_XLcsUtR8yo2-aw~i.;/PG-LX1!RtEw6+ mVa?-y0Kf+&}B.');
define('NONCE_KEY',        '?v!vU7j~Tx}va+r=#Apd>4lY[%9V(FHfK57B]1P/3I9MSAWj46;Ut[t)~*EB#3HA');
define('AUTH_SALT',        'S0TRJTFhkI:.;sD_#$krNd%%R!p78gbhA3JIfeb.e[U8&w=fvHX[@P;Q@|s;M9vq');
define('SECURE_AUTH_SALT', '8(@7}AmuTIIzs.`X[:]1.Z#P&<sj#U_^f6T%z{4(te!E)x#z*Lu+&9?7bdmQwb&B');
define('LOGGED_IN_SALT',   '0MER9-e8]ua9?^Pr&;vc,j[wl`!BcF=ij0MkIZfE-;4rX2N{>xJ^V6Nj:a7 oXMV');
define('NONCE_SALT',       'k51zf|7`pAcb<M^f6SE%g*`FI55at~lsfm3>FZGLU{3/viO.[[xUGeoauA P=S8_');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
