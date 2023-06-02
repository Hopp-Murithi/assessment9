<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'e-commerce' );

/** Database username */
define( 'DB_USER', 'admin10' );

/** Database password */
define( 'DB_PASSWORD', 'admin' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'm@[~XV,yBC3YU)Ah)wFzhf<*{/k~z+88%4GS1gV5*X2y^4<qoxk:dShq/eP~5I7.' );
define( 'SECURE_AUTH_KEY',  'unu`AB8hPD+I4lk{eC!i/*9&mw0dYnYT#DvHFj{zjCm{JKe:xuD8XBM:[Asa}_8;' );
define( 'LOGGED_IN_KEY',    'U;TWKS8aL6^p=OZ0*o8[([6fUE,#KR;p:juSGW}/}}e]Y5N5z7Qb+`y3+l;!rH}Z' );
define( 'NONCE_KEY',        'em6RwL4-@ B+>IKNE,q9+^GFP!Ehw`1?l%]ei<nOsPUd1$#7{YB .Cpthaxpix4X' );
define( 'AUTH_SALT',        'FpP[#d2NQSwQ+ix_F#TdIcB/}xsH1GB.PdSBrhGGQ1)&8 }$RI(c]bTs0x>7_$5E' );
define( 'SECURE_AUTH_SALT', ':oo^u!Ak)4bd}:GG]Bi;5(sI^*R}fj(]Nq&4E#3pG%)<=.K{rIJKf`zaU_X)o?^q' );
define( 'LOGGED_IN_SALT',   '8X/=-_F`vT*s<SQc5Qk1UB]MmVh~<5^m[xK*Y>/|W)<J%/AXnTl,P8v+DbU?7r/m' );
define( 'NONCE_SALT',       'aBv5cl0TE){4pfK^AeNQ^wq[AOQ#qy(>q!xXd]HUYky$F/NO>OR#UT^|X2.40Z5+' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
