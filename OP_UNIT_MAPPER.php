<?php
/**	op-core-trait:/OP_UNIT_MAPPER.php
 *
 * @created    2024-06-08
 * @license    Apache-2.0
 * @package    op-core
 * @subpackage trait
 * @copyright  Tomoaki Nagahara
 */

/**	namespace
 *
 */
namespace OP;

/**	OP_UNIT_MAPPER
 *
 */
trait OP_UNIT_MAPPER
{
	/**	Map unit name.
	 *
	 * @created  2024-07-08
	 * @param    string     $name
	 * @return   IF_UNIT
	 */
	static private function & _Map( string $name, ...$args ) : IF_UNIT
	{
		//	Convert unit name.
		$name = self::Mapping($name);

		//	Return already instantiated unit object.
		$instance =& self::Instantiated($name);

		//	Run Auto only when arguments are passed, so normal unit access stays side-effect free.
		if( $args ){
			//	Check Auto explicitly because not every unit has an automatic entry point.
			if( method_exists($instance, 'Auto') ){
				$instance->Auto(...$args);
			}
		}

		//	Return the mapped unit instance after the optional Auto call.
		return $instance;
	}

	/**	Convert unit name.
	 *
	 * @moved      2026-01-25 Unit::Instantiate()
	 * @param      string     $name
	 * @return     string
	 */
	static function Mapping( string $name ) : string
	{
		//	Get unit config.
		static $_config;

		//	If empty.
		if(!$_config){
			$_config = Config::Get('unit');
		}

		//	Do mapping.
		$map = strtolower($name);
		if( isset($_config['mapping'][$map]) ){
			$name = $_config['mapping'][$map];
		}

		//	Return.
		return $name;
	}

	/**	Api
	 *
	 * @created    2024-06-30
	 * @return     IF_API
	 */
	static function & Api(...$args) : IF_API
	{
		return self::_Map(__FUNCTION__, ...$args);
	}

	/**	App
	 *
	 * @created    2024-06-08
	 * @return     IF_APP
	 */
	static function & App(...$args) : IF_APP
	{
		return self::_Map(__FUNCTION__, ...$args);
	}

	/**	Bitcoin
	 *
	 * @created    2026-01-22
	 * @return     IF_BITCOIN
	 */
	static function & Bitcoin(...$args) : IF_BITCOIN
	{
		return self::_Map(__FUNCTION__, ...$args);
	}

	/**	CD
	 *
	 * @created    2025-07-05
	 * @return     IF_CD
	 */
	static function & CD(...$args) : IF_CD
	{
		return self::_Map(__FUNCTION__, ...$args);
	}

	/**	CI
	 *
	 * @created    2024-11-24
	 * @return     IF_CI
	 */
	static function & CI(...$args) : IF_CI
	{
		return self::_Map(__FUNCTION__, ...$args);
	}

	/**	Database
	 *
	 * @created    2024-06-08
	 * @return     IF_DATABASE
	 */
	static function & Database(...$args) : IF_DATABASE
	{
		return self::_Map(__FUNCTION__, ...$args);
	}

	/**	Dump
	 *
	 * @created    2025-07-04
	 * @return     IF_DUMP
	 */
	static function & Dump(...$args) : IF_DUMP
	{
		return self::_Map(__FUNCTION__, ...$args);
	}

	/**	Form
	 *
	 * @created    2024-06-08
	 * @return     IF_FORM
	 */
	static function & Form(...$args) : IF_FORM
	{
		return self::_Map(__FUNCTION__, ...$args);
	}

	/**	Git
	 *
	 * @created    2025-07-06
	 * @return     IF_GIT
	 */
	static function & Git(...$args) : IF_GIT
	{
		return self::_Map(__FUNCTION__, ...$args);
	}

	/**	Html
	 *
	 * @created    2026-02-02
	 * @return     IF_HTML
	 */
	static function & Html(...$args) : IF_HTML
	{
		return self::_Map(__FUNCTION__, ...$args);
	}

	/**	Layout
	 *
	 * @created    2024-06-08
	 * @return     IF_LAYOUT
	 */
	static function & Layout(...$args) : IF_LAYOUT
	{
		return self::_Map(__FUNCTION__, ...$args);
	}

	/**	Login
	 *
	 * @created    2026-01-20
	 * @return     IF_LOGIN
	 */
	static function & Login(...$args) : IF_LOGIN
	{
		return self::_Map(__FUNCTION__, ...$args);
	}

	/**	Notice
	 *
	 * @created    2025-06-16
	 * @return     IF_NOTICE
	 */
	static function & Notice(...$args) : IF_NOTICE
	{
		return self::_Map(__FUNCTION__, ...$args);
	}

	/**	ORM
	 *
	 * @created    2024-06-08
	 * @return     IF_ORM
	 */
	static function & ORM(...$args) : IF_ORM
	{
		return self::_Map(__FUNCTION__, ...$args);
	}

	/**	QQL
	 *
	 * @created    2024-07-13
	 * @return     IF_QQL
	 */
	static function & QQL(...$args) : IF_QQL
	{
		return self::_Map(__FUNCTION__, ...$args);
	}

	/**	Router
	 *
	 * @created    2024-06-08
	 * @return     IF_ROUTER
	 */
	static function & Router(...$args) : IF_ROUTER
	{
		return self::_Map(__FUNCTION__, ...$args);
	}

	/**	Shell
	 *
	 * @created    2026-03-29
	 * @return     IF_SHELL
	 */
	static function & Shell(...$args) : IF_SHELL
	{
		return self::_Map(__FUNCTION__, ...$args);
	}

	/**	SQL
	 *
	 * @created    2025-12-01
	 * @return     IF_SQL
	 */
	static function & SQL(...$args) : IF_SQL
	{
		return self::_Map(__FUNCTION__, ...$args);
	}

	/**	Validate
	 *
	 * @created    2024-06-08
	 * @return     IF_VALIDATE
	 */
	static function & Validate(...$args) : IF_VALIDATE
	{
		return self::_Map(__FUNCTION__, ...$args);
	}

	/**	WebPack
	 *
	 * @created    2024-06-08
	 * @return     IF_WEBPACK
	 */
	static function & WebPack(...$args) : IF_WEBPACK
	{
		return self::_Map(__FUNCTION__, ...$args);
	}
}
