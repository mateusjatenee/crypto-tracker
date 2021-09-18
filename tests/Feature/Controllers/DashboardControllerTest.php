<?php

use App\Models\Team;

it('loads the dashboard', function () {
    $team = Team::factory()->create();

    $this->actingAs($team->owner)
         ->get('dashboard')
         ->assertStatus(200);
});
