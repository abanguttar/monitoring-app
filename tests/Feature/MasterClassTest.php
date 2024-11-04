<?php

namespace App\Libraries;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;

class MasterClassTest extends CIUnitTestCase
{

    use DatabaseTestTrait;

    protected $db;
    public function setup(): void
    {
        parent::setUp();
        $this->db =  \Config\Database::connect();;
    }

    public function testFooNotBar()
    {
        $build = $this->db->table('pesertas');
        $pesertas = $build->get()->getResult();

        $this->assertNotNull($pesertas);
    }
}
