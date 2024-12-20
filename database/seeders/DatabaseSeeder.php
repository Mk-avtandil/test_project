<?php

namespace Database\Seeders;

use A17\Twill\Models\Media;
use App\Models\Comment;
use App\Models\MenuLink;
use App\Models\Order;
use App\Models\Page;
use App\Models\Product;
use App\Models\Service;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\CommentFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
        $orders = Order::factory()->count(80)->create();

        $types = ['product', 'service'];
        foreach ($orders as $order) {
            for($i=0; $i<rand(5, 15); $i++) {
                $type = $types[array_rand($types)];
                DB::table('orderables')->insert([
                    'order_id' => $order->id,
                    'orderable_id' => rand(1, 40),
                    'orderable_type' => $type,
                    'quantity' => rand(1, 20),
                ]);
            }
        }

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

        DB::table('twill_users')->insert([
            'published' => 1,
            'created_at' => now(),
            'name' => 'Test Admin',
            'email' => 'test@gmail.com',
            'is_superadmin' => 1,
            'password' => Hash::make('password'),
            'registered_at' => now(),
        ]);

        $pages = Page::factory()->count(10)->create();
        foreach($pages as $page) {
            $this->setRelatedForPages($page);
        }

        $page = Page::factory()->count(1)->create([
            'title' => 'Main Page',
            'description' => 'This is main page description.',
            'published' => 1
        ])->first();

        $this->setRelatedForPages($page);

        DB::table('twill_related')->insert([
            'position' => 1,
            'subject_type' => 'blocks',
            'subject_id' => $page->id,
            'related_id' => $page->id,
            'related_type' => 'page',
            'browser_name' => 'page',
        ]);

    }

    /**
     * @param \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection $page
     * @return void
     */
    public function setRelatedForPages(\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection $page): void
    {
        $id = $page->id;
        DB::table('page_translations')->where('page_id', $id)->update([
            'active' => 1
        ]);
        DB::table('menu_links')->insert([
            'published' => 1,
        ]);
        DB::table('menu_link_translations')->insert([
            'menu_link_id' => $id,
            'active' => 1,
            'locale' => 'en',
            'title' => Str::random(10),
            'description' => Str::random(300),
        ]);
        DB::table('twill_related')->insert([
            'position' => $id,
            'subject_id' => $id,
            'subject_type' => 'menu_link',
            'related_id' => $id,
            'related_type' => 'page',
            'browser_name' => 'page'
        ]);
        DB::table('page_slugs')->insert([
            'page_id' => $id,
            'slug' => $page->title,
            'locale' => 'en',
            'active' => 1,
        ]);
    }
}
