<?php

namespace App\Http\Controllers;

use Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use Illuminate\Support\Carbon;

use PDF;

use App\user;

use App\usse;
use App\shop;
use App\shopkeeper;
use App\bought;
use App\sale;
use App\ammountadded;
use App\transaction;
use App\voucher;
use App\summary;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;


class AssetsController extends Controller
{
    
    //
         public function addnewissue(Request $request ,$id)
    {

         $ids = Crypt::decrypt($id);

            $issues = $request['issue'];
            $prices = $request['price'];
            $keepers = $request['keeper'];
           
            foreach($issues as $a => $b){
  
        $us = new usse();
        $us->issue = $issues[$a];
        $us->price = $prices[$a];
        $us->date = $request['date'];
        $us->keeper = $keepers[$a];
        $us->shop_id = $ids;
        $us->month = date('F Y', strtotime($us->date));
        $us->updated = auth()->user()->id;
        $us->save(); 

            }

        $checkempty = summary::where('month', date('F Y', strtotime($us->date)))->where('shop_id',$ids)->first(); 
        if (empty($checkempty)) {
        $month = new summary();
        $month->month = date('F Y', strtotime($us->date));
        $month->shop_id = $ids;
        $month->save();
       }


            return redirect()->back()->with(['message' => 'New used issue updated']);

       }



         public function postshopkeepers(Request $request ,$id)
    {
         

         $ids = Crypt::decrypt($id);

            $name = $request['name'];
            $prices = $request['price'];
           
            foreach($name as $a => $b){

       $checkemptyname = user::where('name', $name[$a])->first();

       if (empty($checkemptyname)) {
  
        $user = new user();
        $user->name = $name[$a];
        $user->price = $prices[$a];
        $user->shop_id = $ids;
        $user->type = 'shopkeeper';
        $user->password =  Hash::make('12345678');
        $user->save(); 

            }
         else {

        return redirect()->back()->withErrors(['message' => 'Name already taken']);
       } 
     }

            return redirect()->back()->with(['message' => 'New shopkeeper updated']);

       }


         public function addnewbought(Request $request ,$id)
    {

       $ids = Crypt::decrypt($id);
            $issues = $request['issue'];
            $prices = $request['price'];
           
            foreach($issues as $a => $b){
  
        $bt = new bought();
        $bt->issue = $issues[$a];
        $bt->price = $prices[$a];
        $bt->date = $request['date'];
        $bt->shop_id = $ids;
        $bt->month = date('F Y', strtotime($bt->date));
        $bt->updated = auth()->user()->id;
        $bt->save();   }

          $checkempty = summary::where('month', date('F Y', strtotime($bt->date)))->where('shop_id',$ids)->first(); 
        if (empty($checkempty)) {
        $month = new summary();
        $month->month = date('F Y', strtotime($bt->date));
         $month->shop_id = $ids;
        $month->save();
       }

            return redirect()->back()->with(['message' => 'New bought issue updated']);

      
       }


       
         public function updatemyamount(Request $request ,$id )
    {

    $ids = Crypt::decrypt($id);
           
            $prices = $request['price'];
           
            foreach($prices as $a => $b){
  
        $amm = new transaction();
       
        $amm->price = $prices[$a];
        $amm->date = $request['date'];
        $amm->shop_id = $ids;
        $amm->month = date('F Y', strtotime($amm->date));
        $amm->updated = auth()->user()->id;
        $amm->save();   }

          $checkempty = summary::where('month', date('F Y', strtotime($amm->date)))->where('shop_id',$ids)->first(); 
        if (empty($checkempty)) {
        $month = new summary();
        $month->month = date('F Y', strtotime($amm->date));
         $month->shop_id = $ids;
        $month->save();
       }

            return redirect()->back()->with(['message' => 'New transaction updated']);

      
       }

