<?php
/**	op-core-trait:/OP_DEPRECATE.php
 *
 * @created    2025-07-01
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

/**	OP_DEPRECATE
 *
 * This trait was created for compatibility.
 *
 * @created    2025-07-01
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
	static function Notice($error, $trace=null)
	{
		Error::Set($error, $trace ?? debug_backtrace());
	}

	/**	Content is a wrapper method for IF_APP::Content().
	 *
	 * Please use instead `OP()->Unit()->App()->Content()`.
	 *
	 * @deprecated 2025-07-01
	 */
	static function Content()
	{
		OP()->Unit()->App()->Content();
	}

	/**	Path & URL
	 *
	 * @deprecated 2025-11-24
	 * @porting    2025-11-24
	 * @param      string     $path
	 * @param      bool       $url
	 * @return     string
	 */
	static function MetaPath(?string $path=null, ?bool $url=null)
	{
		if( empty($path) ){
			return new MetaPath;
		}
		return $url ? OP()->URL($path): OP()->Path($path);
	}
}
