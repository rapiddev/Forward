<?php

/**
 * @package Forward
 *
 * @author RapidDev
 * @copyright Copyright (c) 2019-2021, RapidDev
 * @link https://www.rdev.cc/forward
 * @license https://opensource.org/licenses/MIT
 */

namespace Forward\Views;

defined('ABSPATH') or die('No script kiddies please!');

$this->getHeader();
$this->getNavigation();
?>
<div class="container-fluid" style="margin-bottom: 2rem;">
	<div class="row">
		<div class="col-12">
			<div class="content__title">
				<h1>About</h1>
				<span>Find out more about Forward</span>
			</div>
		</div>
		<div class="col-12">
			<p>
				Forward is a content management system created to shorten links and collect analytics.
				<br>
				It is available under the MIT license.
				<br>
				<small><i>version <?php echo FORWARD_VERSION; ?></i></small>
			</p>
			<hr>
			<h4>Used technologies & things</h4>
			<div class="container-fluid" style="font-size: 13px;">
				<div class="row">
					<div class="col-12 col-lg-6">
						<ul class="list-unstyled">
							<li style="margin-bottom: 10px;"><i>MySQL</i> by the Oracle Corporation<br><a target="_blank" rel="noopener" href="https://www.mysql.com/">https://www.mysql.com/</a><br><small>MySQL is open-sourced software licensed under the GNU General Public License (GPL).</small></li>
							<li style="margin-bottom: 10px;"><i>Chart.js</i> by the Chart.js Contributors<br><a target="_blank" rel="noopener" href="https://github.com/chartjs/Chart.js">https://github.com/chartjs/Chart.js</a><br><small>Chart.js is open-sourced software licensed under the MIT license.</small></li>
							<li style="margin-bottom: 10px;"><i>Bootstrap</i> by the Bootstrap team<br><a target="_blank" rel="noopener" href="https://getbootstrap.com/">https://getbootstrap.com/</a><br><small>Bootstrap is open-sourced software licensed under the MIT license.</small></li>
							<li style="margin-bottom: 10px;"><i>jQuery</i> by the jQuery Foundation<br><a target="_blank" rel="noopener" href="https://jquery.org/">https://jquery.org/</a><br><small>jQuery is open-sourced software licensed under the MIT license.</small></li>
							<li style="margin-bottom: 10px;"><i>Clipboard.js</i> by the Zeno Rocha<br><a target="_blank" rel="noopener" href="https://github.com/zenorocha/clipboard.js/">https://github.com/zenorocha/clipboard.js/</a><br><small>Clipboard.js is open-sourced software licensed under the MIT license.</small></li>
							<li style="margin-bottom: 10px;"><i>Browser.php</i> by the Chris Schuld<br><a target="_blank" rel="noopener" href="https://github.com/cbschuld/Browser.php">https://github.com/cbschuld/Browser.php</a><br><small>Browser.php is open-sourced software licensed under the MIT license.</small></li>
							<li style="margin-bottom: 10px;"><i>node-qrcode</i> by the Ryan Day<br><a target="_blank" rel="noopener" href="https://github.com/soldair/node-qrcode">https://github.com/soldair/node-qrcode</a><br><small>node-qrcode is open-sourced software licensed under the MIT license.</small></li>
						</ul>
					</div>
					<div class="col-12 col-lg-6">
						<ul class="list-unstyled">
							<li style="margin-bottom: 10px;"><i>Bootstrap Icons</i> by the Bootstrap team<br><a target="_blank" rel="noopener" href="https://icons.getbootstrap.com/">https://icons.getbootstrap.com/</a><br><small>Bootstrap is open-sourced software licensed under the MIT license.</small></li>
							<li style="margin-bottom: 10px;"><i>Material Design Icons</i> by the Google and other creators | Maintained by Austin Andrews<br><a target="_blank" rel="noopener" href="https://materialdesignicons.com/">https://materialdesignicons.com/</a><br><small>Material Design Icons is open-sourced software licensed under the Apache License 2.0.</small></li>
							<li style="margin-bottom: 10px;"><i>Questrial font</i> by the Joe Prince<br><a target="_blank" rel="noopener" href="https://fonts.google.com/specimen/Questrial">https://fonts.google.com/specimen/Questrial</a><br><small>Filebase is open-sourced font licensed under the Open Font License.</small></li>
							<li style="margin-bottom: 10px;"><i>Background images</i> by the Marcin Jóźwiak<br><a target="_blank" rel="noopener" href="https://www.pexels.com/@marcin-jozwiak-199600">https://www.pexels.com/@marcin-jozwiak-199600</a><br><small>Photos from the Pexels portal support the idea of open source.</small></li>
							<li style="margin-bottom: 10px;"><i>Background images</i> by the Adam Borkowski<br><a target="_blank" rel="noopener" href="https://www.pexels.com/@borkography">https://www.pexels.com/@borkography</a><br><small>Photos from the Pexels portal support the idea of open source.</small></li>
							<li style="margin-bottom: 10px;"><i>Background images</i> by the Josh Hild<br><a target="_blank" rel="noopener" href="https://www.pexels.com/@josh-hild-1270765">https://www.pexels.com/@josh-hild-1270765</a><br><small>Photos from the Pexels portal support the idea of open source.</small></li>
						</ul>
					</div>
				</div>
			</div>
			<hr>
			<small>
				<?php if (is_file(ABSPATH . 'LICENSE')) {
					echo nl2br(file_get_contents(ABSPATH . 'LICENSE'));
				} ?>
			</small>
		</div>
	</div>
</div>
<?php
$this->getFooter();
?>