<?php
/**
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Brice Tencé
 */

class sphinx {

    private $jCacheProfile = 'sphinxsearch';

    public function resetSources() {
        jCache::delete( 'documentId' );
    }

    public function xmlpipe2source( $listenerParams ) {

        $event = jEvent::notify('ListFields', $listenerParams);
        $fieldsList = $event->getResponse();

        $event = jEvent::notify('ListContent', $listenerParams);
        $sourcesList = $event->getResponse();

        $firstFields = null;
        $xmlWriterInst = null;
        foreach( $sourcesList as $sourceDocs ) {
            if( $sourceDocs ) {
                if( $firstFields === null ) {
                    $firstFields = array_shift( $fieldsList );
                    $currFields = $firstFields;
                    $xmlWriterInst = new xmlWriter;
                    $xmlWriterInst->openMemory();
                    $xmlWriterInst->setIndent(true);
                    $this->xmlpipe2header( $xmlWriterInst, $firstFields );
                    if( !jCache::get( 'documentId', $this->jCacheProfile ) ) {
                        jCache::set( 'documentId', 1, 0, $this->jCacheProfile );
                    }
                } else {
                    $currFields = array_shift( $fieldsList );
                }

                if( ! array_diff( $firstFields, $currFields ) == array() ) {
                    trigger_error( "jEvent got fields (" . implode(',', $currFields) .
                        ") which does not correspond to '" . implode(',', $firstFields) . "'. Skipping." , E_USER_WARNING );
                    continue;
                }

                foreach( $sourceDocs as $sourceDoc ) {
                    $documentId = jCache::get( 'documentId', $this->jCacheProfile );
                    $this->xmlpipe2document( $xmlWriterInst, $documentId, $sourceDoc['content'] );
                    jCache::set( $documentId, $sourceDoc['infos'], 0, $this->jCacheProfile );
                    jCache::increment( 'documentId', 1, $this->jCacheProfile );
                }
            } else {
                array_shift( $fieldsList );
            }
        }
        if( $xmlWriterInst !== null ) {
            $this->xmlpipe2footer( $xmlWriterInst );
            return $xmlWriterInst->flush();
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

