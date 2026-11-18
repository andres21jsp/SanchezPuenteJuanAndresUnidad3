<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ExpenseFlowTest extends TestCase
{
    use RefreshDatabase;

    // Prueba 1: Proteger el dashboard
    public function test_dashboard_requiere_autenticacion(): void
    {
        $this->get('/dashboard')
            ->assertRedirect('/login');
    }

    // Prueba 2: Acceso de usuarios autenticados
    public function test_usuario_puede_acceder_al_dashboard(): void
    {
        $usuario = User::factory()->create();

        $this->actingAs($usuario)
            ->get('/dashboard')
            ->assertOk();
    }

    // Prueba 3: Proteger la API con Sanctum
    public function test_api_rechaza_acceso_sin_token(): void
    {
        $this->getJson('/api/movimientos')
            ->assertUnauthorized();
    }

    // Prueba 4: Registrar ingresos mediante la API
    public function test_api_permite_registrar_ingresos(): void
    {
        $usuario = User::factory()->create();

        Sanctum::actingAs($usuario);

        $this->postJson('/api/movimientos', [
            'concepto' => 'Pago de nomina',
            'monto' => 5000,
            'tipo' => 'ingreso',
            'fecha' => '2026-11-17',
        ])->assertCreated();

        $this->assertDatabaseHas('movimientos', [
            'user_id' => $usuario->id,
            'concepto' => 'Pago de nomina',
            'monto' => 5000,
        ]);
    }

    // Prueba 5: Validación de montos negativos
    public function test_api_rechaza_montos_negativos(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $this->postJson('/api/movimientos', [
            'concepto' => 'Monto invalido',
            'monto' => -500,
            'tipo' => 'gasto',
            'fecha' => '2026-11-17',
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('monto');
    }

    // Prueba 6: Protección de movimientos de otros usuarios
    public function test_usuario_no_puede_eliminar_movimientos_ajenos(): void
    {
        $usuario1 = User::factory()->create();
        $usuario2 = User::factory()->create();

        $movimiento = $usuario1->movimientos()->create([
            'concepto' => 'Movimiento privado',
            'monto' => 1000,
            'tipo' => 'ingreso',
            'fecha' => '2026-11-17',
        ]);

        Sanctum::actingAs($usuario2);

        $this->deleteJson('/api/movimientos/' . $movimiento->id)
            ->assertNotFound();

        $this->assertDatabaseHas('movimientos', [
            'id' => $movimiento->id,
        ]);
    }

    // Prueba 7: Integración con Frankfurter API
    public function test_conversion_de_divisas(): void
    {
        Http::fake([
            'api.frankfurter.dev/*' => Http::response([
                'date' => '2026-11-17',
                'base' => 'USD',
                'quote' => 'MXN',
                'rate' => 18.50,
            ], 200),
        ]);

        $usuario = User::factory()->create();

        $this->actingAs($usuario)
            ->from('/dashboard')
            ->post('/divisas/convertir', [
                'cantidad' => 100,
                'origen' => 'USD',
                'destino' => 'MXN',
            ])
            ->assertRedirect('/dashboard')
            ->assertSessionHas('conversion.resultado', 1850.0);

        Http::assertSentCount(1);
    }
}