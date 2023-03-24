<?php

declare(strict_types=1);

namespace GildedRose;

final class GildedRose
{
    private const MIN_QUALITY = 0;

    private const MAX_QUALITY = 50;

    private const AGED_BRIE = 'Aged Brie';

    private const BACKSTAGE_PASSES = 'Backstage passes to a TAFKAL80ETC concert';

    private const SULFURAS = 'Sulfuras, Hand of Ragnaros';

    private const CONJURED_MANA_CAKE = 'Conjured Mana Cake';

    /**
     * @var Item[]
     */
    private array $items;

    /**
     * @param Item[] $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function updateQuality(): void
    {
        foreach ($this->items as $item) {
            switch ($item->name) {
                case self::AGED_BRIE:
                    $this->updateAgedBrie($item);
                    break;
                case self::SULFURAS:
                    // Sulfuras does not need to be updated.
                    break;
                case self::BACKSTAGE_PASSES:
                    $this->updateBackstagePasses($item);
                    break;
                case self::CONJURED_MANA_CAKE:
                    $this->updateConjuredManaCake($item);
                    break;
                default:
                    $this->updateNormalItem($item);
            }

            $this->decreaseSellIn($item);
        }
    }

    private function decreaseSellIn(Item $item): void
    {
        if ($item->name !== self::SULFURAS) {
            $item->sellIn--;
        }
    }

    private function increaseQuality(Item $item): void
    {
        if ($item->quality < self::MAX_QUALITY) {
            $item->quality++;
        }
    }

    private function decreaseQuality(Item $item, int $amount = 1): void
    {
        $item->quality = max($item->quality - $amount, self::MIN_QUALITY);
    }

    private function updateAgedBrie(Item $item): void
    {
        $this->increaseQuality($item);

        if ($item->sellIn <= 0) {
            $this->increaseQuality($item);
        }
    }

    private function updateBackstagePasses(Item $item): void
    {
        $this->increaseQuality($item);

        if ($item->sellIn < 11) {
            $this->increaseQuality($item);
        }

        if ($item->sellIn < 6) {
            $this->increaseQuality($item);
        }

        if ($item->sellIn < 0) {
            $item->quality = self::MIN_QUALITY;
        }
    }

    private function updateConjuredManaCake(Item $item): void
    {
        $this->decreaseQuality($item);
        $this->decreaseQuality($item);

        if ($item->sellIn < 0) {
            $this->decreaseQuality($item);
            $this->decreaseQuality($item);
        }
    }

    private function updateNormalItem(Item $item): void
    {
        $this->decreaseQuality($item);

        if ($item->sellIn < 0) {
            $this->decreaseQuality($item);
        }
    }
}
