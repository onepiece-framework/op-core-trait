<?php
/**	op-core-trait:/OP_CORE.php
 *
 * @genesis    ????-??-??  op-core-4:/OnePiece.class.php
 * @created    2017-02-16  op-core-5:/OP_CORE.trait.php
 * @copied     2025-06-11  op-core-trait:/OP_CORE.php
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

/**	OP_CORE
 *
 * @created    2016-12-05
 * @author     Tomoaki Nagahara
 * @copyright  Tomoaki Nagahara All right reserved.
 */
trait OP_CORE
{
	/**	Attempted to call an unimplemented method.
	 *
	 * @param string $name
	 * @param array  $args
	 */
	function __call($name, $args)
	{
		$class = __CLASS__;
		$class = preg_replace('/^OP\\\/', '', $class);
		$message = "This method does not exist: {$class}->{$name}()";
		Error::Set($message, debug_backtrace(false));
	}

	/**	Attempted to call an unimplemented static method.
	 *
	 * @param string $name
	 * @param array  $args
	 */
	static function __callstatic($name, $args)
	{
		$class = __CLASS__;
		$class = preg_replace('/^OP\\\/', '', $class);
		$message = "This method does not exist: {$class}::{$name}()";
		Error::Set($message, debug_backtrace(false));
	}

	/**	Attempted to call an unimplemented property.
	 *
	 * @param string $name
	 */
	function __get($name)
	{
		$class = __CLASS__;
		$class = str_replace('\\\\', '\\', $class);
		$message = "This property does not exist: {$class}::{$name}";
		Error::Set($message, debug_backtrace(false));
	}

	/**	Attempted to call an unimplemented property.
	 *
	 * @param string $name
	 * @param array  $args
	 */
	function __set($name, $args)
	{
		$class = __CLASS__;
		$class = str_replace('\\\\', '\\', $class);
		$message = "This property does not exist: {$class}::{$name}";
		Error::Set($message, debug_backtrace(false));
	}

	/**	Enumerate property names to serialize.
	 *
	 */
	function __sleep()
	{
		return [];
	}

	/**	Process to restore from a serialized string.
	 *
	 */
	function __wakeup()
	{

	}
}
