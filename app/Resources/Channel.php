<?php

namespace App\Resources;

use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class Channel
{
    public $name;
    public $web;
    public $language;
    public $description;
    public $image;
    public $category;
    public $asset;

    public function __construct($channel)
    {
        $this->name = $channel->title;
        $this->web = $channel->link;
        $this->language = $channel->language;
        $this->description = $channel->description;
        $this->asset = $channel->image;
        $this->category = $channel->category;
        $this->setImage();
    }

    private function setImage()
    {
        $image = '';

        if ($this->asset->url) {
            $urlRemote = strtok($this->asset->url, '?');
            $extension = pathinfo($urlRemote, PATHINFO_EXTENSION);
            $image = sprintf('/images/show/%s.%s', substr(Str::slug($this->name), 0, 30), $extension);
            if (!file_exists($image)) {
                try {
                    Image::make($urlRemote)->save(public_path($image));

                    /**
                     * Redimensionamos la imagen
                     */
                    $img = Image::make(public_path($image));
                    $img->resize(400, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                } catch (\Exception $e) {

                }
            }
        }

        return $image;
    }

    public function setCategory($category)
    {
        if ($category) {
            $this->category = $category->id;
        }
    }
}
