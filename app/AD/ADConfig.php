<?php

namespace app\AD;
use Adldap;
//require_once __DIR__.'/vendor/autoload.php';
class ADConfig
{
    private $configuration = [
    // Mandatory Configuration Options
            'hosts'            => ['abxads002.int.atosbox.ru'],
            'base_dn'          => 'OU=Users,OU=ABX,OU=OU_Root,DC=int,DC=atosbox,DC=ru',
            'username'         => 'INT\A828835',
            'password'         => 'Rfgbnfk0792!',

                // Optional Configuration Options
            'schema'           => Adldap\Schemas\ActiveDirectory::class,
            'account_prefix'   => 'INT-',
            'account_suffix'   => '@acme.org',
            'port'             => 389,
            'follow_referrals' => false,
            'use_ssl'          => false,
            'use_tls'          => false,
            'version'          => 3,
            'timeout'          => 5,
        ];


    private $connections = [
        'connection1' => [
            'hosts' => ['abxads002.int.atosbox.ru'],
        ],
        "department" => [
            'hosts' => ['abxads002.int.atosbox.ru'],
        ],
        "manager" => [
            'hosts' => ['abxads002.int.atosbox.ru'],
        ],
        "unit" => [
            'hosts' => ['abxads002.int.atosbox.ru'],
        ]
    ];

    public function getConfig(){
        return $this->configuration;
    }

    public function getConnection(){
        return $this->connections;
    }

}
