<?php

/**
 * @file index.php
 *
 * Copyright (c) 2014-2022 Simon Fraser University
 * Copyright (c) 2003-2022 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * Sends additional submission acknowledgement emails.
 *
 * @package plugins.generic.submissionsAckNotifier
 *
 */

require_once('SubmissionsAckNotifier.inc.php');
return new SubmissionsAckNotifier();