                public function updatevoucherass(Request $request , $id )
    {
          $ids = Crypt::decrypt($id);   
            $prices = $request['price'];
            $valuess = $request['value'];
           
            foreach($prices as $a => $b){
  
        $vc = new voucher();
       
        $vc->price = $prices[$a];
        $vc->value = $valuess[$a];
        $vc->date = $request['date'];
        $vc->shop_id = $ids;
        $vc->month = date('F Y', strtotime($vc->date));
        $vc->updated = auth()->user()->id;
        $vc->save();   }

          $checkempty = summary::where('month', date('F Y', strtotime($vc->date)))->where('shop_id',$ids)->first(); 
        if (empty($checkempty)) {
        $month = new summary();
        $month->month = date('F Y', strtotime($vc->date));
         $month->shop_id = $ids;
        $month->save();
       }

            return redirect()->back()->with(['message' => 'New Voucher updated']);

      
       }


       


         public function addnewsale(Request $request ,$id )
    {

          $ids = Crypt::decrypt($id);
           
            $prices = $request['price'];
           
            foreach($prices as $a => $b){
  
        $sl = new sale();
        $sl->price = $prices[$a];
        $sl->date = $request['date'];
        $sl->shop_id = $ids;
        $sl->month = date('F Y', strtotime($sl->date));
        $sl->updated = auth()->user()->id;
        $sl->save();   }

          $checkempty = summary::where('month', date('F Y', strtotime($sl->date)))->where('shop_id',$ids)->first(); 
        if (empty($checkempty)) {
        $month = new summary();
        $month->month = date('F Y', strtotime($sl->date));
         $month->shop_id = $ids;
        $month->save();
       }

            return redirect()->back()->with(['message' => 'New sale updated']);
       }



         public function addnewamount(Request $request ,$id )
    {

            $ids = Crypt::decrypt($id);
            $prices = $request['price'];
           
            foreach($prices as $a => $b){
  
        $am = new ammountadded();
        $am->price = $prices[$a];
        $am->date = $request['date'];
        $am->shop_id = $ids;
        $am->month = date('F Y', strtotime($am->date));
        $am->updated = auth()->user()->id;
        $am->save();   }

          $checkempty = summary::where('month', date('F Y', strtotime($am->date)))->where('shop_id',$ids)->first(); 
        if (empty($checkempty)) {
        $month = new summary();
        $month->month = date('F Y', strtotime($am->date));
         $month->shop_id = $ids;
        $month->save();
       }

            return redirect()->back()->with(['message' => 'New Ammount Updated']);

      
       }


         public function dashboard(){
      

         return view('dashboard');

         }

       public function allissueslistgroup($id){
        $ids = Crypt::decrypt($id);
 
        $usse = usse::select(DB::raw('month,sum(price) as price'))
                     ->where('shop_id',$ids)
                     ->groupBy('month')
                     ->get();           

         return view('myshopuseslistgroup', [

             'usses' => $usse, 
             'idz'=>$ids,

          ]);

         }


      public function allissueslist($id ,$date){
         $ids = Crypt::decrypt($id);
 
         return view('useslist', [
             'usses' => usse::where('shop_id',$ids)->where('month',$date)->get(), 
             'idz'=>$ids,
              'shopkeeper' => user::where('shop_id',$ids)->get(),  

          ]);

         }
   


      public function shopkeepers($id){
         $ids = Crypt::decrypt($id);
 
         return view('shopkeepers', [

             'shopkeeper' => user::where('shop_id',$ids)->where('status',1)->get(), 
             'idz'=>$ids,

          ]);

         }


        public function shops($id){
          $ids = Crypt::decrypt($id);
          $shops = shop::where('id',$ids)->first();

          $usses = usse::select(DB::raw('keeper ,sum(price) as price'))
                     ->groupBy('keeper')
                     ->where('shop_id',$ids)
                     ->get(); 
          $sales = sale::where('shop_id', $ids)->get();   
          $bought = bought::where('shop_id', $ids)->get();   
          $used = usse::where('shop_id', $ids)->get(); 
          $voucher = voucher::where('shop_id', $ids)->get(); 
          $transaction = transaction::where('shop_id', $ids)->get(); 
          $ammountadded = ammountadded::where('shop_id', $ids)->get();             


         return view('shops', [ 
            'shops' => $shops,   
            'usses' => $usses,
             'added' => $ammountadded,
             'transaction' => $transaction,
             'voucher' => $voucher,
             'sales' => $sales,
             'used' => $used,
             'bought' => $bought
         ]);

         }


