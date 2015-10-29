<?php
class Migration_Campos_Ficha_V2 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn( 'ficha', 'detalles', 'string' , null, array( 'notnull' => 0 ));
        $this->addColumn( 'ficha', 'primera_version_publicada_id', 'integer', 4, array( 'unsigned' => 1, 'notnull' => 0 ));
        $this->addIndex( 'ficha', 'primera_version_publicada_id', array('fields' => array('primera_version_publicada_id' => array('username' => array('sorting' => 'ascending')))) );
    }
    
    public function postUp()
    {
        ini_set('memory_limit', '1024M');
        //Se actualiza el nuevo campo de la primera version publicada de cada ficha con la publicación actual.
        $query = Doctrine_Query::create();
        $query->from('Ficha f')
            ->andWhere('f.maestro = 1')
            ->andWhere('f.publicado = 1');
        $fichas = $query->execute();

        foreach($fichas as $ficha){
            $versionPublicada = $ficha->getVersionPublicada();
            if($versionPublicada){
                $ficha->primera_version_publicada_id = $versionPublicada->id;
                $ficha->save();
            }
        }
    }

    public function down()
    {
        $this->removeColumn( 'ficha', 'detalles' );
        $this->removeColumn( 'ficha', 'primera_version_publicada_id' );
    }
}
