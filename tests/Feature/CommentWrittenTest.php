<?php

use App\Events\CommentWritten;
use App\Listeners\CommentWrittenListener;
use App\Models\Comment;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Str;
use Tests\TestCase;

class CommentWrittenTest extends TestCase
{

    use RefreshDatabase;
    use WithoutMiddleware;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function test_store_comment()
    {
        $lesson = Lesson::factory()->create();
        $data = [
            '_token' => csrf_token(),
            'lesson_id' => $lesson->id,
            'user_id' => $this->user->id,
            'body' => Str::random(100)
        ];
        $this->followingRedirects();
        $response = $this->post('/comments', $data);
//        $event = new CommentWritten($response, $this->user);
//        $listener = new CommentWrittenListener();
//        $listener->handle($event);
        $this->assertEquals(200, $response->getStatusCode());

    }
}
