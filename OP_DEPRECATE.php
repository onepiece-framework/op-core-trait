<?php
/**	op-core-trait:/OP_DEPRECATE.php
 *
 * @created    2025-07-01
 * @author     Tomoaki Nagahara
 * @copyright  Tomoaki Nagahara All right reserved.
 */

/**	namespace
 *
 */
namespace OP;

/**	OP_DEPRECATE
 *
 * This trait was created for compatibility.
 *
 * @created    2025-07-01
 * @version    1.0
 * @package    op-core
 * @subpackage trait
 * @author     Tomoaki Nagahara
 * @copyright  Tomoaki Nagahara All right reserved.
 */
trait OP_DEPRECATE
{
	/**	Notice is a wrapper method for Error::Set().
	 *
	 * Please use instead `OP::Error()`.
	 *
	 * @deprecated 2025-06-17
	 * @param      string      $error
	 * @param      array       $trace
	 */
	static function Notice($error, $trace=[])
	{
		Error::Set($error, $trace);
	}
}
