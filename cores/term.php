<?php
/**
 * @package ZMLFrame\Cores
 */

namespace ZMLFrame\Core;

defined( 'ZMLFRAME_PRESENT' ) or die( 'Access Denied' );

/**
 * Class ZMLFrame\Core\Term
 *
 * Term框架
 *
 * @since 1.0.0
 */

class Term {

	private $form;

	public function __construct() {
		
		$this->form = new Form();

	}
	
	/**
	 * 显示添加表单
	 * 
	 * @param  array $setup  参数设置
	 */
	public function showAdd( $setup ) {
		
		echo '<div>' . \esc_html( $setup['title'] ) . '选项内容仅在编辑时可用。</div><br/>';
		
	}
	
	/**
	 * 显示编辑表单
	 *
	 * @param  int   $term_id  TERM_ID
	 * @param  array $areas    区域数据
	 * @param  array $setup    参数设置
	 */
	public function showEdit( $term_id, $areas, $setup ) {
		
		//* 获取当前值
		$values = $this->loadData( $term_id, $areas );
		//* 接受外部值
		if ( ! empty( $setup['values'] ) && is_array( $setup['values'] ) ) {
			foreach ( $setup['values'] as $key => $value ) {
				$values[$key] = $value;
			}			
		}
		
		?>
		<tr>
			<th colspan="2">
				<div class="termbox">
					<div class="termbox-header"><h2><?php echo \esc_html( $setup['title'] ); ?></h2></div>
					<div class="termbox-wrap">
						<div class="content-body">
							<div class="<?php echo( $setup['show'] === 'tabs' ? 'action-term-tabs' : ''  ) ?>">
								<?php switch ( $setup['show'] ) {
									//* 选项卡布局
									case 'tabs': ?>
										<div class="content-aside">
											<ul class="content-tabs">
												<?php foreach ( $areas as $area ) : ?>
												<li class="tabs-term-link" data-tabs-link="<?php echo \esc_attr( $area['id'] ); ?>">
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
											<div class="tabs-term-main" data-tabs-main="<?php echo \esc_attr( $area['id'] ); ?>">
												<table class="content-table">
													<tbody>
														<?php $this->form->showForm( $area['fields'], $values ); ?>
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
													<?php $this->form->showForm( $area['fields'], $values ); ?>
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
													<?php $this->form->showForm( $area['fields'], $values ); ?>
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
				</div>
			</th>
		</tr>
		<?php

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
		\wp_enqueue_style( 'zml-frame-term' );

		\wp_enqueue_script( 'zml-frame-icon' );
		\wp_enqueue_script( 'zml-frame-form' );
		\wp_enqueue_script( 'zml-frame-view' );
		\wp_enqueue_script( 'zml-frame-info' );
		\wp_enqueue_script( 'zml-frame-term' );

	}
	
	/**
	 * 加载选项数据
	 *
	 * @param  int   $term_id  TERM ID
	 * @param  array $fields   表单数据
	 * 
	 * @return array
	 */
	private function loadData( $term_id, $areas ) {

		$values = [];
		$fields = [];
		
		foreach ( $areas as $area ) {
			$fields = array_merge( $fields, $this->form->readField( $area['fields'] ) );
		}
		foreach ( $fields as $field ) {
			$values = array_merge( $values, [$field['id'] => \get_term_meta( $term_id, '_' . $field['id'], true )] );
		}
		
		return $values;

	}
	
	/**
	 * 保存选项数据
	 * 
	 * @param  int   $term_id  TERM ID
	 * @param  array $fields   表单数据
	 * @param  array $setup    参数设置
	 */
	public function saveData( $term_id, $areas, $setup ) {

		//* 编辑状态提交才处理
		if ( isset( $_POST[$setup['slug'] . '-check'] ) ) {

			//* 验证Nonce
			\check_admin_referer( $setup['slug'], $setup['slug'] . '-nonce' );
			
			//* 已保存数据
			$legacy = $this->loadData( $term_id, $areas );
			//* 更新数据
			foreach ( $areas as $area ) {
				$fields = $this->form->readField( $area['fields'] );
				$values = $this->form->readValue( $area['fields'] );
				foreach ( $fields as $field ) {
					if ( isset( $values[$field['id']] ) ) {
						if ( empty( $values[$field['id']] ) && $legacy[$field['id']] ) {
							//* 数据变为空就删除
							\delete_term_meta( $term_id, '_' . $field['id'] );
						} elseif ( $values[$field['id']] !== $legacy[$field['id']] ) {
							//* 数据有变化就更新
							\update_term_meta( $term_id,  '_' . $field['id'], $values[$field['id']] );
						}
					}
				}
			}

		}

	}

}
