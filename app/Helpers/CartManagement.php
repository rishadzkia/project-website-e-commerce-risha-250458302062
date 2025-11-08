<?php

namespace App\Helpers;

use App\Models\Product;
use Illuminate\Support\Facades\Cookie;

class CartManagement
{
    /**
     * Ambil semua item dari cookie cart.
     */
    public static function getCartItemsFromCookie()
    {
        $cart_items = json_decode(Cookie::get('cart_items'), true);
        return is_array($cart_items) ? array_values($cart_items) : [];
    }

    /**
     * Simpan data cart ke cookie (berlaku 30 hari).
     */
    public static function addCartItemsToCookies($cart_items)
    {
        Cookie::queue('cart_items', json_encode(array_values($cart_items)), 60 * 24 * 30);
    }

    /**
     * Tambah produk ke cart (1 item).
     */
    public static function addItemToCart($product_id)
    {
        $cart_items = self::getCartItemsFromCookie();
        $index = self::findItemIndex($cart_items, $product_id);

        if ($index !== null) {
            $cart_items[$index]['quantity']++;
        } else {
            $product = Product::select('id', 'name', 'price', 'images')->find($product_id);
            if (!$product) return count($cart_items);

            $image = is_array($product->images) ? $product->images[0] : $product->images;

            $cart_items[] = [
                'product_id'   => $product->id,
                'name'         => $product->name,
                'image'        => $image,
                'quantity'     => 1,
                'unit_amount'  => $product->price,
                'total_amount' => $product->price,
            ];
        }

        $cart_items = self::updateTotals($cart_items);
        self::addCartItemsToCookies($cart_items);

        return count($cart_items);
    }

    /**
     * Tambah produk dengan jumlah tertentu.
     */
    public static function addItemToCartWithQty($product_id, $qty = 1)
    {
        $cart_items = self::getCartItemsFromCookie();
        $index = self::findItemIndex($cart_items, $product_id);

        if ($index !== null) {
            $cart_items[$index]['quantity'] = max(1, (int) $qty);
        } else {
            $product = Product::select('id', 'name', 'price', 'images')->find($product_id);
            if (!$product) return count($cart_items);

            $image = is_array($product->images) ? $product->images[0] : $product->images;

            $cart_items[] = [
                'product_id'   => $product->id,
                'name'         => $product->name,
                'image'        => $image,
                'quantity'     => max(1, (int) $qty),
                'unit_amount'  => $product->price,
                'total_amount' => $product->price * $qty,
            ];
        }

        $cart_items = self::updateTotals($cart_items);
        self::addCartItemsToCookies($cart_items);

        return count($cart_items);
    }

    /**
     * Hapus item dari cart.
     */
    public static function removeCartItem($product_id)
    {
        $cart_items = array_filter(self::getCartItemsFromCookie(), function ($item) use ($product_id) {
            return $item['product_id'] != $product_id;
        });

        self::addCartItemsToCookies($cart_items);
        return array_values($cart_items);
    }

    /**
     * Tambah quantity.
     */
    public static function incrementQuantityToCartItem($product_id)
    {
        $cart_items = self::getCartItemsFromCookie();
        $index = self::findItemIndex($cart_items, $product_id);

        if ($index !== null) {
            $cart_items[$index]['quantity']++;
        }

        $cart_items = self::updateTotals($cart_items);
        self::addCartItemsToCookies($cart_items);
        return $cart_items;
    }

    /**
     * Kurangi quantity (tidak bisa kurang dari 1).
     */
    public static function decrementQuantityToCartItem($product_id)
    {
        $cart_items = self::getCartItemsFromCookie();
        $index = self::findItemIndex($cart_items, $product_id);

        if ($index !== null && $cart_items[$index]['quantity'] > 1) {
            $cart_items[$index]['quantity']--;
        }

        $cart_items = self::updateTotals($cart_items);
        self::addCartItemsToCookies($cart_items);
        return $cart_items;
    }

    /**
     * Hapus seluruh item di cart.
     */
    public static function clearCartItems()
    {
        Cookie::queue(Cookie::forget('cart_items'));
    }

    /**
     * Hitung total harga semua item.
     */
    public static function calculateGrandTotal($items)
    {
        return array_sum(array_column($items, 'total_amount'));
    }

    /**
     * Cari index produk dalam array cart.
     */
    private static function findItemIndex($cart_items, $product_id)
    {
        foreach ($cart_items as $key => $item) {
            if ($item['product_id'] == $product_id) {
                return $key;
            }
        }
        return null;
    }

    /**
     * Update total_amount setiap item.
     */
    private static function updateTotals($cart_items)
    {
        foreach ($cart_items as &$item) {
            $item['total_amount'] = $item['quantity'] * $item['unit_amount'];
        }
        return $cart_items;
    }
}
