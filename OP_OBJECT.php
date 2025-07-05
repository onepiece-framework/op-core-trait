<?php
/**	op-core-trait:/OP_OBJECT.php
 *
 * @created    2025-06-16
 * @author     Tomoaki Nagahara
 * @copyright  Tomoaki Nagahara All right reserved.
 */

/**	namespace
 *
 */
namespace OP;

/**	OP_OBJECT
 *
 * @deprecated 2025-07-04
 * @created    2022-10-05  op-core-7:/OP.class.php > trait > OP_OBJECT
 * @porting    2025-06-16  op-core-trait:/OP_OBJECT.php
 * @version    1.0
 * @package    op-core
 * @subpackage trait
 * @author     Tomoaki Nagahara
 * @copyright  Tomoaki Nagahara All right reserved.
 */
trait OP_OBJECT
{
	/**	Router unit.
	 *
	 * @deprecated 2025-07-05
	 * @created    2022-09-30
	 * @return     UNIT\Router
	 */
	static function Router() : IF_ROUTER
	{
		return OP::Unit('Router');
	}

	/**	Meta path
	 *
	 * <pre>
	 * // Set meta path.
	 * OP()->MetaPath()->Set('hoge', '/var/www/htdocs/hoge/');
	 *
	 * // Get meta path to full path.
	 * $full_path = OP()->MetaPath('hoge:/foo/bar'); -> /var/www/htdocs/hoge/foo/bar/
	 *
	 * // Get full path to meta path.
	 * $meta_path = OP()->MetaPath('/var/www/htdocs/hoge/foo/bar'); -> hoge:/foo/bar/
	 *
	 * // Get document root path from meta path.
	 * $url_path  = OP()->MetaPath('hoge:/foo/bar?key=value', true); -> /hoge/foo/bar/?key=value
	 * </pre>
	 *
	 * @created    2022-10-16
	 * @param      string     $meta
	 * @param      bool       $url
	 * @throws    \Exception
	 * @return    \OP\MetaPath
	 */
	static function MetaPath( ?string $path=null, ?bool $url=null )
	{
		//	...
		static $_meta_path;

		//	...
		if( $path ){
			$path = trim($path);

			//	Full path to meta path
			if( $path[0] === '/' ){
				//	Full path to URL is not support.
				if( $url ){
					throw new \Exception("Full path to URL is not support. ($path)");
				}
				return MetaPath::Encode($path);
			}

			//	Decode meta path.
			if( $url ){
				// to URL
				return MetaPath::URL($path);
			}else{
				// to File path.
				return MetaPath::Decode($path);
			}
		}

		//	...
		if(!$_meta_path ){
			$_meta_path = new MetaPath();
		}

		//	...
		return $_meta_path;
	}

	/**	Env
	 *
	 * @deprecated  2025-07-05
	 * @created     2023-04-26
	 * @return      Env
	 */
	static function & Env() : Env
	{
		static $_env;
		if(!$_env ){
			$_env = new Env();
		}
		return $_env;
	}
}
