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
define( 'DB_NAME', 'wordpress' );

/** MySQL database username */
define( 'DB_USER', 'wordpress' );

/** MySQL database password */
define( 'DB_PASSWORD', '4a5c91a9e1f2881a987d72db088982f880f6f4d4852cf71b' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'r.W,Go$Vii/gulX?B&!ro7VA<6{!%{asM_dx3}O2XR#;GBZMe:KT[tR1t/UIgR;P' );
define( 'SECURE_AUTH_KEY',  'mwQH7{A0w4J@G6}pmQ-g~@G%wm ^B{7>x2Ioz+g|N!/[qcQ?+>PIH!ctq;AtVtbn' );
define( 'LOGGED_IN_KEY',    'E$e-yu(.#WEn]Sk#O{oz5pz7t!Vjl]:n#v}s}Q)&y-k>Nm[3~` |lqIbz4lS~]f)' );
define( 'NONCE_KEY',        'Kfp!3@Yc|nlT}C.yG+O~3tWIFK@ wqbMACW{S>V[tgg7t4^gDeZ!55Lvx<|i#HmZ' );
define( 'AUTH_SALT',        'm#{AfbfI3]iu!xrV-PB&|#85g? WE_YhA/z+==pGT*7`3O`We!5^SK7M.!MmJ=CI' );
define( 'SECURE_AUTH_SALT', '|VG6Zw1>9dNDAKdW%%CZWBq|H^},1Z_8@I.XzcCp[q{,b-N2m^P8BO[:Iny69a<m' );
define( 'LOGGED_IN_SALT',   '$#%%],ziDQ@JzNMD{`!E*ju^uF0 ZK,d`E<l.eu=%SI2hI?Ou+1Y7kwh%V.(&|<~' );
define( 'NONCE_SALT',       'D(WbD3TrOtZ8>JZrcHB!/mC].-zX`QZ]7[s:{tQ?,ez_,#EX{k4,OqnpPGvTL0oI' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
