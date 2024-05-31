<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function CategoryPage(){
        //$category = Category::findOrFail($id);
        $allproducts = Product::latest()->get();
        return view('user.category', compact('allproducts'));
    }

    public function SingleProduct($id){
        $product = Product::findOrFail($id);
        $subcat_id = Product::where('id', $id)->value('product_subcategory_id');
        $related_products = Product::where('product_subcategory_id', $subcat_id)->latest()->get();
        return view('user.product', compact('product', 'related_products'));
    }

    public function AddToCart(){


        $userid = Auth::user()->id;
        $cart_total = 0;
        $cart_items = Cart::where('user_id', $userid)->get();
        //$cart_items = Cart::where('product_id')->get();
        foreach ($cart_items as $cart) {
            $cart_total+= $cart->price_total;
        }



        return view('user.addtocart', compact('cart_items','cart_total'));
    }

    public function AddProductToCart(Request $request){

        $product_price = $request->price;
        $quantity = $request->quantity;
        $price = $product_price * $quantity;
        Cart::insert([
            'product_id' => $request->product_id,
            'user_id' => Auth::user()->id,
            'quantity' => $request->quantity,
            'price_total' => $price
        ]);

        return redirect()->route('addtocart')->with('message', 'Your item added to cart successfully!');
    }

    public function Checkout(){
        return view('user.checkout');
    }

    public function UserProfile(){
        return view('user.userprofile');
    }

    public function PendingOrders(){
        return view('user.pendingorders');
    }

    public function History(){
        return view('user.history');
    }

    public function NewRelease(){
        return view('user.newrelease');
    }

    public function TodaysDeal(){
        return view('user.todaysdeal');
    }

    public function CustomerService(){
        return view('user.customerservice');
    }
}
