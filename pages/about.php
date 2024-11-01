<?php
/**
 * Package ZMLFrame\Pages
 */

namespace ZMLFrame\Page;

defined( 'ZMLFRAME_PRESENT' ) or die( 'Access Denied' );

/**
 * Class ZMLFrame\Page\About
 *
 * 关于页面
 *
 * @since 1.0.0
 */

class About {

	private $base, $hook;
	private $setup, $menus, $areas;
	private $page;
	
	public function __construct() {

		//* 参数设置
		$this->setup = [
			'base' => 'frame.php',
			'menu' => '紫茉莉 - 基础框架',
			'name' => 'ZML-FRAME',
			'type' => 'plugin',
			'home' => 'https://www.zimoli.me/zml-plugin-frame/',
			'help' => 'https://www.zimoli.me/zml-plugin-frame-document/',
			'show' => 'flow',
			'role' => 'page',
			'path' => \ZMLFrame\PATH_PAGE,
			'data' => '',
			'slug' => 'zml-frame-about',
		];
		
		//* 菜单数据
		$this->menus[] = [];
		
		//* 插件介绍
		$this->areas[] = [
			'id'     => '',
			'menu'   => '',
			'view'   => 'support,about',
		];

		//* 引用框架
		$this->page = new \ZMLFrame\Core\Page();

		//* 添加动作
		\add_action( 'admin_menu', [$this, 'pageInit'] );
		\add_action( 'admin_enqueue_scripts', [$this, 'pageFile'] );
		
		//* 添加过滤器
		\add_filter( 'plugin_action_links', [$this, 'pageLink'], 10, 2 );
		
	}

	/**
	 * 初始化
	 */
	public function pageInit() {

		$this->base = \plugin_basename( \ZMLFrame\PATH_BASE . $this->setup['base'] );
		$this->hook = \add_plugins_page( $this->setup['name'], $this->setup['menu'], 'manage_options', $this->setup['slug'], [$this, 'pageView'] );

	}
	
	/**
	 * 页面链接
	 */
	public function pageLink( $links, $file ) {

		if ( $this->base === $file ) {
			$link = '<a href="plugins.php?page=' . $this->setup['slug'] . '">关于</a>';
			array_push( $links, $link );
		}
		
		return $links;
		
	}

	/**
	 * 静态文件
	 */
	public function pageFile( $hook ) {

		if ( $this->hook === $hook ) {
			$this->page->loadFile();
		}

	}

	/**
	 * 页面视图
	 */
	public function pageView() {

		$this->page->showPage( $this->menus, $this->areas, $this->setup );

	}
	
}