<?php
/**
 * @package ZMLFrame\Boots
 */

namespace ZMLFrame;
 
defined( 'ABSPATH' ) or die( 'Access Denied' );

/**
 * Boot ZMLFrame
 *
 * 插件启动引导
 *
 * @since 1.0.0
 */

if ( \is_admin() ) {
	
	//* 相关文件
	require_once 'define.php';
	require_once 'files.php';
	require_once 'loads.php';
	
	//* 加载页面
	new Page\About();
	
}
