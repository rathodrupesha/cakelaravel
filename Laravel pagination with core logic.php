 ?php 
/*Get redeem history*/
    public function getReedemHistoryBySelf(Request $request)
    {
        $requestData=$request->all();
        $null_obj = new stdClass();
        $validator = Validator::make($request->all(), [
          'size' => 'required|numeric',
          'page' => 'required|numeric',
          'seller_id'=>'required|numeric',
          'businessname'=>'required',
        ]);

        if ($validator->fails()) {
            $errorMessage = '';
            foreach ($validator->messages()->all() as $key => $value) {
                $errorMessage = $value;
            }
            return $this->_failresponse("0", '101', $errorMessage, $null_obj);
        }
        
        
        $resultsPerPage=!empty($request->input('size'))?$request->input('size'):10;
      
        $numberofResult=CouponQrcode::with(['coupon','user','branch','seller'])->where('seller_id',$requestData['seller_id'])->where('redeem', '1')->where('redeem_by','=','admin')->orderBy('created_at', 'desc');

        if(!empty($requestData['search'])){
           $numberofResult->whereHas('coupon', function($q) use($requestData){
                                  $q->where('couponname', 'LIKE','%'.$requestData['search'].'%');
                         })->orWhereHas('user', function($query) use ($requestData) {
                                   $query->where('username', 'LIKE','%'.$requestData['search'].'%');
                         })->orWhereHas('seller', function($query) use ($requestData) {
                                  $query->where('username', 'LIKE','%'.$requestData['search'].'%');
                         });
        }
       $numberofResult=$numberofResult->count();
      
        //determine the total number of pages available
        $numberOfPage =ceil($numberofResult / $resultsPerPage);

        if (!$request->has('page')) {
            $page = 1;
        } else {
            $page = intval($request->input('page'));
        }

        //determine the sql LIMIT starting number for the results on the displaying page
        $page_first_result = ($page - 1) * $resultsPerPage;

        $limit = $resultsPerPage;
        $offset =$page_first_result;
        //->whereHas('coupon', function($q) {$q->where('couponname', 'jjjkkkiii');})
    
        $redeemData=CouponQrcode::with(['coupon','user','branch','seller'])->where('seller_id',$requestData['seller_id'])->where('redeem', '1')->where('redeem_by','=','admin')->orderBy('created_at', 'desc');

        if(!empty($requestData['search'])){
           $redeemData->whereHas('coupon', function($q) use($requestData){
                                  $q->where('couponname', 'LIKE','%'.$requestData['search'].'%');
                         })->orWhereHas('user', function($query) use ($requestData) {
                                   $query->where('username', 'LIKE','%'.$requestData['search'].'%');
                         })->orWhereHas('seller', function($query) use ($requestData) {
                                  $query->where('username', 'LIKE','%'.$requestData['search'].'%');
                         });
        }

       $redeemData=$redeemData->offset($offset)->limit($limit)->get()->toArray();

       // echo "<pre>";print_r($redeemData);exit;

       $responseArry=[];

       foreach($redeemData as $key=>$value){
         $responseArry[$key]['qty']=$value['qty'];
         $responseArry[$key]['created_at']=$value['created_at'];
         $responseArry[$key]['couponname']=$value['coupon']['couponname'];
         $responseArry[$key]['coupontype']=$value['coupon']['coupontype'];
         $responseArry[$key]['buyer']=$value['user']['username'];
         $responseArry[$key]['branch_address']=isset($value['branch']['address'])?$value['branch']['address']:'';
         $responseArry[$key]['name']=!empty($request->input('businessname'))? $request->input('businessname'):''; 
         
       }

        $response=['data'=>$responseArry,
                   'recordsperpage'=>$limit,
                   'totalpage'=>$numberOfPage,
                   'totalrecord'=>$numberofResult
                   ];

        return $this->_successresponse("1", '200', 'success.', $response);

    }
