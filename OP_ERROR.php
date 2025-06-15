<?php
/**	op-core-trait:/OP_ERROR.php
 *
 * The concept behind this file:
 *   I want to change the class name back from `Notice` to `Error`, so go use the `OP\OP_ERROR` trait.
 *   By implementing `OP\OP_ERROR`, the class will behave the same whether its name is `Notice` or `Error`.
 *   If you implement `OP\OP_ERROR`, the class will function the same regardless of whether another named.
 *
 * @created    2025-06-11  op-core-trait:/OP_ERROR.php
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

/**	OP_ERROR
 *
 * @genesis    ????-??-??  op-core-4:/Error.class.php
 * @porting    2025-06-11  from op-core-7:/Notice.class.php
 * @author     Tomoaki Nagahara
 * @copyright  Tomoaki Nagahara All right reserved.
 */
trait OP_ERROR
{
	/**	Get session by reference.
	 *
	 * @porting    2025-06-14  from op-core-7:/Notice.class.php
	 * @return     array
	 */
	static private function & _Session() : array
	{
		//	...
		if(!isset($_SESSION[_OP_NAME_SPACE_][_APP_ID_]['OP_ERROR']) ){
			$_SESSION[_OP_NAME_SPACE_][_APP_ID_]['OP_ERROR'] = [];
		};
		//	...
		return $_SESSION[_OP_NAME_SPACE_][_APP_ID_]['OP_ERROR'];
	}

	/**	Set error information.
	 *
	 * @porting    2025-06-14  from op-core-7:/Notice.class.php
	 * @param     \Throwable   $e
	 * @param      array       $traces
	 */
	static function Set( $e, $traces=null )
	{
		//	Get session reference.
		$session = & self::_Session();

		//	...
		if( $e instanceof \Throwable ){
			$message = $e->getMessage();
			$traces  = $e->getTrace();
			$file    = $e->getFile();
			$line    = $e->getLine();
			array_unshift($traces, ['file'=>$file, 'line'=>$line]);
		}else if( is_array($e) ){
			// Q: In what situations is this needed here?
			// A: error_get_last() is return array.
			$file    = $e['file'];
			$line    = $e['line'];
		//	$type    = $e['type'];
			$message = $e['message'];
		}else{
			$message = $e;
		}

		//	...
		$key       = substr(md5($message), 0, 8);
		$timestamp = date('Y-m-d H:i:s');

		//	...
		$reference = isset($session[$key]) ? $session[$key]: null;

		//	...
		if( empty($reference) ){
			//	...
			$reference['count']     = 1;
			$reference['created']   = $timestamp;
			$reference['message']   = $message;
			$reference['backtrace'] = $traces ?? debug_backtrace();
		}else{
			$reference['count']    += 1;
			$reference['updated']   = $timestamp;
		}

		//	...
		$reference['REQUEST_URI'][] = ($_SERVER['REQUEST_URI'] ?? null);

		//	...
		$session[$key] = $reference;
	}

	/**	Get error information.
	 *
	 * @porting    2025-06-14  from op-core-7:/Notice.class.php
	 * @return     array
	 */
	static function Get() : array
	{
		$session = & self::_Session();
		return array_shift($session) ?? [];
	}
}

/**	Register shutdown function.
 *
 *  This shutdown function is called only when there is the Notice.
 *  If not have Notice, this file will not be called.
 *
 * @porting    2025-06-13  from op-core-7:/Notice.class.php
 * @version    1.0
 * @author     Tomoaki Nagahara
 * @copyright  Tomoaki Nagahara All right reserved.
 */
register_shutdown_function(function()
{
	try{
		//	...
		if( Unit::Load('Error') ){
			Unit::Instantiate('Error')::Auto();
			return;
		}else{
			echo '`op-unit-error` is not available.';
		}

		//	...
		Error::Auto();

	}catch( \Throwable $e ){
		D($e);
	}
});
