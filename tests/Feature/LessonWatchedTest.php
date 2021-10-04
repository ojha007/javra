<?php

use App\Events\LessonWatched;
use App\Listeners\LessonWatchedListener;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;

class LessonWatchedTest extends TestCase
{


    public function test_lesson_list()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/');
        $response->assertStatus(200);


    }

    public function test_lesson_view()
    {
        Bus::fake();
        $user = User::factory()->create();
        $lesson = Lesson::factory()->create();
        $this->actingAs($user)->get('/lessons/' . $lesson->id);
        $event = new LessonWatched($lesson, $user);
        $listener = new LessonWatchedListener();
        $listener->handle($event);
        $this->assertTrue(true);
    }

}
