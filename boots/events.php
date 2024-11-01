<?php
/**
 * @package ZMLFrame\Boots
 */

namespace ZMLFrame;

defined( 'ZMLFRAME_PRESENT' ) or die( 'Access Denied' );

/**
 * Events ZMLFrame
 *
 * 事件相关内容
 *
 * @since 1.0.0
 */

/**
 * 启用插件
 */
function activation() {
	
	//* Nothing
	
}

\register_activation_hook( PATH_BASE . 'frame.php', __NAMESPACE__ . '\\activation' );

/**
 * 停用插件
 */
function deactivation() {
	
	//* Nothing
	
}

\register_deactivation_hook( PATH_BASE . 'frame.php', __NAMESPACE__ . '\\deactivation' );

/**
 * 删除插件
 */
function uninstall() {

	//* Nothing

}

\register_uninstall_hook( PATH_BASE . 'frame.php', __NAMESPACE__ . '\\uninstall' );
