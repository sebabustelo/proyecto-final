<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */

namespace Nette\Http\Diagnostics;

use Nette;


/**
 * Session panel for Debugger Bar.
 *
 * @author     David Grudl
 */
class SessionPanel extends Nette\Object implements Nette\Diagnostics\IBarPanel
{

	/**
	 * Renders tab.
	 * @return string
	 */
	public function getTab()
	{
		ob_start();
		require __DIR__ . '/templates/SessionPanel.tab.phtml';
		return ob_get_clean();
	}


	/**
	 * Renders panel.
	 * @return string
	 */
	public function getPanel()
	{
		ob_start();
		require __DIR__ . '/templates/SessionPanel.panel.phtml';
		return ob_get_clean();
	}

}
