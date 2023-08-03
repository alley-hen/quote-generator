<?php

use App\Models\User;
use function Pest\Laravel\actingAs;

//this test will fail when I change the controller being called
// in the '/dashboard' route for step 5 of this task

it('has sendQuotesFromRemoteApi page', function () {
    $user = User::factory()->create();
    actingAs($user);
    $response = $this->get('/dashboard');
    $response->assertStatus(200);
});
