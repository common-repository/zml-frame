<?php
/**
 * @package ZMLFrame\Cores
 */

namespace ZMLFrame\Core;

defined( 'ZMLFRAME_PRESENT' ) or die( 'Access Denied' );

/**
 * Class ZMLFrame\Core\Meta
 *
 * Metabox框架
 *
 * @since 1.0.0
 */

class Meta {

	private $form;

	public function __construct() {

		$this->form = new Form();

	}

	/**
	 * 显示METABOX
	 *
	 * @param  int   $post_id  POST_ID
	 * @param  array $areas    区域数据
	 * @param  array $setup    参数设置
	 */
	public function showMeta( $post_id, $areas, $setup ) {

		//* 获取当前值
		$values = $this->loadData( $post_id, $areas, $setup );
		//* 接受外部值
		if ( ! empty( $setup['values'] ) ) {
			foreach ( $setup['values'] as $key => $value ) {
				$values[$key] = $value;
			}			
		}

		?>
		<div class="metabox-wrap">
			<?php if ( ! empty( $setup['active'] ) ) : ?>
			<div class="content-header">
				<label>
					<input class="form-switch-small action-meta-active" type="checkbox" id="<?php echo \esc_attr( $setup['active'] ); ?>" name="<?php echo \esc_attr( $setup['active'] ); ?>" <?php \checked( $values[$setup['active']], true ); ?>>
					<span>启用/关闭当前功能</span>
				<label>
			</div>
			<?php endif; ?>
			<div class="content-body meta-active active" id="<?php echo \esc_attr( isset( $setup['active'] ) ? $setup['active'] : '' ); ?>-active">
				<div class="<?php echo $setup['show'] === 'tabs' ? 'action-meta-tabs' : ''; ?>">
					<?php switch ( $setup['show'] ) {
						//* 选项卡布局
						case 'tabs': ?>
							<div class="content-aside">
								<ul class="content-tabs">
									<?php foreach ( $areas as $area ) : ?>
									<li class="tabs-meta-link" data-tabs-link="<?php echo \esc_attr( $area['id'] ); ?>">
										<svg class="svg-icon" aria-hidden="true">
											<use xlink:href="#icon-frame-<?php echo \esc_attr( $area['icon'] ); ?>"></use>
										</svg>
										<?php echo \esc_attr( $area['title'] ); ?>
									</li>
									<?php endforeach; ?>
								</ul>
							</div>
							<div class="content-main">
								<?php foreach ( $areas as $area ) : ?>
								<div class="tabs-meta-main" data-tabs-main="<?php echo \esc_attr( $area['id'] ); ?>">
									<table class="content-table">
										<tbody>
											<?php $this->metaMain( $area, $values ); ?>
										</tbody>
									</table>
								</div>
								<?php endforeach; ?>
							</div>
							<?php break;
						//* 流布局
						case 'flow': ?>
							<div class="content-main">
								<?php foreach ( $areas as $area ) : ?>
								<?php if ( ! empty( $area['title'] ) ) : ?>
								<div class="content-name">
									<span><?php echo \esc_attr( $area['title'] ); ?></span>
								</div>
								<?php endif; ?>
								<table class="content-table">
									<tbody>
										<?php $this->metaMain( $area, $values ); ?>
									</tbody>
								</table>
								<?php endforeach; ?>
							</div>
							<?php break;
						//* 精简布局
						case 'lite': ?>
							<div class="content-main">
								<table class="content-table">
									<?php foreach ( $areas as $area ) : ?>
									<tbody>
										<?php $this->metaMain( $area, $values ); ?>
									</tbody>
									<?php endforeach; ?>
								</table>
							</div>
							<?php break;
					} ?>
					<input type="hidden" id="<?php echo \esc_attr( $setup['slug'] . '-check' ); ?>" name="<?php echo \esc_attr( $setup['slug'] . '-check' ); ?>" value=""/>
					<?php \wp_nonce_field(  $setup['slug'],  $setup['slug'] . '-nonce' ); ?>
				</div>
			</div>
		</div>
		<?php

	}

	/**
	 * 显示STICKYBOX
	 *
	 * @param  string $text  显示文本
	 */
	public function showSticky( $text = '置顶' ) {

		?>
		<div>
			<p>
				<span>&nbsp;&nbsp;</span>
				<input id="sticky" name="sticky" type="checkbox" value="sticky" <?php \checked( \is_sticky() ); ?> />
				<label for="sticky" class="selectit"><?php echo \esc_html( $text ); ?></label>
			</p>
		</div>
		<?php

	}
	
