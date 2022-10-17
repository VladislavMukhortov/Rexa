<?php

namespace App\Services;

use Intervention\Image\Facades\Image;
use Vinkla\Hashids\Facades\Hashids;

class Captcha
{
    public mixed $minAmount = 1000;
    public mixed $maxAmount = 9999;

    public function __construct($minAmount = 1000, $maxAmount = 9000)
    {
        $this->minAmount = $minAmount;
        $this->maxAmount = $maxAmount;

        if ($this->maxAmount <= $this->minAmount) {
            $this->maxAmount = $this->minAmount + 1000;
        }

    }

    public function image(): array
    {
        $randomnr = rand($this->minAmount, $this->maxAmount);
        $textArray = str_split($randomnr);
        $image = Image::canvas(140, 60, '#C4FFC7')
            ->line(
                rand(0, 140) + rand(0, 60),
                rand(0, 60),
                rand(0, 140),
                rand(0, 60),
                function ($draw) {
                    $draw->color('#FEE600');
                }
            )
            ->line(
                rand(0, 140) + rand(0, 60),
                rand(0, 60),
                rand(0, 140),
                rand(0, 60),
                function ($draw) {
                    $draw->color('#7e7e7e');
                }
            )
            ->line(
                rand(0, 140) + rand(0, 60),
                rand(0, 60),
                rand(0, 140),
                rand(0, 60),
                function ($draw) {
                    $draw->color('#7e7e7e');
                }
            )
            ->line(
                rand(0, 140) + rand(0, 60),
                rand(0, 60),
                rand(0, 140),
                rand(0, 60),
                function ($draw) {
                    $draw->color('#07a33c');
                }
            )
            ->line(
                rand(0, 140) + rand(0, 60),
                rand(0, 60),
                rand(0, 140),
                rand(0, 60),
                function ($draw) {
                    $draw->color('#FEE600');
                }
            )
            ->line(
                rand(0, 140) + rand(0, 60),
                rand(0, 60),
                rand(0, 140),
                rand(0, 60),
                function ($draw) {
                    $draw->color('#DA3333');
                }
            )
            ->line(
                rand(0, 140) + rand(0, 60),
                rand(0, 60),
                rand(0, 140),
                rand(0, 60),
                function ($draw) {
                    $draw->color('#7e7e7e');
                }
            )
            ->line(
                rand(0, 140) + rand(0, 60),
                rand(0, 60),
                rand(0, 140),
                rand(0, 60),
                function ($draw) {
                    $draw->color('#DA3333');
                }
            )
            ->line(
                rand(0, 140) + rand(0, 60),
                rand(0, 60),
                rand(0, 140),
                rand(0, 60),
                function ($draw) {
                    $draw->color('#FEE600');
                }
            )
            ->line(
                rand(0, 140) + rand(0, 60),
                rand(0, 60),
                rand(0, 140),
                rand(0, 60),
                function ($draw) {
                    $draw->color('#7e7e7e');
                }
            )
            ->line(
                rand(0, 140) + rand(0, 60),
                rand(0, 60),
                rand(0, 140),
                rand(0, 60),
                function ($draw) {
                    $draw->color('#7e7e7e');
                }
            )
            ->line(
                rand(0, 140) + rand(0, 60),
                rand(0, 60),
                rand(0, 140),
                rand(0, 60),
                function ($draw) {
                    $draw->color('#07a33c');
                }
            )
            ->blur(1)
            ->line(
                rand(0, 140) + rand(0, 60),
                rand(0, 60),
                rand(0, 140),
                rand(0, 60),
                function ($draw) {
                    $draw->color('#FEE600');
                }
            )
            ->line(
                rand(0, 140) + rand(0, 60),
                rand(0, 60),
                rand(0, 140),
                rand(0, 60),
                function ($draw) {
                    $draw->color('#7e7e7e');
                }
            )
            ->line(
                rand(0, 140) + rand(0, 60),
                rand(0, 60),
                rand(0, 140),
                rand(0, 60),
                function ($draw) {
                    $draw->color('#DA3333');
                }
            )
            ->line(
                rand(0, 140) + rand(0, 60),
                rand(0, 60),
                rand(0, 140),
                rand(0, 60),
                function ($draw) {
                    $draw->color('#07a33c');
                }
            )
            ->text($textArray[0], rand(30, 33), 40, function ($font) {
                $font->file(public_path() . '/fonts/HelveticaNeueCyr-Black.woff');
                $font->size(30);
                $font->angle(rand(1, 10));
                $font->color('#C60000');
            })
            ->text($textArray[1], 55, 40, function ($font) {
                $font->file(public_path() . '/fonts/HelveticaNeueCyr-Black.woff');
                $font->size(30);
                $font->angle(rand(-10, -1));
                $font->color('#EE6F34');
            })
            ->text($textArray[2], 75, 40, function ($font) {
                $font->file(public_path() . '/fonts/HelveticaNeueCyr-Black.woff');
                $font->size(30);
                $font->angle(rand(1, 3));
                $font->color('#BF88DB');
            })
            ->text($textArray[3], 95, 40, function ($font) {
                $font->file(public_path() . '/fonts/HelveticaNeueCyr-Black.woff');
                $font->size(30);
                $font->angle(-50);
                $font->color('#00203F');
            })
            ->text($textArray[0], rand(30, 33), 42, function ($font) {
                $font->file(public_path() . '/fonts/HelveticaNeueCyr-Light.woff');
                $font->size(30);
                $font->angle(rand(1, 10));
                $font->color('#135A1F');
            })
            ->text($textArray[1], 55, 42, function ($font) {
                $font->file(public_path() . '/fonts/HelveticaNeueCyr-Light.woff');
                $font->size(30);
                $font->angle(-5);
                $font->color('#EE6F34');
            })
            ->text($textArray[2], 75, 42, function ($font) {
                $font->file(public_path() . '/fonts/HelveticaNeueCyr-Light.woff');
                $font->size(30);
                $font->angle(3);
                $font->color('#377754');
            })
            ->text($textArray[3], 95, 42, function ($font) {
                $font->file(public_path() . '/fonts/HelveticaNeueCyr-Light.woff');
                $font->size(30);
                $font->angle(-50);
                $font->color('#00204F');
            });


        $image = $image->encode('data-url');
        return [
            'image' => $image->encoded,
            'secret' => Hashids::encode($randomnr, now()->timestamp)
        ];
    }
}
