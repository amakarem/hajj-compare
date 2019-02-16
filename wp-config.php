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
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'username');

/** MySQL database password */
define('DB_PASSWORD', 'password');

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
define('AUTH_KEY',         '_8mKq=%aE*Dmhln*Zmgl9M.m[9tKR}MMT%cWV>qm.KgC<u,78DM2{u~aVTvJ)r:{');
define('SECURE_AUTH_KEY',  '4~oO9]V~(ht1INT2>19gzD%B @vc!5m]#Laju6RZwbuA*txS2r<#W j@25m/%EA@');
define('LOGGED_IN_KEY',    'fJcu@99Vc4E[{0RMjf7gEY)fSe6dg?t ylV~BxOcyKh+J, 0:$[O&} W-m]9oG@$');
define('NONCE_KEY',        'TDXN&RJf{=Exm,iEAEET{B05iAglK;O,>*G=%/OzNT@iK~~Q+2HUM0-,Uf/]Ug}B');
define('AUTH_SALT',        'fd0=&mWq&=`,_l@#pz#Y=y/:[dFFgm3va!H=zm(F@PV&@66An|r:vrPk:Yzm=llg');
define('SECURE_AUTH_SALT', 'C,6q#@,>#*B?LC0IqUi{kiF#L*RNuxTy*jVr}gLg;ADHZe>Pd}t(P>C6FhaJUXu#');
define('LOGGED_IN_SALT',   'xpjh]aGu3Q=m=K==%,Ns?#r?nwTOHFKD3zQ3nr!}{/nCO&Jy(U3(/8~:jp!$bgBA');
define('NONCE_SALT',       '3F}-tP(g9F,pw<GX=idRoBxtm8gdM[< _aGJ2<%PC?&dke>ma{;(WjCvHWNZU^sD');

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
