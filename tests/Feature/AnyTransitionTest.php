<?php

namespace Ashraf\EloquentStateMachine\Tests\Feature;

use Ashraf\EloquentStateMachine\Tests\TestCase;
use Ashraf\EloquentStateMachine\Tests\TestModels\SalesOrderWithAnyToAny;
use Ashraf\EloquentStateMachine\Tests\TestModels\SalesOrderWithFromAny;
use Ashraf\EloquentStateMachine\Tests\TestModels\SalesOrderWithToAny;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Queue;

class AnyTransitionTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function can_transition_to_any_state()
    {
        //Arrange
        $salesOrder = SalesOrderWithToAny::create();

        $this->assertTrue($salesOrder->status()->is('pending'));

        $this->assertEquals('pending', $salesOrder->status);

        //Act
        $salesOrder->status()->transitionTo('approved');

        //Assert
        $salesOrder->refresh();

        $this->assertTrue($salesOrder->status()->is('approved'));

        $this->assertEquals('approved', $salesOrder->status);
    }

    /** @test */
    public function can_transition_from_any_state()
    {
        //Arrange
        $salesOrder = SalesOrderWithFromAny::create();

        $this->assertTrue($salesOrder->status()->is('pending'));

        $this->assertEquals('pending', $salesOrder->status);

        //Act
        $salesOrder->status()->transitionTo('approved');

        //Assert
        $salesOrder->refresh();

        $this->assertTrue($salesOrder->status()->is('approved'));

        $this->assertEquals('approved', $salesOrder->status);
    }

    /** @test */
    public function can_transition_from_any_to_any_state()
    {
        //Arrange
        $salesOrder = SalesOrderWithAnyToAny::create();

        $this->assertTrue($salesOrder->status()->is('new'));

        $this->assertEquals('new', $salesOrder->status);

        //Act
        $salesOrder->status()->transitionTo('random');

        //Assert
        $salesOrder->refresh();

        $this->assertTrue($salesOrder->status()->is('random'));

        $this->assertEquals('random', $salesOrder->status);
    }
}
