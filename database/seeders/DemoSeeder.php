<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Project;
use App\Models\Tag;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::count();
        if ($users < 3) {
            User::factory()->create(['name' => 'Alice Johnson', 'email' => 'alice@example.com']);
            User::factory()->create(['name' => 'Bob Smith', 'email' => 'bob@example.com']);
        }

        $admin = User::where('email', 'admin@example.com')->first() ?? User::first();
        $alice = User::where('email', 'alice@example.com')->first() ?? User::skip(0)->first();
        $bob = User::where('email', 'bob@example.com')->first() ?? User::skip(1)->first();

        $project1 = Project::create([
            'name' => 'Website Redesign',
            'description' => 'Complete overhaul of the company website with modern design patterns and improved UX.',
            'status' => 'active',
            'created_by' => $admin->id,
        ]);

        $project2 = Project::create([
            'name' => 'Mobile App Q4 Release',
            'description' => 'Feature improvements and bug fixes for the Q4 mobile app release cycle.',
            'status' => 'active',
            'created_by' => $admin->id,
        ]);

        $tasks = [
            ['project_id' => $project1->id, 'title' => 'Design new homepage mockups', 'status' => 'done', 'priority' => 'high', 'assigned_to' => $alice->id, 'order_column' => 0],
            ['project_id' => $project1->id, 'title' => 'Implement responsive navigation', 'status' => 'in_progress', 'priority' => 'high', 'assigned_to' => $bob->id, 'order_column' => 1],
            ['project_id' => $project1->id, 'title' => 'Create contact form with validation', 'status' => 'todo', 'priority' => 'medium', 'assigned_to' => null, 'order_column' => 2],
            ['project_id' => $project1->id, 'title' => 'SEO optimization pass', 'status' => 'review', 'priority' => 'medium', 'assigned_to' => $alice->id, 'order_column' => 3],
            ['project_id' => $project1->id, 'title' => 'Write unit tests for API endpoints', 'status' => 'todo', 'priority' => 'low', 'assigned_to' => $bob->id, 'order_column' => 4],
            ['project_id' => $project2->id, 'title' => 'Implement push notifications', 'status' => 'in_progress', 'priority' => 'urgent', 'assigned_to' => $alice->id, 'order_column' => 0],
            ['project_id' => $project2->id, 'title' => 'Fix login crash on Android 14', 'status' => 'done', 'priority' => 'urgent', 'assigned_to' => $bob->id, 'order_column' => 1],
            ['project_id' => $project2->id, 'title' => 'Add dark mode support', 'status' => 'todo', 'priority' => 'low', 'assigned_to' => null, 'order_column' => 2],
            ['project_id' => $project2->id, 'title' => 'Performance profiling and optimization', 'status' => 'review', 'priority' => 'high', 'assigned_to' => $alice->id, 'order_column' => 3],
            ['project_id' => $project2->id, 'title' => 'Update privacy policy screen', 'status' => 'todo', 'priority' => 'medium', 'assigned_to' => $bob->id, 'order_column' => 4],
        ];

        foreach ($tasks as $taskData) {
            $task = Task::create($taskData);

            if ($task->assigned_to) {
                Comment::create([
                    'task_id' => $task->id,
                    'user_id' => $task->assigned_to,
                    'body' => 'Starting work on this task.',
                ]);
            }
        }

        $bugTag = Tag::create(['name' => 'Bug', 'color' => '#EF4444']);
        $featureTag = Tag::create(['name' => 'Feature', 'color' => '#3B82F6']);
        $improvementTag = Tag::create(['name' => 'Improvement', 'color' => '#10B981']);
        $urgentTag = Tag::create(['name' => 'Urgent', 'color' => '#F59E0B']);

        Task::where('title', 'Fix login crash on Android 14')->first()?->tags()->attach([$bugTag->id, $urgentTag->id]);
        Task::where('title', 'Implement push notifications')->first()?->tags()->attach($featureTag->id);
        Task::where('title', 'Add dark mode support')->first()?->tags()->attach($improvementTag->id);
        Task::where('title', 'SEO optimization pass')->first()?->tags()->attach($improvementTag->id);

        Comment::create([
            'task_id' => Task::where('title', 'Fix login crash on Android 14')->first()->id,
            'user_id' => $admin->id,
            'body' => 'Great work on this! Can you also check the iOS repro steps?',
        ]);

        Comment::create([
            'task_id' => Task::where('title', 'Implement responsive navigation')->first()->id,
            'user_id' => $alice->id,
            'body' => 'I have some reference designs if needed.',
        ]);
    }
}
