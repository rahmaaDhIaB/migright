<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * The back office requires authentication: guests are sent to the login page.
     */
    public function test_guests_are_redirected_from_the_home_page_to_login(): void
    {
        $this->get('/')->assertRedirect(route('login'));
    }
}
