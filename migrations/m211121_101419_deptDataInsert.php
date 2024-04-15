<?php

use yii\db\Schema;
use yii\db\Migration;

class m211121_101419_deptDataInsert extends Migration
{

    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function safeUp()
    {
        $this->batchInsert('{{%dept}}',
                           ["code", "label"],
                            [
    [
        'code' => 'eng',
        'label' => 'Engineering',
    ],
    [
        'code' => 'prod',
        'label' => 'Production',
    ],
    [
        'code' => 'wh',
        'label' => 'Warehouse',
    ],
    [
        'code' => 'qo',
        'label' => 'Quality Operation',
    ],
    [
        'code' => 'qa',
        'label' => 'Quality Assurance',
    ],
]
        );
    }

    public function safeDown()
    {
        //$this->truncateTable('{{%dept}} CASCADE');
    }
}
