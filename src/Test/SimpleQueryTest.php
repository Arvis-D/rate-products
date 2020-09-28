<?php

namespace App\Test;

use PHPUnit\Framework\TestCase;
use App\Helper\MySql\SimpleQuery;

class SimpleQueryTest extends TestCase
{
    public function testInsert()
    {
        $arr = ['dog', 'cat', 'mouse', 'chicken'];
        $query = SimpleQuery::table('testT')->insert($arr);
        $str = $query->getQuery();
        $params = $query->getParams();

        $this->assertSame('INSERT INTO testT VALUES(null, :key0, :key1, :key2, :key3);', $str);
        $this->assertSame(['key0' => 'dog', 'key1' => 'cat', 'key2' => 'mouse', 'key3' => 'chicken'], $params);
    }

    public function testSelect()
    {
        $query = SimpleQuery::table('testT')->select(['dog', 'cat'], ['id' => 2, 'name' => 'qwerty']);
        $str = $query->getQuery();
        $params = $query->getParams();

        $this->assertSame('SELECT dog, cat FROM testT WHERE id = :id AND name = :name;', $str);
        $this->assertSame(['id' => 2, 'name' => 'qwerty'], $params);
    }

    public function testDelete()
    {
        $query = SimpleQuery::table('testT')->delete(['id' => 2, 'name' => 'qwerty']);
        $str = $query->getQuery();
        $params = $query->getParams();

        $this->assertSame('DELETE FROM testT WHERE id = :id AND name = :name;', $str);
        $this->assertSame(['id' => 2, 'name' => 'qwerty'], $params);
    }
}
