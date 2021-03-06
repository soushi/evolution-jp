<?php
define('MODX_API_MODE', true);
define('IN_MANAGER_MODE', 'true');
$self = 'manager/media/browser/mcpuk/browser.php';
$base_path = str_replace($self,'',str_replace('\\','/',__FILE__));
require_once("{$base_path}index.php");

if(!isset($_SESSION['mgrValidated']))
{
	die("<b>INCLUDE_ORDERING_ERROR</b><br /><br />Please use the MODX Content Manager instead of accessing this file directly.");
}

$rb = new FBROWSER();
$ph = array();
$ph['seturl_js'] = $rb->seturl_js();
$output = $rb->render_fbrowser($ph);
echo $output;

class FBROWSER
{
	function seturl_js()
	{
			$editor_path = htmlspecialchars($_GET['editorpath'], ENT_QUOTES);
			switch($_GET['editor'])
			{
				case 'tinymce' :
				case 'tinymce3':
					$editor_path = rtrim($editor_path, '/') . '/';
					$result = file_get_contents('seturl_js_tinymce.inc');
					$result = str_replace('[+editor_path+]', $editor_path, $result);
					break;
				default:
				$result = '<script src="seturl.js" type="text/javascript"></script>' . "\n";
		}
		return $result;
	}
	
	function render_fbrowser($ph)
	{
		$browser_html = file_get_contents('browser.html.inc');
		foreach($ph as $name => $value)
		{
			$name = '[+' . $name . '+]';
			$browser_html = str_replace($name, $value, $browser_html);
		}
		return $browser_html;
	}
}
