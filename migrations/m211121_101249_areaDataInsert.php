<?php

use yii\db\Schema;
use yii\db\Migration;

class m211121_101249_areaDataInsert extends Migration
{

    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function safeUp()
    {
        $this->batchInsert('{{%area}}',
                           ["label_a"],
                            [
    [
        'label_a' => 'AHU 03',
    ],
    [
        'label_a' => 'AHU 09',
    ],
    [
        'label_a' => 'AHU 14',
    ],
    [
        'label_a' => 'AHU 14A',
    ],
    [
        'label_a' => 'AHU 14B',
    ],
    [
        'label_a' => 'AHU 15',
    ],
    [
        'label_a' => 'AHU 16',
    ],
    [
        'label_a' => 'AHU 17',
    ],
    [
        'label_a' => 'AHU 18',
    ],
    [
        'label_a' => 'AHU 20',
    ],
    [
        'label_a' => 'AHU 21',
    ],
    [
        'label_a' => 'AHU 24.1',
    ],
    [
        'label_a' => 'AHU 24.2',
    ],
    [
        'label_a' => 'AHU 25',
    ],
    [
        'label_a' => 'AHU 26',
    ],
    [
        'label_a' => 'AHU 27',
    ],
    [
        'label_a' => 'AHU 28',
    ],
    [
        'label_a' => 'AHU 304',
    ],
    [
        'label_a' => 'AHU 305',
    ],
    [
        'label_a' => 'AHU 9',
    ],
    [
        'label_a' => 'AHU 9.2',
    ],
    [
        'label_a' => 'AHU 9.3&9.4',
    ],
    [
        'label_a' => 'AHU 9.4',
    ],
    [
        'label_a' => 'Airlock',
    ],
    [
        'label_a' => 'Biologycal Safety Cabinet',
    ],
    [
        'label_a' => 'Cimanggis',
    ],
    [
        'label_a' => 'Coldbox GD05',
    ],
    [
        'label_a' => 'Combantrin Area',
    ],
    [
        'label_a' => 'Cooling Stg',
    ],
    [
        'label_a' => 'Corridor',
    ],
    [
        'label_a' => 'Female Access Area',
    ],
    [
        'label_a' => 'Filtration',
    ],
    [
        'label_a' => 'Generator',
    ],
    [
        'label_a' => 'Gowning',
    ],
    [
        'label_a' => 'Isolator',
    ],
    [
        'label_a' => 'Janitor Storage',
    ],
    [
        'label_a' => 'Kalibrasi',
    ],
    [
        'label_a' => 'Kontainer',
    ],
    [
        'label_a' => 'Lab. Kalibrasi',
    ],
    [
        'label_a' => 'LAF EQU 4',
    ],
    [
        'label_a' => 'Laundry',
    ],
    [
        'label_a' => 'Lytzen',
    ],
    [
        'label_a' => 'Male Access Area',
    ],
    [
        'label_a' => 'Mezanine',
    ],
    [
        'label_a' => 'Mezzanine',
    ],
    [
        'label_a' => 'Micro Lab.',
    ],
    [
        'label_a' => 'Mobile',
    ],
    [
        'label_a' => 'Ointment',
    ],
    [
        'label_a' => 'Other Coump',
    ],
    [
        'label_a' => 'Other Liq Fill',
    ],
    [
        'label_a' => 'Outside',
    ],
    [
        'label_a' => 'Packaging',
    ],
    [
        'label_a' => 'Process Oint',
    ],
    [
        'label_a' => 'Production',
    ],
    [
        'label_a' => 'R-102',
    ],
    [
        'label_a' => 'R-103',
    ],
    [
        'label_a' => 'R-108',
    ],
    [
        'label_a' => 'R-109',
    ],
    [
        'label_a' => 'R-110',
    ],
    [
        'label_a' => 'R-1100',
    ],
    [
        'label_a' => 'R-112',
    ],
    [
        'label_a' => 'R-114',
    ],
    [
        'label_a' => 'R-1200',
    ],
    [
        'label_a' => 'R-123',
    ],
    [
        'label_a' => 'R-1300',
    ],
    [
        'label_a' => 'R-133',
    ],
    [
        'label_a' => 'R-134',
    ],
    [
        'label_a' => 'R-135',
    ],
    [
        'label_a' => 'R-135 A',
    ],
    [
        'label_a' => 'R-135A',
    ],
    [
        'label_a' => 'R-136',
    ],
    [
        'label_a' => 'R-137',
    ],
    [
        'label_a' => 'R-139',
    ],
    [
        'label_a' => 'R-140',
    ],
    [
        'label_a' => 'R-1400',
    ],
    [
        'label_a' => 'R-141',
    ],
    [
        'label_a' => 'R-142',
    ],
    [
        'label_a' => 'R-143',
    ],
    [
        'label_a' => 'R-144A',
    ],
    [
        'label_a' => 'R-144B',
    ],
    [
        'label_a' => 'R-145',
    ],
    [
        'label_a' => 'R-1500',
    ],
    [
        'label_a' => 'R-151',
    ],
    [
        'label_a' => 'R-152',
    ],
    [
        'label_a' => 'R-153',
    ],
    [
        'label_a' => 'R-154',
    ],
    [
        'label_a' => 'R-155',
    ],
    [
        'label_a' => 'R-156',
    ],
    [
        'label_a' => 'R-157',
    ],
    [
        'label_a' => 'R-158',
    ],
    [
        'label_a' => 'R-160',
    ],
    [
        'label_a' => 'R-1600',
    ],
    [
        'label_a' => 'R-162',
    ],
    [
        'label_a' => 'R-163',
    ],
    [
        'label_a' => 'R-164',
    ],
    [
        'label_a' => 'R-165',
    ],
    [
        'label_a' => 'R-166',
    ],
    [
        'label_a' => 'R-167',
    ],
    [
        'label_a' => 'R-168',
    ],
    [
        'label_a' => 'R-1700',
    ],
    [
        'label_a' => 'R-182',
    ],
    [
        'label_a' => 'R-183',
    ],
    [
        'label_a' => 'R-185',
    ],
    [
        'label_a' => 'R-190',
    ],
    [
        'label_a' => 'R-191',
    ],
    [
        'label_a' => 'R-192',
    ],
    [
        'label_a' => 'R-193',
    ],
    [
        'label_a' => 'R-203',
    ],
    [
        'label_a' => 'R-204',
    ],
    [
        'label_a' => 'R-209',
    ],
    [
        'label_a' => 'R-210',
    ],
    [
        'label_a' => 'R-212',
    ],
    [
        'label_a' => 'R-213',
    ],
    [
        'label_a' => 'R-217',
    ],
    [
        'label_a' => 'R-251',
    ],
    [
        'label_a' => 'R-253',
    ],
    [
        'label_a' => 'R-256',
    ],
    [
        'label_a' => 'R-257',
    ],
    [
        'label_a' => 'R-258',
    ],
    [
        'label_a' => 'R-259',
    ],
    [
        'label_a' => 'R-301',
    ],
    [
        'label_a' => 'R-302',
    ],
    [
        'label_a' => 'R-304',
    ],
    [
        'label_a' => 'R-305',
    ],
    [
        'label_a' => 'R-306',
    ],
    [
        'label_a' => 'R-307',
    ],
    [
        'label_a' => 'R-308',
    ],
    [
        'label_a' => 'R-309',
    ],
    [
        'label_a' => 'R-310',
    ],
    [
        'label_a' => 'R-311',
    ],
    [
        'label_a' => 'R-312',
    ],
    [
        'label_a' => 'R-313',
    ],
    [
        'label_a' => 'R-314 ',
    ],
    [
        'label_a' => 'R-316',
    ],
    [
        'label_a' => 'R-317',
    ],
    [
        'label_a' => 'R-318',
    ],
    [
        'label_a' => 'R-319',
    ],
    [
        'label_a' => 'R-321',
    ],
    [
        'label_a' => 'R-323',
    ],
    [
        'label_a' => 'R-324',
    ],
    [
        'label_a' => 'R-328',
    ],
    [
        'label_a' => 'R-332',
    ],
    [
        'label_a' => 'R-334',
    ],
    [
        'label_a' => 'R-5100',
    ],
    [
        'label_a' => 'R-5200',
    ],
    [
        'label_a' => 'R-5300',
    ],
    [
        'label_a' => 'R-5400',
    ],
    [
        'label_a' => 'R-5Q001',
    ],
    [
        'label_a' => 'R-5Q002',
    ],
    [
        'label_a' => 'R-Genset',
    ],
    [
        'label_a' => 'R-Stability',
    ],
    [
        'label_a' => 'Raw Goods Warehouse',
    ],
    [
        'label_a' => 'Sampling booth',
    ],
    [
        'label_a' => 'Storage Cold Box',
    ],
    [
        'label_a' => 'Storage Coldbox',
    ],
    [
        'label_a' => 'Truck Box',
    ],
    [
        'label_a' => 'Uniform',
    ],
    [
        'label_a' => 'Utilities Area',
    ],
    [
        'label_a' => 'Utility',
    ],
    [
        'label_a' => 'Utility Area',
    ],
    [
        'label_a' => 'Utility Control Room',
    ],
    [
        'label_a' => 'UV',
    ],
    [
        'label_a' => 'Visine Coump',
    ],
    [
        'label_a' => 'Visine Liq',
    ],
    [
        'label_a' => 'Ware house',
    ],
    [
        'label_a' => 'Warehouse',
    ],
    [
        'label_a' => 'Washing Str',
    ],
    [
        'label_a' => 'q',
    ],
    [
        'label_a' => 'w',
    ],
    [
        'label_a' => '4',
    ],
    [
        'label_a' => '1',
    ],
    [
        'label_a' => 'a',
    ],
    [
        'label_a' => 'z',
    ],
    [
        'label_a' => 'z1',
    ],
    [
        'label_a' => 'x',
    ],
    [
        'label_a' => 'x1',
    ],
    [
        'label_a' => 's1',
    ],
    [
        'label_a' => 'x2',
    ],
    [
        'label_a' => 'x211',
    ],
    [
        'label_a' => 'x2111',
    ],
    [
        'label_a' => 'x211111',
    ],
    [
        'label_a' => '11',
    ],
    [
        'label_a' => 'w1',
    ],
    [
        'label_a' => 'w11',
    ],
    [
        'label_a' => 'w111',
    ],
    [
        'label_a' => 'w1111',
    ],
    [
        'label_a' => 'w111111',
    ],
    [
        'label_a' => '3',
    ],
    [
        'label_a' => '31',
    ],
    [
        'label_a' => '311',
    ],
    [
        'label_a' => '411',
    ],
    [
        'label_a' => '5',
    ],
    [
        'label_a' => '51',
    ],
    [
        'label_a' => 'b',
    ],
    [
        'label_a' => 'c',
    ],
    [
        'label_a' => 'az',
    ],
    [
        'label_a' => 'aza',
    ],
    [
        'label_a' => 'azaw',
    ],
    [
        'label_a' => 'azawa',
    ],
    [
        'label_a' => 'azawaa',
    ],
    [
        'label_a' => 'azawaaak',
    ],
    [
        'label_a' => 'azawaaak1',
    ],
    [
        'label_a' => 'azawaaak133',
    ],
    [
        'label_a' => 'cc',
    ],
    [
        'label_a' => 'ccc',
    ],
    [
        'label_a' => 'cccc',
    ],
    [
        'label_a' => 'vv',
    ],
    [
        'label_a' => 'vv1',
    ],
    [
        'label_a' => 'vv11',
    ],
    [
        'label_a' => 'vv111',
    ],
    [
        'label_a' => 'vv1111',
    ],
    [
        'label_a' => 'vv11111',
    ],
    [
        'label_a' => 'vv111111',
    ],
    [
        'label_a' => '1vv111111',
    ],
    [
        'label_a' => 'e',
    ],
    [
        'label_a' => 'ew',
    ],
    [
        'label_a' => 'ss',
    ],
    [
        'label_a' => 'aa',
    ],
    [
        'label_a' => 'ww',
    ],
    [
        'label_a' => 'qq',
    ],
    [
        'label_a' => 'qqq',
    ],
    [
        'label_a' => 'ww3',
    ],
    [
        'label_a' => 'aasa',
    ],
]
        );
    }

    public function safeDown()
    {
        //$this->truncateTable('{{%area}} CASCADE');
    }
}
