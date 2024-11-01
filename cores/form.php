<?php
/**
 * @package ZMLFrame\Cores
 */

namespace ZMLFrame\Core;

defined( 'ZMLFRAME_PRESENT' ) or die( 'Access Denied' );

/**
 * Class ZMLFrame\Core\Form
 *
 * 表单框架
 *
 * @since 1.0.0
 */

class Form {

	private $types;

	public function __construct() {

		$this->types = [
			'text',
			'password',
			'number',
			'select',
			'radio',
			'checkbox',
			'textarea',
			'htmlarea',
			'editor',
			'switch',
			'ajax',
			'itags',
			'stags',
			'upload',
			'color',
			'cradio',
			'tradio',
			'iradio',
			'panel',
		];

	}

	/**
	 * 显示表单内容
	 *
	 * @param  array $fields  表单数据
	 * @param  array $values  值数据
	 */
	public function showForm( $fields, $values = [] ) {

		foreach ( $fields as $field ) {
			
			switch ( $field['type'] ) {
					
				//* 组区域
				case 'group': ?>
					<tr class="group">
						<th class="title"><?php echo \esc_html( $field['title'] ); ?></th>
						<td>
							<?php foreach ( $field['fields'] as $group_field ) : ?>
							<div class="area-group">
								<span><?php echo \esc_html( $group_field['type'] === 'switch' ? '' : $group_field['title'] ); ?></span>
								<?php $value = $this->formValue( $group_field, $values ); ?>
								<?php $this->formField( $group_field, $value ); ?>
							</div>
							<?php endforeach; ?>
						</td>
					</tr>
					<?php break;
				
				//* 块区域
				case 'block': ?>
					<tr class="block">
						<th></th>
						<td>
							<div class="area-block">
							<?php foreach ( $field['fields'] as $block_field ) : ?>
								<?php $value = $this->formValue( $block_field, $values ); ?>
								<?php $this->formField( $block_field, $value ); ?>
								<?php endforeach; ?>
							</div>
						</td>
					</tr>
					<?php break;

				//* 选项卡区域
				case 'tabs': ?>
					<tr class="tabs">
						<th class="tabs"></th>
						<td class="tabs">
							<div class="action-body-tabs">
								<div class="inside-aside">
									<ul class="inside-tabs">
										<?php foreach ( $field['tabs'] as $key => $text ) : ?>
										<li class="tabs-body-link" data-tabs-link="<?php echo \esc_attr( $key ); ?>"><?php echo \esc_html( $text ); ?></li>
										<?php endforeach; ?>
									</ul>
								</div>
								<div class="inside-main">
									<?php $i = 0; foreach ( $field['tabs'] as $key => $text ) : ?>
									<div class="tabs-body-main" data-tabs-main="<?php echo \esc_attr( $key ); ?>">
										<table class="content-table">
											<tbody>
												<?php foreach ( $field['fields'][$i] as $tabs_field ) : ?>
												<tr>
													<th class="title"><?php echo \esc_html( $tabs_field['title'] ); ?></th>
													<td>
														<?php $value = $this->formValue( $tabs_field, $values ); ?>
														<?php $this->formField( $tabs_field, $value ); ?>
													</td>
												</tr>
												<?php endforeach; ?>
											</tbody>
										</table>
									</div>
									<?php $i++; endforeach; ?>
								</div>
							</div>
						</td>
					</tr>
					<?php break;
					
				//* 表单
				default: ?>
					<tr>
						<th class="title">
							<?php echo \esc_html( $field['title'] ); ?>
							<?php if ( isset( $field['score'] ) && $field['score'] === true ) : ?>
							<div class="area-score"><p class="score-tips"></p><div class="score-line"><div class="score-fill"></div></div></div>
							<?php endif; ?>
						</th>
						<td>
							<?php $value = $this->formValue( $field, $values ); ?>
							<?php $this->formField( $field, $value ); ?>
						</td>
					</tr>
					<?php break;

			}

		}

	}

