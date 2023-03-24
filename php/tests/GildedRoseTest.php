<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\GildedRose;
use GildedRose\Item;
use PHPUnit\Framework\TestCase;

class GildedRoseTest extends TestCase
{
    public function testNormalItemsQualityDegrades(): void
    {
        $item = new Item('foo', 10, 10);
        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();
        $this->assertEquals(9, $item->quality);
        $gildedRose->updateQuality();
        $this->assertEquals(8, $item->quality);
    }

    public function testNormalItemsQualityDegradesAfterSellInLimit(): void
    {
        $item = new Item('foo', 0, 10);
        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();
        $this->assertEquals(9, $item->quality);
        $gildedRose->updateQuality();
        $this->assertEquals(7, $item->quality);
    }

    public function testQualityCannotBeNegative(): void
    {
        $item = new Item('foo', 0, 0);
        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();
        $this->assertEquals(0, $item->quality);
    }

    public function testAgedBrieIncreasesInQuality(): void
    {
        $item = new Item('Aged Brie', 10, 10);
        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();
        $this->assertEquals(11, $item->quality);
    }

    public function testAgedBrieIncreasesInQualityTwiceAsFast(): void
    {
        $item = new Item('Aged Brie', -1, 10);
        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();
        $this->assertEquals(12, $item->quality);
    }

    public function testQualityCannotBeGreaterThanFifty(): void
    {
        $item = new Item('Aged Brie', 10, 50);
        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();
        $this->assertEquals(50, $item->quality);
    }

    public function testSulfurasNeverDecreasesInQuality(): void
    {
        $item = new Item('Sulfuras, Hand of Ragnaros', 10, 80);
        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();
        $this->assertEquals(80, $item->quality);
        $this->assertEquals(10, $item->sellIn);
    }

    public function testBackstagePassesIncreaseInQuality(): void
    {
        $item = new Item('Backstage passes to a TAFKAL80ETC concert', 20, 10);
        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();
        $this->assertEquals(11, $item->quality);
        $gildedRose->updateQuality();
        $this->assertEquals(12, $item->quality);
        $gildedRose->updateQuality();
        $this->assertEquals(13, $item->quality);
        $gildedRose->updateQuality();
        $this->assertEquals(14, $item->quality);
    }

    public function testBackstagePassesIncreaseInQualityWhenSellingIsLowerThanEleven(): void
    {
        $item = new Item('Backstage passes to a TAFKAL80ETC concert', 12, 10);
        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();
        $this->assertEquals(11, $item->quality);
        $gildedRose->updateQuality();
        $this->assertEquals(12, $item->quality);
        $gildedRose->updateQuality();
        $this->assertEquals(14, $item->quality);
        $gildedRose->updateQuality();
        $this->assertEquals(16, $item->quality);
    }

    public function testBackstagePassesIncreaseInQualityWhenSellingIsLowerThanSix(): void
    {
        $item = new Item('Backstage passes to a TAFKAL80ETC concert', 8, 10);
        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();
        $this->assertEquals(12, $item->quality);
        $gildedRose->updateQuality();
        $this->assertEquals(14, $item->quality);
        $gildedRose->updateQuality();
        $this->assertEquals(16, $item->quality);
        $gildedRose->updateQuality();
        $this->assertEquals(19, $item->quality);
    }

    public function testQualityDropsToZeroAfterConcert(): void
    {
        $item = new Item('Backstage passes to a TAFKAL80ETC concert', -1, 10);
        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();
        $this->assertEquals(0, $item->quality);
    }

    public function testConjuredItemsDegradeInQualityTwiceAsFast(): void
    {
        $item = new Item('Conjured Mana Cake', 10, 10);
        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();
        $this->assertEquals(8, $item->quality);
        $gildedRose->updateQuality();
        $this->assertEquals(6, $item->quality);
    }

    public function testConjuredItemsDegradeInQualityAfterSellInLimit(): void
    {
        $item = new Item('Conjured Mana Cake', 0, 10);
        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();
        $this->assertEquals(8, $item->quality);
        $gildedRose->updateQuality();
        $this->assertEquals(4, $item->quality);
    }
}
