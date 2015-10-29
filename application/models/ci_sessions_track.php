<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class CiSessionsTrack extends Doctrine_Record {
    function  setTableDefinition() {
        $this->hasColumn('session_id','string',40,array('primary'=>true,'autoincrement'=>false));
        $this->hasColumn('ip_address');
        $this->hasColumn('user_agent');
        $this->hasColumn('last_activity');
        $this->hasColumn('user_data');
    }

    function  setUp() {
        parent::setUp();
    }
}
?>
