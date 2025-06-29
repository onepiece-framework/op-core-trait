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
}
