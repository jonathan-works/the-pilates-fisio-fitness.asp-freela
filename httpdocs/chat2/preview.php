<?php
/****************************************************************************************
 * LiveZilla preview.php
 *
 * Copyright 2017 LiveZilla GmbH
 * All rights reserved.
 * LiveZilla is a registered trademark.
 *
 * Improper changes to this file may cause critical errors.
 ***************************************************************************************/

define("IN_LIVEZILLA",true);
header('Content-Type: text/html; charset=utf-8');
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
if(!defined("LIVEZILLA_PATH"))
    define("LIVEZILLA_PATH","./");

require(LIVEZILLA_PATH . "_definitions/definitions.inc.php");
require(LIVEZILLA_PATH . "_lib/functions.global.inc.php");
require(LIVEZILLA_PATH . "_definitions/definitions.dynamic.inc.php");
require(LIVEZILLA_PATH . "_definitions/definitions.protocol.inc.php");

@set_error_handler("handleError");

$bhtml = "<!DOCTYPE HTML><html><head><meta charset=\"UTF-8\"><link rel=\"shortcut icon\" href=\"./images/favicon.ico\" type=\"image/x-icon\"><title>LiveZilla Link Generator Preview</title><meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\" /></head><body topmargin=\"0\" leftmargin=\"0\" background=\"./images/preview_bg.gif\">";

if(Server::InitDataProvider())
{
    Server::DefineURL("preview.php");
    if(strlen($_GET["id"])==32 && Configuration::GetCodeById($_GET["id"]) != null)
    {
        $bhtml .= Configuration::GetCodeById($_GET["id"]);
    }
}
$bhtml = str_replace("<!--server-->","<!--server-->server.php",$bhtml);
exit(Server::Replace($bhtml . "</body></html>"));
?>