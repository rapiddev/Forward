<?php

/**
 * @package   Forward
 *
 * @author    RapidDev
 * @copyright Copyright (c) 2019-2021, RapidDev
 * @link      https://www.rdev.cc/forward
 * @license   https://opensource.org/licenses/MIT
 */

namespace Forward;

if (!defined('PUBLIC_PATH')) {
	define('PUBLIC_PATH', 'root');
}

if (is_file(dirname(__FILE__) . '/public/index.php')) {
	require_once dirname(__FILE__) . '/public/index.php';
}
