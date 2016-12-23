<html>
    <head>
        <title>Test Cash</title>
    </head>
    <body>
        
    

        <h1>智付寶 - 訂單測試</h1>
        <form name='Pay2go' method='post' action='{{ url('/cash/create') }}'>
            {!! csrf_field() !!}
            商店訂單編號：<input type="text" name="MerchantOrderNo" value="<?php echo "20160825" . random_int(1000,9999) ?>"/> <br/>
            訂單金額：<input type="text" name="Amt" value="<?php echo random_int(0,9999) ?>"> <br/>
            商品資訊：<input type="text" name="ItemDesc" value="Subscription to send right"> <br/>
            Email：<input type="text" name="Email" value="Maras0830@gmail.com"> <br/>

            <input type='submit' value='Submit'>
        </form>
            <pre>
            $pay2go_args_2 = array(
            "MerchantID" => $merchantid,
            "RespondType" => $respondtype,
            "CheckValue" => $CheckValue,
            "TimeStamp" => $timestamp,
            "Version" => $version,
            "MerchantOrderNo" => $order_id,
            "Amt" => $amt,
            "ItemDesc" => $itemdesc,
            "ExpireDate" => date('Ymd', time()+intval($this->ExpireDate)*24*60*60),
            "Email" => $order->billing_email,
            "LoginType" => $logintype,
            "NotifyURL" => $this->notify_url, //幕後
            "ReturnURL" => $this->get_return_url($order), //幕前(線上)
            "ClientBackURL" => $this->get_return_url($order), //取消交易
            "CustomerURL" => $this->get_return_url($order), //幕前(線下)
            "Receiver" => $buyer_name, //支付寶、財富通參數
            "Tel1" => $tel, //支付寶、財富通參數
            "Tel2" => $tel, //支付寶、財富通參數
            "LangType" => $this->LangType
            </pre>
    </body>
</html>