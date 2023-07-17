<?php

namespace App\Jobs;

use App\Models\Image;
use App\Services\StorageService;
use FFMpeg\FFMpeg;
use FFMpeg\Format\Video\X264;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MigrateThumbnail implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public Image $image;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Image $image) {
        $this->image = $image;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        $this->image->migrateThumbnail();
        $this->convertTypeToMp4();
    }

    private function convertTypeToMp4() {
        $extension = pathinfo($this->image->path)['extension'];
        if($extension !== 'mp4') {
            $ffmpeg = FFMpeg::create();
            $fileName = public_path(uuid_create() . '.mp4');
            $video = $ffmpeg->open(StorageService::url($this->image->path));
            $format = new X264();
            $format->setAudioCodec("libmp3lame");
            $video->save($format, $fileName);
            $path = StorageService::putFile('/images', $fileName);
            $this->image->path = $path;
            $this->image->save();
            unlink($fileName);
        }
    }
}
