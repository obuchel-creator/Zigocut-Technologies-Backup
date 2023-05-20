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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'zigocut' );

/** Database username */
define( 'DB_USER', 'zigocut' );

/** Database password */
define( 'DB_PASSWORD', 'zigocut@1' );

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
define( 'AUTH_KEY',         ';O/k.>ozOVAe6OOO~4ToSg_Dnwj*t<%}+off~MwP(mnVS~B2eg__A92X@Lp_-`jo' );
define( 'SECURE_AUTH_KEY',  'd?(T0P?gG&*;K5Fyg6ID12DNjW`T]U9D9]~rWp2K|/|!7@w_f5xqCSThqg$)em;n' );
define( 'LOGGED_IN_KEY',    '9F2BQAkc2OX$y$ z*&s3A:z9)$z7Tqn/,w1nzS-ng0upJIkf_$Zgn1y9&/g&a1jT' );
define( 'NONCE_KEY',        '1O4/FaS>SBkexNh/i/_m2|2=Z`kZMB(M|FbJ{*p3?SjL4*IT3&B,V*[N4*GehRt_' );
define( 'AUTH_SALT',        'sv{d5@m,ib?1Jb0P#FYh%+A`i={&+^/*p[niJd:<^d{<3E+C+8aS AJ-_c4PajX]' );
define( 'SECURE_AUTH_SALT', 'Ic#gIyX74t[{%&:}j ~Znn%>FqHRpc`<P-*oOmp:=/XcN[J>d4HQYHc.QoHH]Xi>' );
define( 'LOGGED_IN_SALT',   '#}AgH#0<)I/Czk:z-(YLi6nNJvHC;:#v{V- If-hq~H%*tlGRDWF(Mf%Ku%SUbRm' );
define( 'NONCE_SALT',       'me}-Z_|,hUGC  hD/6bJuN+7m.aAd4P6X6[BEy89p4;8#9Xu44]&tK.]B1jpQ,$k' );

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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
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
