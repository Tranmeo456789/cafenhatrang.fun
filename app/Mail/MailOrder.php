<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Model\OrderModel;
class MailOrder extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public  $data;
    public function __construct( $data)
    {
        $this->data =  $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $order_id_last=OrderModel::latest('id')->first();
        $order=OrderModel::where('id',$order_id_last['id']+1)->get();
        return $this->view('mail.OrderComfirm')
        ->from('dungdeguimail89@gmail.com','STORE THUC')
        ->subject('[STORE THUC] Thông tin đơn hàng')->with($this->data);
        
    }
}
