<?php

/**
 * @package Forward
 *
 * @author RapidDev
 * @copyright Copyright (c) 2019-2021, RapidDev
 * @link https://www.rdev.cc/forward
 * @license https://opensource.org/licenses/MIT
 */

namespace Forward\Models;

use Forward\Core\{Models, Crypter};

defined('ABSPATH') or die('No script kiddies please!');

final class Model extends Models
{
	private int $total_clicks = -1;

	private array $last_visitors = array();

	private array $records = array();

	protected function init(): void
	{
		$this->getRecords();
		$this->getLastVisitors();
	}

	private function getRecords(): void
	{
		if (empty($this->records)) {
			$query = $this->Forward->Database->query("SELECT * FROM forward_records WHERE record_active = true ORDER BY record_id DESC")->fetchAll();

			if (!empty($query)) {
				$this->records = $query;
			}
		}
	}

	private function getLastVisitors(): void
	{
		$records = $this->Forward->Database->query("SELECT visitor_origin_id, visitor_language_id FROM forward_statistics_visitors ORDER BY visitor_id DESC LIMIT ?", $this->Forward->Options->Get('latest_visitors_limit', 200))->fetchAll();

		if (!empty($records)) {
			$languages = $this->Forward->Database->query("SELECT * FROM forward_statistics_languages")->fetchAll();
			$origins = $this->Forward->Database->query("SELECT * FROM forward_statistics_origins")->fetchAll();

			$this->last_visitors = $records;
		}
	}

	public function totalClicks(): int
	{
		if ($this->total_clicks == -1) {
			$this->total_clicks = 0;
			foreach ($this->records as $record) {
				$this->total_clicks += $record['record_clicks'];
			}
		}

		return $this->total_clicks;
	}

	public function topReferrer(): string
	{
		$origins = array();
		$origin = $this->__('Unknown');

		foreach ($this->last_visitors as $visitor)
			if (isset($origins[$visitor['visitor_origin_id']]))
				$origins[$visitor['visitor_origin_id']]++;
			else
				$origins[$visitor['visitor_origin_id']] = 1;

		arsort($origins);

		$query = $this->Forward->Database->query("SELECT origin_name FROM forward_statistics_origins WHERE origin_id = ?", key($origins))->fetchArray();

		if (!empty($query))
			switch ($query['origin_name']) {
				case 'direct':
					$origin = $this->__('Email, SMS, Direct');
					break;
				case 'www.youtube.com':
					$origin = 'YouTube';
					break;
				case 'www.facebook.com':
					$origin = 'Facebook';
					break;
				default:
					$origin = $query['origin_name'];
					break;
			}

		return $origin;
	}

	public function topLanguage(): string
	{
		$languages = array();
		$language = $origin = $this->__('Unknown');

		foreach ($this->last_visitors as $visitor)
			if (isset($languages[$visitor['visitor_language_id']]))
				$languages[$visitor['visitor_language_id']]++;
			else
				$languages[$visitor['visitor_language_id']] = 1;

		arsort($languages);
		$query = $this->Forward->Database->query("SELECT language_name FROM forward_statistics_languages WHERE language_id = ?", key($languages))->fetchArray();

		if (!empty($query))
			switch (substr(strtolower($query['language_name']), 0, 2)) {
				case 'en':
					$language = $this->__('English');
					break;
				case 'pl':
					$language = $this->__('Polish');
					break;
				default:
					$language = $query['language_name'];
					break;
			}

		return $language;
	}

	public function records(): array
	{
		return $this->records;
	}

	public function shortUrl($url): string
	{
		if ($url > 15) {
			return substr($url, 0, 15) . '...';
		} else {
			return $url;
		}
	}

	public function header()
	{
		$html  = '<script type="text/javascript" nonce="' . $this->js_nonce . '">';
		//Records
		$html .= 'let records = {';
		$c = 0;
		foreach ($this->records as $r) {
			$c++;
			$html .= ($c > 1 ? ', ' : '') . $r['record_id'] . ': [' . $r['record_id'] . ',' . $r['record_clicks'] . ',' . $r['record_author'] . ',"' . $r['record_name'] . '","' . $r['record_display_name'] . '","' . $r['record_url'] . '","' . $r['record_updated'] . '","' . $r['record_created'] . '"]';
		}
		$html .= '};';

		//Current date for printing the pie chart
		$date = array(
			'y' => date('Y', time()),
			'm' => date('m', time()),
			'd' => date('d', time())
		);
		$date['days'] = cal_days_in_month(CAL_GREGORIAN, (int)$date['m'], (int)$date['y']);

		$html .= 'let bar_chart_height = 200;';

		$html .= 'let bar_chart_labels = [';
		for ($i = 1; $i <= $date['days']; $i++) {
			$html .= ($i > 1 ? ', ' : '') . '\'' . $i . '\'';
		}
		$html .= '];';

		echo $html . '</script>' . PHP_EOL;
	}
}
