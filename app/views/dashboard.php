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

use DateTime;

$this->getHeader();
$this->getNavigation();
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-12">
			<div class="content__title">
				<h1><?php $this->_e('Dashboard'); ?></h1>
				<span>Forward - a modern link shortener</span>
			</div>
		</div>

		<div class="col-12 col-lg-3">
			<div class="content__card">
				<div class="content__card__body">
					<span class="content__card__header"><?php echo $this->_e('Top referrer'); ?></span>
					<h3><?php echo $this->topReferrer(); ?></h3>
				</div>
			</div>
		</div>
		<div class="col-12 col-lg-3">
			<div class="content__card">
				<div class="content__card__body">
					<span class="content__card__header"><?php echo $this->_e('Top language'); ?></span>
					<h3><?php echo $this->topLanguage(); ?></h3>
				</div>
			</div>
		</div>
		<div class="col-12 col-lg-3">
			<div class="content__card">
				<div class="content__card__body">
					<span class="content__card__header"><?php echo $this->_e('Total clicks'); ?></span>
					<h3><?php echo $this->totalClicks(); ?></h3>
				</div>
			</div>
		</div>
		<div class="col-12 col-lg-3">
			<div class="content__card">
				<div class="content__card__body">
					<span class="content__card__header"><?php echo $this->_e('API requests'); ?></span>
					<h3>0</h3>
				</div>
			</div>
		</div>
		<div class="col-12 col-lg-4">
			<div class="content__card">
				<div class="content__card__body">
					<span class="content__card__header"><?php echo $this->_e('Links'); ?></span>
					<div class="records-list">
						<div class="records-list__container">
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-12 col-lg-8">
			<div class="content__card">
				<div class="content__card__body">
					<span class="content__card__header"><?php echo $this->_e('Selected link'); ?></span>
					<h2 id="ds_record_name"></h2>
					<small id="ds_record_url"></small>
					<div class="d-grid gap-2 d-md-block" style="margin-top:1rem;margin-bottom:.5rem;">
						<button id="ds_record_copy" class="dashboard__btn--copy-recent btn btn-outline-light btn-sm" type="button" data-clipboard-text=""><?php $this->_e('Copy'); ?></button>
						<button id="ds_record_qrcode" class="btn btn-outline-primary btn-sm" type="button"><?php $this->_e('QR Code'); ?></button>
						<button id="ds_record_delete" class="btn btn-outline-primary btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#archiveRecordModal"><?php $this->_e('Archive'); ?></button>
					</div>

					<div class="content__card__floating">
						<div>
							<span id="ds_record_clicks"></span>
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bar-chart" viewBox="0 0 16 16">
								<path d="M4 11H2v3h2v-3zm5-4H7v7h2V7zm5-5v12h-2V2h2zm-2-1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1h-2zM6 7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7zm-5 4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-3z" />
							</svg>
						</div>
						<p><?php echo $this->_e('link clicks'); ?></p>
					</div>

					<div class="content__chart">
						<canvas id="ds_chart_days" class="chartjs-chart" height="200"></canvas>
					</div>
				</div>
			</div>
		</div>
		<div class="col-12 col-lg-4">
			<div class="content__card">
				<div class="content__card__body">
					<span class="content__card__header"><?php echo $this->_e('Add new'); ?></span>
					<form class="forward-form forward-dashboard__add__form">
						<input type="hidden" value="add_record" name="action">
						<input type="hidden" value="<?php echo $this->ajaxNonce('add_record'); ?>" name="nonce">
						<input type="hidden" value="<?php echo $this->newRecord(); ?>" id="input-dashboard-rand-value" name="input-rand-value">
						<div class="row">
							<div class="col-12 col-lg-6" style="margin-bottom:1rem;">
								<div class="form-group">
									<input type="text" id="input-dashboard-record-url" name="input-record-url" class="form-control" placeholder="https://">
								</div>
							</div>
							<div class="col-12 col-lg-6" style="margin-bottom:1rem;">
								<div class="form-group">
									<input type="text" id="input-dashboard-record-slug" name="input-record-slug" class="form-control" placeholder="<?php echo $this->newRecord(); ?>" value="<?php echo $this->newRecord(); ?>">
								</div>
							</div>
							<div class="d-grid">
								<button type="submit" class="btn-forward block"><?php echo $this->_e('Add new'); ?></button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="col-12 col-lg-2">
			<div class="content__card">
				<div class="content__card__body">
					<span class="content__card__header"><?php echo $this->_e('Origins'); ?></span>
					<div class="content__chart">
						<canvas id="ds_chart_origins" class="chartjs-chart" width="400" height="400">></canvas>
					</div>
				</div>
			</div>
		</div>
		<div class="col-12 col-lg-2">
			<div class="content__card">
				<div class="content__card__body">
					<span class="content__card__header"><?php echo $this->_e('Languages'); ?></span>
					<div class="content__chart">
						<canvas id="ds_chart_languages" class="chartjs-chart"></canvas>
					</div>
				</div>
			</div>
		</div>
		<div class="col-12 col-lg-2">
			<div class="content__card">
				<div class="content__card__body">
					<span class="content__card__header"><?php echo $this->_e('Platforms'); ?></span>
					<div class="content__chart">
						<canvas id="ds_chart_platforms" class="chartjs-chart"></canvas>
					</div>
				</div>
			</div>
		</div>
		<div class="col-12 col-lg-2">
			<div class="content__card">
				<div class="content__card__body">
					<span class="content__card__header"><?php echo $this->_e('Browsers'); ?></span>
					<div class="content__chart">
						<canvas id="ds_chart_agents" class="chartjs-chart"></canvas>
					</div>
				</div>
			</div>
		</div>
		<div class="col-12">
			<div class="content__copyright">
				<p>Created in Poland by Leszek Pomianowski</p>
				<span>Copyright © 2019-<?php echo date('Y'); ?> RAPIDDEV | MIT License</span>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="qrcodeRecordModal" tabindex="-1" aria-labelledby="qrcodeRecordModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body" style="padding: 0;">
				<div id="ds_qrcode_container" style="display: flex;justify-content: center;align-items: center;">
					<canvas id="ds_qrcode_canvas" style="max-width: 240px;object-fit: contain;"></canvas>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-light" data-bs-dismiss="modal"><?php $this->_e('Close'); ?></button>
				<a id="ds_qrcode_download" target="_blank" type="button" class="btn btn-success"><?php $this->_e('Save to device'); ?></a>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="archiveRecordModal" tabindex="-1" aria-labelledby="archiveRecordModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<p style="text-align:center;"><?php $this->_e('Are you sure you want to archive this link?'); ?></p>
				<h4 style="text-align:center;" class="display-4" id="ds_archive_name">/AJKSD</h4>
				<span id="ds_archive_target" style="text-align:center;opacity: 0.6;display:block;"></span>
				<span style="text-align:center;opacity: 0.6;display:block;"><span id="ds_archive_clicks"></span> <?php $this->_e('clicks'); ?></span>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-light" data-bs-dismiss="modal"><?php $this->_e('Cancel'); ?></button>
				<button id="ds_archive_action" data-id="-1" type="button" class="btn btn-danger"><?php $this->_e('Archive'); ?></button>
			</div>
		</div>
	</div>