            public function shopsadmin(){
            $shops = shop::where('user_id', auth()->user()->id)->get();
         return view('shopsadmin', ['shops' => $shops,]);

         }



      public function newshopadd(){
         return view('addshop');

         }


        public function postnewshop(Request $request ,$id)
    {
        $ids = Crypt::decrypt($id);
        $names = $request['name'];
           
            foreach($names as $a => $b){
  
        $sp = new shop();
        $sp->name = $names[$a];
        $sp->user_id = $ids;
        $sp->save();   }

            return redirect()->back()->with(['message' => 'New Shop Updated']);

      
       }


         public function biughtissueslistgroup($id){
         $ids = Crypt::decrypt($id);
        $bought = bought::select(DB::raw('month,sum(price) as price'))
                     ->where('shop_id',$ids)
                     ->groupBy('month')
                     ->get(); 

        $ids = Crypt::decrypt($id);
         return view('myshopboughtissuegroup', [
             'bought' => $bought,
             'idz'=>$ids,
          ]);

         }

             public function biughtissueslist($id , $date){
       
          $ids = Crypt::decrypt($id);
         return view('boughtissue', [
             'bought' => bought::where('shop_id',$ids)->where('month',$date)->get(),
             'idz'=>$ids,
          ]);

         }

 
            public function alltransactions($id , $date){
       
                 $ids = Crypt::decrypt($id);
         return view('transactions', [
            

             'transaction' => transaction::where('shop_id',$ids)->where('month',$date)->get(), 
             'idz'=>$ids,

          ]);

         }
           


            public function alltransactionsgroup($id){
       
                 $ids = Crypt::decrypt($id);

                  $transaction = transaction::select(DB::raw('month,sum(price) as price'))
                     ->where('shop_id',$ids)
                     ->groupBy('month')
                     ->get(); 

          return view('myshoptransactionsgroup', [
             'transaction' => $transaction, 
             'idz'=>$ids,

          ]);

         }


                public function vouchers($id ,$date){
            $ids = Crypt::decrypt($id);

         return view('voucher', [
        
             'voucher' => voucher::where('shop_id',$ids)->where('month',$date)->get(),
               'idz'=>$ids,

          ]);

         }


                public function vouchersgroup($id){
            $ids = Crypt::decrypt($id);
            $voucher = voucher::select(DB::raw('month,sum(price) as price,sum(value) as value'))
                     ->where('shop_id',$ids)
                     ->groupBy('month')
                     ->get(); 
         return view('myshopvouchergroup', [
        
             'voucher' => $voucher,
               'idz'=>$ids,

          ]);

         }


        public function salesissueslistgroup($id){
         $ids = Crypt::decrypt($id);
         $sales = sale::select(DB::raw('month,sum(price) as price'))
                     ->where('shop_id',$ids)
                     ->groupBy('month')
                     ->get(); 
         return view('myshopsalesissuegroup', [
           
             'sales' => $sales,
              'idz'=>$ids,
          ]);

         }
     


        public function salesissueslist($id , $date){
         $ids = Crypt::decrypt($id);
         return view('salesissue', [
           
             'sales' => sale::where('shop_id',$ids)->where('month',$date)->get(),
              'idz'=>$ids,
          ]);

         }



          
           public function ammountadded($id , $date){
         $ids = Crypt::decrypt($id);
         return view('amountadded', [
          
             'ammounts' => ammountadded::where('shop_id',$ids)->where('month',$date)->get(),
              'idz' => $ids,

          ]);

         }


