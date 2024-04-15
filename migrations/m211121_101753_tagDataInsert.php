<?php

use yii\db\Schema;
use yii\db\Migration;

class m211121_101753_tagDataInsert extends Migration
{

    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function safeUp()
    {
        $this->batchInsert('{{%tag}}',
                           ["area_id", "tagnum", "desc"],
                            [
    [
        'area_id' => '84',
        'tagnum' => 'BR-21-15101',
        'desc' => 'Balance Indicator',
    ],
    [
        'area_id' => '84',
        'tagnum' => 'BR-21-15102',
        'desc' => 'Balance Indicator',
    ],
    [
        'area_id' => '87',
        'tagnum' => 'BR-21-15401',
        'desc' => 'Balance Indicator',
    ],
    [
        'area_id' => '137',
        'tagnum' => 'BR-21-15501',
        'desc' => 'Balance Indicator',
    ],
    [
        'area_id' => '97',
        'tagnum' => 'BR-21-15502',
        'desc' => 'Balance Indicator',
    ],
    [
        'area_id' => '140',
        'tagnum' => 'BR-21-15503',
        'desc' => 'Balance Indicator',
    ],
    [
        'area_id' => '86',
        'tagnum' => 'BR-21-16501',
        'desc' => 'Balance Indicator',
    ],
    [
        'area_id' => '88',
        'tagnum' => 'BR-21-16502',
        'desc' => 'Balance Indicator',
    ],
    [
        'area_id' => '86',
        'tagnum' => 'BR-21-31601',
        'desc' => 'Balance Indicator',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'BR-22-11001',
        'desc' => 'Balance Indicator',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'BR-22-11002',
        'desc' => 'Balance Indicator',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'BR-22-11005',
        'desc' => 'Balance Indicator',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'BR-22-11006',
        'desc' => 'Check Weigher',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'BR-22-11008',
        'desc' => 'Balance Indicator',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'BR-22-11010',
        'desc' => 'Balance Indicator',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'BR-22-11011',
        'desc' => 'Balance Readout',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'BR-22-11012',
        'desc' => 'Balance Indicator',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'BR-22-11013',
        'desc' => 'Balance Indicator',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'BR-22-11014',
        'desc' => 'Balance Indicator',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'BR-22-11015',
        'desc' => 'Check Weigher',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'BR-22-11016',
        'desc' => 'Balance',
    ],
    [
        'area_id' => '79',
        'tagnum' => 'BR-25-14302',
        'desc' => 'Balance Indicator',
    ],
    [
        'area_id' => '66',
        'tagnum' => 'BR-32-11201',
        'desc' => 'Balance Indicator',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'BR-33-10302',
        'desc' => 'Balance Indicator',
    ],
    [
        'area_id' => '57',
        'tagnum' => 'BR-33-10306',
        'desc' => 'Balance Indicator',
    ],
    [
        'area_id' => '139',
        'tagnum' => 'BR-33-10307',
        'desc' => 'Balance Indicator',
    ],
    [
        'area_id' => '67',
        'tagnum' => 'BR-33-10308',
        'desc' => 'Balance Indicator',
    ],
    [
        'area_id' => '67',
        'tagnum' => 'BR-33-32802',
        'desc' => 'Balance Readout',
    ],
    [
        'area_id' => '142',
        'tagnum' => 'BR-33-32803',
        'desc' => 'Balance Readout',
    ],
    [
        'area_id' => '135',
        'tagnum' => 'BR-33-32804',
        'desc' => 'Balance Readout',
    ],
    [
        'area_id' => '142',
        'tagnum' => 'BR-33-32805',
        'desc' => 'Balance Indicator',
    ],
    [
        'area_id' => '67',
        'tagnum' => 'BR-93-00101-A',
        'desc' => 'Balance Indicator',
    ],
    [
        'area_id' => '67',
        'tagnum' => 'BR-93-00101-B',
        'desc' => 'Balance Indicator',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'BR-93-00101-C',
        'desc' => 'Balance Indicator',
    ],
    [
        'area_id' => '99',
        'tagnum' => 'BR-93-02101',
        'desc' => 'Balance Indicator',
    ],
    [
        'area_id' => '92',
        'tagnum' => 'BR-93-02102',
        'desc' => 'Balance Indicator',
    ],
    [
        'area_id' => '69',
        'tagnum' => 'CIT-11-13503-CB',
        'desc' => 'Conductivity Transmitter',
    ],
    [
        'area_id' => '69',
        'tagnum' => 'CIT-11-13506-CB',
        'desc' => 'Conductivity Transmitter',
    ],
    [
        'area_id' => '69',
        'tagnum' => 'CIT-11-13507-CB',
        'desc' => 'Conductivity Meter',
    ],
    [
        'area_id' => '69',
        'tagnum' => 'CIT-11-13508-CB',
        'desc' => 'Conductivity Meter',
    ],
    [
        'area_id' => '69',
        'tagnum' => 'CIT-11-13509-CB',
        'desc' => 'Conductivity Meter',
    ],
    [
        'area_id' => '72',
        'tagnum' => 'CIT-11-13605-CB',
        'desc' => 'Conductivity Meter',
    ],
    [
        'area_id' => '72',
        'tagnum' => 'CIT-11-13606-CB',
        'desc' => 'Conductivity Meter',
    ],
    [
        'area_id' => '72',
        'tagnum' => 'CIT-11-13607-CB',
        'desc' => 'Conductivity Meter',
    ],
    [
        'area_id' => '72',
        'tagnum' => 'CIT-11-13608-CB',
        'desc' => 'Conductivity Meter',
    ],
    [
        'area_id' => '126',
        'tagnum' => 'CIT-11-30602',
        'desc' => 'Conductivity Meter',
    ],
    [
        'area_id' => '126',
        'tagnum' => 'CIT-19-30601',
        'desc' => 'Conductivity Transmitter',
    ],
    [
        'area_id' => '44',
        'tagnum' => 'DPI-19-33201',
        'desc' => 'Differential Pressure',
    ],
    [
        'area_id' => '84',
        'tagnum' => 'DPI-21-15101',
        'desc' => 'Differential Pressure Digital',
    ],
    [
        'area_id' => '85',
        'tagnum' => 'DPI-21-15203',
        'desc' => 'Differential Pressure Digital',
    ],
    [
        'area_id' => '87',
        'tagnum' => 'DPI-21-15403',
        'desc' => 'Differential Pressure Digital',
    ],
    [
        'area_id' => '88',
        'tagnum' => 'DPI-21-15501',
        'desc' => 'Differential Pressure Digital',
    ],
    [
        'area_id' => '89',
        'tagnum' => 'DPI-21-15603',
        'desc' => 'Differential Pressure Digital',
    ],
    [
        'area_id' => '90',
        'tagnum' => 'DPI-21-15703',
        'desc' => 'Differential Pressure Digital',
    ],
    [
        'area_id' => '91',
        'tagnum' => 'DPI-21-15803',
        'desc' => 'Differential Pressure Digital',
    ],
    [
        'area_id' => '92',
        'tagnum' => 'DPI-21-16001',
        'desc' => 'Differential Pressure',
    ],
    [
        'area_id' => '92',
        'tagnum' => 'DPI-21-16002',
        'desc' => 'Differential Pressure Digital',
    ],
    [
        'area_id' => '94',
        'tagnum' => 'DPI-21-16204',
        'desc' => 'Differential Pressure Digital',
    ],
    [
        'area_id' => '95',
        'tagnum' => 'DPI-21-16303',
        'desc' => 'Differential Pressure Digital',
    ],
    [
        'area_id' => '96',
        'tagnum' => 'DPI-21-16403',
        'desc' => 'Differential Pressure Digital',
    ],
    [
        'area_id' => '97',
        'tagnum' => 'DPI-21-16501',
        'desc' => 'Differential Pressure Digital',
    ],
    [
        'area_id' => '98',
        'tagnum' => 'DPI-21-16603',
        'desc' => 'Differential Pressure Digital',
    ],
    [
        'area_id' => '99',
        'tagnum' => 'DPI-21-16703',
        'desc' => 'Differential Pressure Digital',
    ],
    [
        'area_id' => '100',
        'tagnum' => 'DPI-21-16803',
        'desc' => 'Differential Pressure Digital',
    ],
    [
        'area_id' => '122',
        'tagnum' => 'DPI-21-30104',
        'desc' => 'Differential Pressure Digital',
    ],
    [
        'area_id' => '122',
        'tagnum' => 'DPI-21-30105',
        'desc' => 'Differential Pressure Indicator',
    ],
    [
        'area_id' => '122',
        'tagnum' => 'DPI-21-30106',
        'desc' => 'Differential Pressure Indicator',
    ],
    [
        'area_id' => '122',
        'tagnum' => 'DPI-21-30107',
        'desc' => 'Differential Pressure Indicator',
    ],
    [
        'area_id' => '123',
        'tagnum' => 'DPI-21-30203',
        'desc' => 'Differential Pressure Digital',
    ],
    [
        'area_id' => '130',
        'tagnum' => 'DPI-21-31001',
        'desc' => 'Differential Pressure Digital',
    ],
    [
        'area_id' => '131',
        'tagnum' => 'DPI-21-31101',
        'desc' => 'Differential Pressure Digital',
    ],
    [
        'area_id' => '132',
        'tagnum' => 'DPI-21-31201',
        'desc' => 'Differential Pressure Digital',
    ],
    [
        'area_id' => '133',
        'tagnum' => 'DPI-21-31301',
        'desc' => 'Differential Pressure Digital',
    ],
    [
        'area_id' => '104',
        'tagnum' => 'DPI-26-18501-COM',
        'desc' => 'Differential Pressure',
    ],
    [
        'area_id' => '104',
        'tagnum' => 'DPI-26-18502-COM',
        'desc' => 'Differential Pressure',
    ],
    [
        'area_id' => '104',
        'tagnum' => 'DPI-26-18504-COM',
        'desc' => 'Differential Pressure',
    ],
    [
        'area_id' => '104',
        'tagnum' => 'DPI-26-18505-COM',
        'desc' => 'Differential Pressure',
    ],
    [
        'area_id' => '104',
        'tagnum' => 'DPI-26-18506-COM',
        'desc' => 'Differential Pressure',
    ],
    [
        'area_id' => '104',
        'tagnum' => 'DPI-26-18507-COM',
        'desc' => 'Differential Pressure',
    ],
    [
        'area_id' => '116',
        'tagnum' => 'DPI-26-25101',
        'desc' => 'Differential Pressure',
    ],
    [
        'area_id' => '116',
        'tagnum' => 'DPI-26-25102',
        'desc' => 'Differential Pressure',
    ],
    [
        'area_id' => '116',
        'tagnum' => 'DPI-26-25103',
        'desc' => 'Differential Pressure',
    ],
    [
        'area_id' => '116',
        'tagnum' => 'DPI-26-25104',
        'desc' => 'Differential Pressure',
    ],
    [
        'area_id' => '116',
        'tagnum' => 'DPI-26-25105',
        'desc' => 'Differential Pressure',
    ],
    [
        'area_id' => '116',
        'tagnum' => 'DPI-26-25106',
        'desc' => 'Differential Pressure',
    ],
    [
        'area_id' => '116',
        'tagnum' => 'DPI-26-25107',
        'desc' => 'Differential Pressure',
    ],
    [
        'area_id' => '116',
        'tagnum' => 'DPI-26-25108',
        'desc' => 'Differential Pressure',
    ],
    [
        'area_id' => '119',
        'tagnum' => 'DPI-26-25701',
        'desc' => 'Differential Pressure',
    ],
    [
        'area_id' => '63',
        'tagnum' => 'DPI-31-11401',
        'desc' => 'Differential Pressure',
    ],
    [
        'area_id' => '63',
        'tagnum' => 'DPI-31-11402',
        'desc' => 'Differential Pressure',
    ],
    [
        'area_id' => '63',
        'tagnum' => 'DPI-31-11403',
        'desc' => 'Differential Pressure',
    ],
    [
        'area_id' => '63',
        'tagnum' => 'DPI-31-11404',
        'desc' => 'Differential Pressure',
    ],
    [
        'area_id' => '67',
        'tagnum' => 'DPI-33-13302',
        'desc' => 'Differential Pressure',
    ],
    [
        'area_id' => '67',
        'tagnum' => 'DPI-33-13303',
        'desc' => 'Differential Pressure',
    ],
    [
        'area_id' => '67',
        'tagnum' => 'DPI-33-13304-MOV',
        'desc' => 'Differential Pressure Gauge',
    ],
    [
        'area_id' => '67',
        'tagnum' => 'DPI-33-13305',
        'desc' => 'Differential Pressure',
    ],
    [
        'area_id' => '142',
        'tagnum' => 'DPI-33-32801',
        'desc' => 'Differential Pressure Gauge',
    ],
    [
        'area_id' => '142',
        'tagnum' => 'DPI-33-32802',
        'desc' => 'Differential Pressure Gauge',
    ],
    [
        'area_id' => '142',
        'tagnum' => 'DPI-33-32803',
        'desc' => 'Differential Pressure Gauge',
    ],
    [
        'area_id' => '63',
        'tagnum' => 'DPI-41-11405',
        'desc' => 'Differential Pressure Gauge',
    ],
    [
        'area_id' => '63',
        'tagnum' => 'DPI-41-11406',
        'desc' => 'Differential Pressure Gauge',
    ],
    [
        'area_id' => '118',
        'tagnum' => 'DPI-42-25601-BSC',
        'desc' => 'Differential Pressure Gauge',
    ],
    [
        'area_id' => '75',
        'tagnum' => 'DPS-24-14001',
        'desc' => 'Differential Pressure Switch',
    ],
    [
        'area_id' => '75',
        'tagnum' => 'DPS-24-14002',
        'desc' => 'Differential Pressure Switch',
    ],
    [
        'area_id' => '75',
        'tagnum' => 'DPS-24-14003',
        'desc' => 'Differential Pressure Switch',
    ],
    [
        'area_id' => '75',
        'tagnum' => 'DPS-24-14004',
        'desc' => 'Differential Pressure Switch',
    ],
    [
        'area_id' => '8',
        'tagnum' => 'DPT-13-33305',
        'desc' => 'Differential Pressure Transmitter',
    ],
    [
        'area_id' => '11',
        'tagnum' => 'DPT-13-33308',
        'desc' => 'Differential Pressure Transmitter',
    ],
    [
        'area_id' => '5',
        'tagnum' => 'DPT-13-33314',
        'desc' => 'Differential Pressure Transmitter',
    ],
    [
        'area_id' => '13',
        'tagnum' => 'DPT-13-33320',
        'desc' => 'Differential Pressure Transmitter',
    ],
    [
        'area_id' => '14',
        'tagnum' => 'DPT-13-33323',
        'desc' => 'Differential Pressure Transmitter',
    ],
    [
        'area_id' => '17',
        'tagnum' => 'DPT-13-33326',
        'desc' => 'Differential Pressure Transmitter',
    ],
    [
        'area_id' => '23',
        'tagnum' => 'DPT-13-33328',
        'desc' => 'Differential Pressure Transmitter',
    ],
    [
        'area_id' => '136',
        'tagnum' => 'DPT-21-31701',
        'desc' => 'Differential Pressure Transmitter',
    ],
    [
        'area_id' => '137',
        'tagnum' => 'DPT-21-31801',
        'desc' => 'Differential Pressure Transmitter',
    ],
    [
        'area_id' => '138',
        'tagnum' => 'DPT-21-31901',
        'desc' => 'Differential Pressure Transmitter',
    ],
    [
        'area_id' => '139',
        'tagnum' => 'DPT-21-32101',
        'desc' => 'Differential Pressure Transmitter',
    ],
    [
        'area_id' => '140',
        'tagnum' => 'DPT-21-32301',
        'desc' => 'Differential Pressure Transmitter',
    ],
    [
        'area_id' => '141',
        'tagnum' => 'DPT-21-32401',
        'desc' => 'Differential Pressure Transmitter',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'DPT-22-11001',
        'desc' => 'Differential Pressure Transmitter',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'DPT-22-11002',
        'desc' => 'Differential Pressure Transmitter',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'DPT-22-11003',
        'desc' => 'Differential Pressure Transmitter',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'DPT-22-11004',
        'desc' => 'Differential Pressure Transmitter',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'DPT-22-11005',
        'desc' => 'Differential Pressure Transmitter',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'DPT-22-11006',
        'desc' => 'Differential Pressure Transmitter',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'DPT-22-11007',
        'desc' => 'Differential Pressure Transmitter',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'DPT-22-11008',
        'desc' => 'Differential Pressure Transmitter',
    ],
    [
        'area_id' => '63',
        'tagnum' => 'DPT-31-11401',
        'desc' => 'Differential Pressure Transmitter',
    ],
    [
        'area_id' => '63',
        'tagnum' => 'DPT-31-11402',
        'desc' => 'Differential Pressure Transmitter',
    ],
    [
        'area_id' => '63',
        'tagnum' => 'DPT-31-11403',
        'desc' => 'Differential Pressure Transmitter',
    ],
    [
        'area_id' => '117',
        'tagnum' => 'DPT-42-25301',
        'desc' => 'Differential Pressure Transmitter',
    ],
    [
        'area_id' => '117',
        'tagnum' => 'DPT-42-25302',
        'desc' => 'Differential Pressure Transmitter',
    ],
    [
        'area_id' => '39',
        'tagnum' => 'ENG-INS-16010001',
        'desc' => 'Thermometer Calibration KIT',
    ],
    [
        'area_id' => '37',
        'tagnum' => 'ENG-INS-25DT0047',
        'desc' => 'Digital Manometer',
    ],
    [
        'area_id' => '39',
        'tagnum' => 'ENG-INS-58506H',
        'desc' => 'Temperature Calibration Block HTR',
    ],
    [
        'area_id' => '39',
        'tagnum' => 'ENG-INS-58506L',
        'desc' => 'Temperature Calibration Block LTR',
    ],
    [
        'area_id' => '39',
        'tagnum' => 'ENG-INS-ATM301',
        'desc' => 'Anak Timbang',
    ],
    [
        'area_id' => '39',
        'tagnum' => 'ENG-INS-ATM302',
        'desc' => 'Anak Timbang',
    ],
    [
        'area_id' => '39',
        'tagnum' => 'ENG-INS-ATM303',
        'desc' => 'Anak Timbang',
    ],
    [
        'area_id' => '39',
        'tagnum' => 'ENG-INS-ATM304',
        'desc' => 'Anak Timbang',
    ],
    [
        'area_id' => '39',
        'tagnum' => 'ENG-INS-ATM305',
        'desc' => 'Anak Timbang',
    ],
    [
        'area_id' => '92',
        'tagnum' => 'FM-21-16001',
        'desc' => 'Flow Meter',
    ],
    [
        'area_id' => '139',
        'tagnum' => 'FM-21-32101',
        'desc' => 'Flow Meter',
    ],
    [
        'area_id' => '15',
        'tagnum' => 'FT-13-33301',
        'desc' => 'Air Flow Tranmitter',
    ],
    [
        'area_id' => '16',
        'tagnum' => 'FT-13-33302',
        'desc' => 'Air Flow Tranmitter',
    ],
    [
        'area_id' => '140',
        'tagnum' => 'FT-21-32301',
        'desc' => 'Air Flow Sensor',
    ],
    [
        'area_id' => '69',
        'tagnum' => 'I/P-11-13516.1-JB',
        'desc' => 'I/P Converter',
    ],
    [
        'area_id' => '69',
        'tagnum' => 'I/P-11-1353.1-JB',
        'desc' => 'I/P Converter',
    ],
    [
        'area_id' => '72',
        'tagnum' => 'I/P-11-13610.10-CB',
        'desc' => 'I/P Converter',
    ],
    [
        'area_id' => '72',
        'tagnum' => 'I/P-11-13610.5-CB',
        'desc' => 'I/P Converter',
    ],
    [
        'area_id' => '72',
        'tagnum' => 'I/P-11-13615.15-CB',
        'desc' => 'I/P Converter',
    ],
    [
        'area_id' => '72',
        'tagnum' => 'I/P-11-13615.1-CB',
        'desc' => 'I/P Converter',
    ],
    [
        'area_id' => '72',
        'tagnum' => 'I/P-11-13620-CB',
        'desc' => 'I/P Converter',
    ],
    [
        'area_id' => '144',
        'tagnum' => 'PI-11-33402-BMI',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'PI-21-11011',
        'desc' => 'Vacuum  Gauge',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'PI-21-11012',
        'desc' => 'Pressure  Gauge',
    ],
    [
        'area_id' => '92',
        'tagnum' => 'PI-21-16002',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '92',
        'tagnum' => 'PI-21-16003',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '130',
        'tagnum' => 'PI-21-31001',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '130',
        'tagnum' => 'PI-21-31002',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '136',
        'tagnum' => 'PI-21-31702',
        'desc' => 'Pressure Indicator',
    ],
    [
        'area_id' => '139',
        'tagnum' => 'PI-21-32101',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '139',
        'tagnum' => 'PI-21-32102',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '139',
        'tagnum' => 'PI-21-32103',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '139',
        'tagnum' => 'PI-21-32104',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '140',
        'tagnum' => 'PI-21-32301',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '140',
        'tagnum' => 'PI-21-32302',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'PI-22-11003',
        'desc' => 'Pressure Indicator',
    ],
    [
        'area_id' => '75',
        'tagnum' => 'PI-24-14005',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '82',
        'tagnum' => 'PI-24-14503',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '82',
        'tagnum' => 'PI-24-14511',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '81',
        'tagnum' => 'PI-25-14401-B',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '81',
        'tagnum' => 'PI-25-14402-B',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '81',
        'tagnum' => 'PI-25-14404-B',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '69',
        'tagnum' => 'PSL-11-1351.1-PT',
        'desc' => 'Pressure Switch Low',
    ],
    [
        'area_id' => '69',
        'tagnum' => 'PSL-11-13530-DMP',
        'desc' => 'Pressure Switch Low',
    ],
    [
        'area_id' => '72',
        'tagnum' => 'PSL-11-13609-PMS',
        'desc' => 'Pressure Switch Low',
    ],
    [
        'area_id' => '72',
        'tagnum' => 'PSL-11-13610-PMS',
        'desc' => 'Pressure Switch Low',
    ],
    [
        'area_id' => '72',
        'tagnum' => 'PSL-11-13611-PMS',
        'desc' => 'Pressure Switch Low',
    ],
    [
        'area_id' => '144',
        'tagnum' => 'PSL-11-33401-BMI',
        'desc' => 'Pressure Switch Low',
    ],
    [
        'area_id' => '144',
        'tagnum' => 'PSL-11-33402-BMI',
        'desc' => 'Pressure Switch Low',
    ],
    [
        'area_id' => '65',
        'tagnum' => 'PSL-23-12373-GET',
        'desc' => 'Pressure Switch',
    ],
    [
        'area_id' => '65',
        'tagnum' => 'PSL-23-12374-GET',
        'desc' => 'Pressure Switch',
    ],
    [
        'area_id' => '119',
        'tagnum' => 'PSL-26-25701-GET',
        'desc' => 'Pressure Switch Low',
    ],
    [
        'area_id' => '119',
        'tagnum' => 'PSL-42-25701',
        'desc' => 'Pressure Switch Low',
    ],
    [
        'area_id' => '119',
        'tagnum' => 'PSL-42-25702',
        'desc' => 'Pressure Switch Low',
    ],
    [
        'area_id' => '72',
        'tagnum' => 'PT-11-13610.1-WPU',
        'desc' => 'Pressure Transmitter',
    ],
    [
        'area_id' => '72',
        'tagnum' => 'PT-11-13615.1-PMS',
        'desc' => 'Pressure Transmitter',
    ],
    [
        'area_id' => '72',
        'tagnum' => 'PT-11-13620-PSG',
        'desc' => 'Pressure Transmitter',
    ],
    [
        'area_id' => '122',
        'tagnum' => 'PT-21-30101',
        'desc' => 'Pressure For Convert to Flow Indicator',
    ],
    [
        'area_id' => '140',
        'tagnum' => 'PT-21-32301',
        'desc' => 'Pressure Transmitter',
    ],
    [
        'area_id' => '65',
        'tagnum' => 'PT-23-12303-GET',
        'desc' => 'Pressure Transmitter',
    ],
    [
        'area_id' => '65',
        'tagnum' => 'PT-23-12304-GET',
        'desc' => 'Pressure Transmitter',
    ],
    [
        'area_id' => '78',
        'tagnum' => 'PT-25-14201-KRG',
        'desc' => 'Pressure Transmitter',
    ],
    [
        'area_id' => '63',
        'tagnum' => 'PT-31-11401',
        'desc' => 'Pressure Transmitter',
    ],
    [
        'area_id' => '119',
        'tagnum' => 'PT-42-25701-GET',
        'desc' => 'Pressure Transmitter',
    ],
    [
        'area_id' => '72',
        'tagnum' => 'R-11-13602-PMS',
        'desc' => 'Temperature Recorder',
    ],
    [
        'area_id' => '78',
        'tagnum' => 'R-25-14202-KRG-CH1',
        'desc' => 'Recorder',
    ],
    [
        'area_id' => '78',
        'tagnum' => 'R-25-14202-KRG-CH2',
        'desc' => 'Recorder',
    ],
    [
        'area_id' => '78',
        'tagnum' => 'R-25-14202-KRG-CH3',
        'desc' => 'Recorder',
    ],
    [
        'area_id' => '91',
        'tagnum' => 'RH-21-15802',
        'desc' => 'Temperature & RH Indicator',
    ],
    [
        'area_id' => '56',
        'tagnum' => 'RH-41-10201',
        'desc' => 'RH Recorder',
    ],
    [
        'area_id' => '152',
        'tagnum' => 'RH-41-21010',
        'desc' => 'RH Recorder',
    ],
    [
        'area_id' => '152',
        'tagnum' => 'RH-41-21011',
        'desc' => 'RH Recorder',
    ],
    [
        'area_id' => '152',
        'tagnum' => 'RH-41-21012',
        'desc' => 'RH Recorder',
    ],
    [
        'area_id' => '152',
        'tagnum' => 'RH-41-21013',
        'desc' => 'RH Recorder',
    ],
    [
        'area_id' => '152',
        'tagnum' => 'RH-41-21014',
        'desc' => 'RH Recorder',
    ],
    [
        'area_id' => '152',
        'tagnum' => 'RH-41-21015',
        'desc' => 'RH Recorder',
    ],
    [
        'area_id' => '152',
        'tagnum' => 'RH-41-21016',
        'desc' => 'RH Recorder',
    ],
    [
        'area_id' => '152',
        'tagnum' => 'RH-41-21018',
        'desc' => 'RH Recorder',
    ],
    [
        'area_id' => '152',
        'tagnum' => 'RH-41-21019',
        'desc' => 'Chamber',
    ],
    [
        'area_id' => '117',
        'tagnum' => 'RH-42-25301',
        'desc' => 'Hygrometer',
    ],
    [
        'area_id' => '147',
        'tagnum' => 'RH-99-5300-001',
        'desc' => 'RH Indicator (Hygrometer)',
    ],
    [
        'area_id' => '147',
        'tagnum' => 'RH-99-5300-002',
        'desc' => 'RH Indicator (Hygrometer)',
    ],
    [
        'area_id' => '124',
        'tagnum' => 'TC-11-30401',
        'desc' => 'Temperature Controller',
    ],
    [
        'area_id' => '124',
        'tagnum' => 'TC-11-30402',
        'desc' => 'Temperature Controller',
    ],
    [
        'area_id' => '125',
        'tagnum' => 'TC-11-30501-CT',
        'desc' => 'Temperature Transmitter',
    ],
    [
        'area_id' => '144',
        'tagnum' => 'TC-11-33401-HW',
        'desc' => 'Temperature Controller',
    ],
    [
        'area_id' => '151',
        'tagnum' => 'TC-19-33201',
        'desc' => 'Temperature Control',
    ],
    [
        'area_id' => '140',
        'tagnum' => 'TC-21-15503',
        'desc' => 'Temperature Controller',
    ],
    [
        'area_id' => '90',
        'tagnum' => 'TC-21-15701-DK',
        'desc' => 'Temperature Controller',
    ],
    [
        'area_id' => '90',
        'tagnum' => 'TC-21-15702-DK',
        'desc' => 'Temperature Controller',
    ],
    [
        'area_id' => '90',
        'tagnum' => 'TC-21-15703-DK',
        'desc' => 'Temperature Controller',
    ],
    [
        'area_id' => '90',
        'tagnum' => 'TC-21-15704-DK',
        'desc' => 'Temperature Controller',
    ],
    [
        'area_id' => '92',
        'tagnum' => 'TC-21-16004',
        'desc' => 'Temperature Controller',
    ],
    [
        'area_id' => '98',
        'tagnum' => 'TC-21-16602',
        'desc' => 'Temperature Controller',
    ],
    [
        'area_id' => '100',
        'tagnum' => 'TC-21-16801',
        'desc' => 'Temperature Controller',
    ],
    [
        'area_id' => '131',
        'tagnum' => 'TC-21-31101-UHL',
        'desc' => 'Temperature Controller',
    ],
    [
        'area_id' => '131',
        'tagnum' => 'TC-21-31102-UHL',
        'desc' => 'Temperature Controller',
    ],
    [
        'area_id' => '131',
        'tagnum' => 'TC-21-31103-UHL',
        'desc' => 'Temperature Controller',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'TC-22-11001',
        'desc' => 'Temperature Controller',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'TC-22-11002',
        'desc' => 'Temperature Controller',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'TC-22-11004',
        'desc' => 'Temperature Controller',
    ],
    [
        'area_id' => '106',
        'tagnum' => 'TC-27-19102',
        'desc' => 'Temperature Controller',
    ],
    [
        'area_id' => '112',
        'tagnum' => 'TC-41-21001-INC',
        'desc' => 'Temperature Controller',
    ],
    [
        'area_id' => '114',
        'tagnum' => 'TC-41-21001-OVN',
        'desc' => 'Temperature Controller',
    ],
    [
        'area_id' => '112',
        'tagnum' => 'TC-41-21003',
        'desc' => 'Temperature Controller',
    ],
    [
        'area_id' => '112',
        'tagnum' => 'TC-41-21004',
        'desc' => 'Temperature Controller',
    ],
    [
        'area_id' => '112',
        'tagnum' => 'TC-41-21005',
        'desc' => 'Oil Bath',
    ],
    [
        'area_id' => '152',
        'tagnum' => 'TC-41-21010',
        'desc' => 'Temperature Controller',
    ],
    [
        'area_id' => '152',
        'tagnum' => 'TC-41-21011',
        'desc' => 'Temperature Transmitter',
    ],
    [
        'area_id' => '152',
        'tagnum' => 'TC-41-21012',
        'desc' => 'Temperature Transmitter',
    ],
    [
        'area_id' => '152',
        'tagnum' => 'TC-41-21013',
        'desc' => 'Temperature Transmitter',
    ],
    [
        'area_id' => '152',
        'tagnum' => 'TC-41-21014',
        'desc' => 'Temperature Transmitter',
    ],
    [
        'area_id' => '152',
        'tagnum' => 'TC-41-21015',
        'desc' => 'Temperature Transmitter',
    ],
    [
        'area_id' => '152',
        'tagnum' => 'TC-41-21016',
        'desc' => 'Temperature Transmitter',
    ],
    [
        'area_id' => '112',
        'tagnum' => 'TC-41-21017',
        'desc' => 'Temperature Controller',
    ],
    [
        'area_id' => '152',
        'tagnum' => 'TC-41-21018',
        'desc' => 'Temperature Transmitter',
    ],
    [
        'area_id' => '152',
        'tagnum' => 'TC-41-21019',
        'desc' => 'Chamber',
    ],
    [
        'area_id' => '112',
        'tagnum' => 'TC-41-21019-FRN',
        'desc' => 'Temperature Controller',
    ],
    [
        'area_id' => '120',
        'tagnum' => 'TC-41-21201-WTB',
        'desc' => 'Temperature Controller',
    ],
    [
        'area_id' => '119',
        'tagnum' => 'TC-41-21202-HTP',
        'desc' => 'Temperature Controller',
    ],
    [
        'area_id' => '121',
        'tagnum' => 'TC-42-25901-INC',
        'desc' => 'Temperature Controller',
    ],
    [
        'area_id' => '121',
        'tagnum' => 'TC-42-25901-OVN',
        'desc' => 'Temperature Controller',
    ],
    [
        'area_id' => '121',
        'tagnum' => 'TC-42-25902',
        'desc' => 'Temperature Controller',
    ],
    [
        'area_id' => '121',
        'tagnum' => 'TC-42-25903-FRI',
        'desc' => 'Temperature Controller',
    ],
    [
        'area_id' => '66',
        'tagnum' => 'TC-99-1300-001',
        'desc' => 'Temperature Control',
    ],
    [
        'area_id' => '66',
        'tagnum' => 'TC-99-1300-002',
        'desc' => 'Temperature Control',
    ],
    [
        'area_id' => '66',
        'tagnum' => 'TC-99-1300-003',
        'desc' => 'Temperature Control',
    ],
    [
        'area_id' => '66',
        'tagnum' => 'TC-99-1300-004',
        'desc' => 'Temperature Control',
    ],
    [
        'area_id' => '92',
        'tagnum' => 'THT-21-16001',
        'desc' => 'Temperatur Humidity trasmitter',
    ],
    [
        'area_id' => '92',
        'tagnum' => 'THT-21-16001.',
        'desc' => 'Temperature Humidity Transmitter',
    ],
    [
        'area_id' => '99',
        'tagnum' => 'THT-21-16701',
        'desc' => 'Temperatur Humidity trasmitter',
    ],
    [
        'area_id' => '99',
        'tagnum' => 'THT-21-16701.',
        'desc' => 'Temperature Humidity Transmitter',
    ],
    [
        'area_id' => '67',
        'tagnum' => 'THT-33-13301',
        'desc' => 'Temperatur Humidity trasmitter',
    ],
    [
        'area_id' => '67',
        'tagnum' => 'THT-33-13301.',
        'desc' => 'Temperature Humidity Transmitter',
    ],
    [
        'area_id' => '100',
        'tagnum' => 'TI/RH-21-16801',
        'desc' => 'Temperature/Humidity Indicator',
    ],
    [
        'area_id' => '100',
        'tagnum' => 'TI/RH-21-16801.',
        'desc' => 'Temperature/Humidity Indicator',
    ],
    [
        'area_id' => '100',
        'tagnum' => 'TI/RH-21-16802',
        'desc' => 'Thermohygrometer Indicator',
    ],
    [
        'area_id' => '100',
        'tagnum' => 'TI/RH-21-16802.',
        'desc' => 'Thermohygrometer Indicator',
    ],
    [
        'area_id' => '123',
        'tagnum' => 'TI/RH-21-30202',
        'desc' => 'Temperature & RH Indicator',
    ],
    [
        'area_id' => '123',
        'tagnum' => 'TI/RH-21-30202.',
        'desc' => 'Temperature & RH Indicator',
    ],
    [
        'area_id' => '132',
        'tagnum' => 'TI/RH-21-31201',
        'desc' => 'Temperature/Humidity Indicator',
    ],
    [
        'area_id' => '132',
        'tagnum' => 'TI/RH-21-31201.',
        'desc' => 'Temperature/Humidity Indicator',
    ],
    [
        'area_id' => '75',
        'tagnum' => 'TI/RH-24-14001',
        'desc' => 'Temperature/Humidity Indicator',
    ],
    [
        'area_id' => '75',
        'tagnum' => 'TI/RH-24-14001.',
        'desc' => 'Temperature/Humidity Indicator',
    ],
    [
        'area_id' => '67',
        'tagnum' => 'TI/RH-33-13302',
        'desc' => 'Thermohygrometer Indicator',
    ],
    [
        'area_id' => '67',
        'tagnum' => 'TI/RH-33-13302.',
        'desc' => 'Thermohygrometer Indicator',
    ],
    [
        'area_id' => '142',
        'tagnum' => 'TI/RH-33-32801',
        'desc' => 'Temperature/Humidity Indicator',
    ],
    [
        'area_id' => '142',
        'tagnum' => 'TI/RH-33-32801.',
        'desc' => 'Temperature/Humidity Indicator',
    ],
    [
        'area_id' => '111',
        'tagnum' => 'TI/RH-41-20901',
        'desc' => 'Temperature Room Indicator',
    ],
    [
        'area_id' => '111',
        'tagnum' => 'TI/RH-41-20901.',
        'desc' => 'Humidity Room Indicator',
    ],
    [
        'area_id' => '113',
        'tagnum' => 'TI/RH-41-21201',
        'desc' => 'Temperature Room Indicator',
    ],
    [
        'area_id' => '113',
        'tagnum' => 'TI/RH-41-21201.',
        'desc' => 'Humidity Room Indicator',
    ],
    [
        'area_id' => '114',
        'tagnum' => 'TI/RH-41-21301',
        'desc' => 'Temperature Room Indicator',
    ],
    [
        'area_id' => '114',
        'tagnum' => 'TI/RH-41-21301.',
        'desc' => 'Humidity Room Indicator',
    ],
    [
        'area_id' => '121',
        'tagnum' => 'TI/RH-42-25910',
        'desc' => 'Temperature Room Indicator',
    ],
    [
        'area_id' => '121',
        'tagnum' => 'TI/RH-42-25910.',
        'desc' => 'Humidity Room Indicator',
    ],
    [
        'area_id' => '147',
        'tagnum' => 'TI/RH-99-5300-002',
        'desc' => 'Thermohygrometer Indicator',
    ],
    [
        'area_id' => '147',
        'tagnum' => 'TI/RH-99-5300-002.',
        'desc' => 'Thermohygrometer Indicator',
    ],
    [
        'area_id' => '72',
        'tagnum' => 'TI-12-13601',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '72',
        'tagnum' => 'TI-12-13602',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '72',
        'tagnum' => 'TI-12-13603',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '72',
        'tagnum' => 'TI-12-13604',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '72',
        'tagnum' => 'TI-12-13605',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '72',
        'tagnum' => 'TI-12-13606',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '72',
        'tagnum' => 'TI-12-13607',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '86',
        'tagnum' => 'TI-21-15302',
        'desc' => 'Valprobe II Logger Kaye',
    ],
    [
        'area_id' => '91',
        'tagnum' => 'TI-21-15802',
        'desc' => 'Temperature & RH Indicator',
    ],
    [
        'area_id' => '92',
        'tagnum' => 'TI-21-16603',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '98',
        'tagnum' => 'TI-21-16604',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '122',
        'tagnum' => 'TI-21-30101',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '122',
        'tagnum' => 'TI-21-30102',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '122',
        'tagnum' => 'TI-21-30103',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '122',
        'tagnum' => 'TI-21-30104',
        'desc' => 'Sensor Bypass Temperature Indicator',
    ],
    [
        'area_id' => '134',
        'tagnum' => 'TI-21-31401',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '139',
        'tagnum' => 'TI-21-32101',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '139',
        'tagnum' => 'TI-21-32102',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '139',
        'tagnum' => 'TI-21-32103',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'TI-22-11001',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'TI-22-11007',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '65',
        'tagnum' => 'TI-23-12307-GET',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '65',
        'tagnum' => 'TI-23-12307-SPV-GET',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '65',
        'tagnum' => 'TI-23-12312-GET',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '65',
        'tagnum' => 'TI-23-12312-SPV-GET',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '77',
        'tagnum' => 'TI-24-14101',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '78',
        'tagnum' => 'TI-25-14201',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '80',
        'tagnum' => 'TI-25-14401-A',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '80',
        'tagnum' => 'TI-25-14402-A',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '81',
        'tagnum' => 'TI-25-14403-B',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '81',
        'tagnum' => 'TI-25-14404-B',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '106',
        'tagnum' => 'TI-25-19101',
        'desc' => 'Temperature Mixing Tank 1000L',
    ],
    [
        'area_id' => '121',
        'tagnum' => 'TI-26-25901-PRC',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '121',
        'tagnum' => 'TI-26-25902-PRC',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '106',
        'tagnum' => 'TI-27-19101',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '108',
        'tagnum' => 'TI-27-19302',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '156',
        'tagnum' => 'TI-31-10201-WH',
        'desc' => 'Temperature Gauge',
    ],
    [
        'area_id' => '155',
        'tagnum' => 'TI-31-18101',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '27',
        'tagnum' => 'TI-31-18102',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '62',
        'tagnum' => 'TI-32-11201',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '62',
        'tagnum' => 'TI-32-11202',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '62',
        'tagnum' => 'TI-32-11203',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '62',
        'tagnum' => 'TI-32-11204',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '62',
        'tagnum' => 'TI-32-11205',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '62',
        'tagnum' => 'TI-32-11206',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '62',
        'tagnum' => 'TI-32-11207',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '62',
        'tagnum' => 'TI-32-11208',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '93',
        'tagnum' => 'TI-39-18102-CMGS',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '56',
        'tagnum' => 'TI-41-10201',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '102',
        'tagnum' => 'TI-41-18202',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '103',
        'tagnum' => 'TI-41-18305',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '103',
        'tagnum' => 'TI-41-18306',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '112',
        'tagnum' => 'TI-41-21001',
        'desc' => 'Temperature Room Indicator',
    ],
    [
        'area_id' => '112',
        'tagnum' => 'TI-41-21011',
        'desc' => 'Thermometer of Pycnometer',
    ],
    [
        'area_id' => '112',
        'tagnum' => 'TI-41-21012',
        'desc' => 'Thermometer of Pycnometer',
    ],
    [
        'area_id' => '112',
        'tagnum' => 'TI-41-21013',
        'desc' => 'Thermometer of Pycnometer',
    ],
    [
        'area_id' => '112',
        'tagnum' => 'TI-41-21014',
        'desc' => 'Thermometer of Pycnometer',
    ],
    [
        'area_id' => '112',
        'tagnum' => 'TI-41-21401',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '119',
        'tagnum' => 'TI-42-21002',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '115',
        'tagnum' => 'TI-42-21702',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '117',
        'tagnum' => 'TI-42-25302',
        'desc' => 'Temperature Transmitter',
    ],
    [
        'area_id' => '117',
        'tagnum' => 'TI-42-25303',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '118',
        'tagnum' => 'TI-42-25602',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '119',
        'tagnum' => 'TI-42-25701-GET',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '119',
        'tagnum' => 'TI-42-25703',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '119',
        'tagnum' => 'TI-42-25705',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '121',
        'tagnum' => 'TI-42-25707',
        'desc' => 'BOD Inkubator',
    ],
    [
        'area_id' => '119',
        'tagnum' => 'TI-42-25708-WTB',
        'desc' => 'Water Bath',
    ],
    [
        'area_id' => '121',
        'tagnum' => 'TI-42-25903',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '113',
        'tagnum' => 'TI-42-25907',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '112',
        'tagnum' => 'TI-42-25908',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '121',
        'tagnum' => 'TI-42-25911',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '121',
        'tagnum' => 'TI-42-25912',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '121',
        'tagnum' => 'TI-42-25914',
        'desc' => 'Temperature sensor',
    ],
    [
        'area_id' => '61',
        'tagnum' => 'TI-91-018',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '64',
        'tagnum' => 'TI-91-019',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '61',
        'tagnum' => 'TI-99-1100-003',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '61',
        'tagnum' => 'TI-99-1100-004',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '64',
        'tagnum' => 'TI-99-1200-002',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '66',
        'tagnum' => 'TI-99-1300-005',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '66',
        'tagnum' => 'TI-99-1300-006',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '66',
        'tagnum' => 'TI-99-1300-007',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '66',
        'tagnum' => 'TI-99-1300-008',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '76',
        'tagnum' => 'TI-99-1400-003',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '76',
        'tagnum' => 'TI-99-1400-004',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '93',
        'tagnum' => 'TI-99-1600-002',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '101',
        'tagnum' => 'TI-99-1700-004',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '101',
        'tagnum' => 'TI-99-1700-005',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '101',
        'tagnum' => 'TI-99-1700-006',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '145',
        'tagnum' => 'TI-99-5100-003',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '145',
        'tagnum' => 'TI-99-5100-004',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '83',
        'tagnum' => 'TI-99-5100-005',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '146',
        'tagnum' => 'TI-99-5200-003',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '146',
        'tagnum' => 'TI-99-5200-004',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '148',
        'tagnum' => 'TI-99-5400-002',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '149',
        'tagnum' => 'TI-99-5Q001-003',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '149',
        'tagnum' => 'TI-99-5Q001-004',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '150',
        'tagnum' => 'TI-99-5Q002-003',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '150',
        'tagnum' => 'TI-99-5Q002-004',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '38',
        'tagnum' => 'TI-99-CRXU',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '38',
        'tagnum' => 'TI-99-CRXU-5254372',
        'desc' => 'Thermometer Indicator Thermocouple',
    ],
    [
        'area_id' => '38',
        'tagnum' => 'TI-99-KKTU',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '38',
        'tagnum' => 'TI-99-KKTU-6042937',
        'desc' => 'Thermometer Indicator Thermocouple',
    ],
    [
        'area_id' => '157',
        'tagnum' => 'TI-99-Truck-001',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '58',
        'tagnum' => 'TM-21-10801',
        'desc' => 'Timer',
    ],
    [
        'area_id' => '58',
        'tagnum' => 'TM-21-10802',
        'desc' => 'Timer',
    ],
    [
        'area_id' => '122',
        'tagnum' => 'TM-21-30101',
        'desc' => 'Sensor Current Step Time Indicator',
    ],
    [
        'area_id' => '138',
        'tagnum' => 'TM-21-31901',
        'desc' => 'Timer',
    ],
    [
        'area_id' => '138',
        'tagnum' => 'TM-21-31903',
        'desc' => 'Timer',
    ],
    [
        'area_id' => '138',
        'tagnum' => 'TM-21-31904',
        'desc' => 'Timer',
    ],
    [
        'area_id' => '119',
        'tagnum' => 'TM-26-25701',
        'desc' => 'Timer',
    ],
    [
        'area_id' => '78',
        'tagnum' => 'TSL-25-14201',
        'desc' => 'Temperature Switch',
    ],
    [
        'area_id' => '109',
        'tagnum' => 'TT-12-20301',
        'desc' => 'Temperature Transmitter',
    ],
    [
        'area_id' => '110',
        'tagnum' => 'TT-12-20401',
        'desc' => 'Temperature Transmitter',
    ],
    [
        'area_id' => '126',
        'tagnum' => 'TT-12-30601',
        'desc' => 'Temperature Transmitter',
    ],
    [
        'area_id' => '127',
        'tagnum' => 'TT-12-30701',
        'desc' => 'Temperature Transmitter',
    ],
    [
        'area_id' => '128',
        'tagnum' => 'TT-12-30801',
        'desc' => 'Temperature Transmitter',
    ],
    [
        'area_id' => '129',
        'tagnum' => 'TT-12-30901',
        'desc' => 'Temperature Transmitter',
    ],
    [
        'area_id' => '130',
        'tagnum' => 'TT-12-31001',
        'desc' => 'Temperature Transmitter',
    ],
    [
        'area_id' => '91',
        'tagnum' => 'TT-21-15801-UHL',
        'desc' => 'Temperature Transmitter',
    ],
    [
        'area_id' => '91',
        'tagnum' => 'TT-21-15802-UHL',
        'desc' => 'Temperature Transmitter',
    ],
    [
        'area_id' => '91',
        'tagnum' => 'TT-21-15803-UHL',
        'desc' => 'Temperature Transmitter',
    ],
    [
        'area_id' => '130',
        'tagnum' => 'TT-21-31001',
        'desc' => 'Temperature Transmitter',
    ],
    [
        'area_id' => '130',
        'tagnum' => 'TT-21-31002',
        'desc' => 'Temperature Transmitter',
    ],
    [
        'area_id' => '130',
        'tagnum' => 'TT-21-31003',
        'desc' => 'Temperature Transmitter',
    ],
    [
        'area_id' => '130',
        'tagnum' => 'TT-21-31004',
        'desc' => 'Temperature Transmitter',
    ],
    [
        'area_id' => '140',
        'tagnum' => 'TT-21-32301',
        'desc' => 'Temperature Transmitter',
    ],
    [
        'area_id' => '140',
        'tagnum' => 'TT-21-32302',
        'desc' => 'Temperature Transmitter',
    ],
    [
        'area_id' => '140',
        'tagnum' => 'TT-21-32303',
        'desc' => 'Temperature Transmitter',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'TT-22-11001',
        'desc' => 'Temperature Transmitter',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'TT-22-11002',
        'desc' => 'Temperature Transmitter',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'TT-22-11003',
        'desc' => 'Temperature Transmitter',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'TT-22-11004',
        'desc' => 'Temperature Transmitter',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'TT-22-11005',
        'desc' => 'Temperature Transmitter',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'TT-22-11006',
        'desc' => 'Temperature Transmitter',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'TT-22-11007',
        'desc' => 'Temperature Transmitter',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'TT-22-11008',
        'desc' => 'Temperature Transmitter',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'TT-22-11009',
        'desc' => 'Temperature Transmitter',
    ],
    [
        'area_id' => '65',
        'tagnum' => 'TT-23-12303-GET',
        'desc' => 'Temperature Transmitter',
    ],
    [
        'area_id' => '78',
        'tagnum' => 'TT-25-14201-KRG',
        'desc' => 'Temperature Transmitter',
    ],
    [
        'area_id' => '119',
        'tagnum' => 'TT-26-25702-GET',
        'desc' => 'Temperature Transmitter',
    ],
    [
        'area_id' => '119',
        'tagnum' => 'TT-26-25703-GET',
        'desc' => 'Temperature Transmitter',
    ],
    [
        'area_id' => '56',
        'tagnum' => 'TT-31-10201',
        'desc' => 'Temperatur Trasmitter',
    ],
    [
        'area_id' => '56',
        'tagnum' => 'TT-31-10202',
        'desc' => 'Temperatur Trasmitter',
    ],
    [
        'area_id' => '56',
        'tagnum' => 'TT-31-10204',
        'desc' => 'Temperatur Trasmitter',
    ],
    [
        'area_id' => '56',
        'tagnum' => 'TT-31-10205',
        'desc' => 'Temperatur Trasmitter',
    ],
    [
        'area_id' => '56',
        'tagnum' => 'TT-31-10206',
        'desc' => 'Temperatur Trasmitter',
    ],
    [
        'area_id' => '56',
        'tagnum' => 'TT-31-10207',
        'desc' => 'Temperatur Trasmitter',
    ],
    [
        'area_id' => '56',
        'tagnum' => 'TT-31-10208',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '117',
        'tagnum' => 'TT-42-25301',
        'desc' => 'Temperature Transmitter',
    ],
    [
        'area_id' => '86',
        'tagnum' => 'WS-21-13701',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '86',
        'tagnum' => 'WS-21-13702',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '86',
        'tagnum' => 'WS-21-13703',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '86',
        'tagnum' => 'WS-21-13704',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '86',
        'tagnum' => 'WS-21-13705',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '86',
        'tagnum' => 'WS-21-13706',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '86',
        'tagnum' => 'WS-21-13707',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '86',
        'tagnum' => 'WS-21-13708',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '107',
        'tagnum' => 'WS-21-13709',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '107',
        'tagnum' => 'WS-21-13710',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '107',
        'tagnum' => 'WS-21-13711',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '79',
        'tagnum' => 'WS-21-13712',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '79',
        'tagnum' => 'WS-21-13713',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '79',
        'tagnum' => 'WS-21-13714',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '79',
        'tagnum' => 'WS-21-13715',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '79',
        'tagnum' => 'WS-21-13716',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '79',
        'tagnum' => 'WS-21-13717',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '74',
        'tagnum' => 'WS-21-13718',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'WS-21-13719',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'WS-21-13720',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'WS-21-13721',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'WS-21-13722',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'WS-21-13723',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'WS-21-13724',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'WS-21-13725',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'WS-21-13726',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'WS-21-13727',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'WS-21-13728',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'WS-21-13729',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'WS-21-13730',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'WS-21-13731',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'WS-21-13732',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'WS-21-13733',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'WS-21-13734',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '74',
        'tagnum' => 'WS-21-13736',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '74',
        'tagnum' => 'WS-21-13737',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '74',
        'tagnum' => 'WS-21-13738',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '86',
        'tagnum' => 'WS-21-13739',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '86',
        'tagnum' => 'WS-21-13740',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '86',
        'tagnum' => 'WS-21-13741',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '86',
        'tagnum' => 'WS-21-13742',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '86',
        'tagnum' => 'WS-21-13743',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '86',
        'tagnum' => 'WS-21-13744',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '86',
        'tagnum' => 'WS-21-13745',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '86',
        'tagnum' => 'WS-21-13746',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '67',
        'tagnum' => 'WS-31-17701',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '67',
        'tagnum' => 'WS-33-13307',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '67',
        'tagnum' => 'WS-33-13308',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '67',
        'tagnum' => 'WS-33-13309',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '67',
        'tagnum' => 'WS-33-13310',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '67',
        'tagnum' => 'WS-33-13311',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '67',
        'tagnum' => 'WS-33-13313',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '67',
        'tagnum' => 'WS-33-13319',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '67',
        'tagnum' => 'WS-33-13322',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '67',
        'tagnum' => 'WS-33-13323',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '67',
        'tagnum' => 'WS-33-13325',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '67',
        'tagnum' => 'WS-33-13326',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '67',
        'tagnum' => 'WS-33-13327',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '67',
        'tagnum' => 'WS-33-13328',
        'desc' => 'Weight',
    ],
    [
        'area_id' => '66',
        'tagnum' => 'WS-39-001',
        'desc' => 'Anak Timbang F1',
    ],
    [
        'area_id' => '66',
        'tagnum' => 'WS-39-002',
        'desc' => 'Anak Timbang F1',
    ],
    [
        'area_id' => '66',
        'tagnum' => 'WS-39-003',
        'desc' => 'Anak Timbang M1',
    ],
    [
        'area_id' => '66',
        'tagnum' => 'WS-39-004',
        'desc' => 'Anak Timbang M1',
    ],
    [
        'area_id' => '118',
        'tagnum' => 'WS-42-25701',
        'desc' => 'Anak Timbangan',
    ],
    [
        'area_id' => '118',
        'tagnum' => 'WS-42-25702',
        'desc' => 'Anak Timbangan',
    ],
    [
        'area_id' => '118',
        'tagnum' => 'WS-42-25703',
        'desc' => 'Anak Timbangan',
    ],
    [
        'area_id' => '118',
        'tagnum' => 'WS-42-25704',
        'desc' => 'Anak Timbangan',
    ],
    [
        'area_id' => '121',
        'tagnum' => 'TI-42-25915',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '160',
        'tagnum' => 'PI-11-33201',
        'desc' => 'Pressure Indicator',
    ],
    [
        'area_id' => '160',
        'tagnum' => 'PI-11-33202',
        'desc' => 'Pressure Indicator',
    ],
    [
        'area_id' => '140',
        'tagnum' => 'DPI-21-32301',
        'desc' => 'Differential Pressure Indicator',
    ],
    [
        'area_id' => '125',
        'tagnum' => 'PI-11-30501-OFA',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '125',
        'tagnum' => 'PI-11-30502-OFA',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '125',
        'tagnum' => 'PI-11-30503-OFA',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '125',
        'tagnum' => 'PI-11-30504-OFA',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '125',
        'tagnum' => 'PI-11-30505-OFA',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '144',
        'tagnum' => 'PI-11-33401-BMI',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '144',
        'tagnum' => 'PI-11-33401-HD',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '144',
        'tagnum' => 'PI-11-33402-HD',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '144',
        'tagnum' => 'PI-11-33402-TK',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '144',
        'tagnum' => 'PI-11-33403-BMI',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '144',
        'tagnum' => 'PI-11-33404-BMI',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '144',
        'tagnum' => 'PSL-11-33403',
        'desc' => 'Pressure Switch Low',
    ],
    [
        'area_id' => '125',
        'tagnum' => 'SV-11-30501-OFA',
        'desc' => 'Safety Valve',
    ],
    [
        'area_id' => '125',
        'tagnum' => 'SV-11-30502-OFA',
        'desc' => 'Safety Valve',
    ],
    [
        'area_id' => '69',
        'tagnum' => 'TC-11-1356.1-CB',
        'desc' => 'Temperature Controller',
    ],
    [
        'area_id' => '69',
        'tagnum' => 'TC-11-1356.2-CB',
        'desc' => 'Temperature Controller',
    ],
    [
        'area_id' => '73',
        'tagnum' => 'TC-23-13701',
        'desc' => 'Temperature Controller',
    ],
    [
        'area_id' => '144',
        'tagnum' => 'TI-11-33401-BMI',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '144',
        'tagnum' => 'TI-11-33401-HW',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '144',
        'tagnum' => 'TI-11-33402-BMI',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '144',
        'tagnum' => 'TI-11-33403-BMI',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '144',
        'tagnum' => 'TI-11-33404-BMI',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '144',
        'tagnum' => 'TI-11-33405-BMI',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '144',
        'tagnum' => 'TI-11-33406-BMI',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '138',
        'tagnum' => 'PI-21-31901',
        'desc' => 'Pressure Indicator',
    ],
    [
        'area_id' => '140',
        'tagnum' => 'PI-21-32304',
        'desc' => 'Pressure Indicator',
    ],
    [
        'area_id' => '140',
        'tagnum' => 'PI-21-32305',
        'desc' => 'Pressure Indicator',
    ],
    [
        'area_id' => '140',
        'tagnum' => 'PI-21-32306',
        'desc' => 'Pressure Indicator',
    ],
    [
        'area_id' => '137',
        'tagnum' => 'PI-21-31801',
        'desc' => 'Pressure Indicator',
    ],
    [
        'area_id' => '141',
        'tagnum' => 'PI-21-32401',
        'desc' => 'Pressure Indicator',
    ],
    [
        'area_id' => '141',
        'tagnum' => 'PI-21-32402',
        'desc' => 'Pressure Indicator',
    ],
    [
        'area_id' => '141',
        'tagnum' => 'PI-21-32403',
        'desc' => 'Pressure Indicator',
    ],
    [
        'area_id' => '141',
        'tagnum' => 'PI-21-32404',
        'desc' => 'Pressure Indicator',
    ],
    [
        'area_id' => '141',
        'tagnum' => 'PI-21-32405',
        'desc' => 'Pressure Indicator',
    ],
    [
        'area_id' => '138',
        'tagnum' => 'TM-21-31902',
        'desc' => 'Timer Indicator',
    ],
    [
        'area_id' => '122',
        'tagnum' => 'PT-21-30102',
        'desc' => 'Pressure For Convert to Flow Indicator',
    ],
    [
        'area_id' => '122',
        'tagnum' => 'TI-21-30105',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '140',
        'tagnum' => 'PI-21-32307',
        'desc' => 'Pressure Indicator',
    ],
    [
        'area_id' => '138',
        'tagnum' => 'PI-21-31902',
        'desc' => 'Pressure Indicator',
    ],
    [
        'area_id' => '138',
        'tagnum' => 'PI-21-31903',
        'desc' => 'Pressure Indicator',
    ],
    [
        'area_id' => '137',
        'tagnum' => 'PI-21-31802',
        'desc' => 'Pressure Indicator',
    ],
    [
        'area_id' => '4',
        'tagnum' => 'DPI-12-20502A-BF1',
        'desc' => 'Differential Pressure Gauge',
    ],
    [
        'area_id' => '5',
        'tagnum' => 'DPI-12-20502B-BF1',
        'desc' => 'Differential Pressure Gauge',
    ],
    [
        'area_id' => '4',
        'tagnum' => 'DPI-12-20503A-BF2',
        'desc' => 'Differential Pressure Gauge',
    ],
    [
        'area_id' => '5',
        'tagnum' => 'DPI-12-20503B-BF2',
        'desc' => 'Differential Pressure Gauge',
    ],
    [
        'area_id' => '4',
        'tagnum' => 'DPI-12-20504A-HF',
        'desc' => 'Differential Pressure Gauge',
    ],
    [
        'area_id' => '5',
        'tagnum' => 'DPI-12-20504B-HF',
        'desc' => 'Differential Pressure Gauge',
    ],
    [
        'area_id' => '122',
        'tagnum' => 'DPI-12-30101-GLT',
        'desc' => 'Differential Pressure Gauge',
    ],
    [
        'area_id' => '122',
        'tagnum' => 'DPI-12-30102-GLT',
        'desc' => 'Differential Pressure Gauge',
    ],
    [
        'area_id' => '7',
        'tagnum' => 'DPI-12-30401-AHU',
        'desc' => 'Differential Pressure Gauge',
    ],
    [
        'area_id' => '7',
        'tagnum' => 'DPI-12-30402-AHU',
        'desc' => 'Differential Pressure Gauge',
    ],
    [
        'area_id' => '7',
        'tagnum' => 'DPI-12-30403-AHU',
        'desc' => 'Differential Pressure Gauge',
    ],
    [
        'area_id' => '11',
        'tagnum' => 'DPI-12-30701-AHU',
        'desc' => 'Differential Pressure Gauge',
    ],
    [
        'area_id' => '11',
        'tagnum' => 'DPI-12-30702-AHU',
        'desc' => 'Differential Pressure Gauge',
    ],
    [
        'area_id' => '11',
        'tagnum' => 'DPI-12-30703-AHU',
        'desc' => 'Differential Pressure Gauge',
    ],
    [
        'area_id' => '11',
        'tagnum' => 'DPI-12-30901-AHU',
        'desc' => 'Differential Pressure Gauge',
    ],
    [
        'area_id' => '11',
        'tagnum' => 'DPI-12-30902-AHU',
        'desc' => 'Differential Pressure Gauge',
    ],
    [
        'area_id' => '11',
        'tagnum' => 'DPI-12-30903-AHU',
        'desc' => 'Differential Pressure Gauge',
    ],
    [
        'area_id' => '11',
        'tagnum' => 'DPI-12-30904-AHU',
        'desc' => 'Differential Pressure Gauge',
    ],
    [
        'area_id' => '11',
        'tagnum' => 'DPI-12-30905-AHU',
        'desc' => 'Differential Pressure Gauge',
    ],
    [
        'area_id' => '11',
        'tagnum' => 'DPI-12-30906-AHU',
        'desc' => 'Differential Pressure Gauge',
    ],
    [
        'area_id' => '11',
        'tagnum' => 'DPI-12-30907-AHU',
        'desc' => 'Differential Pressure Gauge',
    ],
    [
        'area_id' => '11',
        'tagnum' => 'DPI-12-30908-AHU',
        'desc' => 'Differential Pressure Gauge',
    ],
    [
        'area_id' => '133',
        'tagnum' => 'DPI-21-31301-LAF',
        'desc' => 'Differential Pressure',
    ],
    [
        'area_id' => '7',
        'tagnum' => 'DPT-13-33301',
        'desc' => 'Differential Pressure Transmitter',
    ],
    [
        'area_id' => '7',
        'tagnum' => 'DPT-13-33302',
        'desc' => 'Differential Pressure Transmitter',
    ],
    [
        'area_id' => '8',
        'tagnum' => 'DPT-13-33303',
        'desc' => 'Differential Pressure Transmitter',
    ],
    [
        'area_id' => '8',
        'tagnum' => 'DPT-13-33304',
        'desc' => 'Differential Pressure Transmitter',
    ],
    [
        'area_id' => '11',
        'tagnum' => 'DPT-13-33306',
        'desc' => 'Differential Pressure Transmitter',
    ],
    [
        'area_id' => '11',
        'tagnum' => 'DPT-13-33307',
        'desc' => 'Differential Pressure Transmitter',
    ],
    [
        'area_id' => '4',
        'tagnum' => 'DPT-13-33309',
        'desc' => 'Differential Pressure Transmitter',
    ],
    [
        'area_id' => '4',
        'tagnum' => 'DPT-13-33310',
        'desc' => 'Differential Pressure Transmitter',
    ],
    [
        'area_id' => '4',
        'tagnum' => 'DPT-13-33311',
        'desc' => 'Differential Pressure Transmitter',
    ],
    [
        'area_id' => '5',
        'tagnum' => 'DPT-13-33312',
        'desc' => 'Differential Pressure Transmitter',
    ],
    [
        'area_id' => '5',
        'tagnum' => 'DPT-13-33313',
        'desc' => 'Differential Pressure Transmitter',
    ],
    [
        'area_id' => '21',
        'tagnum' => 'DPT-13-33315',
        'desc' => 'Differential Pressure Transmitter',
    ],
    [
        'area_id' => '21',
        'tagnum' => 'DPT-13-33316',
        'desc' => 'Differential Pressure Transmitter',
    ],
    [
        'area_id' => '12',
        'tagnum' => 'DPT-13-33317',
        'desc' => 'Differential Pressure Transmitter',
    ],
    [
        'area_id' => '13',
        'tagnum' => 'DPT-13-33318',
        'desc' => 'Differential Pressure Transmitter',
    ],
    [
        'area_id' => '13',
        'tagnum' => 'DPT-13-33319',
        'desc' => 'Differential Pressure Transmitter',
    ],
    [
        'area_id' => '14',
        'tagnum' => 'DPT-13-33321',
        'desc' => 'Differential Pressure Transmitter',
    ],
    [
        'area_id' => '14',
        'tagnum' => 'DPT-13-33322',
        'desc' => 'Differential Pressure Transmitter',
    ],
    [
        'area_id' => '17',
        'tagnum' => 'DPT-13-33324',
        'desc' => 'Differential Pressure Transmitter',
    ],
    [
        'area_id' => '17',
        'tagnum' => 'DPT-13-33325',
        'desc' => 'Differential Pressure Transmitter',
    ],
    [
        'area_id' => '23',
        'tagnum' => 'DPT-13-33327',
        'desc' => 'Differential Pressure Transmitter',
    ],
    [
        'area_id' => '69',
        'tagnum' => 'PI-11-13501-DMP',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '69',
        'tagnum' => 'PI-11-13501-RO',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '69',
        'tagnum' => 'PI-11-13502-DMP',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '69',
        'tagnum' => 'PI-11-13502-RO',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '69',
        'tagnum' => 'PI-11-13503-DMP',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '69',
        'tagnum' => 'PI-11-13503-RO',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '69',
        'tagnum' => 'PI-11-13504-DMP',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '69',
        'tagnum' => 'PI-11-13504-RO',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '69',
        'tagnum' => 'PI-11-13505-DMP',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '69',
        'tagnum' => 'PI-11-13506-DMP',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '69',
        'tagnum' => 'PI-11-1351.1-PT',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '69',
        'tagnum' => 'PI-11-1351.2-PT',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '69',
        'tagnum' => 'PI-11-13516.2',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '69',
        'tagnum' => 'PI-11-1353.1-PT',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '69',
        'tagnum' => 'PI-11-1353.2-PT',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '69',
        'tagnum' => 'PI-11-1355.1A-DMP',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '69',
        'tagnum' => 'PI-11-1355.1B-DMP',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '69',
        'tagnum' => 'PI-11-1355.2A-DMP',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '69',
        'tagnum' => 'PI-11-1355.2B-DMP',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '69',
        'tagnum' => 'PI-11-1355.3A-DMP',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '69',
        'tagnum' => 'PI-11-1355.3B-DMP',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '69',
        'tagnum' => 'PI-11-1355.4A-DMP',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '69',
        'tagnum' => 'PI-11-1355.4B-DMP',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '69',
        'tagnum' => 'PI-11-1356.1A-DMP',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '69',
        'tagnum' => 'PI-11-1356.1B-DMP',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '69',
        'tagnum' => 'PI-11-1356.2A-DMP',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '69',
        'tagnum' => 'PI-11-1356.2B-DMP',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '72',
        'tagnum' => 'PI-11-136011-PMS',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '72',
        'tagnum' => 'PI-11-136020.1-PSG',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '72',
        'tagnum' => 'PI-11-136020-PSG',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '72',
        'tagnum' => 'PI-11-13609-PMS',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '72',
        'tagnum' => 'PI-11-13610.1-PWU',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '72',
        'tagnum' => 'PI-11-13610.2-PWU',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '72',
        'tagnum' => 'PI-11-13615.1-PWU ',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '72',
        'tagnum' => 'PI-11-13615.2-PMS',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '124',
        'tagnum' => 'PI-11-30401-CH',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '124',
        'tagnum' => 'PI-11-30402-CH',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '124',
        'tagnum' => 'PI-11-30403-CH',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '124',
        'tagnum' => 'PI-11-30404-CH',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '124',
        'tagnum' => 'PI-11-30405-CH',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '124',
        'tagnum' => 'PI-11-30406-CH',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '125',
        'tagnum' => 'PI-11-30501-CH',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '125',
        'tagnum' => 'PI-11-30502-CH',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '125',
        'tagnum' => 'PI-11-30503-CH',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '125',
        'tagnum' => 'PI-11-30504-CH',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '125',
        'tagnum' => 'PI-11-30505-CH',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '126',
        'tagnum' => 'PI-11-30601',
        'desc' => 'Pressure Indicator',
    ],
    [
        'area_id' => '126',
        'tagnum' => 'PI-11-30602',
        'desc' => 'Pressure Indicator',
    ],
    [
        'area_id' => '126',
        'tagnum' => 'PI-11-30603',
        'desc' => 'Pressure Indicator',
    ],
    [
        'area_id' => '126',
        'tagnum' => 'PI-11-30604',
        'desc' => 'Pressure Indicator',
    ],
    [
        'area_id' => '126',
        'tagnum' => 'PI-11-30605',
        'desc' => 'Pressure Indicator',
    ],
    [
        'area_id' => '126',
        'tagnum' => 'PI-11-30606',
        'desc' => 'Pressure Indicator',
    ],
    [
        'area_id' => '126',
        'tagnum' => 'PI-11-30607',
        'desc' => 'Pressure Indicator',
    ],
    [
        'area_id' => '126',
        'tagnum' => 'PI-11-30608',
        'desc' => 'Pressure Indicator',
    ],
    [
        'area_id' => '144',
        'tagnum' => 'PI-11-33403-HD',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '144',
        'tagnum' => 'PI-11-33404-HD',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '144',
        'tagnum' => 'PI-11-33405-HD',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '144',
        'tagnum' => 'PI-11-33406-HD',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '144',
        'tagnum' => 'PI-11-33407-HD',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '20',
        'tagnum' => 'PI-12-20101',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '20',
        'tagnum' => 'PI-12-20102',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '20',
        'tagnum' => 'PI-12-20103',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '20',
        'tagnum' => 'PI-12-20104',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '6',
        'tagnum' => 'PI-12-20301',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '6',
        'tagnum' => 'PI-12-20302',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '9',
        'tagnum' => 'PI-12-20401',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '9',
        'tagnum' => 'PI-12-20402',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '1',
        'tagnum' => 'PI-12-30101',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '1',
        'tagnum' => 'PI-12-30102',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '3',
        'tagnum' => 'PI-12-30301',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '3',
        'tagnum' => 'PI-12-30302',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '3',
        'tagnum' => 'PI-12-30303',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '3',
        'tagnum' => 'PI-12-30304',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '7',
        'tagnum' => 'PI-12-30401',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '7',
        'tagnum' => 'PI-12-30402',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '8',
        'tagnum' => 'PI-12-30501',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '8',
        'tagnum' => 'PI-12-30502',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '10',
        'tagnum' => 'PI-12-30601',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '10',
        'tagnum' => 'PI-12-30602',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '70',
        'tagnum' => 'PI-13-40001-CHO',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '70',
        'tagnum' => 'PI-13-40002-CHO',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '70',
        'tagnum' => 'PI-13-40003-CHO',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '70',
        'tagnum' => 'PI-13-40004-CHO',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '68',
        'tagnum' => 'PI-16-30001-BC',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '68',
        'tagnum' => 'PI-16-30001-TC',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '68',
        'tagnum' => 'PI-16-30002-SC',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '143',
        'tagnum' => 'PI-17-13402-WT',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '68',
        'tagnum' => 'PI-17-13403-HWT',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '143',
        'tagnum' => 'PI-17-33201',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '143',
        'tagnum' => 'PI-17-33202',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '143',
        'tagnum' => 'PI-17-33203',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '143',
        'tagnum' => 'PI-17-33204',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '143',
        'tagnum' => 'PI-17-33205',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '143',
        'tagnum' => 'PI-17-33206',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '161',
        'tagnum' => 'PI-17-40001-HP',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '161',
        'tagnum' => 'PI-17-40001-PG',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '161',
        'tagnum' => 'PI-17-40002-HP',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '161',
        'tagnum' => 'PI-17-40002-PG',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '161',
        'tagnum' => 'PI-17-40003-HP',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '161',
        'tagnum' => 'PI-17-40003-SF',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '161',
        'tagnum' => 'PI-17-40004-SF',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '161',
        'tagnum' => 'PI-17-40005-FP',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '126',
        'tagnum' => 'PI-19-30601',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '126',
        'tagnum' => 'PI-19-30602',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '126',
        'tagnum' => 'PI-19-30603',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '126',
        'tagnum' => 'PI-19-30604',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '126',
        'tagnum' => 'PI-19-30605',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '126',
        'tagnum' => 'PI-19-30606',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '126',
        'tagnum' => 'PI-19-30607',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '126',
        'tagnum' => 'PI-19-30608',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '126',
        'tagnum' => 'PI-19-30609',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '161',
        'tagnum' => 'PI-19-33201',
        'desc' => 'Pressure Indicator',
    ],
    [
        'area_id' => '161',
        'tagnum' => 'PI-19-33202',
        'desc' => 'Pressure Indicator',
    ],
    [
        'area_id' => '84',
        'tagnum' => 'PI-21-15101',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '84',
        'tagnum' => 'PI-21-15102',
        'desc' => 'Vacuum Gauge',
    ],
    [
        'area_id' => '87',
        'tagnum' => 'PI-21-15401',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '87',
        'tagnum' => 'PI-21-15403',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '87',
        'tagnum' => 'PI-21-15404',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '88',
        'tagnum' => 'PI-21-15501',
        'desc' => 'Vacuum  Gauge',
    ],
    [
        'area_id' => '91',
        'tagnum' => 'PI-21-15801-UHL',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '91',
        'tagnum' => 'PI-21-15802-UHL',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '91',
        'tagnum' => 'PI-21-15803-UHL',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '91',
        'tagnum' => 'PI-21-15804-UHL',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '98',
        'tagnum' => 'PI-21-16601',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '98',
        'tagnum' => 'PI-21-16602',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '98',
        'tagnum' => 'PI-21-16603',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '98',
        'tagnum' => 'PI-21-16604',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '130',
        'tagnum' => 'PI-21-31003',
        'desc' => 'Pressure Indicator',
    ],
    [
        'area_id' => '131',
        'tagnum' => 'PI-21-31101-UHL',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '131',
        'tagnum' => 'PI-21-31102-UHL',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '136',
        'tagnum' => 'PI-21-31701',
        'desc' => 'Pressure Indicator',
    ],
    [
        'area_id' => '140',
        'tagnum' => 'PI-21-32303',
        'desc' => 'Pressure Indicator',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'PI-22-11001',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'PI-22-11002',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '60',
        'tagnum' => 'PI-22-11004',
        'desc' => 'Pressure Indicator',
    ],
    [
        'area_id' => '65',
        'tagnum' => 'PI-23-12301',
        'desc' => 'Pressure Indicator',
    ],
    [
        'area_id' => '65',
        'tagnum' => 'PI-23-12301-GET',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '65',
        'tagnum' => 'PI-23-12302-GET',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '65',
        'tagnum' => 'PI-23-12302-GNR',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '65',
        'tagnum' => 'PI-23-12303-GET',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '65',
        'tagnum' => 'PI-23-12304-GET',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '65',
        'tagnum' => 'PI-23-12305-GET',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '78',
        'tagnum' => 'PI-25-30001-KRG',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '78',
        'tagnum' => 'PI-25-30002-KRG',
        'desc' => 'Pressure Gauge',
    ],
    [
        'area_id' => '80',
        'tagnum' => 'PI-29-144A01',
        'desc' => 'Pressure Indicator',
    ],
    [
        'area_id' => '119',
        'tagnum' => 'PI-42-25701',
        'desc' => 'Pressure Indicator',
    ],
    [
        'area_id' => '119',
        'tagnum' => 'PI-42-25702',
        'desc' => 'Pressure Indicator',
    ],
    [
        'area_id' => '126',
        'tagnum' => 'PS-11-30601',
        'desc' => 'Pressure Switch',
    ],
    [
        'area_id' => '126',
        'tagnum' => 'PS-11-30602',
        'desc' => 'Pressure Switch',
    ],
    [
        'area_id' => '126',
        'tagnum' => 'PS-11-30603',
        'desc' => 'Pressure Switch',
    ],
    [
        'area_id' => '126',
        'tagnum' => 'PS-11-30604',
        'desc' => 'Pressure Switch',
    ],
    [
        'area_id' => '143',
        'tagnum' => 'PSL-17-33201',
        'desc' => 'Pressure Switch Low',
    ],
    [
        'area_id' => '143',
        'tagnum' => 'PSL-17-33202',
        'desc' => 'Pressure Switch Low',
    ],
    [
        'area_id' => '143',
        'tagnum' => 'PSL-17-33203',
        'desc' => 'Pressure Switch',
    ],
    [
        'area_id' => '62',
        'tagnum' => 'RH-32-11208',
        'desc' => 'Humidity Indicator',
    ],
    [
        'area_id' => '143',
        'tagnum' => 'SV-17-33201',
        'desc' => 'Safety Valve',
    ],
    [
        'area_id' => '143',
        'tagnum' => 'SV-17-33202',
        'desc' => 'Safety Valve',
    ],
    [
        'area_id' => '7',
        'tagnum' => 'THT-13-33301',
        'desc' => 'Temperature Humidity Transmitter',
    ],
    [
        'area_id' => '7',
        'tagnum' => 'THT-13-33301.',
        'desc' => 'Temperature Humidity Transmitter',
    ],
    [
        'area_id' => '4',
        'tagnum' => 'THT-13-33303',
        'desc' => 'Temperature Humidity Transmitter',
    ],
    [
        'area_id' => '4',
        'tagnum' => 'THT-13-33303.',
        'desc' => 'Temperature Humidity Transmitter',
    ],
    [
        'area_id' => '15',
        'tagnum' => 'THT-13-33304',
        'desc' => 'Temperature Humidity Transmitter',
    ],
    [
        'area_id' => '5',
        'tagnum' => 'THT-13-33305',
        'desc' => 'Temperature Humidity Transmitter',
    ],
    [
        'area_id' => '5',
        'tagnum' => 'THT-13-33305.',
        'desc' => 'Temperature Humidity Transmitter',
    ],
    [
        'area_id' => '22',
        'tagnum' => 'THT-13-33306',
        'desc' => 'Temperatur Humidity trasmitter',
    ],
    [
        'area_id' => '22',
        'tagnum' => 'THT-13-33306.',
        'desc' => 'Temperature Humidity Transmitter',
    ],
    [
        'area_id' => '15',
        'tagnum' => 'THT-13-33308',
        'desc' => 'Temperature Humidity Transmitter',
    ],
    [
        'area_id' => '8',
        'tagnum' => 'THT-13-33309',
        'desc' => 'Temperatur Humidity trasmitter',
    ],
    [
        'area_id' => '8',
        'tagnum' => 'THT-13-33309.',
        'desc' => 'Temperature Humidity Transmitter',
    ],
    [
        'area_id' => '16',
        'tagnum' => 'THT-13-33314',
        'desc' => 'Temperature Humidity Transmitter',
    ],
    [
        'area_id' => '18',
        'tagnum' => 'TI-11-30401-CH',
        'desc' => 'Temperature Gauge',
    ],
    [
        'area_id' => '18',
        'tagnum' => 'TI-11-30402-CH',
        'desc' => 'Temperature Gauge',
    ],
    [
        'area_id' => '18',
        'tagnum' => 'TI-11-30403-CH',
        'desc' => 'Temperature Gauge',
    ],
    [
        'area_id' => '18',
        'tagnum' => 'TI-11-30404-CH',
        'desc' => 'Temperature Gauge',
    ],
    [
        'area_id' => '19',
        'tagnum' => 'TI-11-30501-CH',
        'desc' => 'Temperature Gauge',
    ],
    [
        'area_id' => '19',
        'tagnum' => 'TI-11-30502-CH',
        'desc' => 'Temperature Gauge',
    ],
    [
        'area_id' => '19',
        'tagnum' => 'TI-11-30503-CH',
        'desc' => 'Temperature Gauge',
    ],
    [
        'area_id' => '126',
        'tagnum' => 'TI-11-30601',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '126',
        'tagnum' => 'TI-11-30602',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '2',
        'tagnum' => 'TI-12-20101',
        'desc' => 'Temperature Gauge',
    ],
    [
        'area_id' => '2',
        'tagnum' => 'TI-12-20102',
        'desc' => 'Temperature Gauge',
    ],
    [
        'area_id' => '2',
        'tagnum' => 'TI-12-20103',
        'desc' => 'Temperature Gauge',
    ],
    [
        'area_id' => '2',
        'tagnum' => 'TI-12-20104',
        'desc' => 'Temperature Gauge',
    ],
    [
        'area_id' => '6',
        'tagnum' => 'TI-12-20301',
        'desc' => 'Temperature Gauge',
    ],
    [
        'area_id' => '6',
        'tagnum' => 'TI-12-20302',
        'desc' => 'Temperature Gauge',
    ],
    [
        'area_id' => '9',
        'tagnum' => 'TI-12-20401',
        'desc' => 'Temperature Gauge',
    ],
    [
        'area_id' => '9',
        'tagnum' => 'TI-12-20402',
        'desc' => 'Temperature Gauge',
    ],
    [
        'area_id' => '1',
        'tagnum' => 'TI-12-30101',
        'desc' => 'Temperature Gauge',
    ],
    [
        'area_id' => '1',
        'tagnum' => 'TI-12-30102',
        'desc' => 'Temperature Gauge',
    ],
    [
        'area_id' => '3',
        'tagnum' => 'TI-12-30302',
        'desc' => 'Temperature Gauge',
    ],
    [
        'area_id' => '3',
        'tagnum' => 'TI-12-30303',
        'desc' => 'Temperature Gauge',
    ],
    [
        'area_id' => '3',
        'tagnum' => 'TI-12-30304',
        'desc' => 'Temperature Gauge',
    ],
    [
        'area_id' => '7',
        'tagnum' => 'TI-12-30401',
        'desc' => 'Temperature Gauge',
    ],
    [
        'area_id' => '7',
        'tagnum' => 'TI-12-30402',
        'desc' => 'Temperature Gauge',
    ],
    [
        'area_id' => '8',
        'tagnum' => 'TI-12-30501',
        'desc' => 'Temperature Gauge',
    ],
    [
        'area_id' => '8',
        'tagnum' => 'TI-12-30502',
        'desc' => 'Temperature Gauge',
    ],
    [
        'area_id' => '10',
        'tagnum' => 'TI-12-30601',
        'desc' => 'Temperature Gauge',
    ],
    [
        'area_id' => '10',
        'tagnum' => 'TI-12-30602',
        'desc' => 'Temperature Gauge',
    ],
    [
        'area_id' => '71',
        'tagnum' => 'TI-13-40001-CHO',
        'desc' => 'Temperature Gauge',
    ],
    [
        'area_id' => '71',
        'tagnum' => 'TI-13-40002-CHO',
        'desc' => 'Temperature Gauge',
    ],
    [
        'area_id' => '71',
        'tagnum' => 'TI-13-40003-CHO',
        'desc' => 'Temperature Gauge',
    ],
    [
        'area_id' => '71',
        'tagnum' => 'TI-13-40004-CHO',
        'desc' => 'Temperature Gauge',
    ],
    [
        'area_id' => '68',
        'tagnum' => 'TI-14-13401-BBL',
        'desc' => 'Temperature Gauge',
    ],
    [
        'area_id' => '68',
        'tagnum' => 'TI-15-13401-L',
        'desc' => 'Temperature Gauge',
    ],
    [
        'area_id' => '68',
        'tagnum' => 'TI-15-13402-L',
        'desc' => 'Temperature Gauge',
    ],
    [
        'area_id' => '68',
        'tagnum' => 'TI-15-13403-L',
        'desc' => 'Temperature Gauge',
    ],
    [
        'area_id' => '68',
        'tagnum' => 'TI-17-13401-HWT',
        'desc' => 'Temperature Gauge',
    ],
    [
        'area_id' => '68',
        'tagnum' => 'TI-17-13402-HWT',
        'desc' => 'Temperature Gauge',
    ],
    [
        'area_id' => '68',
        'tagnum' => 'TI-17-30001-STM',
        'desc' => 'Temperature Gauge',
    ],
    [
        'area_id' => '65',
        'tagnum' => 'TI-23-12301-WFI',
        'desc' => 'Temperature Gauge',
    ],
    [
        'area_id' => '84',
        'tagnum' => 'TM-21-15101',
        'desc' => 'Timer',
    ],
    [
        'area_id' => '84',
        'tagnum' => 'TM-21-15102',
        'desc' => 'Timer',
    ],
    [
        'area_id' => '84',
        'tagnum' => 'TM-21-15103',
        'desc' => 'Timer',
    ],
    [
        'area_id' => '84',
        'tagnum' => 'TM-21-15104',
        'desc' => 'Timer',
    ],
    [
        'area_id' => '87',
        'tagnum' => 'TM-21-15401',
        'desc' => 'Timer',
    ],
    [
        'area_id' => '87',
        'tagnum' => 'TM-21-15402',
        'desc' => 'Timer',
    ],
    [
        'area_id' => '87',
        'tagnum' => 'TM-21-15404',
        'desc' => 'Timer',
    ],
    [
        'area_id' => '96',
        'tagnum' => 'PI-21-16401',
        'desc' => 'Pressure Indicator',
    ],
    [
        'area_id' => '59',
        'tagnum' => 'PI-21-10901',
        'desc' => 'Pressure Indicator',
    ],
    [
        'area_id' => '94',
        'tagnum' => 'PI-21-16201',
        'desc' => 'Pressure Indicator',
    ],
    [
        'area_id' => '78',
        'tagnum' => 'TI-25-14202',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '105',
        'tagnum' => 'TI-25-19102',
        'desc' => 'Temperature Indicator',
    ],
    [
        'area_id' => '159',
        'tagnum' => 'AC-001',
        'desc' => 'Dehumidifier 14-2',
    ],
    [
        'area_id' => '159',
        'tagnum' => 'AC-002',
        'desc' => 'Dehumidifier 9-3',
    ],
    [
        'area_id' => '45',
        'tagnum' => 'AC-015',
        'desc' => 'Level Control Valve',
    ],
    [
        'area_id' => '45',
        'tagnum' => 'AC-016',
        'desc' => 'AHU System 3',
    ],
    [
        'area_id' => '45',
        'tagnum' => 'AC-017',
        'desc' => 'AHU System 5',
    ],
    [
        'area_id' => '45',
        'tagnum' => 'AC-018',
        'desc' => 'AHU System 14 A',
    ],
    [
        'area_id' => '45',
        'tagnum' => 'AC-019',
        'desc' => 'AHU System 14 B',
    ],
    [
        'area_id' => '45',
        'tagnum' => 'AC-021',
        'desc' => 'AHU System 15',
    ],
    [
        'area_id' => '45',
        'tagnum' => 'AC-022',
        'desc' => 'AHU System 16',
    ],
    [
        'area_id' => '45',
        'tagnum' => 'AC-023',
        'desc' => 'AHU System 17',
    ],
    [
        'area_id' => '45',
        'tagnum' => 'AC-024',
        'desc' => 'AHU System 18',
    ],
    [
        'area_id' => '45',
        'tagnum' => 'AC-026',
        'desc' => 'AHU System 20',
    ],
    [
        'area_id' => '45',
        'tagnum' => 'AC-027',
        'desc' => 'Exhaust Fan System 4',
    ],
    [
        'area_id' => '45',
        'tagnum' => 'AC-050',
        'desc' => 'Fan Toilet',
    ],
    [
        'area_id' => '166',
        'tagnum' => 'AC-052',
        'desc' => 'AHU System 23',
    ],
    [
        'area_id' => '45',
        'tagnum' => 'AC-055',
        'desc' => 'AHU System 9-1',
    ],
    [
        'area_id' => '45',
        'tagnum' => 'AC-056',
        'desc' => 'AHU System 9-2',
    ],
    [
        'area_id' => '45',
        'tagnum' => 'AC-058',
        'desc' => 'AHU System 24.1',
    ],
    [
        'area_id' => '45',
        'tagnum' => 'AC-059',
        'desc' => 'AHU System 24.2',
    ],
    [
        'area_id' => '45',
        'tagnum' => 'AC-060',
        'desc' => 'Dehumidifier 24.2',
    ],
    [
        'area_id' => '45',
        'tagnum' => 'AC-061',
        'desc' => 'AHU System 25',
    ],
    [
        'area_id' => '45',
        'tagnum' => 'AC-062',
        'desc' => 'AHU System 26',
    ],
    [
        'area_id' => '45',
        'tagnum' => 'AC-063',
        'desc' => 'AHU System 27',
    ],
    [
        'area_id' => '45',
        'tagnum' => 'AC-064',
        'desc' => 'AHU System 28',
    ],
    [
        'area_id' => '26',
        'tagnum' => 'AC-065',
        'desc' => 'Dehumidifier 1',
    ],
    [
        'area_id' => '26',
        'tagnum' => 'AC-066',
        'desc' => 'Dehumidifier 2',
    ],
    [
        'area_id' => '167',
        'tagnum' => 'AC-067',
        'desc' => 'Dehumidifier',
    ],
    [
        'area_id' => '26',
        'tagnum' => 'AC-068',
        'desc' => 'Air Conditioner 1300A',
    ],
    [
        'area_id' => '26',
        'tagnum' => 'AC-069',
        'desc' => 'Air Conditioner 1300B',
    ],
    [
        'area_id' => '26',
        'tagnum' => 'AC-070',
        'desc' => 'Air Conditioner 1300C',
    ],
    [
        'area_id' => '26',
        'tagnum' => 'AC-071',
        'desc' => 'Air Conditioner 1300D',
    ],
    [
        'area_id' => '162',
        'tagnum' => 'CSV-004-00 ',
        'desc' => 'BMS Gandaria SCADA/BMS web View',
    ],
    [
        'area_id' => '33',
        'tagnum' => 'U-002',
        'desc' => 'Fuel Trans.Pump',
    ],
    [
        'area_id' => '33',
        'tagnum' => 'U-004',
        'desc' => 'Battery Charger',
    ],
    [
        'area_id' => '51',
        'tagnum' => 'U-005',
        'desc' => 'Fuel Main Tank 1',
    ],
    [
        'area_id' => '159',
        'tagnum' => 'U-015',
        'desc' => 'Air Compressor 1',
    ],
    [
        'area_id' => '159',
        'tagnum' => 'U-016',
        'desc' => 'Air Compressor 2',
    ],
    [
        'area_id' => '159',
        'tagnum' => 'U-018-1',
        'desc' => 'Air Dryer 1',
    ],
    [
        'area_id' => '159',
        'tagnum' => 'U-018-2',
        'desc' => 'Air Dryer 2',
    ],
    [
        'area_id' => '159',
        'tagnum' => 'U-019',
        'desc' => 'Hot Water Mixing Tank',
    ],
    [
        'area_id' => '159',
        'tagnum' => 'U-020',
        'desc' => 'Hot Water Pump',
    ],
    [
        'area_id' => '159',
        'tagnum' => 'U-021',
        'desc' => 'Hot Water Storage Tank',
    ],
    [
        'area_id' => '159',
        'tagnum' => 'U-021-2',
        'desc' => 'Potable Water Tank A',
    ],
    [
        'area_id' => '159',
        'tagnum' => 'U-022',
        'desc' => 'Submersible Pump No.2',
    ],
    [
        'area_id' => '159',
        'tagnum' => 'U-024',
        'desc' => 'Well W. Main Tank 50 M3',
    ],
    [
        'area_id' => '159',
        'tagnum' => 'U-025',
        'desc' => 'Well W. Main Tank 100 M3',
    ],
    [
        'area_id' => '159',
        'tagnum' => 'U-026',
        'desc' => 'Transfer Pump',
    ],
    [
        'area_id' => '159',
        'tagnum' => 'U-027',
        'desc' => 'Degisifier',
    ],
    [
        'area_id' => '159',
        'tagnum' => 'U-028',
        'desc' => 'Clorinator',
    ],
    [
        'area_id' => '159',
        'tagnum' => 'U-029',
        'desc' => 'Sand Filter',
    ],
    [
        'area_id' => '159',
        'tagnum' => 'U-030',
        'desc' => 'Daily Well Water Pump 1 (PW A)',
    ],
    [
        'area_id' => '159',
        'tagnum' => 'U-031',
        'desc' => 'Daily Well Water Pump 2 (PW B)',
    ],
    [
        'area_id' => '51',
        'tagnum' => 'U-034',
        'desc' => 'N2 Liquid Tank',
    ],
    [
        'area_id' => '51',
        'tagnum' => 'U-035',
        'desc' => 'N2 Filter',
    ],
    [
        'area_id' => '159',
        'tagnum' => 'U-036',
        'desc' => 'Demi Plant Unit',
    ],
    [
        'area_id' => '159',
        'tagnum' => 'U-037',
        'desc' => 'PSG Unit',
    ],
    [
        'area_id' => '159',
        'tagnum' => 'U-038',
        'desc' => 'Neutralizer Unit',
    ],
    [
        'area_id' => '51',
        'tagnum' => 'U-039',
        'desc' => 'Stand by cold water pump A',
    ],
    [
        'area_id' => '45',
        'tagnum' => 'U-040',
        'desc' => 'AHU sytem 21.1',
    ],
    [
        'area_id' => '45',
        'tagnum' => 'U-041',
        'desc' => 'AHU system 22.2',
    ],
    [
        'area_id' => '159',
        'tagnum' => 'U-042',
        'desc' => 'Oil Free Air ZT-37',
    ],
    [
        'area_id' => '159',
        'tagnum' => 'U-043-1',
        'desc' => 'Blower 1',
    ],
    [
        'area_id' => '159',
        'tagnum' => 'U-043-2',
        'desc' => 'Blower 2',
    ],
    [
        'area_id' => '159',
        'tagnum' => 'U-044',
        'desc' => 'Sand Filter Pump Waste Water 1',
    ],
    [
        'area_id' => '159',
        'tagnum' => 'U-045',
        'desc' => 'Carbon Filter Pump Waste Water 2',
    ],
    [
        'area_id' => '159',
        'tagnum' => 'U-046',
        'desc' => 'Electric Drying',
    ],
    [
        'area_id' => '41',
        'tagnum' => 'U-047',
        'desc' => 'Washing Machine',
    ],
    [
        'area_id' => '41',
        'tagnum' => 'U-048',
        'desc' => 'Draying machine',
    ],
    [
        'area_id' => '53',
        'tagnum' => 'U-049',
        'desc' => 'Floor Polisher',
    ],
    [
        'area_id' => '161',
        'tagnum' => 'U-050',
        'desc' => 'Holding Tank Air Compressor',
    ],
    [
        'area_id' => '159',
        'tagnum' => 'U-052',
        'desc' => 'Waste Water Pump',
    ],
    [
        'area_id' => '159',
        'tagnum' => 'U-055',
        'desc' => 'WPU tank and loop',
    ],
    [
        'area_id' => '159',
        'tagnum' => 'U-056',
        'desc' => 'WFI tank and loop',
    ],
    [
        'area_id' => '159',
        'tagnum' => 'U-057',
        'desc' => 'WFI production',
    ],
    [
        'area_id' => '51',
        'tagnum' => 'U-058-1',
        'desc' => 'Jocky pump',
    ],
    [
        'area_id' => '28',
        'tagnum' => 'U-067',
        'desc' => 'Lift',
    ],
    [
        'area_id' => '159',
        'tagnum' => 'U-070',
        'desc' => 'Fuel Main Tank 2',
    ],
    [
        'area_id' => '159',
        'tagnum' => 'U-075',
        'desc' => 'Trane 1 Chiller',
    ],
    [
        'area_id' => '159',
        'tagnum' => 'U-075-2',
        'desc' => 'Trane 2 Chiller',
    ],
    [
        'area_id' => '159',
        'tagnum' => 'U-076',
        'desc' => 'Cooling water pump 1 ',
    ],
    [
        'area_id' => '159',
        'tagnum' => 'U-077',
        'desc' => 'Chiller water pump 1',
    ],
    [
        'area_id' => '51',
        'tagnum' => 'U-078',
        'desc' => 'Water Cooler LBC 500',
    ],
    [
        'area_id' => '153',
        'tagnum' => 'U-079',
        'desc' => 'Hand Dryer',
    ],
    [
        'area_id' => '159',
        'tagnum' => 'U-080',
        'desc' => 'Tapproge CCS 1',
    ],
    [
        'area_id' => '159',
        'tagnum' => 'U-080-2',
        'desc' => 'Tapproge CCS 2',
    ],
    [
        'area_id' => '159',
        'tagnum' => 'U-081',
        'desc' => 'Reverse Osmosis Demin',
    ],
    [
        'area_id' => '159',
        'tagnum' => 'U-082',
        'desc' => 'Holding Tank Oil Free',
    ],
    [
        'area_id' => '159',
        'tagnum' => 'U-083',
        'desc' => 'Cooling water pump 2',
    ],
    [
        'area_id' => '159',
        'tagnum' => 'U-084',
        'desc' => 'Chiller water pump 2',
    ],
    [
        'area_id' => '43',
        'tagnum' => 'U-085',
        'desc' => 'Hand Dryer',
    ],
    [
        'area_id' => '43',
        'tagnum' => 'U-086',
        'desc' => 'Hand Dryer',
    ],
    [
        'area_id' => '31',
        'tagnum' => 'U-087',
        'desc' => 'Hand Dryer',
    ],
    [
        'area_id' => '31',
        'tagnum' => 'U-088',
        'desc' => 'Hand Dryer',
    ],
    [
        'area_id' => '158',
        'tagnum' => 'U-089',
        'desc' => 'Hand Dryer',
    ],
    [
        'area_id' => '45',
        'tagnum' => 'U-090',
        'desc' => 'Compressed Air Dryer',
    ],
    [
        'area_id' => '161',
        'tagnum' => 'U-091',
        'desc' => 'Holding Tank for Boiler',
    ],
    [
        'area_id' => '161',
        'tagnum' => 'U-096',
        'desc' => 'Miura Boiler 1',
    ],
    [
        'area_id' => '161',
        'tagnum' => 'U-097',
        'desc' => 'Miura Boiler 2',
    ],
    [
        'area_id' => '161',
        'tagnum' => 'U-098',
        'desc' => 'Reverse Osmosis Raw Water',
    ],
    [
        'area_id' => '161',
        'tagnum' => 'U-099',
        'desc' => 'Carbon Filter Raw Water',
    ],
    [
        'area_id' => '161',
        'tagnum' => 'U-100',
        'desc' => 'Dessicant Dryer',
    ],
    [
        'area_id' => '161',
        'tagnum' => 'U-101',
        'desc' => 'OFA Compressor Water Lubricated',
    ],
    [
        'area_id' => '161',
        'tagnum' => 'U-102',
        'desc' => 'Yamaha Sand & Corbon Water Filter',
    ],
    [
        'area_id' => '161',
        'tagnum' => 'U-104',
        'desc' => 'Water Filter 5 µ for Mitshui Seiki Compressor',
    ],
    [
        'area_id' => '36',
        'tagnum' => 'U-107',
        'desc' => 'Vacuum Cleaner Delvin',
    ],
    [
        'area_id' => '55',
        'tagnum' => 'U-108',
        'desc' => 'Vacuum Cleaner Krisbow',
    ],
    [
        'area_id' => '161',
        'tagnum' => 'U-109',
        'desc' => 'Potable Water Tank B',
    ],
    [
        'area_id' => '51',
        'tagnum' => 'U-110',
        'desc' => 'Water Cooling Tower LRC 250',
    ],
    [
        'area_id' => '161',
        'tagnum' => 'U-111',
        'desc' => 'AiCool Chiller',
    ],
    [
        'area_id' => '161',
        'tagnum' => 'U-112',
        'desc' => 'OFA Compressor Water Lubricated 2',
    ],
    [
        'area_id' => '161',
        'tagnum' => 'U-113',
        'desc' => 'Water Filter 5 µ for Mitshui Seiki Compressor 2',
    ],
    [
        'area_id' => '161',
        'tagnum' => 'U-114',
        'desc' => 'Chlorinator 2',
    ],
    [
        'area_id' => '33',
        'tagnum' => 'U-115',
        'desc' => 'Perkins Genset',
    ],
    [
        'area_id' => '154',
        'tagnum' => 'HF-31-11401',
        'desc' => 'HEPA Ceiling',
    ],
    [
        'area_id' => '154',
        'tagnum' => 'HF-31-11402',
        'desc' => 'HEPA Ceiling',
    ],
    [
        'area_id' => '154',
        'tagnum' => 'HF-31-11403',
        'desc' => 'HEPA Ceiling',
    ],
    [
        'area_id' => '154',
        'tagnum' => 'HF-31-11404',
        'desc' => 'HEPA Ceiling',
    ],
    [
        'area_id' => '154',
        'tagnum' => 'HF-31-11405',
        'desc' => 'HEPA Ceiling',
    ],
    [
        'area_id' => '154',
        'tagnum' => 'HF-31-11406',
        'desc' => 'HEPA Ceiling',
    ],
    [
        'area_id' => '154',
        'tagnum' => 'HF-31-11407',
        'desc' => 'HEPA Ceiling',
    ],
    [
        'area_id' => '154',
        'tagnum' => 'HF-31-11408',
        'desc' => 'HEPA Ceiling',
    ],
    [
        'area_id' => '154',
        'tagnum' => 'HF-31-11409',
        'desc' => 'HEPA Ceiling',
    ],
    [
        'area_id' => '48',
        'tagnum' => 'HF-25-14301-P20',
        'desc' => 'Laminar Air Flow',
    ],
    [
        'area_id' => '48',
        'tagnum' => 'HF-25-14302-P20',
        'desc' => 'Laminar Air Flow',
    ],
    [
        'area_id' => '48',
        'tagnum' => 'HF-25-14303',
        'desc' => 'HEPA Ceiling',
    ],
    [
        'area_id' => '48',
        'tagnum' => 'HF-25-14304',
        'desc' => 'HEPA Ceiling',
    ],
    [
        'area_id' => '54',
        'tagnum' => 'HF-25-14201',
        'desc' => 'HEPA Ceiling',
    ],
    [
        'area_id' => '54',
        'tagnum' => 'HF-25-14202',
        'desc' => 'HEPA Ceiling',
    ],
    [
        'area_id' => '40',
        'tagnum' => 'HF-21605',
        'desc' => 'Laminar Air Flow',
    ],
    [
        'area_id' => '46',
        'tagnum' => 'HF-26-25301',
        'desc' => 'HEPA Ceiling',
    ],
    [
        'area_id' => '34',
        'tagnum' => 'HF-26-25401',
        'desc' => 'HEPA Ceiling',
    ],
    [
        'area_id' => '24',
        'tagnum' => 'HF-26-25501',
        'desc' => 'HEPA Ceiling',
    ],
    [
        'area_id' => '46',
        'tagnum' => 'HF-26-25601',
        'desc' => 'HEPA Ceiling',
    ],
    [
        'area_id' => '164',
        'tagnum' => 'HF-25-14401-A',
        'desc' => 'HEPA Ceiling',
    ],
    [
        'area_id' => '49',
        'tagnum' => 'HF-25-14401-B',
        'desc' => 'HEPA Ceiling',
    ],
    [
        'area_id' => '49',
        'tagnum' => 'HF-25-14402-B',
        'desc' => 'HEPA Ceiling',
    ],
    [
        'area_id' => '168',
        'tagnum' => 'HF-23-12301-P21',
        'desc' => 'Laminar Air Flow',
    ],
    [
        'area_id' => '168',
        'tagnum' => 'HF-23-12302-P21',
        'desc' => 'Laminar Air Flow',
    ],
    [
        'area_id' => '168',
        'tagnum' => 'HF-23-12303-P21',
        'desc' => 'Laminar Air Flow',
    ],
    [
        'area_id' => '168',
        'tagnum' => 'HF-23-12304-P21',
        'desc' => 'Laminar Air Flow',
    ],
    [
        'area_id' => '168',
        'tagnum' => 'HF-23-12305-P21',
        'desc' => 'Laminar Air Flow',
    ],
    [
        'area_id' => '42',
        'tagnum' => 'HF-23-12301-PI7',
        'desc' => 'Laminar Air Flow',
    ],
    [
        'area_id' => '42',
        'tagnum' => 'HF-23-12302-PI7',
        'desc' => 'Laminar Air Flow',
    ],
    [
        'area_id' => '42',
        'tagnum' => 'HF-23-12303-P17',
        'desc' => 'Laminar Air Flow',
    ],
    [
        'area_id' => '42',
        'tagnum' => 'HF-23-12304-PI7',
        'desc' => 'Laminar Air Flow',
    ],
    [
        'area_id' => '34',
        'tagnum' => 'HF-24-12703',
        'desc' => 'HEPA Ceiling',
    ],
    [
        'area_id' => '24',
        'tagnum' => 'HF-24-12803',
        'desc' => 'HEPA Ceiling',
    ],
    [
        'area_id' => '30',
        'tagnum' => 'HF-24-12605',
        'desc' => 'HEPA Ceiling',
    ],
    [
        'area_id' => '30',
        'tagnum' => 'HF-24-12606',
        'desc' => 'HEPA Ceiling',
    ],
    [
        'area_id' => '163',
        'tagnum' => 'HF-24-12903',
        'desc' => 'HEPA Ceiling',
    ],
    [
        'area_id' => '165',
        'tagnum' => 'HF-24-14014',
        'desc' => 'HEPA Ceiling',
    ],
    [
        'area_id' => '165',
        'tagnum' => 'HF-24-14015',
        'desc' => 'HEPA Ceiling',
    ],
    [
        'area_id' => '165',
        'tagnum' => 'HF-24-14016',
        'desc' => 'HEPA Ceiling',
    ],
    [
        'area_id' => '165',
        'tagnum' => 'HF-24-14017',
        'desc' => 'HEPA Ceiling',
    ],
    [
        'area_id' => '50',
        'tagnum' => 'HF-24-14108',
        'desc' => 'HEPA Ceiling',
    ],
    [
        'area_id' => '50',
        'tagnum' => 'HF-24-14109',
        'desc' => 'HEPA Ceiling',
    ],
    [
        'area_id' => '32',
        'tagnum' => 'HF-24-14503',
        'desc' => 'HEPA Ceiling',
    ],
    [
        'area_id' => '50',
        'tagnum' => 'HF-24-14101-PI9',
        'desc' => 'Laminar Air Flow',
    ],
    [
        'area_id' => '50',
        'tagnum' => 'HF-24-14102-PI9',
        'desc' => 'Laminar Air Flow',
    ],
    [
        'area_id' => '50',
        'tagnum' => 'HF-24-14103-PI9',
        'desc' => 'Laminar Air Flow',
    ],
    [
        'area_id' => '50',
        'tagnum' => 'HF-24-14104-PI9',
        'desc' => 'Laminar Air Flow',
    ],
    [
        'area_id' => '165',
        'tagnum' => 'HF-24-14005-PI8',
        'desc' => 'Laminar Air Flow',
    ],
    [
        'area_id' => '165',
        'tagnum' => 'HF-24-14006-PI8',
        'desc' => 'Laminar Air Flow',
    ],
    [
        'area_id' => '165',
        'tagnum' => 'HF-24-14007-PI8',
        'desc' => 'Laminar Air Flow',
    ],
    [
        'area_id' => '165',
        'tagnum' => 'HF-24-14008-PI8',
        'desc' => 'Laminar Air Flow',
    ],
    [
        'area_id' => '165',
        'tagnum' => 'HF-24-14009-P18',
        'desc' => 'Laminar Air Flow',
    ],
    [
        'area_id' => '165',
        'tagnum' => 'HF-24-12501-P25',
        'desc' => 'Laminar Air Flow',
    ],
    [
        'area_id' => '29',
        'tagnum' => 'HF-24-12502-P25',
        'desc' => 'Laminar Air Flow',
    ],
    [
        'area_id' => '29',
        'tagnum' => 'HF-24-12503-P25',
        'desc' => 'Laminar Air Flow',
    ],
    [
        'area_id' => '29',
        'tagnum' => 'HF-24-12504-P25',
        'desc' => 'Laminar Air Flow',
    ],
    [
        'area_id' => '29',
        'tagnum' => 'HF-24-12505-P25',
        'desc' => 'Laminar Air Flow',
    ],
    [
        'area_id' => '29',
        'tagnum' => 'HF-24-12506-P25',
        'desc' => 'Laminar Air Flow',
    ],
    [
        'area_id' => '29',
        'tagnum' => 'HF-24-12507-P25',
        'desc' => 'Laminar Air Flow',
    ],
    [
        'area_id' => '29',
        'tagnum' => 'HF-24-12508-P25',
        'desc' => 'Laminar Air Flow',
    ],
    [
        'area_id' => '47',
        'tagnum' => 'HF-24003-MOB',
        'desc' => 'Laminar Air Flow',
    ],
    [
        'area_id' => '35',
        'tagnum' => 'HF-42-25301',
        'desc' => 'HEPA Ceiling',
    ],
    [
        'area_id' => '35',
        'tagnum' => 'HF-42-25302',
        'desc' => 'HEPA Ceiling',
    ],
    [
        'area_id' => '25',
        'tagnum' => 'HF-42-25601-BSC',
        'desc' => 'HEPA Ceiling',
    ],
    [
        'area_id' => '25',
        'tagnum' => 'HF-42-25602-BSC',
        'desc' => 'HEPA Ceiling',
    ],
]
        );
    }

    public function safeDown()
    {
        //$this->truncateTable('{{%tag}} CASCADE');
    }
}