	/**
	 * 获取表单值
	 *
	 * @param  array $field   字段数据
	 * @param  array $values  值数据
	 *
	 * @return mixed
	 */
	private function formValue( $field, $values ) {

		if ( isset( $values[$field['id']] ) ) {
			$value = $values[$field['id']];
		} else {
			$value = isset( $field['default'] ) ? $field['default'] : '';
		}

		return $value;

	}

	/**
	 * 显示表单字段
	 *
	 * @param  array $field  字段数据
	 * @param  mixed $value  值数据
	 */
	private function formField( $field, $value ) {

		//* 防止未设置产生错误
		$field['desc']  = $field['desc'] ?? '';
		$field['place'] = $field['place'] ?? '';

		//* 表单隐藏
		if ( ! empty( $field['hidden'] ) ) {
			?>
			<div class="area-switch form-hidden">
				<label>
					<input class="form-switch-small action-form-hidden" type="checkbox" id="<?php echo \esc_attr( $field['id'] . '-hidden' ); ?>" name="<?php echo \esc_attr( $field['id'] . '-hidden' ); ?>" <?php \checked( $value ? false : true, true ); ?>>
					<span class="desc"><?php echo \esc_html( $field['hidden'] ); ?></span>
				</label>
			</div>
			<div id="<?php echo \esc_attr( $field['id'] . '-hidden-form' ); ?>">
			<?php
		}

		//* 表单内容
		switch ( $field['type'] ) {

			//* 文本框
			case 'text': ?>
				<?php if ( isset( $field['score'] ) && $field['score'] === true ) : ?>
				<div class="area-input">
					<input class="form-input action-view-score" type="text" id="<?php echo \esc_attr( $field['id'] ); ?>" name="<?php echo \esc_attr( $field['id'] ); ?>" data-min="<?php echo \esc_attr( $field['min'] ); ?>" data-max="<?php echo \esc_attr( $field['max'] ); ?>" placeholder="<?php echo \esc_attr( $field['place'] ); ?>" value="<?php echo \esc_attr( $value ); ?>"/>
				</div>
				<p class="desc"><?php echo $field['desc'] ? \wp_kses_post( $field['desc'] ) : ''; ?>&nbsp;</p>
				<?php else : ?>
				<div class="area-input">
					<input class="form-input" type="text" autocomplete="off" id="<?php echo \esc_attr( $field['id'] ); ?>" name="<?php echo \esc_attr( $field['id'] ); ?>" placeholder="<?php echo \esc_attr( $field['place'] ); ?>" value="<?php echo \esc_attr( $value ); ?>"/>
				</div>
				<?php echo $field['desc'] ? '<p class="desc">' . \wp_kses_post( $field['desc'] ) . '</p>' : ''; ?>
				<?php endif; ?>
				<?php break;

			//* 密码文本框
			case 'password': ?>
				<div class="area-input">
					<input class="form-input" type="password" autocomplete="off" id="<?php echo \esc_attr( $field['id'] ); ?>" name="<?php echo \esc_attr( $field['id'] ); ?>" placeholder="<?php echo \esc_attr( $field['place'] ); ?>" value="<?php echo \esc_attr( $value ); ?>"/>
				</div>
				<?php echo $field['desc'] ? '<p class="desc">' . \wp_kses_post( $field['desc'] ) . '</p>' : ''; ?>
				<?php break;

			//* 数字输入框
			case 'number': ?>
				<div class="area-number">
					<input class="form-number" type="number" id="<?php echo \esc_attr( $field['id'] ); ?>" name="<?php echo \esc_attr( $field['id'] ); ?>" step="<?php echo \esc_attr( isset( $field['step'] ) ? $field['step'] : 1 ); ?>" min="<?php echo \esc_attr( isset( $field['min'] ) ? $field['min'] : 0 ); ?>" max="<?php echo \esc_attr( isset( $field['max'] ) ? $field['max'] : '' ); ?>" placeholder="<?php echo \esc_attr( $field['place'] ); ?>" value="<?php echo \esc_attr( $value ); ?>"/>
					<?php if ( ! empty( $field['unit'] ) ) : ?>
					<span><?php echo \esc_html( $field['unit'] ); ?></span>
					<?php endif; ?>
				</div>
				<?php echo $field['desc'] ? '<p class="desc">' . \wp_kses_post( $field['desc'] ) . '</p>' : ''; ?>
				<?php break;

			//* 下拉框
			case 'select': ?>
				<div class="area-select">
					<select class="form-select <?php echo isset( $field['image'] ) && $field['image'] === true ? 'action-view-select' : '';?>" id="<?php echo \esc_attr( $field['id'] ); ?>" name="<?php echo \esc_attr( $field['id'] ); ?>">
					<?php foreach ( $field['option'] as $key => $text ) : ?>
						<?php if ( is_array( $text ) ) : ?>
						<optgroup label="<?php echo \esc_attr( $key ); ?>">
							<?php foreach ( $text as $key => $text ) : ?>
							<option value="<?php echo \esc_attr( $key ); ?>" <?php \selected( $value, $key ); ?>><?php echo \esc_html( $text ); ?></option>
							<?php endforeach; ?>
						</optgroup>
						<?php else : ?>
						<option value="<?php echo \esc_attr( $key ); ?>" <?php \selected( $value, $key ); ?>><?php echo \esc_html( $text ); ?></option>
						<?php endif; ?>
					<?php endforeach; ?>
					</select>
				</div>
				<?php if ( isset( $field['image'] ) && $field['image'] === true ) : ?>
				<div class="area-image">
					<img class="image-view" id="<?php echo \esc_attr( $field['id'] ); ?>-image" name="<?php echo \esc_attr( $field['id'] ); ?>-image"  data-path="<?php echo \esc_attr( $field['path'] ); ?>" data-ext="<?php echo \esc_attr( $field['ext'] ); ?>" src="">
				</div>
				<?php endif; ?>
				<?php echo $field['desc'] ? '<p class="desc">' . \wp_kses_post( $field['desc'] ) . '</p>' : ''; ?>
				<?php break;

			//* 单选框
			case 'radio': ?>
				<div class="area-radio">
					<?php foreach ( $field['option'] as $key => $text ) : ?>
					<label>
						<input class="form-radio" type="radio" id="<?php echo \esc_attr( $field['id'] . '-' . $key ); ?>" name="<?php echo \esc_attr( $field['id'] ); ?>" value="<?php echo \esc_attr( $key ); ?>" <?php \checked( $value, $key ); ?>>
						<span><?php echo \esc_html( $text ); ?></span>
					</label>
					<?php endforeach; ?>
				</div>
				<?php echo $field['desc'] ? '<p class="desc">' . \wp_kses_post( $field['desc'] ) . '</p>' : ''; ?>
				<?php break;

			//* 复选框
			case 'checkbox': ?>
				<div class="area-check">
					<?php foreach ( $field['option'] as $key => $text ) : ?>
					<label>
						<input class="form-check" type="checkbox" id="<?php echo \esc_attr( $field['id'] . '-' . $key ) ?>" name="<?php echo \esc_attr( $field['id'] . '-' . $key ); ?>" <?php \checked( in_array( $key, is_array( $value ) ? $value : [] ), true ); ?>>
						<span><?php echo \esc_html( $text ); ?></span>
					</label>
					<?php endforeach; ?>
				</div>
				<?php echo $field['desc'] ? '<p class="desc">' . \wp_kses_post( $field['desc'] ) . '</p>' : ''; ?>
				<?php break;

			//* 文本域
			case 'textarea': ?>
				<div class="area-input">
					<?php if ( isset( $field['score'] ) && $field['score'] === true ) : ?>
					<textarea class="form-input action-view-score" id="<?php echo \esc_attr( $field['id'] ); ?>" name="<?php echo \esc_attr( $field['id'] ); ?>" rows="<?php echo \esc_attr( ! empty( $field['rows'] ) ? $field['rows'] : '6' ); ?>" data-min="<?php echo \esc_attr( $field['min'] ); ?>" data-max="<?php echo \esc_attr( $field['max'] ); ?>" placeholder="<?php echo \esc_attr( $field['place'] ); ?>"><?php echo \esc_textarea( $value ); ?></textarea>
					<?php else : ?>
					<textarea class="form-input" id="<?php echo \esc_attr( $field['id'] ); ?>" name="<?php echo \esc_attr( $field['id'] ); ?>" rows="<?php echo \esc_attr( ! empty( $field['rows'] ) ? $field['rows'] : '6' ); ?>" placeholder="<?php echo \esc_attr( $field['place'] ); ?>"><?php echo \esc_textarea( $value ); ?></textarea>
					<?php endif; ?>
				</div>
				<?php echo $field['desc'] ? '<p class="desc">' . \wp_kses_post( $field['desc'] ) . '</p>' : ''; ?>
				<?php break;

			//* HTML域
			case 'htmlarea': ?>
				<div class="area-input">
					<textarea class="form-input html-input" id="<?php echo \esc_attr( $field['id'] ); ?>" name="<?php echo \esc_attr( $field['id'] ); ?>" rows="<?php echo \esc_attr( ! empty( $field['rows'] ) ? $field['rows'] : '15' ); ?>" placeholder="<?php echo \esc_attr( $field['place'] ); ?>"><?php echo htmlspecialchars_decode( $value, ENT_QUOTES ); ?></textarea>
				</div>
				<?php echo $field['desc'] ? '<p class="desc">' . \wp_kses_post( $field['desc'] ) . '</p>' : ''; ?>
				<?php break;
			
			//* 编辑器
			case 'editor': ?>
				<div class="area-input">
					<?php
					$editor = [
						'textarea_name' => $field['id'],
						'textarea_rows' => ! empty( $field['rows'] ) ? \esc_attr( $field['rows'] ) : 15,
						'media_buttons' => false,
						'quicktags'     => false,
						'teeny'         => true,
					];
					if ( ! empty( $field['mode'] ) ) {
						switch ( $field['mode']  ) {
							case 'full':
								$editor['media_buttons'] = true;
								$editor['quicktags'] = true;
								$editor['teeny'] = false;
								break;
							case 'base':
								$editor['media_buttons'] = false;
								$editor['quicktags'] = false;
								$editor['teeny'] = false;
								break;
						}
					}
					\wp_editor( $value, $field['id'], $editor );
					?>
				</div>
				<?php echo $field['desc'] ? '<p class="desc">' . \wp_kses_post( $field['desc'] ) . '</p>' : ''; ?>
				<?php break;
			
			//* 切换按钮
			case 'switch': ?>
				<div class="area-switch">
					<label>
						<input class="form-switch-small" type="checkbox" id="<?php echo \esc_attr( $field['id'] ); ?>" name="<?php echo \esc_attr( $field['id'] ); ?>" <?php \checked( $value, true ); ?>>
						<span class="desc"><?php echo isset( $field['indent'] ) && $field['indent'] === true ? \esc_html( $field['title'] ) : \wp_kses_post( $field['desc'] ); ?></span>
					</label>
				</div>
				<?php echo isset( $field['indent'] ) && $field['indent'] === true && $field['desc'] ? '<p class="desc">' . \wp_kses_post( $field['desc'] ) . '</p>' : ''; ?>
				<?php break;

			//* AJAX交互
			case 'ajax': ?>
				<div class="area-ajax">
					<input class="form-input" type="text" id="<?php echo \esc_attr( $field['id'] ); ?>" name="<?php echo \esc_attr( $field['id'] ); ?>" placeholder="<?php echo \esc_attr( $field['place'] ); ?>" value="<?php echo \esc_attr( $value ); ?>"/>
					<button class="form-button" type="button" id="<?php echo \esc_attr( $field['id'] ); ?>-button" name="<?php echo \esc_attr( $field['id'] ); ?>-button" value="<?php echo \esc_attr( $field['action'] ); ?>">
						<svg class="svg-icon" aria-hidden="true"><use xlink:href="#icon-frame-ajax"></use></svg>
						<?php if ( isset( $field['button'] ) ) : ?>
						<span><?php echo \esc_html( $field['button'] ); ?></span>
						<?php endif; ?>
					</button>
				</div>
				<?php echo $field['desc'] ? '<p class="desc">' . \wp_kses_post( $field['desc'] ) . '</p>' : ''; ?>
				<?php break;

			//* 输入标签
			case 'itags': ?>
				<div class="area-tags">
					<div class="input-tags">
						<div class="tag-front <?php echo( isset( $field['line'] ) && $field['line'] === true ? 'list-line' : 'list-tags' ); ?>" id="<?php echo \esc_attr( $field['id'] ); ?>-front" name="<?php echo \esc_attr( $field['id'] ); ?>-front"></div>
							<div class="tag-form"><input class="form-input tag-input" type="text" id="<?php echo \esc_attr( $field['id'] ); ?>-input" name="<?php echo \esc_attr( $field['id'] ); ?>-input" value="" placeholder="<?php echo \esc_attr( $field['place'] ); ?>"/>
							<button class="form-button <?php echo( isset( $field['upload'] ) && $field['upload'] === true ? 'main-button' : '' ); ?>" type="button" id="<?php echo \esc_attr( $field['id'] ); ?>-submit" name="<?php echo \esc_attr( $field['id'] ); ?>-submit">
								<svg class="svg-icon" aria-hidden="true"><use xlink:href="#icon-frame-add"></use></svg>
								<?php if ( isset( $field['button'] ) ) : ?>
								<span><?php echo \esc_html( $field['button'] ); ?></span>
								<?php endif; ?>
							</button>
							<?php if ( isset( $field['upload'] ) && $field['upload'] === true ) : ?>
							<button class="form-button icon-button" type="button" id="<?php echo \esc_attr( $field['id'] ); ?>-upload" name="<?php echo \esc_attr( $field['id'] ); ?>-upload">
								<svg class="svg-icon" aria-hidden="true"><use xlink:href="#icon-frame-upload"></use></svg>
							</button>
							<?php endif; ?>
						</div>
					</div>
					<input class="form-input action-input-tags" type="text" id="<?php echo \esc_attr( $field['id'] ); ?>" name="<?php echo \esc_attr( $field['id'] ); ?>" placeholder="<?php echo \esc_attr( $field['place'] ); ?>" value="<?php echo \esc_attr( $value ); ?>"/>
				</div>
				<?php echo $field['desc'] ? '<p class="desc">' . \wp_kses_post( $field['desc'] ) . '</p>' : ''; ?>
				<?php break;

			//* 选择标签
			case 'stags': ?>
				<div class="area-tags">
					<div class="select-tags">
						<div class="tag-front <?php echo( isset( $field['multi'] ) && $field['multi'] === true ? 'multi-line' : '' ); ?>" contenteditable="true" id="<?php echo \esc_attr( $field['id'] ); ?>-front" name="<?php echo \esc_attr( $field['id'] ); ?>-front"></div>
						<select class="form-select" id="<?php echo \esc_attr( $field['id'] ); ?>-input" name="<?php echo \esc_attr( $field['id'] ); ?>-input">
							<option selected hidden disabled value=""><?php echo \esc_html( ! empty( $field['prompt'] ) ? $field['prompt'] : '插入标签' ); ?></option>
							<?php foreach ( $field['option'] as $key => $text ) : ?>
								<?php if ( is_array( $text ) ) : ?>
								<optgroup label="<?php echo \esc_attr( $key ); ?>">
									<?php foreach ( $text as $key => $text ) : ?>
									<option value="<?php echo \esc_attr( $key ); ?>" <?php \selected( $value, $key ); ?>><?php echo \esc_html( $text ); ?></option>
									<?php endforeach; ?>
								</optgroup>
								<?php else : ?>
								<option value="<?php echo \esc_attr( $key ); ?>" <?php \selected( $value, $key ); ?>><?php echo \esc_html( $text ); ?></option>
								<?php endif; ?>
							<?php endforeach; ?>
						</select>
					</div>
					<input class="form-input action-select-tags" type="text" id="<?php echo \esc_attr( $field['id'] ); ?>" name="<?php echo \esc_attr( $field['id'] ); ?>" value="<?php echo \esc_attr( $value ); ?>"/>
				</div>
				<?php echo $field['desc'] ? '<p class="desc">' . \wp_kses_post( $field['desc'] ) . '</p>' : ''; ?>
				<?php break;
				
			//* 文件上传
			case 'upload': ?>
				<div class="area-upload">
					<input class="form-input action-file-upload" type="text" id="<?php echo \esc_attr( $field['id'] ); ?>" name="<?php echo \esc_attr( $field['id'] ); ?>" placeholder="<?php echo \esc_attr( $field['place'] ); ?>" value="<?php echo \esc_url( $value ); ?>"/>
					<button class="form-button main-button" type="button" id="<?php echo \esc_attr( $field['id'] ); ?>-upload" name="<?php echo \esc_attr( $field['id'] ); ?>-upload">
						<svg class="svg-icon" aria-hidden="true"><use xlink:href="#icon-frame-upload"></use></svg>
						<?php if ( isset( $field['button'] ) ) : ?>
						<span><?php echo \esc_html( $field['button'] ); ?></span>
						<?php endif; ?>
					</button>
					<button class="form-button icon-button" type="button" id="<?php echo \esc_attr( $field['id'] ); ?>-delete" name="<?php echo \esc_attr( $field['id'] ); ?>-delete">
						<svg class="svg-icon" aria-hidden="true"><use xlink:href="#icon-frame-delete"></use></svg>
					</button>
				</div>
				<?php if ( isset( $field['image'] ) && $field['image'] === true ) : ?>
				<div class="area-image">
					<img class="image-view" id="<?php echo \esc_attr( $field['id'] ); ?>-image" name="<?php echo \esc_attr( $field['id'] ); ?>-image" src="">
				</div>
				<?php endif; ?>
				<?php echo $field['desc'] ? '<p class="desc">' . \wp_kses_post( $field['desc'] ) . '</p>' : ''; ?>
				<?php break;
				
			//* 颜色选择
			case 'color': ?>
				<div class="area-color">
					<input class="form-color action-color-picker" type="text" id="<?php echo \esc_attr( $field['id'] ); ?>" name="<?php echo \esc_attr( $field['id'] ); ?>" value="<?php echo \esc_attr( $value ); ?>"/>
				</div>
				<?php echo $field['desc'] ? '<p class="desc">' . \wp_kses_post( $field['desc'] ) . '</p>' : ''; ?>
				<?php break;

			//* 颜色单选框
			case 'cradio': ?>
				<div class="area-cradio">
					<?php foreach ( $field['option'] as $key => $text ) : ?>
					<label>
						<input class="form-cradio action-color-radio" type="radio" id="<?php echo \esc_attr( $field['id'] . '-' . $key ); ?>" name="<?php echo \esc_attr( $field['id'] ); ?>" value="<?php echo \esc_attr( $key ); ?>" <?php \checked( $value, $key ); ?>>
						<span style="background-color:<?php echo \esc_attr( $key ); ?>"></span>
					</label>
					<?php endforeach; ?>
				</div>
				<?php echo $field['desc'] ? '<p class="desc">' . \wp_kses_post( $field['desc'] ) . '</p>' : ''; ?>
				<?php break;

			//* 文本单选框
			case 'tradio': ?>
				<div class="area-tradio">
					<?php foreach ( $field['option'] as $key => $text ) : ?>
					<label>
						<input class="form-tradio action-text-radio" type="radio" id="<?php echo \esc_attr( $field['id'] . '-' . $key ); ?>" name="<?php echo \esc_attr( $field['id'] ); ?>" value="<?php echo \esc_attr( $key ); ?>" <?php \checked( $value, $key ); ?>>
						<span><?php echo \esc_html( $text ); ?></span>
					</label>
					<?php endforeach; ?>
				</div>
				<?php echo $field['desc'] ? '<p class="desc">' . \wp_kses_post( $field['desc'] ) . '</p>' : ''; ?>
				<?php break;

			//* 图片单选框
			case 'iradio': ?>
				<div class="area-iradio">
					<?php foreach ( $field['option'] as $key => $text ) : ?>
					<label>
						<input class="form-iradio action-image-radio" type="radio" id="<?php echo \esc_attr( $field['id'] . '-' . $key ); ?>" name="<?php echo \esc_attr( $field['id'] ); ?>" value="<?php echo \esc_attr( $key ); ?>" <?php \checked( $value, $key ); ?>>
						<span><img src="<?php echo \esc_url( $text ); ?>"/></span>
					</label>
					<?php endforeach; ?>
				</div>
				<?php echo $field['desc'] ? '<p class="desc">' . \wp_kses_post( $field['desc'] ) . '</p>' : ''; ?>
				<?php break;

			//* 功能面板
			case 'panel': ?>
				<div class="area-panel">
					<div class="icon">
						<svg class="svg-icon" aria-hidden="true">
							<use xlink:href="#<?php echo \esc_attr( ! empty( $field['icon'] ) ? $field['icon'] : 'icon-frame-panel' ); ?>"></use>
						</svg>
					</div>
					<div class="title"><?php echo \esc_html( $field['title'] ); ?></div>
					<div class="desc"><?php echo \wp_kses_post( $field['desc'] ); ?></div>
					<div class="tool">
						<div class="option">
							<?php if ( ! empty( $field['url'] ) ) : ?>
							<a href="<?php echo \esc_url( $field['url'] ); ?>" target="_self"><svg class="svg-icon" aria-hidden="true"><use xlink:href="#icon-frame-general"></use></svg><span>设置</span></a>
							<?php else : ?>
							<svg class="svg-icon" aria-hidden="true"><use xlink:href="#icon-frame-general"></use></svg><span>设置</span><?php endif; ?>
						</div>
						<div class="switch">
							<input class="form-switch-small" type="checkbox" id="<?php echo \esc_attr( $field['id'] ); ?>" name="<?php echo \esc_attr( $field['id'] ); ?>" <?php \checked( $value, true ); ?>>
						</div>
					</div>
				</div>
				<?php break;
				
			//* HTML内容
			case 'html': ?>
				<div class="area-html">
					<?php echo \wp_kses_post( $field['desc'] ); ?>
				</div>
				<?php break;

			//* 说明信息
			case 'info': ?>
				<div class="area-info">
					<label>
						<span><?php echo \wp_kses_post( $field['desc'] ); ?></span>
					</label>
				</div>
				<?php break;

			default: ?>
				<div class="area-info">
					<label>
						<span class="desc">无对应表单类型，请检查类型设置是否正确！</span>
					</label>
				</div>
				<?php break;

		}
		
		//* 表单开关
		echo empty( $field['hidden'] ) ? '' : '</div>';

	}

