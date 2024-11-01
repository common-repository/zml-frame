<?php
/**
 * @package ZMLFrame\Cores
 */

namespace ZMLFrame\Core;

defined( 'ZMLFRAME_PRESENT' ) or die( 'Access Denied' );

/**
 * Class ZMLFrame\Core\Page
 *
 * 页面框架
 *
 * @since 1.0.0
 */

class Page {

	private $form;

	public function __construct() {
		
		$this->form = new Form();

	}
	
	/**
	 * 显示页面
	 *
	 * @param  array $menus  菜单数据
	 * @param  array $areas  区域数据
	 * @param  array $setup  参数设置
	 */
	public function showPage( $menus, $areas, $setup ) {

		//* 参数未设置
		if ( empty( $areas ) || empty( $setup ) ) {
			echo '<div id="message" class="error">';
			echo '<p>缺少相关数据设置，页面无法显示。</p>';
			echo '</div>';
			return;
		}
		
		//* 临时全局变量
		global $zmlframe_tabs; $zmlframe_tabs = [];
		
		?>
		<div class="page-wrap <?php echo \esc_attr( $setup['show'] ); ?>">

			<div class="page-header">
				<div class="page-logo"><svg class="svg-icon" aria-hidden="true"><use xlink:href="#icon-frame-zimoli"></use></svg></div>
				<div class="page-title">
					<div>紫茉莉</div>
					<div class="title-super">.<?php echo \esc_attr( $setup['type'] ); ?></div>
					<div><svg class="svg-icon" aria-hidden="true"><use xlink:href="#icon-frame-arrow"></use></svg><?php echo \esc_attr( $setup['name'] ); ?></div>
				</div>
				<div class="page-link">
					<a class="link-button" href="<?php echo \esc_url( $setup['help'] ); ?>" target="_blank" title="在线文档">
						<svg class="svg-icon" aria-hidden="true"><use xlink:href="#icon-frame-document"></use></svg>
					</a>
					<a class="link-button" href="<?php echo \esc_url( $setup['home'] ); ?>" target="_blank" title="产品主页">
						<svg class="svg-icon" aria-hidden="true"><use xlink:href="#icon-frame-home"></use></svg>
					</a>
				</div>                                                                     
			</div>

			<?php echo $setup['role'] === 'option' ? '<form class="action-page-form" id="' . \esc_attr( $setup['slug'] ) . '-form" name="' . \esc_attr( $setup['slug'] ) . '-form" action="" method="post">' : ''; ?>

			<?php if ( $setup['show'] === 'tabs' ) : ?>
			<!-- 选项卡布局-开始 -->
			<div class="page-body action-page-tabs">
				<div class="page-aside">
					<ul class="page-tabs">
						<?php $this->showTabs( $menus ); ?>
					</ul>
				</div>
				<div class="page-main">
					<?php $this->showMain( $areas, $setup ); ?>
				</div>
			</div>
			<div class="<?php echo $setup['role'] === 'option' ? 'page-info' : 'hide'; ?>">
				<span></span>
			</div>
			<!-- 选项卡布局-结束 -->
			<?php endif; ?>
			
			<?php if ( $setup['show'] === 'flow' ) : ?>
			<!-- 流布局-开始 -->
			<div class="page-body">
				<div class="page-main">
					<?php $this->showMain( $areas, $setup ); ?>
				</div>
			</div>
			<!-- 流布局-结束 -->
			<?php endif; ?>

			<div class="<?php echo $setup['role'] === 'option' ? 'page-footer' : 'hide'; ?>">
				<div class="page-status">
					<span class="status" id="<?php echo \esc_attr( $setup['slug'] ); ?>-status" name="<?php echo \esc_attr( $setup['slug'] ); ?>-status"> </span>
				</div>
				<?php if ( $setup['role'] === 'option' ) : ?>
				<div class="page-action">
					<?php \wp_nonce_field( $setup['slug'], $setup['slug'] . '-nonce' ); ?>
					<button class="page-button data-reset" type="button" id="<?php echo \esc_attr( $setup['slug'] ); ?>-reset" name="<?php echo \esc_attr( $setup['slug'] ); ?>-reset" value="<?php echo \esc_attr( $setup['slug'] ); ?>-reset">恢复默认</button>
					<button class="page-button data-save" type="button" id="<?php echo \esc_attr( $setup['slug'] ); ?>-save" name="<?php echo \esc_attr( $setup['slug'] ); ?>-save" value="<?php echo \esc_attr( $setup['slug'] ); ?>-save">保存设置</button>
				</div>
				<?php endif; ?>
			</div>

			<?php echo $setup['role'] === 'option' ? '</form>' : ''; ?>

		</div>
		<!-- 检测Adblock -->
		<div class="adsbygoogle"></div>
		<!-- 自动选项卡 -->
		<?php
		//* 加载自动TABS
		\wp_enqueue_script( 'zml-frame-tabs' );
		\wp_localize_script( 'zml-frame-tabs', 'zml_frame_preset', ['tabs' => $zmlframe_tabs]);
		//* 销毁变量
		unset( $zmlframe_tabs );
		
	}

