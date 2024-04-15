<?php

use yii\db\Schema;
use yii\db\Migration;

class m211121_102842_ordersDataInsert extends Migration
{

    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function safeUp()
    {
        $this->batchInsert('{{%orders}}',
                           ["id", "assign_to", "region_id", "initiator_id", "dept_id", "tag_num", "item_desc", "area_id", "priority", "status", "title", "detail_desc", "ehs_assest", "ehs_hazard", "ehs_hazard_risk", "replacement", "create_at", "update_at", "complete_at"],
                            [
    [
        'id' => '1112021001',
        'assign_to' => '4',
        'region_id' => '1',
        'initiator_id' => '1',
        'dept_id' => '1',
        'tag_num' => 'AC-001',
        'item_desc' => 'Dehumidifier 14-2',
        'area_id' => '11',
        'priority' => '2',
        'status' => '2',
        'title' => 'TEST akhskahsakhskaksha ashakshkahs aksjkasjkajskajs aksjaksjkajskajsak asjasjkajsakjsksjakjs jshjdhsjhdjshd ksdjksjdksdkjskdjs sdjskdjksjdksjkdj sdjskjdksjdksjd skjdksjdksjkdskjd sdjsljdlsdjsl sdlsdlsjdlj alsjlaslajslajs lajlsjalsjlajs <br> alsjlaslajs a',
        'detail_desc' => 'test zzzzzzzzzzz asasa ask;as;aks asalsalsjal askask;aks aska;sk;aska aska;sk;aks aska;ska;asas assas;aks;ka;sk ask;as;ask;a asa;sk;aks;ak laslaslakslaks aska;ks;aks;aks a;sa;ks;aks;aks;ka;ksjjasalslajs asklasklakslaks aslkalslakslask askalsklakslkalsklaks askalsklakslaklsk asaaaaaaaaa',
        'ehs_assest' => 'N/A',
        'ehs_hazard' => 'N/A',
        'ehs_hazard_risk' => 'N/A',
        'replacement' => null,
        'create_at' => '2021-11-01 03:05:00',
        'update_at' => '2021-11-01 03:05:00',
        'complete_at' => '2021-11-01 04:05:00',
    ],
    [
        'id' => '1112021002',
        'assign_to' => '1',
        'region_id' => '1',
        'initiator_id' => '4',
        'dept_id' => '3',
        'tag_num' => 'WS-33-13310',
        'item_desc' => 'Weight',
        'area_id' => '66',
        'priority' => '2',
        'status' => '2',
        'title' => 'asasasasas',
        'detail_desc' => 'asasasdfdf',
        'ehs_assest' => 'N/A',
        'ehs_hazard' => 'N/A',
        'ehs_hazard_risk' => null,
        'replacement' => null,
        'create_at' => '2021-11-10 23:17:00',
        'update_at' => '2021-11-10 23:17:00',
        'complete_at' => '2021-11-11 23:17:00',
    ],
    [
        'id' => '1112021003',
        'assign_to' => '2',
        'region_id' => '1',
        'initiator_id' => '1',
        'dept_id' => '1',
        'tag_num' => 'AC-016',
        'item_desc' => 'AHU System 3',
        'area_id' => '45',
        'priority' => '2',
        'status' => '1',
        'title' => 'axxxx',
        'detail_desc' => 'a',
        'ehs_assest' => 'N/A',
        'ehs_hazard' => 'N/A',
        'ehs_hazard_risk' => null,
        'replacement' => null,
        'create_at' => '2021-11-12 14:42:00',
        'update_at' => '2021-11-12 14:42:00',
        'complete_at' => null,
    ],
    [
        'id' => '2112021001',
        'assign_to' => '40',
        'region_id' => '2',
        'initiator_id' => '1',
        'dept_id' => '1',
        'tag_num' => 'ENG-INS-ATM302',
        'item_desc' => 'Anak Timbang',
        'area_id' => '39',
        'priority' => '1',
        'status' => '1',
        'title' => 'asasa',
        'detail_desc' => 'asas',
        'ehs_assest' => 'N/A',
        'ehs_hazard' => 'N/A',
        'ehs_hazard_risk' => null,
        'replacement' => null,
        'create_at' => '2021-11-15 23:05:00',
        'update_at' => '2021-11-15 23:05:00',
        'complete_at' => null,
    ],
]
        );
    }

    public function safeDown()
    {
        //$this->truncateTable('{{%orders}} CASCADE');
    }
}
