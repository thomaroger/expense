<?php

namespace App\Tests\Unit;

use Mockery;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ExpenseTestCase extends WebTestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        gc_collect_cycles();
    }

    public function testExpenseWebCase(): void
    {
        $success = true;
        $this->assertSame($success, true, 'ExpenseTestCase failure.');
    }
}
