<?php
/**
 * @package ZMLFrame\Boots
 */

namespace ZMLFrame;

defined( 'ZMLFRAME_PRESENT' ) or die( 'Access Denied' );

/**
 * Loads ZMLFrame
 *
 * 加载相关内容
 *
 * @since 1.0.0
 */

/**
 * 快捷加载视图
 *
 * @param string $path 视图路径
 * @param string $view 视图类型
 * @param string $page 视图页面
 */
function loadView( $path, $view, $page = null ) {

	$file = $path . $view . DIRECTORY_SEPARATOR . $page . '.php';
	
	include $file;

}

/**
 * 自动加载类
 *
 * @param string $class 类名称
 */
function loadClass( $class ) {

	//* 限定作用范围于当前命名空间
	if ( strpos( $class, __NAMESPACE__ . '\\', 0 ) !== 0 ) {
		return;
	}

	$main = str_replace( __NAMESPACE__ . '\\', '', $class );
	
    if ( strrpos( $main, '\\' ) ) {

		$mark = strrpos( $main, '\\' );
		$name = strtolower( substr( $main, $mark + 1 ) );
		$type = strtolower( rtrim( substr( $main, 0, $mark ), '\\' ) );

		//* 兼容多层目录
		if ( strrpos( $type, '\\' ) ) {
			$mark = strrpos( $type, '\\' );
			$name = strtolower( substr( $main, $mark + 1 ) );
			$name = str_replace( '\\', DIRECTORY_SEPARATOR, $name );
			$type = strtolower( rtrim( substr( $main, 0, $mark ), '\\' ) );
		}

		$path = constant( __NAMESPACE__ . '\\PATH_' . strtoupper( $type ) );
		$file = $path . $name . '.php';

		require_once $file;

	}

}

spl_autoload_register( __NAMESPACE__ . '\\loadClass', true, true );
