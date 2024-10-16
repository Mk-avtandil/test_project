<?php

namespace Database\Seeders;

use A17\Twill\Models\Media;
use App\Models\Comment;
use App\Models\Order;
use App\Models\Product;
use App\Models\Service;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\CommentFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Product::factory()->count(40)->create();
        Service::factory()->count(40)->create();
        Order::factory()->count(80)->create();

        // Creating fake images
        $disk = Config::get('twill.media_library.disk');

        $medias = [];
        for($i=1; $i<=6; $i++){
            $filename = $i . '.jpeg';
            $filePath = database_path('seeders/images/') . $filename;
            $uuid = Str::uuid();
            list($w, $h) = getimagesize($filePath);

            Storage::disk($disk)->put($uuid . '/' . $filename, file_get_contents($filePath));
            $medias[] = Media::create([
                'uuid' => $uuid . '/' . $filename,
                'filename' => $filename,
                'caption' => '',
                'alt_text' => '',
                'width' => $w,
                'height' => $h,
            ]);
        }

        foreach(Product::all() as $product) {
            $product->medias()->attach($medias[rand(0, 5)]->id, ['metadatas' => '{}']);
        }

        Comment::factory()->count(80)->create();
    }
}
