<?php
define( 'WP_CACHE', true );
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'erome_db' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         's3[u;|kq$!_EI.;l,@+pT_ZW7&=7$yApGZ!m!e<phCA={(OOyH6G^,iActH,|zLF' );
define( 'SECURE_AUTH_KEY',  '2tRbh%+fJMqJ`FYH}F96U@]{|f#aG#O1}^_^^YW2(jKJ$Q2]:4w)O(=C~IEa=i{8' );
define( 'LOGGED_IN_KEY',    'qgB%c@.WyCd|)_j5)M@6o5w#<q&X52.KU9`J?S7v:Cw-WhWiOj4^#L XAq>kK3:2' );
define( 'NONCE_KEY',        'Hjb`<q9Rn+h>-bn(chXfe;|}{F qF4R=`37`c/U.*~ iFkKd}WtnnZz <Gi`(M.)' );
define( 'AUTH_SALT',        '=9 IeB>;DNrS5rK[jmDk2%({@|<>l:X=Vnwf~7~F5^JE#@yI]T|[l).VO4kvI~<(' );
define( 'SECURE_AUTH_SALT', 'j ^dRL(EwYps[wSln#=tN>6bgCBv~k*$n|JlSx{h3#6Cb;-fzog,7QHk?!!3n{R+' );
define( 'LOGGED_IN_SALT',   'nImED|n5&Y<%&Q> 4PFV*sPNM?;+H^xSj6B(Ba&K% bKm7y akU^UHz&2#K1Fv[]' );
define( 'NONCE_SALT',       'Wo+vr<]F:d])Ao%D]9*HVTzo|Imc{kE974c3Scip!6{bnsUAh;,[^R=[ku:,bIHB' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
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