</div>
<?php
/*
?>
			<div id="rdev-dashboard" class="block-page distance-navbar">
				<div class="container-fluid">
					<div class="row row-no-gutter">
						<div class="col-12 col-lg-3 col-no-gutters" id="records_list">
							<div class="card links-header"><div class="card-body"><small><strong id="total_records_count"><?php echo count($this->Records()); ?></strong> <?php echo $this->_e('total links'); ?></small></div></div>
							<div id="links-copied" class="alert alert-success fade show" role="alert" style="display: none;margin: 0;border-radius: 0;">
								<div>
									<svg style="width:24px;height:24px" viewBox="0 0 24 24"><path fill="#155724" d="M19,3H14.82C14.4,1.84 13.3,1 12,1C10.7,1 9.6,1.84 9.18,3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5A2,2 0 0,0 19,3M12,3A1,1 0 0,1 13,4A1,1 0 0,1 12,5A1,1 0 0,1 11,4A1,1 0 0,1 12,3M7,7H17V5H19V19H5V5H7V7M7.5,13.5L9,12L11,14L15.5,9.5L17,11L11,17L7.5,13.5Z" /></svg>
									<small style="font-size:13px;"><?php echo $this->_e('Link has been copied to your clipboard'); ?></small>
								</div>
							</div>
<?php $c = 0; foreach ($this->Records() as $record): $c++; ?>
							<div class="card links-card record-<?php echo $record['record_id']; ?>" data-clipboard-text="<?php echo $this->baseurl . $record['record_name']; ?>" data-id="<?php echo $record['record_id']; ?>">
								<div class="card-body">
									<div>
										<small><?php echo (new DateTime($record['record_created']))->format('Y-m-d'); ?></small>
										<h2><a class="shorted-url" data-clipboard-text="<?php echo $this->baseurl . $record['record_display_name']; ?>" target="_blank" rel="noopener" href="<?php echo $this->baseurl . $record['record_display_name']; ?>">/<?php echo $record['record_display_name']; ?></a></h2>
										<p><a target="_blank" rel="noopener" class="overflow-url" href="<?php echo $record['record_url'] ?>"><?php echo $record['record_url']; ?></a></p>
									</div>
									<span><?php echo $record['record_clicks']; ?></span>
								</div>
							</div>
<?php endforeach; ?>
						</div>
						<div id="dashboard-box" class="col-12 col-lg-9" style="padding-top:32px;padding-bottom:15px;min-height: 100%;height: inherit; overflow: auto;">
							<div class="container-fluid">
								<div class="row">
<?php if ($this->Forward->User->IsManager()): ?>
										<div class="col-12">
											<div id="add-alert" class="alert alert-danger fade show" role="alert" style="display: none;">
												<strong><?php echo $this->_e('Holy guacamole!'); ?></strong> <span id="error_text"> <?php echo $this->_e('Something went wrong!'); ?></span>
											</div>
											<div id="add-success" class="alert alert-success fade show" role="alert" style="display: none;">
												<strong><?php echo $this->_e('Success!'); ?></strong> <?php echo $this->_e('New link was added.'); ?>
											</div>
											<form id="add-record-form" action="<?php echo $this->AjaxGateway(); ?>">
												<input type="hidden" value="add_record" name="action">
												<input type="hidden" value="<?php echo $this->AjaxNonce( 'add_record' ); ?>" name="nonce">
												<input type="hidden" value="<?php echo $this->NewRecord(); ?>" id="input-rand-value" name="input-rand-value">
												<div class="row">
													<div class="col-12 col-lg-3">
														<div class="form-group">
															<input type="text" id="input-record-url" name="input-record-url" class="form-control" placeholder="https://">
														</div>
													</div>
													<div class="col-12 col-lg-3">
														<div class="form-group">
															<input type="text" id="input-record-slug" name="input-record-slug" class="form-control" placeholder="<?php echo $this->NewRecord(); ?>" value="<?php echo $this->NewRecord(); ?>">
														</div>
													</div>
													<div class="col-12 col-lg-3">
														<button type="submit" id="add-record-send" class="btn btn-block btn-outline-dark"><?php echo $this->_e('Add new'); ?></button>
													</div>
												</div>
											</form>
										</div>
<?php endif; ?>
									<div class="col-12" style="margin-top:32px;">
										<ul class="dashboard-list list-inline">
											<li class="list-inline-item">
												<div class="stats-header">
													<div>
														<svg viewBox="0 0 16 16" class="bi bi-share" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
															<path fill-rule="evenodd" d="M11.724 3.947l-7 3.5-.448-.894 7-3.5.448.894zm-.448 9l-7-3.5.448-.894 7 3.5-.448.894z"/>
															<path fill-rule="evenodd" d="M13.5 4a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zm0 1a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5zm0 10a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zm0 1a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5zm-11-6.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zm0 1a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
														</svg>
														<div>
															<h1><?php echo $this->TopReferrer(); ?></h1>
															<p><?php echo $this->_e('Top referrer'); ?></p>
														</div>
													</div>
												</div>
											</li>
											<li class="list-inline-item">
												<div class="stats-header">
													<div>
														<svg viewBox="0 0 16 16" class="bi bi-geo" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
															<path d="M11 4a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
															<path d="M7.5 4h1v9a.5.5 0 0 1-1 0V4z"/>
															<path fill-rule="evenodd" d="M6.489 12.095a.5.5 0 0 1-.383.594c-.565.123-1.003.292-1.286.472-.302.192-.32.321-.32.339 0 .013.005.085.146.21.14.124.372.26.701.382.655.246 1.593.408 2.653.408s1.998-.162 2.653-.408c.329-.123.56-.258.701-.382.14-.125.146-.197.146-.21 0-.018-.018-.147-.32-.339-.283-.18-.721-.35-1.286-.472a.5.5 0 1 1 .212-.977c.63.137 1.193.34 1.61.606.4.253.784.645.784 1.182 0 .402-.219.724-.483.958-.264.235-.618.423-1.013.57-.793.298-1.855.472-3.004.472s-2.21-.174-3.004-.471c-.395-.148-.749-.336-1.013-.571-.264-.234-.483-.556-.483-.958 0-.537.384-.929.783-1.182.418-.266.98-.47 1.611-.606a.5.5 0 0 1 .595.383z"/>
														</svg>
														<div>
															<h1><?php echo $this->TopLanguage(); ?></h1>
															<p><?php echo $this->_e('Top language'); ?></p>
														</div>
													</div>
												</div>
											</li>
											<li class="list-inline-item">
												<div class="stats-header">
													<div>
														<svg viewBox="0 0 16 16" class="bi bi-bar-chart" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
															<path fill-rule="evenodd" d="M4 11H2v3h2v-3zm5-4H7v7h2V7zm5-5h-2v12h2V2zm-2-1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1h-2zM6 7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7zm-5 4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-3z"/>
														</svg>
														<div>
															<h1><?php echo $this->TotalClicks(); ?></h1>
															<p><?php echo $this->_e('Total clicks'); ?></p>
														</div>
													</div>
												</div>
											</li>
										</ul>
									</div>
									<div class="col-12" style="margin:0;">
										<hr>
									</div>
									<div class="col-12">
										<div id="single-record">
											<div class="row">
												<div class="col-12">
													<p class="record-shortdata">created <span id="preview-record-date"></span> | <a href="#" id="preview-record-user"></a></p>
													<h2 id="preview-record-slug"></h2>
													<span><a id="preview-record-url" href="#" target="_blank" rel="noopener"></a></span>
												</div>
												<div class="col-12 record-buttons">
													<ul class="list-inline" style="margin-top:15px;">
														<li class="list-inline-item" id="preview-record-copy"><button class="btn btn-outline-warning">COPY</button></li>
														<li class="list-inline-item" id="preview-record-share"><button class="btn btn-outline-warning">SHARE</button></li>
														<li class="list-inline-item" id="preview-record-qrcode"><button class="btn btn-outline-warning">QR CODE</button></li>
<?php if ($this->Forward->User->IsManager()): ?>
														<li class="list-inline-item" id="preview-record-delete"><button class="btn btn-outline-warning">DELETE</button></li>
<?php endif; ?>
													</ul>
												</div>
												<div class="col-12">
													<div id="qrcode-record-alert" class="alert alert-light" role="alert" style="display: none;">
														<canvas id="qrcode-record-image"></canvas>
														<hr>
														<button id="close-qrcode-record" class="btn btn-outline-secondary">Close</button>
													</div>
												</div>
<?php if ($this->Forward->User->IsManager()): ?>
												<div class="col-12">
													<div id="delete-record-alert" class="alert alert-danger" role="alert" style="display: none;">
														<h4 class="alert-heading">Warning!</h4>
														<p>Are you sure you want to delete selected record? If yes, the record will be hidden, but its data will be kept. It will only be recovered by editing the database.</p>
														<hr>
														<button id="confirm-delete-record" class="btn btn-outline-danger">Delete record</button> <button id="cancel-delete-record" class="btn btn-outline-secondary">Cancel</button>
													</div>
												</div>
<?php endif; ?>
											</div>
											<div class="row">
												<div class="col-12 col-lg-6 pie-container">
													<div class="row">
														<div class="col-12">
															<p class="pie-header">browsers</p>
														</div>
														<div class="col-12 col-lg-6 col-no-gutters">
															<div style="position: relative">
																<div>
																	<div class="pie-browsers pie-color-blue ct-pie-hover ct-perfect-fourth"></div>
																</div>
																<span id="pie-browsers-count"></span>
															</div>
														</div>
														<div class="col-12 col-lg-6">
															<ul class="pie-browsers-labels"></ul>
														</div>
													</div>
												</div>
												<div class="col-12 col-lg-6 pie-container">
													<div class="row">
														<div class="col-12">
															<p class="pie-header">platforms</p>
														</div>
														<div class="col-12 col-lg-6 col-no-gutters">
															<div style="position: relative">
																<div>
																	<div class="pie-platforms pie-color-blue ct-pie-hover ct-perfect-fourth"></div>
																</div>
																<span id="pie-platforms-count"></span>
															</div>
														</div>
														<div class="col-12 col-lg-6">
															<ul class="pie-platforms-labels"></ul>
														</div>
													</div>
												</div>
												<div class="col-12 col-lg-6 bar-container" style="height: 250px;">
													<div class="row">
														<div class="col-12">
															<p class="bar-header">origins</p>
														</div>
														<div class="col-12 col-no-gutters">
															<div style="position: relative">
																<div>
																	<div class="bar-origins bar-color-blue ct-bar-hover ct-perfect-fourth"></div>
																</div>
																<span id="bar-origins-count"></span>
															</div>
														</div>
													</div>
												</div>
												<div class="col-12 col-lg-6 bar-container" style="height: 250px;">
													<div class="row">
														<div class="col-12">
															<p class="bar-header">languages</p>
														</div>
														<div class="col-12 col-no-gutters">
															<div style="position: relative">
																<div>
																	<div class="bar-languages bar-color-blue ct-bar-hover ct-perfect-fourth"></div>
																</div>
																<span id="bar-languages-count"></span>
															</div>
														</div>
													</div>
												</div>
												<div class="col-12 col-no-gutters" style="height: 220px;">
													<div class="bar-color-blue ct-chart ct-perfect-fourth" style="height: 220px;"></div>
												</div>
												<div class="col-12">
													<div class="row">
														<div id="record-referrers" class="col-12 col-md-6">
														</div>
														<div id="record-locations" class="col-12 col-md-6">
														</div>
													</div>
												</div>
												<div class="col-12">
													<div class="overflow-auto" style="height: 150px;">
														<table class="table table-sm">
															<thead>
																<tr>
																	<th scope="col">#</th>
																	<th scope="col">IP</th>
																	<th scope="col">Lookup</th>
																</tr>
															</thead>
															<tbody id="records-ip-list">
																
															</tbody>
														</table>
													</div>
												</div>
												<div class="col-12">
													<span class="stats-data-info">data in utc</span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
<?php */
$this->getFooter();
