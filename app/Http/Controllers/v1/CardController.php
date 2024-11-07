<?php

namespace App\Http\Controllers\v1;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Category;
use App\Models\Journal;
use App\Models\Subcategory;

class CardController extends Controller
{
    public function index()
    {
        $total_categories = Category::count();
        $total_subcategories = Subcategory::count();
        $total_accounts = Account::count();
        $total_journals = Journal::count();

        return ResponseHelper::success([
            'total_categories' => $total_categories,
            'total_subcategories' => $total_subcategories,
            'total_accounts' => $total_accounts,
            'total_journals' => $total_journals,
        ]);
    }
}