	/**
	 * 显示选项卡
	 *
	 * @param  array $menus  菜单数据
	 */
	private function showTabs( $menus ) {
		
		foreach ( $menus as $menu ) {

			?>
			<li class="tabs-page-menu" data-tabs-menu="<?php echo \esc_attr( $menu['id'] ); ?>">
				<svg class="svg-icon" aria-hidden="true">
					<use xlink:href="#icon-frame-<?php echo \esc_attr( $menu['icon'] ); ?>"></use>
				</svg>
				<span><?php echo \esc_attr( $menu['title'] ); ?></span>
			</li>
			<?php

			foreach ( $menu['links'] as $link ) {

				switch ( $link['type'] ) {

					case 'area': ?>
						<li class="tabs-page-link <?php echo isset( $link['renew'] ) && $link['renew'] === true ? 'renew' : ''; ?>" data-tabs-link="<?php echo \esc_attr( $link['id'] ); ?>" data-tabs-menu="<?php echo \esc_attr( $menu['id'] ); ?>">
							<span><?php echo \esc_attr( $link['title'] ); ?></span>
						</li>
						<?php break;

					case 'page': ?>
						<li class="tabs-page-link" data-tabs-link="<?php echo \esc_attr( $link['id'] ); ?>"  data-tabs-menu="<?php echo \esc_attr( $menu['id'] ); ?>">
							<a href="<?php echo \esc_url( $link['url'] ); ?>" target="_self"><span><?php echo \esc_attr( $link['title'] ); ?></span></a>
						</li>
						<?php break;

					case 'link': ?>
						<li class="tabs-page-link" data-tabs-link="<?php echo \esc_attr( $link['id'] ); ?>"  data-tabs-menu="<?php echo \esc_attr( $menu['id'] ); ?>">
							<a href="<?php echo \esc_url( $link['url'] ); ?>" target="_blank"><span><?php echo \esc_attr( $link['title'] ); ?></span></a>
						</li>
						<?php break;

				}

			}
			
		}

	}

	/**
	 * 显示主内容
	 *
	 * @param  array $areas  区域数据
	 * @param  array $setup  参数设置
	 */
	private function showMain( $areas, $setup ) {
		
		switch ( $setup['show'] ) {

			case 'tabs':
				//* 获取菜单数据
				foreach ( $areas as $area ) {
					if ( isset( $menus ) && is_array( $menus ) ) {
						if ( ! in_array( $area['menu'], $menus ) ) {
							$menus[] = $area['menu'];
						}
					} else {
						$menus[] = $area['menu'];
					}
				}
				//* 输出内容数据
				foreach ( $menus as $menu ) {
					echo '<div class="tabs-page-main" data-tabs-main="' . \esc_attr( $menu ) . '">';
					foreach ( $areas as $area ) {
						if ( $area['menu'] === $menu ) {
							$this->mainArea( $area, $setup );
						}
					}
					echo '</div>';
				}
				break;

			case 'flow':
				foreach ( $areas as $area ) {
					$this->mainArea( $area, $setup );
				}
				break;
			
		}

	}