           public function ammountaddedgroup($id){
         $ids = Crypt::decrypt($id);
         $ammount = ammountadded::select(DB::raw('month,sum(price) as price'))
                     ->where('shop_id',$ids)
                     ->groupBy('month')
                     ->get(); 

         return view('myshopamountaddedgroup', [
          
             'ammounts' => $ammount,
              'idz' => $ids,

          ]);

         }
         

    
            public function dairlyissueadd($id){
             $ids = Crypt::decrypt($id);
         return view('myshopdairyissue', [
          'idz' => $ids,
          'shopkeeper' => user::where('shop_id',$ids)->get(),  
          ]);

         }

               public function addshopkeepers($id){
             $ids = Crypt::decrypt($id);
         return view('addshopkeepers', [
          'idz' => $ids,
             
          ]);

         }



            public function boughts($id){
               $ids = Crypt::decrypt($id);
         return view('myshopaddboughtissues', [
            'idz' => $ids,
          ]);

         }

           public function updatetransaction($id){
      
                $ids = Crypt::decrypt($id);
         return view('myshopupdatetransaction', [
           
           'idz' => $ids,
          ]);

         }

             public function updatevoucher($id){
             $ids = Crypt::decrypt($id);
         return view('myshopupdatevoucheradd', [
           
         'idz' => $ids,
          ]);

         }


         

         



            public function newsaleadd($id){
          $ids = Crypt::decrypt($id);

         return view('myshopaddsales', [   'idz' => $ids,
           
          ]);

         }

           public function newamount($id){
        $ids = Crypt::decrypt($id);
         return view('myshopamountadd', [   'idz' => $ids,
           
          ]);

         }


       public function summarygroup($id){
       
          $ids = Crypt::decrypt($id);
          $summary = summary::select(DB::raw('month'))
                     ->groupBy('month')
                     ->where('shop_id',$ids)
                     ->get(); 

         return view('summarygroup', [
            
             'summary' => $summary,
             'idz' => $ids,
          ]);

         }
        

        public function summary($id, $date){
          
          $ids = Crypt::decrypt($id);
          $usses = usse::select(DB::raw('keeper ,sum(price) as price'))
                     ->groupBy('keeper')
                     ->where('shop_id',$ids)
                     ->where('month', $date)
                     ->get(); 
          $sales = sale::where('month', $date)->where('shop_id', $ids)->get();   
          $bought = bought::where('month', $date)->where('shop_id', $ids)->get();   
          $used = usse::where('month', $date)->where('shop_id', $ids)->get(); 
          $voucher = voucher::where('month', $date)->where('shop_id', $ids)->get(); 
          $transaction = transaction::where('month', $date)->where('shop_id', $ids)->get(); 
          $ammountadded = ammountadded::where('month', $date)->where('shop_id', $ids)->get();             

         return view('summary', [
            
             'usses' => $usses,
             'added' => $ammountadded,
             'transaction' => $transaction,
             'voucher' => $voucher,
             'sales' => $sales,
             'used' => $used,
             'bought' => $bought,
             'date' => $date,
          ]);
         }


       public function users(){
             $user = user::where('status',1)->get();
         return view('users', [
          
         'users' => $user,
          ]);

         }



             public function editshop(Request $request ,$id)
    {
          $ids = Crypt::decrypt($id);
          $sp = shop::where('id',$ids)->first();
          $sp->name = $request['shop'];
          $sp->save();   

            return redirect()->back()->with(['message' => 'Shop Edited']);

       }

             public function editusses(Request $request ,$id)
    {
          $ids = Crypt::decrypt($id);
          $us = usse::where('id',$ids)->first();
          $us->issue = $request['issue'];
          $us->price = $request['price'];
          $us->date = $request['date'];
          $us->keeper = $request['keeper'];
          $us->month = date('F Y', strtotime($us->date));
          $us->updated = auth()->user()->id;
          $us->save(); 

            return redirect()->back()->with(['message' => 'Used Issue Edited']);

       }


