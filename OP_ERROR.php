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

}
