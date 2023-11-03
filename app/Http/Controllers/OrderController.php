<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Jobs\SendMailToAdmin;
use App\Model\CatProductModel;
use App\Model\ProductModel;
use App\Model\OrderModel;
use App\Model\ProvinceModel;
use App\Mail\MailOrder;
use App\Mail\MailToAdmin;
use App\Model\DistrictModel;
use App\Model\WardModel;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Mail;


class OrderController extends Controller
{
    function __construct()
    {
        
    }
    function viewSearchPhoneOrder(){
       return view('client.order.search_phone_order');
    }
    function searchPhoneOrder(Request $request){
        if ($request->method() == 'POST') {
            $params = $request->all();
            $phone = trim((string)$params['phone']);
            $listOrder=(new OrderModel)->searchPhone(['search'=>$phone],['task'=>'search-phone-order']);
            return(view('client.order.list_order',['listOrder'=>$listOrder,'phone'=>$phone]));
        }  
    }
    public function ajaxFliter(Request $request){
        $data = $request->all();
        $params['phone']=$request->phone;
        $params['status']=$request->status;
        $listOrder=(new OrderModel)->listItems($params, ['task' => 'list-order-flow-status']);
        return view("client.order.partial.product_order_frontend",compact('listOrder'));
    }
    public function detail(Request $request){
        $data = $request->all();
        $params['id']=intval($request->id);
        $order_detail=(new OrderModel)->getItem(['id'=>$params['id']], ['task' => 'get-item-frontend']);
        
        return view("client.order.child_list_order.detail_order",compact('order_detail'));
    }
    function buynow($id){
        
        $product1 = ProductModel::find($id);
        $qty_exist=0;
        foreach(Cart::content() as $row4){
                if((int)$id == (int)$row4->id){
                    $qty_exist = (int)$row4->qty;
                    $rowId_exist = $row4->rowId;
                    
                }
            }    
           if(isset($rowId_exist)){
            Cart::content()[$rowId_exist]->qty = $qty_exist;
           }
            else{
            Cart::add([
                'id' => (int)$product1->id,
                'name' => $product1->name,
                'qty' => 1,
                'price' => $product1->price,
                'options' => ['slug'=>$product1->slug,'thumbnail'=>$product1->thumbnail, 'unit' => $product1->unitProduct->name],
            ]);
        }
            return redirect('thanh-toan');
    }
    function checkout(){
       $order_id_last=OrderModel::latest('id')->first();
       $order_id= isset($order_id_last['id']) ? $order_id_last['id']+1 : 1;
       $itemsProvince= (new ProvinceModel)->listItems(null,['task'=>'admin-list-items-in-selectbox']);
       
        return view('client.cart.checkout',compact('itemsProvince','order_id'));
    }
    function OrderSuccess(Request $request){
        $params = $request->all();
       // $params['note']=$request->input('note');
        //$params['delivery_method']=$request->input('delivery_method');
        $params['total']=0;
        $params['total_product']=0;
        //$params['value_fee_ship']=(int)$request->input('value_fee_ship');
        foreach(Cart::content() as $itemCart){           
            $params['info_product'][$itemCart->id]['product_id']=$itemCart->id;
            $params['info_product'][$itemCart->id]['name']=$itemCart->name;
            $params['info_product'][$itemCart->id]['price']=$itemCart->price;
            $params['info_product'][$itemCart->id]['total_money']=(int)$itemCart->subtotal;
            $params['info_product'][$itemCart->id]['quantity']=$itemCart->qty;
            $params['info_product'][$itemCart->id]['image']=$itemCart->options->thumbnail;
            $params['info_product'][$itemCart->id]['unit']=$itemCart->options->unit;
            $params['total']+=$itemCart->subtotal;
            $params['total_product']+=$itemCart->qty;
        }
        $params['total']+=$params['value_fee_ship'];
        $province=(new ProvinceModel)->getItem(['id'=>$params['province_id']],['task'=>'get-item-full']);
        $district=(new DistrictModel)->getItem(['id'=>$params['district_id']],['task'=>'get-item-full']);
        $ward=(new WardModel)->getItem(['id'=>$params['ward_id']],['task'=>'get-item-full']);
        $params['buyer']['gender']=$params['gender'];
        $params['buyer']['fullname']=$params['fullname'];
        $params['buyer']['phone']=$params['phone'];
        $params['buyer']['email']=$params['email'];
        $params['buyer']['address']=$params['address'].', '.$ward['name'].', '.$district['name'].', '.$province['name'];
        (new OrderModel)->saveItem($params,['task'=>'frontend-save-item']);
        $OrderLast=OrderModel::latest('id')->first();
        (new OrderModel)->saveItem(['id' => $OrderLast->id],['task'=>'frontend-save-code-order']);
        $OrderLast=OrderModel::latest('id')->first();
        $data=[
            'code_order' => $OrderLast['code_order'],
            'fullname'=>$OrderLast['buyer']['fullname'],
            'email'=>$OrderLast['buyer']['email'],
            'address'=>$OrderLast['buyer']['address'],
            'phone'=>$OrderLast['buyer']['phone'],
            'note'=>$OrderLast['note'],
            'payments'=>$OrderLast['delivery_method'],
        ];
        if($request->input('email')){
            Mail::to($request->input('email'))->send(new MailOrder( $data));
        }  
        $data=[];
        $emailJob = new SendMailToAdmin();
        dispatch($emailJob);
        return response()->json([
            'status' => 'success',
            'redirect_url' => route('order.success', ['id' => $OrderLast['id']]),
        ],200);
    }
    function viewOrderSuccess($id){
        $order=(new OrderModel)->getItem(['id'=>$id],['task'=>'get-item-frontend']);
        Cart::destroy();
        $data='';
        return view('client.order.orderSuccess',compact('order'));
    }
        

}
