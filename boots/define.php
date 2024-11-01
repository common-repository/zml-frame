<?php
/**
 * @package ZMLFrame\Boots
 */

namespace ZMLFrame;

defined( 'ABSPATH' ) or die( 'Access Denied' );

/**
 * Const ZMLFrame
 *
 * 通用常量定义
 *
 * @since 1.0.0
 */

//* 授权常量
define( 'ZMLFRAME_PRESENT', TRUE );

//* 基准常量
const URL_BASE  = \ZMLFRAME_URL;
const PATH_BASE = \ZMLFRAME_PATH;

//* 附加常量
const URL_PLUS  = \ZMLFRAME_DEV ? URL_BASE . 'assets/src/' : URL_BASE . 'assets/';
const PATH_PLUS = \ZMLFRAME_DEV ? PATH_BASE . 'assets' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR : PATH_BASE . 'assets' . DIRECTORY_SEPARATOR;

//* URL常量
const URL_JS  = URL_PLUS . 'js/';
const URL_CSS = URL_PLUS . 'css/';
const URL_IMG = URL_PLUS . 'images/';

//* PATH常量
const PATH_BOOT = PATH_BASE . 'boots' . DIRECTORY_SEPARATOR;
const PATH_CORE = PATH_BASE . 'cores' . DIRECTORY_SEPARATOR;
const PATH_PAGE = PATH_BASE . 'pages' . DIRECTORY_SEPARATOR;
