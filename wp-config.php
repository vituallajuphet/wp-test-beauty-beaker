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
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'thebeautybeaker_db21' );

/** MySQL database username */
define( 'DB_USER', 'thebeautybeaker_usr21 ' );

/** MySQL database password */
define( 'DB_PASSWORD', 'odRa;O~A5rSe' );

/** MySQL hostname */
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
define( 'AUTH_KEY',         ':?mf%~l[g_L,DWO}Gu4NUgg=9TV%|>5Mv[G#{(0.z*-ly`$?pl0khX1*iH=bL.kI' );
define( 'SECURE_AUTH_KEY',  '_LLin:yxpn7X{SZ L!*r1_3P-`A O$4lH[m)q+>j-jKZ6[2Yr^etuAu({NPd}5Id' );
define( 'LOGGED_IN_KEY',    'q8e#{PCB5t!Q(B.W6V@EFi+sMP~2J3=5ce 6KTdA!}Ya&_XK5fTjey/eg}q?* :q' );
define( 'NONCE_KEY',        'wc0|DL#Cguef{_9pOmTCts#Q{p]&smT.-ymNc#G9):k=3N +8h9Y3Ccg#th+K5vG' );
define( 'AUTH_SALT',        '-]%WlHe4d,{?&|BN1p;,C@1|MDz[mY]i<y6t>:(y5rIY,z8kq@nYG#U%c# vUQ=V' );
define( 'SECURE_AUTH_SALT', '[Yq:;i6fC/.zzq)E}C$:F~:Dsjq-ZV`f5bH.-An-MIaK2m@)%q@NW;J<.^h+m`J`' );
define( 'LOGGED_IN_SALT',   'L6!/H1l<;yrk6Jqb^9v?<9_N(K-2u7A`EK](?6<AoEGZA#5]K4k{#[4K.327ce}9' );
define( 'NONCE_SALT',       '=}r$._2k*2FXUc&fJQEXhx!/2ar(&onI$_bz2nMyHYz]DwyS*>VR|{]K<d%cC?+S' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'bb_';

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
