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
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'blank');

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
define('AUTH_KEY',         '{=3}:&s&Uub[h>-=>O#NpmO|d+%_|C-)f%,u%g%d}nYH+.k[J gyZh}{]0FJmihl');
define('SECURE_AUTH_KEY',  '<3vbL;5:R6FH_bTyMfAL;!]9fm1L?KMq::QGyD-]=fg}3;lQP$E~+Xpy+uD@{grE');
define('LOGGED_IN_KEY',    'o]Q4o#({jfX(JA._$-0hzoS~$~/?p=59jMb??c#^$$/r2Orc8^thlDlc[hSY- d@');
define('NONCE_KEY',        'X8v{OHj}v`XM%:f6O!8.!3*-&0.p7f-^fGpXs.p@+hm_yP 5+Ez5;E~8{!EyZ-=j');
define('AUTH_SALT',        ':C{pX{11C^&2u@^L[bwo#GJ./_s#!.eC+mp_wOpiQr^b+#(g>[*<upg=p+IT)Q9C');
define('SECURE_AUTH_SALT', '2{PHSL$naa&=SY>OW90_E`awhqaUju37vt-1pagBTP+#8Wt2dwC`+J+CGeO(TXcw');
define('LOGGED_IN_SALT',   '97$n;A5tvZab5[{L=nYY0pRSav/7(DV,BBr{!-&b$f2+Ghz@acNe$J9+@TPU>)sN');
define('NONCE_SALT',       'ry||ksE?|LMOF.zE37V7I0A~n*9kRwXU+6$,8h0da&ssN-cbqq8rW/Rk+ikd5:jK');

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