	/**
	 * 显示主内容
	 *
	 * @param  array $area    区域数据
	 * @param  array $values  值数据
	 * 
	 * @return array
	 */
	private function metaMain( $area, $values ) {

		//* 视图内容
		if ( ! empty( $area['view'] ) ) {
			$view = explode( ',', $area['view'] );
			\ZMLFrame\loadView( $view[0], $view[1] );
		}

		//* 表单内容
		if ( ! empty( $area['fields'] ) ) {
			$this->form->showForm( $area['fields'], $values );
		}

	}

	/**
	 * 加载静态文件
	 */
	public function loadFile() {

		\wp_enqueue_media();
		\wp_enqueue_style( 'wp-color-picker' );
		\wp_enqueue_script( 'wp-color-picker' );

		\wp_enqueue_style( 'zml-frame-icon' );
		\wp_enqueue_style( 'zml-frame-form' );
		\wp_enqueue_style( 'zml-frame-view' );
		\wp_enqueue_style( 'zml-frame-info' );
		\wp_enqueue_style( 'zml-frame-meta' );

		\wp_enqueue_script( 'zml-frame-icon' );
		\wp_enqueue_script( 'zml-frame-form' );
		\wp_enqueue_script( 'zml-frame-view' );
		\wp_enqueue_script( 'zml-frame-info' );
		\wp_enqueue_script( 'zml-frame-meta' );

	}
	
	/**
	 * 加载选项数据
	 *
	 * @param  int   $post_id  POST_ID
	 * @param  array $areas    区域数据
	 * @param  array $setup    参数设置
	 * 
	 * @return array
	 */
	private function loadData( $post_id, $areas, $setup ) {

		$values = [];
		$fields = [];

		//* 启用按钮
		if ( ! empty( $setup['active'] ) ) {
			$values = array_merge( $values, [$setup['active'] => \get_post_meta( $post_id, '_' . $setup['active'], true )] );
		}
		//* 表单内容	
		foreach ( $areas as $area ) {
			$fields = array_merge( $fields, $this->form->readField( $area['fields'] ) );
		}
		foreach ( $fields as $field ) {
			$values = array_merge( $values, [$field['id'] => \get_post_meta( $post_id, '_' . $field['id'], true )] );
		}

		return $values;

	}
	
	/**
	 * 保存选项数据
	 *
	 * @param  int   $post_id  POST_ID
	 * @param  array $areas    区域数据
	 * @param  array $setup    参数设置
	 */
	public function saveData( $post_id, $areas, $setup ) {
		
		//* 检查类型
		if ( ! isset( $_POST['post_type'] ) ) {
			return;
		}

		//* 检查新添加
		if ( ! isset( $_POST[($setup['slug'].'-check')] ) ) {
			return;
		}
		
		//* 检查提前提交
		if ( ! \get_permalink( $post_id ) ) {
			return;
		}
		
		//* 检查自动保存
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		
		//* 检查是否版本
		if ( \wp_is_post_revision( $post_id ) ) {
			return;
		}
		
		//* 验证权限
		if ( $_POST['post_type'] === 'page' ) {
			if ( ! \current_user_can( 'edit_page', $post_id) ) {
				return;
			}
		} elseif ( ! \current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
		
		//* 验证Nonce
		\check_admin_referer( $setup['slug'],  $setup['slug'] . '-nonce' );
		
		//* 更新状态
		if ( ! empty( $setup['active'] ) ) {
			if ( isset( $_POST[$setup['active']] ) && \sanitize_text_field( \wp_unslash( $_POST[$setup['active']] ) ) === 'on' ) {
				\update_post_meta( $post_id, '_' . $setup['active'], true );
				$status = 'update';
			} else {
				\delete_post_meta( $post_id, '_' . $setup['active'] );
				$status = 'delete';
			}
		} else {
			$status = 'update';
		}

		//* 更新数据
		if ( $status === 'update' ) {
			$legacy = $this->loadData( $post_id, $areas, $setup );
			foreach ( $areas as $area ) {
				$fields = $this->form->readField( $area['fields'] );
				$values = $this->form->readValue( $area['fields'] );
				foreach ( $fields as $field ) {
					if ( isset( $values[$field['id']] ) ) {
						if ( empty( $values[$field['id']] ) && $legacy[$field['id']] ) {
							//* 数据变为空就删除
							\delete_post_meta( $post_id, '_' . $field['id'] );
						} elseif ( $values[$field['id']] !== $legacy[$field['id']] ) {
							//* 数据有变化就更新
							\update_post_meta( $post_id,  '_' . $field['id'], $values[$field['id']] );
						}
					}
				}
			}
		}

		//* 删除数据
		if ( $status === 'delete' ) {
			foreach ( $areas as $area ) {
				$fields = $this->form->readField( $area['fields'] );
				foreach ( $fields as $field ) {
					\delete_post_meta( $post_id, '_' . $field['id'] );
				}
				
			}
		}
	
	}

}
