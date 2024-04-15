<?php

use yii\db\Schema;
use yii\db\Migration;

class m211121_101647_regionDataInsert extends Migration
{

    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function safeUp()
    {
        $this->batchInsert('{{%region}}',
                           ["dept_id", "nama"],
                            [
    [
        'dept_id' => '1',
        'nama' => 'Maintenace',
    ],
    [
        'dept_id' => '1',
        'nama' => 'Utility',
    ],
    [
        'dept_id' => '1',
        'nama' => 'Calibration',
    ],
    [
        'dept_id' => '1',
        'nama' => 'Automation',
    ],
    [
        'dept_id' => '1',
        'nama' => 'Facility',
    ],
    [
        'dept_id' => '1',
        'nama' => 'EHS',
    ],
    [
        'dept_id' => '1',
        'nama' => 'Other',
    ],
]
        );
    }

    public function safeDown()
    {
        //$this->truncateTable('{{%region}} CASCADE');
    }
}
