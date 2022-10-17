<?php

namespace Database\Seeders;

use App\Models\DefaultAvatars;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Symfony\Component\Console\Input\Input;

class DefaultAvatarsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $directory = public_path("img/default_avatars");
        $avatars = File::files($directory);
        foreach ($avatars as $avatar) {
            DefaultAvatars::query()->updateOrCreate([
                'path' => '/img/default_avatars/'.$avatar->getFilename()
            ]);
        }
        foreach (DefaultAvatars::query()->get() as $item) {
            dump(secure_url($item->path));
        }
    }
}
