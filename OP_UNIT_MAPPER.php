<?php
/**	op-core-trait:/OP_UNIT_MAPPER.php
 *
 * @created    2024-06-08
 * @author     Tomoaki Nagahara
 * @copyright  Tomoaki Nagahara All right reserved.
 */

/**	namespace
 *
 */
namespace OP;

/**	OP_UNIT_MAPPER
 *
 * @created    2024-06-08
 * @version    1.0
 * @package    op-core
 * @subpackage trait
 * @author     Tomoaki Nagahara
 * @copyright  Tomoaki Nagahara All right reserved.
 */
trait OP_UNIT_MAPPER
{
	/**	Map unit name.
	 *
	 * @created  2024-07-08
	 * @param    string     $name
	 * @return   IF_UNIT
	 */
	static private function & _Map( string $name ) : IF_UNIT
	{
		//	Get unit config.
		static $_config;
		if(!$_config){
			$_config = Config::Get('unit');
		}

		//	Do mapping.
		if( isset($_config[$name]) ){
			$name = $_config[$name];
		}

		//	Return already instantiated unit object.
		return self::Instantiated($name);
	}

	/**	Api
	 *
	 * @created    2024-06-30
	 * @return     IF_API
	 */
	static function & Api() : IF_API
	{
		return self::_Map(__FUNCTION__);
	}

	/**	App
	 *
	 * @created    2024-06-08
	 * @return     IF_APP
	 */
	static function & App() : IF_APP
	{
		return self::_Map(__FUNCTION__);
	}
}
