<?php

class Diccionario extends Doctrine_Record{
    public function setTableDefinition() {
        $this->hasColumn('id');
        $this->hasColumn('termino');
        $this->hasColumn('definicion');
    }
}