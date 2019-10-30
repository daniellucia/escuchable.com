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
    public $thumbnail;
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
        $this->image = $this->setImage();
        $this->thumbnail = $this->setImage('/images/show/thumbnail', 32);
    }

    private function setImage($route = '/images/show', $width = 400)
    {
        $image = '';
        $route .= '/%s.%s';

        if ($this->asset->url) {
            $urlRemote = strtok($this->asset->url, '?');
            $extension = pathinfo($urlRemote, PATHINFO_EXTENSION);

            $image = sprintf($route, substr(Str::slug($this->name), 0, 30), $extension);
            if (!file_exists($image)) {
                try {
                    Image::make($urlRemote)->save(public_path($image));

                    /**
                     * Redimensionamos la imagen
                     */
                    dump(public_path($image));
                    $img = Image::make(public_path($image));
                    $img->resize(intval($width), intval($width), function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($image);

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
