<?php
/**	op-core-trait:/OP_SESSION.php
 *
 * @created    2019-04-10
 * @license    Apache-2.0
 * @package    op-core
 * @subpackage trait
 * @copyright  (C) 2019 Tomoaki Nagahara
 */

/**	namespace
 *
 */
namespace OP;

/**	OP_SESSION
 *
 * @created    2019-04-10
 */
trait OP_SESSION
{
	/**	Get/Set Session
	 *
	 * @created   ????-??-??
	 * @updated   2019-04-10
	 */
	static function & Session($key=null, $val=null)
	{
		//	For op-asset-bootstrap2
		if( defined( '_APP_ID_' ) ){
			$app_id = _APP_ID_;
		}else{
			$app_id = md5(__FILE__);
		}

		//	OP\UNIT\UnitName --> ['OP','UNIT','UnitName']
		$explode = explode('\\', get_called_class());

		//	OP\ClassName --> ['OP','CORE','ClassName']
		if( count($explode) === 2 ){
			$explode[2] = $explode[1];
			$explode[1] = 'CORE';
		}

		//	OP --> NAME_SPACE
		$explode[0] = _OP_NAME_SPACE_;

		//	Reference
		$session = & $_SESSION[$explode[0]][$explode[1]][$explode[2]][$app_id];

		//	If passed assoc key name.
		if( $key ){
			/*
			//	If not passed value.
			if( $val !== null ){
				$session[$key] = $val;
			};
			*/
			//	Check if passed value.
			if( func_num_args() >= 2 ){
				if( $val === null ){
					unset( $session[$key] );
				}else{
					$session[$key] = $val;
				}
			}
		};

		//	...
		if( $key ){
			return $session[$key];
		}else{
			return $session;
		};
	}
}
