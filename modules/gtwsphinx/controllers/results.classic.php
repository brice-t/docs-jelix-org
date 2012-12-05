<?php
/**
* @package   gitiwiki
* @subpackage gtwsphinx
* @author    Brice Tencé
* @copyright 2012 Brice Tencé
* @link      http://jelix.org
* @license    GNU PUBLIC LICENCE
*/

class resultsCtrl extends jController {
    /**
    *
    */
    function page() {
        $rep = $this->getResponse('html');

        $repoName = $this->param('repository');
        $searchString = $this->param('search');

        $sphinxSrv = jClasses::getService( 'sphinxsearch~sphinx' );
        $resultsInfos = $sphinxSrv->resultsInfos( $searchString, 'docs-jelix-1-5-fr' );//TODO : index name in profiles
        jLog::dump( $resultsInfos );

        $tpl = new jTpl();
        $rep->body->assign('MAIN', $tpl->fetch('repolist'));
        return $rep;
    }
}
