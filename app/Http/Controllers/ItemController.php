<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function searchByDescription($query = '') {
        if ($query != '') {
            $items = Item::select("description", "code")
                ->where('description', 'LIKE', '%' . $query . '%')
                ->limit(7)
                ->get();
            $items_list = '<ul>';
            if (count($items) > 0) {
                foreach ($items as $item) {
                    $items_list .= '<li class="items-list-item" value="'.$item->code.'">' . $item->description . '</li>';
                }
                $message = 'not empty';
            }else{
                $message = 'empty';
            }
            $items_list .= '</ul>';
        }
        return response()->json([
            'items_list' => $items_list,
            'message' => $message,
        ]);
    }
}
