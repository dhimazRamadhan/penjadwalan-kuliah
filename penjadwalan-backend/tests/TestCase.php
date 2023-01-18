<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Faker\Factory;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    protected $faker;

    public function setUp(): void{
    parent::setUp();
    $this->faker = Factory::create();
    }
}