         public function editboughts(Request $request ,$id)
    {
          $ids = Crypt::decrypt($id);
          $bt = bought::where('id',$ids)->first();
          $bt->issue = $request['issue'];
          $bt->price = $request['price'];
          $bt->date = $request['date'];
          $bt->month = date('F Y', strtotime($bt->date));
          $bt->updated = auth()->user()->id;
          $bt->save(); 

            return redirect()->back()->with(['message' => 'Bought Issue Edited']);

       }


                public function editvoucher(Request $request ,$id)
    {
          $ids = Crypt::decrypt($id);
          $vc = voucher::where('id',$ids)->first();
          $vc->value = $request['value'];
          $vc->price = $request['price'];
          $vc->date = $request['date'];
          $vc->month = date('F Y', strtotime($vc->date));
          $vc->updated = auth()->user()->id;
          $vc->save(); 

            return redirect()->back()->with(['message' => 'Voucher Edited']);

       }

                public function edittransactions(Request $request ,$id)
    {
          $ids = Crypt::decrypt($id);
          $tra = transaction::where('id',$ids)->first();
          $tra->price = $request['price'];
          $tra->date = $request['dates'];
          $tra->month = date('F Y', strtotime($tra->date));
          $tra->updated = auth()->user()->id;
          $tra->save(); 

            return redirect()->back()->with(['message' => 'Transaction Edited']);

       }



           public function editammount(Request $request ,$id)
    {
          $ids = Crypt::decrypt($id);
          $am = ammountadded::where('id',$ids)->first();
          $am->price = $request['price'];
          $am->date = $request['date'];
          $am->month = date('F Y', strtotime($am->date));
          $am->updated = auth()->user()->id;
          $am->save(); 

            return redirect()->back()->with(['message' => 'Amount Edited']);

       }



         public function editsales(Request $request ,$id)
    {
          $ids = Crypt::decrypt($id);
          $sl = sale::where('id',$ids)->first();
          $sl->price = $request['price'];
          $sl->date = $request['date'];
          $sl->month = date('F Y', strtotime($sl->date));
          $sl->updated = auth()->user()->id;
          $sl->save(); 

            return redirect()->back()->with(['message' => 'Sales Issue Edited']);

       }



             public function editshopkeeper(Request $request ,$id)
    {
          $ids = Crypt::decrypt($id);
          $kp = user::where('id',$ids)->first();
          $kp->name = $request['name'];
          $kp->price = $request['price'];
          $kp->save(); 

            return redirect()->back()->with(['message' => 'Shop Keeper Edited']);

       }

     
       public function deleteused($id)
    {
          
          $us = usse::where('id',$id)->first();
          $us->delete(); 

        return redirect()->back()->with(['message' => 'Used Issue Deleted']);

       }


           public function deletebought($id)
    {
          
          $bt = bought::where('id',$id)->first();
          $bt->delete(); 

            return redirect()->back()->with(['message' => 'Bought Issue Deleted']);

       }


       public function deletekeeper($id)
    {
          
          $us = user::where('id',$id)->first();
          $us->status = 2;
          $us->save(); 

            return redirect()->back()->with(['message' => 'User Deleted']);

       }


        public function deletesales($id)
    {
          
          $sl = sale::where('id',$id)->first();
          $sl->delete(); 

            return redirect()->back()->with(['message' => 'Sale Deleted']);

       }



        public function deleteammount($id)
    {
          
          $sl = ammountadded::where('id',$id)->first();
          $sl->delete(); 

            return redirect()->back()->with(['message' => 'Amount Deleted']);

       }


               public function deletevoucher($id)
    {
          
          $vc = voucher::where('id',$id)->first();
          $vc->delete(); 

            return redirect()->back()->with(['message' => 'Voucher Deleted']);

       }

    public function deletetransaction($id)
    {
          
          $tra = transaction::where('id',$id)->first();
          $tra->delete(); 

            return redirect()->back()->with(['message' => 'Transaction Deleted']);

       }

       

}