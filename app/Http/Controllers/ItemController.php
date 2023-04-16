<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use Illuminate\Support\Facades\Gate;

class ItemController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 商品一覧
     */
    public function index(Request $request)
    {
        // 商品一覧取得
        $items = Item
            ::where('items.status', 'active')
            ->select();

        // キーワード検索処理
        $keyword = $request->input('keyword');

        //$keywordが空ではない場合、検索処理を実行
        if (!empty($keyword)) {
            $items->where('name', 'LIKE', "%{$keyword}%")
                ->orWhere('id', 'LIKE', "%{$keyword}%")
                ->orWhere('type', 'LIKE', "%{$keyword}%")
                ->orWhere('detail', 'LIKE', "%{$keyword}%");
        }

        /* ページネーション */
        $items = $items->orderBy('id', 'desc')->paginate(20);
        //$items = $items->orderBy('id', 'desc')->get();
        return view('item.index', ['items' => $items]);
    }

    /**
     * 商品登録
     */
    public function add(Request $request)
    {
        // 管理者だけ商品登録ができる
        if (Gate::allows('admin')) {
            // POSTリクエストのとき
            if ($request->isMethod('post')) {
                // バリデーション
                $this->validate($request, [
                    'name' => 'required|max:100',
                ]);

                // 商品登録
                Item::create([
                    'user_id' => Auth::user()->id,
                    'name' => $request->name,
                    'type' => $request->type,
                    'detail' => $request->detail,
                ]);

                return redirect('/items');
            }
            return view('item.add');
        }
    }

    /**
     * 商品を編集
     */
    public function edit(Item $item)
    {
        if (Gate::allows('admin')) {
            return view('item.edit', compact('item'));
        }
    }

    /**
     * 商品を更新
     */

    public function update(Request $request, Item $item)
    {
        $request->validate([
            'name' => 'required|max:100',
            'type' => 'required|max:255',
            'detail' => 'nullable|max:500',
        ]);

        if (Gate::allows('admin')) {
            $item->update($request->all());
            return redirect()->route('item.index')->with('success', 'Item updated successfully.');
        }
    }

    /**
     * 商品を削除
     */
    public function destroy(Item $item)
    {
        if (Gate::allows('admin')) {
            $item->delete();
            return redirect()->route('item.index')->with('success', 'Item deleted successfully.');
        }
    }
}
