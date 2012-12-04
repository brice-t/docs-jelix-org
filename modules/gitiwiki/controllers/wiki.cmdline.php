<?php
/**
* @package   gitiwiki
* @subpackage gitiwiki
* @author    Laurent Jouanneau
* @copyright 2012 laurent Jouanneau
* @link      http://jelix.org
* @license    GNU PUBLIC LICENCE
*/

class wikiCtrl extends jControllerCmdLine {

    /**
    * Options to the command line
    *  'method_name' => array('-option_name' => true/false)
    * true means that a value should be provided for the option on the command line
    */
    protected $allowed_options = array(
            'generateBook' => array(),
            'sphinxSearchExport' => array()
    );

    /**
     * Parameters for the command line
     * 'method_name' => array('parameter_name' => true/false)
     * false means that the parameter is optionnal. All parameters which follow an optional parameter
     * is optional
     */
    protected $allowed_parameters = array(
            'generateBook' => array('repository'=>true, 'bookindex'=>true),
            'sphinxSearchExport' => array('repository'=>true)
    );
    /**
    *
    */
    function generateBook() {
        $rep = $this->getResponse();

        jClasses::inc('gtwRepo');
        $repo = new gtwRepo($this->param('repository'));
        $page = $repo->findFile($this->param('bookindex'));
        if ($page === null) {
            throw new Exception('Book index is not found');
        }        
        elseif($page instanceof gtwFile) {
            if ($page->isStaticContent()) {
                throw new Exception('The given path is not a book index');
            }

            $basePath = jUrl::get('gitiwiki~wiki:page@classic', array('repository'=>$this->param('repository'), 'page'=>''));
            // FIXME: do rules for wikirenderer that just extract book info contents.
            $html = $page->getHtmlContent($basePath);

            $extraData = $page->getExtraData();

            // for book index
            if (isset($extraData['bookContent']) && isset($extraData['bookInfos'])) {
                $books = jClasses::create('gitiwiki~gtwBooks');
                $books->saveBook($page->getCommitId(), $repo->getName(), $page->getPathFileName(), $extraData, true);
            }
            else {
                throw new Exception('The given path is not a book index');
            }
            $rep->addContent("Book is generated\n");
        }
        else {
            throw new Exception('The given path is not a page');
        }

        return $rep;
    }

     
    function sphinxSearchExport() {

        $paramRepo = $this->param('repository');

        $rep = $this->getResponse();

        jClasses::inc('gtwRepo');
        $repo = new gtwRepo($paramRepo);
        $repoConfig = $repo->config();
        if (isset($repoConfig['locale']))
            jApp::config()->locale = $repoConfig['locale'];

        $xmlwriter = new xmlWriter;
        $xmlwriter->openMemory();
        $xmlwriter->setIndent(true);
        $this->xmlpipe2header( $xmlwriter, array('page') );

        if( !jCache::get( 'documentId', 'sphinxsearch' ) ) {
            jCache::set( 'documentId', 1, 0, 'sphinxsearch' );
        }
        $this->indexPageAndChildren( $xmlwriter, $repo, '/' );

        $this->xmlpipe2footer( $xmlwriter );
        $rep->addContent( $xmlwriter->flush() );
        return $rep;
    }

    private function indexPageAndChildren( $xmlWriterInst, $repo, $pagePath ) {

        $page = $repo->findFile( $pagePath );
        if ($page !== null && ! $page instanceof gtwRedirection && ! ( $page instanceof gtwFile && $page->isStaticContent() )) {
            // let's generate the HTML content
            $basePath = jUrl::get('gitiwiki~wiki:page@classic', array('repository'=>$repo->getName(), 'page'=>''));
            $html = $page->getHtmlContent($basePath);
            $documentId = jCache::get( 'documentId', 'sphinxsearch' );
            $this->xmlpipe2document( $xmlWriterInst, $documentId, array('page' => $html) );
            jCache::set( $documentId, array( 'repo' => $repo->getName(), 'page' => $pagePath ), 0, 'sphinxsearch' );
            jCache::increment( 'documentId', 1, 'sphinxsearch' );

            if($page instanceof gtwFile) {
                $string = $page->getContent();
                if(preg_match_all("/(\s*)\-\s*(foreword|part|chapter|section)\s*\:\s*\[\[([\w\-\/\.]+)\s*\|(.*)\]\]/", $string, $matches, PREG_SET_ORDER)) {
                    foreach( $matches as $m ) {
                        list(,$level, $type, $pageId, $title) = $m;
                        $this->indexPageAndChildren( $xmlWriterInst, $repo, $pageId );
                    }
                }
            } else { // directory index
            }
        }
    }

    private function xmlpipe2header( $xmlWriterInst, $fields ) {

        $xmlWriterInst->startDocument('1.0', 'utf-8');
        $xmlWriterInst->startElement('sphinx:docset');

        $xmlWriterInst->startElement('sphinx:schema');

        foreach( $fields as $field ) {
            $xmlWriterInst->startElement('sphinx:field');
            $xmlWriterInst->writeAttribute("name", $field);
            $xmlWriterInst->endElement();
        }

        $xmlWriterInst->endElement();
    }

    private function xmlpipe2document( $xmlWriterInst, $id, $fieldsContent ) {

        $xmlWriterInst->startElement('sphinx:document');
        $xmlWriterInst->writeAttribute("id", $id);

        foreach( $fieldsContent as $fieldName => $fieldContent ) {
            $xmlWriterInst->startElement( $fieldName );
            $xmlWriterInst->text( $fieldContent );
            $xmlWriterInst->endElement();
        }

        $xmlWriterInst->endElement();
    }

    private function xmlpipe2footer( $xmlWriterInst ) {
        $xmlWriterInst->endElement();
    }
}
