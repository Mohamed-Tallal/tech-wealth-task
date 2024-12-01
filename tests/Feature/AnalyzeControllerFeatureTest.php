<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class AnalyzeControllerFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_allows_authenticated_user_to_analyze_text_and_return_true()
    {
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson('/analyze', [
            'text' => 'A man, a plan, a canal, Panama'
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'matches_pattern' => true,
                     'reversed_text' => 'amanaP lanac a nalp a nam A',
                    ]);
    }

    public function test_it_allows_authenticated_user_to_analyze_text_and_return_false()
    {
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson('/analyze', [
            'text' => 'Hello, World!'
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'matches_pattern' => false,
                     'reversed_text' => 'dlroW olleH',
                    ]);
    }

    public function test_it_does_not_allow_unauthenticated_user_to_access_analyze_route()
    {
        $response = $this->postJson('/analyze', [
            'text' => 'A man, a plan, a canal, Panama'
        ]);
        $response->assertStatus(401);
    }

    public function test_it_validates_required_text_field()
    {
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson('/analyze', [
            'text' => ''
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['text']);
    }

    public function test_it_validates_string_type_for_text_field()
    {
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson('/analyze', [
            'text' => 12345
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['text']);
    }
}