	/**
	 * 读取表单结构
	 * 
	 * @param array $fields  表单数据
	 * 
	 * @return array
	 */
	public function readField( $fields ) {
		
		$fieldset = [];
		
		foreach ( $fields as $field ) {
			switch ( $field['type'] ) {
				//* 组区域数据
				case 'group':
					$fieldset = array_merge( $fieldset, $field['fields'] );
					break;
				//* 块区域数据
				case 'block':
					$fieldset = array_merge( $fieldset, $field['fields'] );
					break;
				//* 选项卡区域数据
				case 'tabs':
					foreach ( $field['fields'] as $tabs_field ) {
						$fieldset = array_merge( $fieldset, $tabs_field );
					}
					break;
				//* 表单
				default:
					$fieldset = array_merge( $fieldset, [$field] );
					break;
			}
		}
		
		return $fieldset;
		
	}
	
	/**
	 * 读取表单值
	 * 
	 * @param  array  $fields  表单数据
	 * @param  string $type    数据类型
	 * 
	 * @return array
	 */
	public function readValue( $fields, $type = 'input' ) {

		$values = [];
		$fields = $this->readField( $fields );
		
		switch ( $type ) {
			
			//* 读取输入数据
			case 'input':
				foreach ( $fields as $field ) {
					//* 跳过不支持类型
					if ( ! in_array( $field['type'], $this->types ) ) {
						continue;
					}
					if ( ! empty( $field['hidden'] ) && isset( $_POST[$field['id'] . '-hidden'] ) && $_POST[$field['id'] . '-hidden'] === 'on' ) {
						//* 隐藏表单开启不取值
						$values[$field['id']] = '';
					} else {
						switch ( $field['type'] ) {
							//* 复选框
							case 'checkbox':
								$values[$field['id']] = [];
								foreach ( $field['option'] as $key => $text ) {
									if ( isset( $_POST[($field['id'].'-'.$key)] ) && $_POST[($field['id'].'-'.$key)] === 'on' ) {
										$values[$field['id']][] = \sanitize_text_field( $key );
									}
								}
								break;
							//* 文本域
							case 'textarea':
								$values[$field['id']] = isset( $_POST[$field['id']] ) ? \sanitize_textarea_field( \wp_unslash( $_POST[$field['id']] ) ) : '';
								break;
							//* HTML域
							case 'htmlarea':
								$values[$field['id']] = isset( $_POST[$field['id']] ) ? \sanitize_textarea_field( htmlspecialchars( \wp_unslash( $_POST[$field['id']] ), ENT_QUOTES ) ) : '';
								break;
							//* 编辑器
							case 'editor':
								$values[$field['id']] = isset( $_POST[$field['id']] ) ? \wp_kses_post( \wp_unslash( $_POST[$field['id']] ) ) : '';
								break;
							//* 切换按钮
							case 'switch':
								$values[$field['id']] = isset( $_POST[$field['id']] ) && $_POST[$field['id']] === 'on' ? true : false;
								break;
							//* 功能面板
							case 'panel':
								$values[$field['id']] = isset( $_POST[$field['id']] ) && $_POST[$field['id']] === 'on' ? true : false;
								break;
							//* 其他类型
							default:
								$values[$field['id']] = isset( $_POST[$field['id']] ) ? \sanitize_text_field( \wp_unslash( $_POST[$field['id']] ) ) : '';
								break;
						}
					}
				}
				break;
				
			//* 读取表单默认值
			case 'default':
				foreach ( $fields as $field ) {
					//* 跳过不支持类型
					if ( ! in_array( $field['type'], $this->types ) ) {
						continue;
					}
					switch ( $field['type'] ) {
						case 'checkbox':
							$values[$field['id']] = array_filter( $field['default'] );
							break;
						case 'textarea':
							$values[$field['id']] = \sanitize_textarea_field( $field['default'] );
							break;
						case 'htmlarea':
							$values[$field['id']] = htmlspecialchars( $field['default'], ENT_QUOTES );
							break;
						case 'editor':
							$values[$field['id']] = \wp_kses_post( $field['default'] );
							break;
						default:
							$values[$field['id']] = \sanitize_text_field( $field['default'] );
							break;
					}
				}
				break;
				
		}

		return $values; 
		
	}

}