	/**
	 * 主内容-区域
	 *
	 * @param  array $area   区域数据
	 * @param  array $setup  参数设置
	 */
	private function mainArea( $area, $setup ) {
		
		//* 单元内容
		if ( ! empty( $area['unit'] ) ) {
			$this->mainUnit( $area['unit'], $setup );
			return;
		}
		
		//* 视图内容
		if ( ! empty( $area['view'] ) ) {
			$view = explode( ',', $area['view'] );
			\ZMLFrame\loadView( $setup['path'], $view[0], $view[1] );
			return;
		}
		
		//* TABS内容
		if ( ! empty( $area['tabs'] ) ) {
			global $zmlframe_tabs;
			//* 获取参数
			if ( is_array( $area['tabs'] ) ) {
				$mark = \esc_attr( $area['tabs'][0] );
				$name = \esc_attr( $area['tabs'][1] );
			} else {
				$mark = \esc_attr( $area['menu'] );
				$name = \esc_attr( $area['tabs'] );
			}
			$item = bin2hex( $name );
			//* 存储到全局变量
			if ( ! in_array( $mark, $zmlframe_tabs ) ) {
				array_push( $zmlframe_tabs, $mark );
			}
			echo '<div class="' . \esc_attr( $mark ) . '" data-tabs-item="' . \esc_attr( $item ) . '" data-tabs-name="' . \esc_attr( $name ) . '">';
			$this->mainForm( $area, $setup );
			echo '</div>';
		} else {
			$this->mainForm( $area, $setup );
		}

	}

	/**
	 * 主内容-单元
	 *
	 * @param  string $unit   单元名称
	 * @param  array  $setup  参数设置
	 */
	private function mainUnit( $unit, $setup ) {

		switch ( $unit ) {

			//* 数据单元
			case 'data': ?>
				<div class="content-header">
					<strong>数据备份</strong>
					<span>备份参数设置</span>
				</div>
				<div class="content-body">
					<table class="content-table">
						<tbody>
							<tr>
								<th class="title">设置内容</th>
								<td>
									<div class="area-unit">
										<textarea class="form-input" id="<?php echo \esc_attr( $setup['slug'] ); ?>-backup-show" name="<?php echo \esc_attr( $setup['slug'] ); ?>-backup-show" rows="15" readonly="readonly"><?php echo \esc_attr( $this->safeData( \wp_json_encode( \get_option( $setup['data'] ), JSON_UNESCAPED_UNICODE ), $setup['slug'] ) ); ?></textarea>
										<button class="ajax-button inline data-backup" type="button" id="<?php echo \esc_attr( $setup['slug'] ); ?>-backup-copy" name="<?php echo \esc_attr( $setup['slug'] ); ?>-backup-copy" value="<?php echo \esc_attr( $setup['slug'] ); ?>-backup">复制数据</button>
										<button class="ajax-button inline data-backup" type="button" id="<?php echo \esc_attr( $setup['slug'] ); ?>-backup-down" name="<?php echo \esc_attr( $setup['slug'] ); ?>-backup-down" value="<?php echo \esc_attr( $setup['slug'] ); ?>-backup">下载数据</button>
									</div>
								</td>
							</tr>
							<tr>
								<th class="title">备份方法</th>
								<td>
									<div class="area-unit">
										<label>
											<span>1、点击 “复制数据” 按钮，选项数据自动复制到剪贴板，再将其粘贴到指定位置。<br/>2、点击 “下载数据” 按钮，生成包含日期时间命名的备份文件，并自动下载至本地。<br/>3、不要直接从 “设置内容” 中复制数据，如果必须直接复制，请先刷新当前页面以保证数据一致性。</span>
										</label>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="content-header">
					<strong>数据恢复</strong>
					<span>恢复参数设置</span>
				</div>
				<div class="content-body">
					<table class="content-table">
						<tbody>
							<tr>
								<th class="title">设置内容</th>
								<td>
									<div class="area-unit">
										<textarea class="form-input" id="<?php echo \esc_attr( $setup['slug'] ); ?>-restore-read" name="<?php echo \esc_attr( $setup['slug'] ); ?>-restore-read" rows="15"></textarea>
										<input class="form-input" type="file" id="<?php echo \esc_attr( $setup['slug'] ); ?>-restore-upload" name="<?php echo \esc_attr( $setup['slug'] ); ?>-restore-upload" accept=".dat" style="display:none;"/>
										<button class="ajax-button inline" type="button" id="<?php echo \esc_attr( $setup['slug'] ); ?>-restore-select" name="<?php echo \esc_attr( $setup['slug'] ); ?>-restore-select">上传文件</button>
										<button class="ajax-button inline" type="button" id="<?php echo \esc_attr( $setup['slug'] ); ?>-restore-button" name="<?php echo \esc_attr( $setup['slug'] ); ?>-restore-button" value="<?php echo \esc_attr( $setup['slug'] ); ?>-restore">恢复数据</button>
									</div>
								</td>
							</tr>
							<tr>
								<th class="title">恢复方法</th>
								<td>
									<div class="area-unit">
										<label>
											<span>1、点击 “上传文件” 按钮，选择已备份的文件，文件内容会显示在 “设置内容” 中，然后点击 “恢复数据” 按钮。<br/>2、打开自行保存的内容或自动保存的文件，复制其中内容到 “设置内容” 中，然后点击 “恢复数据” 按钮。<br/>2、注意，请不要更改其中的任何内容，否则会导致数据错误。</span>
										</label>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<?php break;
			
			//* 其他类型
			default: ?>
				<div class="content-header">
					<strong>未定义单元</strong>
					<span></span>
				</div>
				<div class="content-body">
					<table class="content-table">
						<tbody>指定的单元未定义，请检查调用单元时是否存在错误。</tbody>
					</table>
				</div>
				<?php break;

		}

	}
	
