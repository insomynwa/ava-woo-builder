<?php
/**
 * Main dashboard template
 */
?><div id="ava-dashboard-page" class="ava-dashboard-page">
	<ava-dashboard-header></ava-dashboard-header>
	<div class="ava-dashboard-page__content">
		<component
		:is="page"
		></component>
	</div>
</div>
