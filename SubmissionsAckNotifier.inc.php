<?php

/**
 * @file SubmissionsAckNotifier.inc.php
 *
 * Copyright (c) 2014-2022 Simon Fraser University
 * Copyright (c) 2003-2022 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * @package plugins.generic.submissionsAckNotifier
 * @class SubmissionsAckNotifier
 */

import('lib.pkp.classes.plugins.GenericPlugin');

class SubmissionsAckNotifier extends GenericPlugin
{

	/**
	 * @copydoc Plugin::register()
	 */
	function register($category, $path, $mainContextId = null)
	{
		$success = parent::register($category, $path, $mainContextId);
		if ($success) {
			if ($this->getEnabled($mainContextId)) {
				HookRegistry::register('Mail::send', [$this, 'bccManager']);
			}
		}

		return $success;
	}

	/**
	 * @inheritDoc
	 */
	function getDisplayName()
	{
		return __('plugins.generic.submissionsAckNotifier.displayName');
	}

	/**
	 * @inheritDoc
	 */
	function getDescription()
	{
		return __('plugins.generic.submissionsAckNotifier.description');
	}

	/**
	 * BCCs listed journal contact on all submission acknowledgements
	 *
	 * @param string $hookName Mail::send
	 * @param array $args [Mail $mail]
	 * @return void
	 */
	public function bccManager(string $hookName, array $args): void {
		/** @var Mail $mail */
		$mail = $args[0];
		if ($mail->emailKey === 'SUBMISSION_ACK' && $mail->context) {
			$contactEmail = $mail->context->getData('contactEmail');
			$contactName = $mail->context->getData('contactName');
			if ($contactEmail) {
				$mail->addBcc($contactEmail, !empty($contactName) ? $contactName : '');
			}
		}
	}
}