	/**
	 * 主内容-表单
	 *
	 * @param  array $area   区域数据
	 * @param  array $setup  参数设置
	 */
	private function mainForm( $area, $setup ) {

		$options = \get_option( $setup['data'] );
		
		//* 表单内容
		if ( ! empty( $area['active'] ) ) {
			?>
			<div class="content-header">
				<label>
					<input class="form-switch action-area-active" type="checkbox" id="<?php echo \esc_attr( $area['active'] ); ?>" name="<?php echo \esc_attr( $area['active'] ); ?>" <?php \checked( $options[$area['active']] ?? false, true ); ?>>
					<strong><?php echo \esc_attr( $area['title'] ); ?></strong>
				</label>
				<span><?php echo \esc_attr( $area['desc'] ); ?></span>
			</div>
			<div class="content-body area-margin" id="<?php echo \esc_attr( $area['active'] ); ?>-margin"></div>
			<div class="content-body area-active" id="<?php echo \esc_attr( $area['active'] ); ?>-active">
				<?php if ( ! empty( $area['fields'] ) ) : ?>
				<table class="content-table">
					<tbody>
						<?php empty( $area['fields'] ) ? null : $this->form->showForm( $area['fields'], $options ); ?>
					</tbody>
				</table>
				<?php endif; ?>
			</div>
			<?php
		} else {
			?>
			<div class="content-header">
				<strong><?php echo \esc_attr( $area['title'] ); ?></strong>
				<span><?php echo \esc_attr( $area['desc'] ); ?></span>
			</div>
			<div class="content-body">
				<table class="content-table">
					<tbody>
						<?php empty( $area['fields'] ) ? null : $this->form->showForm( $area['fields'], $options ); ?>
					</tbody>
				</table>
			</div>
			<?php
		}

	}

	/**
	 * 加载静态文件
	 *
	 */
	public function loadFile() {
		
		\wp_enqueue_media();
		\wp_enqueue_style( 'wp-color-picker' );
		\wp_enqueue_script( 'wp-color-picker' );

		\wp_enqueue_style( 'zml-frame-icon' );
		\wp_enqueue_style( 'zml-frame-form' );
		\wp_enqueue_style( 'zml-frame-view' );
		\wp_enqueue_style( 'zml-frame-info' );
		\wp_enqueue_style( 'zml-frame-page' );

		\wp_enqueue_script( 'zml-frame-icon' );
		\wp_enqueue_script( 'zml-frame-form' );
		\wp_enqueue_script( 'zml-frame-view' );
		\wp_enqueue_script( 'zml-frame-info' );
		\wp_enqueue_script( 'zml-frame-page' );
		
	}

	/**
	 * 保存选项数据
	 *
	 * @param  array $areas  区域数据
	 * @param  array $setup  参数设置
	 */
	public function saveData( $areas, $setup ) {
		
		//* 验证Nonce
		\check_ajax_referer( $setup['slug'], $setup['slug'] . '-nonce' );

		$values = [];
		
		foreach ( $areas as $area ) {
			//* 启用按钮
			if ( ! empty( $area['active'] ) ) {
				$fields = [
					[
						'id'   => $area['active'],
						'type' => 'switch',
					]
				];
				$values = array_merge( $values, $this->form->readValue( $fields ) );
			}
			//* 常规表单
			if ( ! empty( $area['fields'] ) ) {
				$values = array_merge( $values, $this->form->readValue( $area['fields'] ) );
			}
		}
		
		\update_option( $setup['data'], $values );

		\do_action( $setup['slug'] . '-save' );
		
		\flush_rewrite_rules( false );

		echo \wp_json_encode( [
			'state' => 'success',
		] );

		die();
		
	}

