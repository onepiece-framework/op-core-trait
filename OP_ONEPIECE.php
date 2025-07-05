<?php
/**	op-core-trait:/OP_ONEPIECE.php
 *
 * @created    2025-06-22
 * @version    1.0
 * @package    op-core
 * @subpackage trait
 * @author     Tomoaki Nagahara
 * @copyright  Tomoaki Nagahara All right reserved.
 */

/**	namespace
 *
 */
namespace OP;

/**	OP_ONEPIECE
 *
 * Connected to op-core-7:/OP.class.php
 *
 * @genesis    ????-??-??  op-core-4:/OnePiece.class.php
 * @created    2025-06-22
 * @version    1.0
 * @author     Tomoaki Nagahara
 * @copyright  Tomoaki Nagahara All right reserved.
 */
trait OP_ONEPIECE
{
	/**	Error
	 *
	 * @created    2026-06-22
	 * @param      string      $error_message
	 * @param      string      $debag_backtrace
	 * @return    &Error
	 */
	static function & Error( $error_message=null, $debag_backtrace=null ) : Error
	{
		//	...
		static $_error;

		//	...
		if( $error_message ){
			Error::Set( $error_message, $debag_backtrace );
		}

		//	...
		if(!$_error ){
			$_error = new Error();
		}

		//	...
		return $_error;
	}

	/**	Return already instantiated unit object. (Singleton)
	 *
	 * This method that I thought of seems to be called the singleton pattern in the world.
	 *
	 * <pre>
	 * //  ...
	 * OP()->Unit()->App()->Auto();
	 *
	 * //  ...
	 * OP()->Unit('App')->Auto();
	 * </pre>
	 *
	 * @created   2022-10-07
	 * @porting   2025-07-04
	 * @param     string     $name
	 */
	static function & Unit( string $name='' )
	{
		//	...
		if( $name ){
			return Unit::Instantiated($name);
		}

		//	...
		static $_unit;
		//	...
		if(!$_unit ){
			$_unit = new Unit();
		}
		//	...
		return $_unit;
	}

	/**	Convert local file path.
	 *
	 * <pre>
	 * //  Convert to meta path from full path.
	 * $meta_path = OP()->Path(__FILE__);
	 *
	 * //  Convert to full path from meta path.
	 * $app_root = OP()->Path('app:/smart_url/id');
	 * </pre>
	 *
	 * @created    2025-06-13
	 * @param      string     $path
	 * @return     string
	 */
	static function Path( string $path ) : string
	{
		//	...
		$path = trim($path);

		//	...
		if( $path[0] === '/' ){
			require_once(_ROOT_CORE_.'/function/CompressPath.php');
			return CompressPath( $path );
		}else{
			require_once(_ROOT_CORE_.'/function/ConvertPath.php');
			return ConvertPath( $path, false, false );
		}
	}

	/**	Convert to document root path from full path and meta path.
	 *
	 * <pre>
	 * //  Convert to document root path from full path.
	 * $url = OP()->URL(__FILE__);
	 *
	 * //  Convert to document root path from meta path.
	 * $url = OP()->URL('app:/smart_url/id');
	 * </pre>
	 *
	 * @created    2025-06-13
	 * @param      string     $path
	 * @return     string
	 */
	static function URL( string $path ) : string
	{
		require_once(_ROOT_CORE_.'/function/ConvertURL-2.php');
		return ConvertURL( $path );
	}

	/**	Config
	 *
	 * <pre>
	 * // Get config by name. file is "asset:/config/name.php".
	 * $config = OP::Config('name');
	 *
	 * // Set config by name.
	 * OP::Config('name', ['key'=>'value']);
	 * </pre>
	 *
	 * @created    2022-11-01
	 * @param      string     $name
	 * @param      array      $config
	 * @return
	 */
	static function Config( ?string $name=null, ?array $config=null )
	{
		//	...
		if( $name ){
			if( $config ){
				return Config::Set($name, $config);
			}else{
				return Config::Get($name);
			}
		}else{
			static $_config;
			if(!$_config ){
				$_config = new Config();
			}
			return $_config;
		}
	}

	/**	Layout
	 *
	 * @created    2022-10-04
	 * @param      string|boolean|null
	 * @return     string|boolean
	 */
	static function Layout( string|bool|null $value=null ) : string | bool | IF_LAYOUT
	{
		//	...
		if( $value !== null ){
			require_once(_ROOT_CORE_.'/function/Layout.php');
			return Layout($value);
		}

		//	...
		return OP::Unit('Layout');
	}

	/**	Encode value(s).
	 *
	 * @param  mixed $value
	 * @return mixed $value
	 */
	static function Encode( $value )
	{
		require_once(_ROOT_CORE_.'/function/Encode.php');
		return Encode( $value );
	}

	/**	Decode value(s).
	 *
	 * @param  mixed $value
	 * @return mixed $value
	 */
	static function Decode( $value )
	{
		require_once(_ROOT_CORE_.'/function/Decode.php');
		return Decode( $value );
	}
}
