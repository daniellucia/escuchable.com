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
    public $categories_id;

    public function __construct($channel)
    {
        $this->name = strval($channel->title);
        $this->web = strval($channel->link);
        $this->language = substr(strval($channel->language), 0, 2);
        $this->description = strval($channel->description);
        $this->categories_id = strval($channel->category);

        $this->image = '/images/show/no-image.jpg';

        if (is_object($channel) && property_exists($channel, 'image')) {
            if (isset($channel->image->url)) {
                $this->image = $this->setImage(strval($channel->image->url));
                $this->thumbnail = $this->setImage(strval($channel->image->url), '/images/show/thumbnail', 40);
            }
        }

    }

    private function setImage($urlRemote, $route = '/images/show', $width = 400)
    {
        $image = '';
        $route .= '/%s.%s';

        if ($urlRemote != '') {
            $urlRemote = strtok($urlRemote, '?');
            $extension = pathinfo($urlRemote, PATHINFO_EXTENSION);

            $image = sprintf($route, substr(Str::slug($this->name), 0, 30), $extension);
            if (!file_exists($image)) {
                try {
                    Image::make($urlRemote)->save(public_path($image));

                    /**
                     * Redimensionamos la imagen
                     */
                    $img = Image::make(public_path($image));
                    $img->resize(intval($width), intval($width), function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    $img->save(public_path($image));

                } catch (\Exception $e) {

                }
            }

        }

        return $image;
    }

    public function setCategory($category, $default = 0)
    {
        $this->categories_id = $default;
        if (isset($category->id) && $default == 0) {
            $this->categories_id = $category->id;
        }
    }

    public function toArray()
    {
        return [
            'name' => $this->name,
            'web' => $this->web,
            'language' => $this->language,
            'description' => $this->description,
            'image' => $this->image,
            'thumbnail' => $this->thumbnail,
            'categories_id' => $this->categories_id == 0 ? 1 : $this->categories_id,
        ];
    }
}
