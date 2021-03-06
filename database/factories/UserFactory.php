<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/
//        $threads = factory(App\Thread::class, 50)->create();
//        $threads->each(function($thread){ factory(App\Reply::class, 10)->create(['thread_id'=>$thread->id]); });
$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});

$factory->define(App\Thread::class, function ($faker) {
   return [
       'user_id' => function(){
            return factory(App\User::class)->create()->id;
       },
       'channel_id' => function(){
           return factory(App\Channel::class)->create()->id;
       },
       'title' => $faker->sentence,
       'body' => $faker->paragraph,
   ];
});

$factory->define(App\Channel::class, function ($faker) {
    $name = $faker->word;
    return [
        'name' => $name, //serveradmin
        'slug' => $name, //
    ];
});

$factory->define(App\Reply::class, function ($faker) {
    return [
        'thread_id' => function(){
            return factory(App\Thread::class)->create()->id;
        },
        'user_id' => function(){
            return factory(App\User::class)->create()->id;
        },
        'body' => $faker->paragraph,
    ];
});
