<?php

use yii\db\Schema;
use yii\db\Migration;

class m211120_150226_userDataInsert extends Migration
{

    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function safeUp()
    {
        $this->batchInsert('{{%user}}',
                           ["username", "fullname", "email", "dept_id", "status", "role", "signature", "priv", "created_at", "updated_at", "last_loged", "auth_key", "password_hash", "access_token", "password_reset_token"],
                            [
    [
        'username' => 'admin',
        'fullname' => 'Admin User',
        'email' => 'anthon.awan@gmail.com',
        'dept_id' => '1',
        'status' => '1',
        'role' => '1',
        'signature' => '',
        'priv' => '',
        'created_at' => '1625132687',
        'updated_at' => '1637316909',
        'last_loged' => '1637415882',
        'auth_key' => 'o_vQHseuaqDp6j3g31mQz_NMvJO3kFfJ',
        'password_hash' => '$2y$13$e8gIxO2RHl.UFFWnhrTwd.Upuw8xaflr7xv/9UtX6tCjYVwB5opiK',
        'access_token' => '_e7cWKC1w7eHVUyjgN6Nr17zyCj8-RnI_admin',
        'password_reset_token' => null,
    ],
    [
        'username' => 'init',
        'fullname' => 'Initiator user',
        'email' => 'int@int.com',
        'dept_id' => '1',
        'status' => '1',
        'role' => '2',
        'signature' => '',
        'priv' => '',
        'created_at' => '1625135463',
        'updated_at' => '1633292325',
        'last_loged' => '1633320102',
        'auth_key' => 'wjraTFgE-qDVZSX7URI4HzxZyWBY3hrL',
        'password_hash' => '$2y$13$z7irJ651MgrkuBGvVuSec.bJqW6ozSepWk3BeezCtSx8eAals.7xm',
        'access_token' => 'xvNAYEvH6SfdNGzaRIzHHbqRn1Es7A1W_init',
        'password_reset_token' => null,
    ],
    [
        'username' => 'spv',
        'fullname' => 'Supervisor user',
        'email' => 'spv@spv.com',
        'dept_id' => '2',
        'status' => '1',
        'role' => '2',
        'signature' => '',
        'priv' => '',
        'created_at' => '1625153413',
        'updated_at' => '1633381719',
        'last_loged' => '1633503369',
        'auth_key' => 'DTy7AYVRqzDJ4P73tYUh6IBPQhVBbJLf',
        'password_hash' => '$2y$13$LWp9rHkbu.T3tMSzJMx/geyssur3xQ8N/scQXMMYz03R6BIUgvlYy',
        'access_token' => 'xL9t4X_fDS5cWgU1NBOqgrM_8RJ4gdkq_spv',
        'password_reset_token' => null,
    ],
    [
        'username' => 'test',
        'fullname' => 'test user',
        'email' => 'blaquecry@gmail.com',
        'dept_id' => '3',
        'status' => '1',
        'role' => '1',
        'signature' => null,
        'priv' => null,
        'created_at' => '1625344438',
        'updated_at' => '1636477121',
        'last_loged' => '1636622230',
        'auth_key' => 'MJ8lZAefo2x_6WycakQYxyh4CDIqysre',
        'password_hash' => '$2y$13$lILhFrqlrBqzEtXFtqr.1e4KLwombZJHe3P12skByKENmmswpmD5i',
        'access_token' => 'zwZvZ5x5-rLLs5oNOiYYA2cIK0LP4bZ8_test',
        'password_reset_token' => null,
    ],
    [
        'username' => 'wendy',
        'fullname' => 'Setiadi Ruswendy',
        'email' => 'Setiadi.uswendy@test.com',
        'dept_id' => '1',
        'status' => '1',
        'role' => '2',
        'signature' => null,
        'priv' => null,
        'created_at' => '1626208286',
        'updated_at' => '1633301085',
        'last_loged' => '1633503689',
        'auth_key' => 'OTeO3x2kCWL8sDzcH9J88B5l4bAKbe5-',
        'password_hash' => '$2y$13$PSLpXHUTwyrU5H0voNXhxO/pntEgC6R3rK05notH8gmjquXFwSc3C',
        'access_token' => 'yk8pv2XcOQdsOOr_f3GU6OgocppY6cbn_wendy',
        'password_reset_token' => null,
    ],
    [
        'username' => 'suratno',
        'fullname' => 'Suratno Suratno',
        'email' => 'Suratno.suratno@test.com',
        'dept_id' => '5',
        'status' => '1',
        'role' => '2',
        'signature' => '',
        'priv' => '',
        'created_at' => '1626208521',
        'updated_at' => '1636354280',
        'last_loged' => '1633329764',
        'auth_key' => '8bYXFB5rVc6HwlYPRDHvOtNOgKyNAjPX',
        'password_hash' => '$2y$13$SrJN4xPuEAQtJglzVahhwekJ1m06viO9LrpMhbKUO/uamBIowwsGG',
        'access_token' => '50e3EXVP5Z7d9J_uy_HpgvIZHbs362Ud_suratno',
        'password_reset_token' => null,
    ],
    [
        'username' => 'init2',
        'fullname' => 'init2 user',
        'email' => 'init@init.com',
        'dept_id' => '4',
        'status' => '1',
        'role' => '2',
        'signature' => null,
        'priv' => null,
        'created_at' => '1633290050',
        'updated_at' => '1633290050',
        'last_loged' => '0',
        'auth_key' => 'Ajoc645CwZcusfV7_V713osnZO3OTM2e',
        'password_hash' => '$2y$13$wS8Ua8IJ5GLuH1danwDgZ.KqpEiERf3pOnYwl9hIK3uWI1xhnMbW2',
        'access_token' => 'Z_ox8pxj5LXG5taqfYIG1VVbY18RJ39H_init2',
        'password_reset_token' => null,
    ],
    [
        'username' => 'blaq',
        'fullname' => 'blaq',
        'email' => 'a@a.com',
        'dept_id' => '4',
        'status' => '1',
        'role' => '2',
        'signature' => null,
        'priv' => null,
        'created_at' => '1636880221',
        'updated_at' => '1636880222',
        'last_loged' => '1637184598',
        'auth_key' => 'K3KujDUYXrD4vr8h97vk-CJdHsap6bjN',
        'password_hash' => '$2y$13$Jts4PecGbY7fS6Y4CYG0CeoZdZcjzmdOKY1FRdI1QjcJfsL0rq5p2',
        'access_token' => 'gjRjHv4pFCrclFm0lUtTUiE4rZ1UrtPV_blaq',
        'password_reset_token' => null,
    ],
]
        );
    }

    public function safeDown()
    {
        //$this->truncateTable('{{%user}} CASCADE');
    }
}
