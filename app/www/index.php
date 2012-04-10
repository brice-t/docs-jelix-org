<?php
/**
* @package   app
* @subpackage 
* @author    Laurent Jouanneau
* @copyright 2012 Innophi
* @link      http://innophi.com
* @license    All rights reserved
*/

require ('../application.init.php');
require (JELIX_LIB_CORE_PATH.'request/jClassicRequest.class.php');

checkAppOpened();

jApp::loadConfig('index/config.ini.php');

jApp::setCoord(new jCoordinator());
jApp::coord()->process(new jClassicRequest());



