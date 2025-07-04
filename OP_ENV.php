<?php
/**	op-core-trait:/OP_ENV.php
 *
 * @genesis    2016-06-09  op-core:/Env.class.php separated from OnePiece5.class.php
 * @rebirth    2025-06-15  op-core-trait:/OP_ENV.php
 * @version    1.0
 * @package    op-core-trait
 * @author     Tomoaki Nagahara
 * @copyright  Tomoaki Nagahara All right reserved.
 */

/**	namespace
 *
 */
namespace OP;

/**	OP_ENV
 *
 * @genesis    2022-10-05  Move from op-core-7:/Env.class.php
 * @rebirth    2025-06-15  op-core-trait:/OP_ENV.php
 * @version    1.0
 * @package    op-core-trait
 * @author     Tomoaki Nagahara
 * @copyright  Tomoaki Nagahara All right reserved.
 */
trait OP_ENV
{
	/**	Is CI
	 *
	 * @created    2022-11-11
	 * @return     boolean
	 */
	static function isCI() : bool
	{
		return defined('_IS_CI_');
	}

	/**	Is Shell
	 *
	 * @return boolean
	 */
	static function isShell() : bool
	{
		return PHP_SAPI === 'cli' ? true: false;
	}

	/**	Is Http(s) protocol.
	 *
	 * @return boolean
	 */
	static function isHttp() : bool
	{
		return isset($_SERVER['SERVER_NAME']);
	}

	/**	Is secure HTTPs protocol.
	 *
	 * @return boolean
	 */
	static function isHTTPs() : bool
	{
		return isset($_SERVER['HTTPS']);
	}

	/**	Is localhost
	 *
	 * @return boolean
	 */
	static function isLocalhost() : bool
	{
		//	Keep calced value.
		static $_is_localhost;

		//	Check if not init.
		if( $_is_localhost === null ){
			$_is_localhost = include_once(_ROOT_ASSET_.'/core/include/isLocalhost.php');
		}

		//	Return already calced static value.
		return $_is_localhost;
	}

	/**	Is Admin
	 *
	 * @return boolean
	 */
	static function isAdmin() : bool
	{
		//	Keep calced value.
		static $_is_admin;

		//	Check if not init.
		if( $_is_admin === null ){
			$_is_admin = include_once(_ROOT_ASSET_.'/core/include/isAdmin.php');
		}

		//	Return already calced static value.
		return $_is_admin;
	}

	/**	Get/Set MIME
	 *
	 * <pre>
	 * //  Set MIME.
	 * OP()->MIME('text/html');
	 *
	 * //  Set MIME by extension.
	 * OP()->MIME('html');
	 *
	 * //  Get the MIME that has already been set.
	 * $mime = OP()->MIME();
	 * </pre>
	 *
	 * @porting    2025-06-20
	 * @param      string     $mime
	 * @return     string     $mime
	 */
	static function MIME(?string $mime='') : string
	{
		//	...
		static $_mime = '';

		//	...
		if( $mime ){
			//	...
			if( strpos($mime, '/') ){
				$_mime = $mime;
			}else{
				require_once(_ROOT_CORE_.'/function/GetMimeFromExtension.php');
				$_mime = GetMimeFromExtension($mime);
			}

			//	...
			if(!self::isShell() ){
				/* @var $file null */
				/* @var $line null */
				if( headers_sent($file, $line) ){
					$meta    =  OP::Path($file);
					$message = "Header has already sent. ($meta, $line)";
					Error::Set($message);
				}

				//	...
				header("Content-type: $_mime");
			}
		}

		//	...
		return $_mime;
	}

	/**	Get GET/POST/JSON request.
	 *
	 * <pre>
	 * //  GET and POST and JSON
	 * $request = OP()->Request();
	 *
	 * // Specify key name.
	 * $val = OP()->Request('key_name');
	 *
	 * // If not set key name.
	 * $null = OP()->Request('not_set_key_name');
	 *
	 * // If set default value.
	 * $name = OP()->Request('nickname') ?? 'unknown';
	 * </pre>
	 *
	 * @porting    2025-06-20
	 * @param      string     $key
	 * @return     NULL
	 */
	static function Request($key=null)
	{
		//	...
		static $_request = null;

		//	...
		if( $_request === null ){
			/**	Need to include from both OP and Env.
			$_request = require_once(_ROOT_CORE_.'/include/Request.php');
			*/
			$_request = require     (_ROOT_CORE_.'/include/Request.php');
		}

		//	...
		return $key ? $_request[$key] ?? null : $_request;
	}

	/**	AppID
	 *
	 * Returns a secret, unique AppID that should not be made public.
	 *
	 * @deprecated 2025-07-01 Keep for compatibility.
	 * @return     string
	 */
	static function AppID() : string
	{
		return _APP_ID_;
	}

	/**	Get/Set frozen unix time.
	 *
	 * <pre>
	 * // Get local unix time
	 * $local_unit_time = OP()->Env()->Time();
	 *
	 * // Get UTC unix time
	 * $utc_unit_time = OP()->Env()->Time(true);
	 *
	 * // Set local unix time
	 * OP()->Env()->Time(false, strtotime('2024-01-01'));
	 * </pre>
	 *
	 * @param  boolean $utc
	 * @param  string  $time
	 * @return integer $time
	 */
	static function Time( ?bool $utc=false, ?string $time='' ) : int
	{
		require_once(_ROOT_CORE_.'/function/Time.php');
		return Time($utc, $time);
	}

	/**	Return Y-m-d H:i:s timestamp.
	 *
	 * <pre>
	 * // Local time timestamp
	 * $local_timestamp = OP()->Env()->Timestamp();
	 *
	 * // UTC time timestamp
	 * $utc       = OP()->Env()->Timestamp(true);
	 *
	 * // 1 month ago timestamp
	 * $offset    = OP()->Env()->Timestamp(true, '-1 month');
	 * </pre>
	 *
	 * @created  2019-09-24
	 * @param    boolean     $utc
	 * @param    string      $offset
	 * @return   string      $timestamp
	 */
	static function Timestamp( ?bool $utc=false, $offset=null ) : string
	{
		require_once(_ROOT_CORE_.'/function/Timestamp.php');
		return Timestamp($utc, $offset);
	}
}
