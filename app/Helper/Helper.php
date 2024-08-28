<?php

function cart()
{
    return \Cart::session(auth()->user()->id)->getContent();
}

function clearCart()
{
    return \Cart::session(auth()->user()->id)->clear();
}

function convertToRupiah($jumlah)
{
    return 'Rp ' . number_format($jumlah, 0, '.', '.');
}

function subTotal()
{
    $user_id = auth()->user()->id;
    $cart = \Cart::session($user_id)->getContent();
    $subtotal = 0;
    foreach ($cart as $item) {
        $subtotal += $item->price * $item->quantity;
    }

    return convertToRupiah($subtotal);
}

function cartQuantity()
{
    $total = 0;
    foreach (cart() as $key => $value) {
        $total += $value->quantity;
    }

    return $total;
}

function month()
{
    $month = [
        1 => 'January',
        2 => 'February',
        3 => 'March',
        4 => 'April',
        5 => 'Mei',
        6 => 'June',
        7 => 'July',
        8 => 'August',
        9 => 'September',
        10 => 'October',
        11 => 'November',
        12 => 'December'
    ];

    return $month;
}
