<?php
namespace Tests\Feature;
use App\Models\Comment;
use App\Models\Department;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class AdminPanelTest extends TestCase
{
    use RefreshDatabase;
    public function test_regular_users_cannot_access_admin_panel(): void
    {
        $this->actingAs(User::factory()->create())->get(route('admin.dashboard'))->assertForbidden();
    }
    public function test_admin_can_access_dashboard_and_create_institution(): void
    {
        $admin=User::factory()->create(['is_admin'=>true]);
        $department=Department::create(['name'=>'Cochabamba','slug'=>'cochabamba','capital'=>'Cochabamba','is_active'=>true]);
        $this->actingAs($admin)->get(route('admin.dashboard'))->assertOk()->assertSee('Resumen general');
        $this->post(route('admin.content.store','institutions'),[
            'department_id'=>$department->id,'name'=>'Instituto Administrado','institution_type'=>'Instituto técnico',
            'city'=>'Cochabamba','address'=>'Calle de prueba','is_active'=>'1',
        ])->assertRedirect(route('admin.content.index','institutions'));
        $this->assertDatabaseHas('institutions',['slug'=>'instituto-administrado','is_active'=>true]);
    }
    public function test_admin_can_approve_a_comment(): void
    {
        $admin=User::factory()->create(['is_admin'=>true]); $user=User::factory()->create();
        $comment=Comment::create(['user_id'=>$user->id,'content'=>'La plataforma me ayudó a conocer nuevas opciones profesionales.','status'=>'pending']);
        $this->actingAs($admin)->patch(route('admin.comments.review',$comment),['status'=>'approved'])->assertSessionHas('status');
        $this->assertDatabaseHas('comments',['id'=>$comment->id,'status'=>'approved','reviewed_by'=>$admin->id]);
    }
}
