<?php

class SearchPromocionado extends Doctrine_Record{
    
    public function setTableDefinition() {
        parent::setTableDefinition();
        
        $this->hasColumn('id');
        $this->hasColumn('titulo');
        $this->hasColumn('introtext');
        $this->hasColumn('url');
        $this->hasColumn('query');
        $this->hasColumn('regex');
        $this->hasColumn('orden');
        $this->hasColumn('activo');
        
        
    }
    
}