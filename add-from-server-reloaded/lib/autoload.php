<?php
/**
 * Minimal autoloader for the bundled SFTP fallback libraries.
 *
 * Bundled:
 * - phpseclib 3.0.43 (MIT)                       namespace phpseclib3\
 * - paragonie/constant_time_encoding 2.7.0 (MIT) namespace ParagonIE\ConstantTime\
 *
 * Loaded lazily by AFSRReloaded\Sftp_Client only when the PHP ssh2 extension
 * is not available.
 *
 * @package AFSRReloaded
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

spl_autoload_register(
	static function ( $class ) {
		$map = array(
			'phpseclib3\\'            => __DIR__ . '/phpseclib/',
			'ParagonIE\\ConstantTime\\' => __DIR__ . '/constant-time-encoding/',
		);

		foreach ( $map as $prefix => $dir ) {
			if ( 0 !== strpos( $class, $prefix ) ) {
				continue;
			}
			$file = $dir . str_replace( '\\', '/', substr( $class, strlen( $prefix ) ) ) . '.php';
			if ( is_readable( $file ) ) {
				require $file;
			}
			return;
		}
	}
);

// phpseclib helper functions / polyfills.
if ( is_readable( __DIR__ . '/phpseclib/bootstrap.php' ) ) {
	require_once __DIR__ . '/phpseclib/bootstrap.php';
}
