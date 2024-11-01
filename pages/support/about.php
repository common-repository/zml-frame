<?php
/**
 * @package ZMLFrame\Views
 */

namespace ZMLFrame\View;

defined( 'ZMLFRAME_PRESENT' ) or die( 'Access Denied' );

\current_user_can( 'manage_options' ) or die( 'Access Denied' );

/**
 * 视图 - 关于插件
 *
 * 插件介绍
 * 
 * @since 1.0.0
 */
?>

<div class="content-header">
	<strong>关于插件</strong>
	<span>插件简单介绍</span>
</div>
<div class="content-body">
	<div class="content-main">
		<div class="view-help">
			<p><h2>ZML-Frame Version <?php echo \esc_html( \ZMLFRAME_VER ); ?></h2></p>
			<p>紫茉莉-基础框架，紫茉莉系列产品用于后台管理的基础框架。</p>
			<p>紫茉莉系列主题、插件都采用此基础框架生成后台管理页面。不用担心使用此基础框架会造成系统资源浪费，采用此种方法能够减少主题或插件文件大小，并且在安装多个插件时能够减少文件的重复加载，减少资源占用。</p>
			<p>如果您的版本不是最新的，请及时更新，以免影响主题或插件的正常使用 [ <a href="https://www.zimoli.me/zml-plugin-frame/" target="_blank">查看详情</a> ]。主题、插件、基础框架更新时，请注意主题和插件对框架版本的要求，推荐全部升级至最新版本，以免同时存在新旧版本，导致主题或插件不能正常运行。</p>
		</div>
	</div>
</div>