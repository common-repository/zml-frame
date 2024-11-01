<?php
/**
 * Plugin Name:       ZML-Frame
 * Plugin URI:        https://www.zimoli.me/zml-plugin-frame/
 * Description:       紫茉莉系列产品用于后台管理的基础框架。
 * Version:           1.0.0
 * Author:            紫茉莉.ME
 * Author URI:        https://www.zimoli.me
 * Requires at least: 5.6
 * Requires PHP:      7.3
 * License:           GPLv3
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 */

//* 检查访问
defined( 'ABSPATH' ) or die( 'Access Denied' );

//* 全局常量
define( 'ZMLFRAME_ID', 'zml-plugin-frame' );
define( 'ZMLFRAME_VER', '1.0.0' );
define( 'ZMLFRAME_DEV', false );
define( 'ZMLFRAME_URL', plugin_dir_url( __FILE__ ) );
define( 'ZMLFRAME_PATH', plugin_dir_path( __FILE__ ) );

//* 启动插件
require 'boots/boot.php';
