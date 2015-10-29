<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class SearchLog extends Doctrine_Record {
    
    function  setTableDefinition() {
        $this->hasColumn('id');
        $this->hasColumn('search_query');
        $this->hasColumn('search_query_parsed');
        $this->hasColumn('cantidad_resultados');
        $this->hasColumn('version','integer',4,array('default'=>2));
        $this->hasColumn('referrer');
        $this->hasColumn('parametros');
        $this->hasColumn('session_id');
    }

    function  setUp() {
        parent::setUp();
        $this->actAs('Timestampable');
    }
}
?>
