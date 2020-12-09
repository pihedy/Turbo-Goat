<?php
/** 
 * @author Pihe Edmond <pihedy@gmail.com>
 */

header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header(sprintf('Last-Modified: %s GMT', gmdate('D, d M Y H:i:s')));

header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');

header("Location: /");

die();
