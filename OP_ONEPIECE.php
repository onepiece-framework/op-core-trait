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
}
