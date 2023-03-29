# -*- coding: utf-8 -*-
import unittest

from gilded_rose import Item, GildedRose


class GildedRoseTest(unittest.TestCase):
    def test_aged_brie(self):
        items = [Item("Aged Brie", 10, 20)]
        gilded_rose = GildedRose(items)
        gilded_rose.update_quality()
        self.assertEqual(items[0].name, "Aged Brie")
        self.assertEqual(items[0].sell_in, 9)
        self.assertEqual(items[0].quality, 21)

    def test_sulfuras(self):
        items = [Item("Sulfuras, Hand of Ragnaros", 10, 80)]
        gilded_rose = GildedRose(items)
        gilded_rose.update_quality()
        self.assertEqual(items[0].name, "Sulfuras, Hand of Ragnaros")
        self.assertEqual(items[0].sell_in, 10)
        self.assertEqual(items[0].quality, 80)

    def test_normal_item(self):
        items = [Item("Normal Item", 10, 20)]
        gilded_rose = GildedRose(items)
        gilded_rose.update_quality()
        self.assertEqual(items[0].name, "Normal Item")
        self.assertEqual(items[0].sell_in, 9)
        self.assertEqual(items[0].quality, 19)

    def test_backstage_passes(self):
        items = [Item("Backstage passes to a TAFKAL80ETC concert", 20, 20)]
        gilded_rose = GildedRose(items)
        gilded_rose.update_quality()
        self.assertEqual(items[0].name, "Backstage passes to a TAFKAL80ETC concert")
        self.assertEqual(items[0].sell_in, 19)
        self.assertEqual(items[0].quality, 21)

        items = [Item("Backstage passes to a TAFKAL80ETC concert", 10, 20)]
        gilded_rose = GildedRose(items)
        gilded_rose.update_quality()
        self.assertEqual(items[0].name, "Backstage passes to a TAFKAL80ETC concert")
        self.assertEqual(items[0].sell_in, 9)
        self.assertEqual(items[0].quality, 22)

        items = [Item("Backstage passes to a TAFKAL80ETC concert", 5, 20)]
        gilded_rose = GildedRose(items)
        gilded_rose.update_quality()
        self.assertEqual(items[0].name, "Backstage passes to a TAFKAL80ETC concert")
        self.assertEqual(items[0].sell_in, 4)
        self.assertEqual(items[0].quality, 23)

        items = [Item("Backstage passes to a TAFKAL80ETC concert", -1, 20)]
        gilded_rose = GildedRose(items)
        gilded_rose.update_quality()
        self.assertEqual(items[0].name, "Backstage passes to a TAFKAL80ETC concert")
        self.assertEqual(items[0].sell_in, -2)
        self.assertEqual(items[0].quality, 0)

if __name__ == '__main__':
    unittest.main()
