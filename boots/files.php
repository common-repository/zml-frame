<?php
/**
 * @package ZMLFrame\Boots
 */

namespace ZMLFrame;

defined( 'ZMLFRAME_PRESENT' ) or die( 'Access Denied' );

/**
 * Files ZMLFrame
 *
 * 文件相关内容
 *
 * @since 1.0.0
 */
 
//* 注册文件
function registerFile() {
	
	//* 注册CSS
	\wp_register_style( 'zml-frame-icon', URL_CSS . 'icon.css', [], \ZMLFRAME_VER, 'all' );
	\wp_register_style( 'zml-frame-form', URL_CSS . 'form.css', [], \ZMLFRAME_VER, 'all' );
	\wp_register_style( 'zml-frame-view', URL_CSS . 'view.css', [], \ZMLFRAME_VER, 'all' );
	\wp_register_style( 'zml-frame-info', URL_CSS . 'info.css', [], \ZMLFRAME_VER, 'all' );
	\wp_register_style( 'zml-frame-meta', URL_CSS . 'meta.css', [], \ZMLFRAME_VER, 'all' );
	\wp_register_style( 'zml-frame-term', URL_CSS . 'term.css', [], \ZMLFRAME_VER, 'all' );
	\wp_register_style( 'zml-frame-page', URL_CSS . 'page.css', [], \ZMLFRAME_VER, 'all' );

	//* 注册SCRIPT
	\wp_register_script( 'zml-frame-icon', URL_JS . 'icon.js', ['jquery-core'], \ZMLFRAME_VER, true );
	\wp_register_script( 'zml-frame-form', URL_JS . 'form.js', ['jquery-core'], \ZMLFRAME_VER, true );
	\wp_register_script( 'zml-frame-view', URL_JS . 'view.js', ['jquery-core'], \ZMLFRAME_VER, true );
	\wp_register_script( 'zml-frame-info', URL_JS . 'info.js', ['jquery-core'], \ZMLFRAME_VER, false );
	\wp_register_script( 'zml-frame-meta', URL_JS . 'meta.js', ['jquery-core'], \ZMLFRAME_VER, true );
	\wp_register_script( 'zml-frame-term', URL_JS . 'term.js', ['jquery-core'], \ZMLFRAME_VER, true );
	\wp_register_script( 'zml-frame-page', URL_JS . 'page.js', ['jquery-core'], \ZMLFRAME_VER, true );
	\wp_register_script( 'zml-frame-tabs', URL_JS . 'tabs.js', ['jquery-core'], \ZMLFRAME_VER, true );
	
}

\add_action( 'init', __NAMESPACE__ . '\\registerFile' );
