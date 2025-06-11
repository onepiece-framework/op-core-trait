<?php
/**	op-core-trait:/OP_CI.php
 *
 * @created    2022-10-12  op-core-7:/trait/OP_CI.php
 * @moved      2025-06-11  op-core-trait:/OP_CI.php
 * @version    1.0
 * @package    op-core-trait
 * @author     Tomoaki Nagahara
 * @copyright  Tomoaki Nagahara All right reserved.
 */

/**	namespace
 *
 */
namespace OP;

/**	OP_CI
 *
 * If OP_CI is not used as a trait, the CI/CD pipeline will fail.
 *
 * @created    2022-10-12  op-core-7:/trait/OP_CI.php
 * @moved      2025-06-11  op-core-trait:/OP_CI.php
 * @version    1.0
 * @package    op-core
 * @subpackage trait
 * @author     Tomoaki Nagahara
 * @copyright  Tomoaki Nagahara All right reserved.
 */
trait OP_CI
{
	/**	Return all method names that the instance has.
	 *
	 * @created    2023-02-10
	 * @return     array
	 */
	function CI_AllMethods() : array
	{
		return get_class_methods($this);
	}

	/**	Inspection target method.
	 *
	 * @created    2023-02-10
	 * @param      string      $method
	 * @param      array    ...$args
	 * @return     mixed
	 */
	function CI_Inspection(string $method, ...$args)
	{
		return $this->{$method}(...$args);
	}
}
