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
	/**	Is Shell
	 *
	 * @return boolean
	 */
	static function isShell() : bool
	{
		return PHP_SAPI === 'cli' ? true: false;
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
}
