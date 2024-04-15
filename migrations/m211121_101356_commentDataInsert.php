<?php

use yii\db\Schema;
use yii\db\Migration;

class m211121_101356_commentDataInsert extends Migration
{

    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function safeUp()
    {
        $this->batchInsert('{{%comment}}',
                           ["user_id", "order_id", "comment", "time"],
                            [
    [
        'user_id' => '4',
        'order_id' => '1112021001',
        'comment' => 'test comment ahhh.. AJSLAJSLAJSLA aska;ks; skdksdjskjdksjd skdksjdksjdkskdjkskdjskd skdjskdjksjdksdjksjdksjd skdjksdjsj;dsjd;sj; sljnvnldldjfljdf sljsjdljskdjlajdlajd saljdlajdlkjladjlajaks;a askask;aks;aks asla;ls;adfd mmmmmmmmmmmmmmmmm asasjkajsaksjskas askasjakjskajs ashakskajskjas asjasjdjsldjsljdlsjd sdsssssssss sdsldksldklskd sdksldklskdlskds sdsjdksjdksjkdjskdd;sd;skd;skd ksdkshdkhskdhkshdhskd sdjlsjdlsjdsjd sldlskdlskdlskd sdksldklskdlskld sldklskdlskldklskd sldkslkdlskdlsdk sldklskdlskdlskdlskd sldklskdlskdsdjshdjhsjdhjshdjshd skdjksdjksjdkjskd skdjksjdksjdksjdksjkjd',
        'time' => '1626206694',
    ],
    [
        'user_id' => '2',
        'order_id' => '1112021001',
        'comment' => 'jlajjalkjaja',
        'time' => '1212121',
    ],
]
        );
    }

    public function safeDown()
    {
        //$this->truncateTable('{{%comment}} CASCADE');
    }
}