	/**
	 * 重置选项数据
	 *
	 * @param  array $areas  区域数据
	 * @param  array $setup  参数设置 
	 */
	public function resetData( $areas, $setup ) {

		//* 验证Nonce
		\check_ajax_referer( $setup['slug'], $setup['slug'] . '-nonce' );

		$values = [];

		foreach ( $areas as $area ) {
			//* 启用按钮
			if ( ! empty( $area['active'] ) ) {
				$values = array_merge( $values, [$area['active'] => false] );
			}
			//* 常规表单
			if ( ! empty( $area['fields'] ) ) {
				$values = array_merge( $values, $this->form->readValue( $area['fields'], 'default' ) );
			}
		}

		\update_option( $setup['data'], $values );

		\do_action( $setup['slug'] . '-reset' );

		\flush_rewrite_rules( false );
		
		echo \wp_json_encode( [
			'state' => 'success',
		] );

		die();
		
	}

	/**
	 * 备份选项数据
	 *
	 * @param  array $setup  参数设置
	 */
	public function backupData( $setup ) {

		//* 验证Nonce
		\check_ajax_referer( $setup['slug'], $setup['slug'] . '-nonce' );

		//* 转换数据
		$data = \get_option( $setup['data'] );
		$data = \wp_json_encode( $data, JSON_UNESCAPED_UNICODE );
		$data = $this->safeData( $data, $setup['slug'] );

		\do_action( $setup['slug'] . '-backup' );
		
		echo \wp_json_encode( [
			'state' => 'success',
			'name'  => $setup['slug'] . '-backup-' . date("Y-md-hi"),
			'value' => $data,
		] );

		die();

	}

	/**
	 * 恢复选项数据
	 *
	 * @param  array $setup  参数设置 
	 */
	public function restoreData( $setup ) {

		//* 验证Nonce
		\check_ajax_referer( $setup['slug'], $setup['slug'] . '-nonce' );

		//* 解析数据
		if ( isset( $_POST[ $setup['slug'] . '-restore-read'] ) ) {
			$data = \sanitize_textarea_field( \wp_unslash( $_POST[ $setup['slug'] . '-restore-read'] ) );
			$data = $this->readData( $data, $setup['slug'] );
			$data = json_decode( $data, true );
			if ( is_array( $data ) ) {
				\update_option( $setup['data'], $data );
				$state = 'success';
			} else {
				$state = 'error';
			}
		} else {
			$state = 'error';
		}

		\do_action( $setup['slug'] . '-restore' );

		\flush_rewrite_rules( false );
		
		echo \wp_json_encode( [
			'state' => $state,
		] );

		die();
		
	}
	
	/**
	 * 安全数据
	 *
	 * @param string $data
	 * @param string $slug
	 *
	 * @return string
	 */
	private function safeData( $data, $slug ) {

		$data = $this->dataNonce( $data, $slug ) . base64_encode( $data );
		$data = str_replace( ['+', '/'], ['-', '_'], $data );

		return $data;

	}

	/**
	 * 读取数据
	 *
	 * @param string $data
	 * @param string $slug
	 *
	 * @return string
	 */
	private function readData( $data, $slug ) {

		$data = str_replace( ['-', '_'], ['+', '/'], $data );
		$safe = substr( $data, 0, 10 );
		$data = base64_decode( substr( $data, 10 ) );
		$data = $data && $this->dataNonce( $data, $slug, $safe ) ? $data : '';
		
		return $data;

	}

	/**
	 * 数据验证
	 *
	 * @param string $data
	 * @param string $slug
	 * @param string $nonce
	 *
	 * @return mixed
	 */
	private function dataNonce( $data, $slug, $nonce = null ) {

		$md5   = substr( md5( $slug . $data ), 12, 10 );
		$nonce = $nonce ? ( $md5 == $nonce ) : $md5;

		return $nonce;

	}

}
