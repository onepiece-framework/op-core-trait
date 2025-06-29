<?php
/**	op-core-trait:/OP_FUNCTION.php
 *
 * @porting    2025-06-15  op-core-trait:/OP_FUNCTION.php
 * @author     Tomoaki Nagahara
 * @copyright  Tomoaki Nagahara All right reserved.
 */

/**	namespace
 *
 */
namespace OP;

/**	OP_FUNCTION
 *
 * Wrapper functions. auto load function/*.php.
 *
 * @created    2022-10-05
 * @version    1.0
 * @package    op-core
 * @subpackage trait
 * @author     Tomoaki Nagahara
 * @copyright  Tomoaki Nagahara All right reserved.
 */
trait OP_FUNCTION
{
	/**	An undefined method was called.
	 *
	 * @created     2022-11-12
	 * @param       string      $method_name
	 * @param       array       $args
	 * @return      mixed
	 */
	function __call($method_name, $args)
	{
		return self::_Function($method_name, ...$args);
	}

	/**	An undefined method was called.
	 *
	 * @created   2022-10-11
	 * @param     string $method_name
	 * @param     array  $args
	 */
	static function __callstatic($method_name, $args)
	{
		return self::_Function($method_name, ...$args);
	}

	/**	_Function
	 *
	 * @created   2022-10-05
	 * @param     string     $function
	 * @param     variable variable
	 * @return    null|boolean|string|array|object
	 */
	static private function _Function(string $function, ...$args)
	{
		//	...
		if(!function_exists('OP\\'.$function) ){
			$path = _ROOT_CORE_."/function/{$function}.php";
			if( file_exists( $path) ){
				require_once($path);
			}else{
				Error::Set("This function is not implemented: $function");
				return;
			}
		}

		//	...
		$function = 'OP\\'.$function;

		//	...
		return $function( ...$args );
	}
}
