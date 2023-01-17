<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;

class NotificationController extends Controller
{

    public static function index(){
        $user_id= Auth::user()->id;
        $today= date('Y-m-d');
        
        $notifications= DB::table('notifications')->where('user_id' , $user_id)->where('date' , $today)->get();
        // $notification_texts= ['New Client Added In This Week' , 'Clients Whose Agreement Is Going To Expire In 15 Days' , 'Client Added To New Route In This Week' , 'Payment Recieved In This Week'];
        $notification_texts= ['Clients Whose Agreement Is Going To Expire In 15 Days'];
        $fifteen_days_later= date('Y-m-d' , strtotime($today .'+15days'));
        // $one_week_before= date('Y-m-d' , strtotime($today .'-1 week'));
        // $new_added_clients= DB::table('client')->whereRaw("DATE_FORMAT(client.created_at,'%Y-%m-%d')>= '$one_week_before' and DATE_FORMAT(client.created_at,'%Y-%m-%d')<= '$today'")->where('status' , 1)->count();
        // $clients_added_to_new_route= DB::table('client_routes')->whereRaw("DATE_FORMAT(client_routes.created_at,'%Y-%m-%d')>= '$one_week_before' and DATE_FORMAT(client_routes.created_at,'%Y-%m-%d')<= '$today'")->where('status' , 1)->count();
        // $payment_recieved= DB::table('payment')->whereRaw("DATE_FORMAT(payment.created_at,'%Y-%m-%d')>= '$one_week_before' and DATE_FORMAT(payment.created_at,'%Y-%m-%d')<= '$today'")->where('status' , 1)->count();
        $expire_details= DB::table('client') ->whereRaw("DATE_FORMAT(client.agreement_end_date,'%Y-%m-%d')>= '$today' and DATE_FORMAT(client.agreement_end_date,'%Y-%m-%d')<= '$fifteen_days_later'")->where('status' , 1)->count();
       $title=array(
        // "New Client Added In This Week"=>"Client" ,
        "Clients Whose Agreement Is Going To Expire In 15 Days"=>"Client",
        // 'Client Added To New Route In This Week'=>"Client",
        // 'Payment Recieved In This Week'=>"Payment"
       );
        $counts= array(
            // "New Client Added In This Week"=>$new_added_clients ,
            "Clients Whose Agreement Is Going To Expire In 15 Days"=>$expire_details,
            // 'Client Added To New Route In This Week'=>$clients_added_to_new_route,
            // 'Payment Recieved In This Week'=>$payment_recieved
        );
        if(count($notifications)==0){
           $urls= array(
            // "New Client Added In This Week"=>"notifications/new_client" ,
            "Clients Whose Agreement Is Going To Expire In 15 Days"=>"notifications/agreement_expire",
            // 'Client Added To New Route In This Week'=>'notifications/client_added_to_new_route',
            // 'Payment Recieved In This Week'=>'notifications/payment_recieved'
           );
           foreach($notification_texts as $text){
                DB::table('notifications')->insert([
                    'parent'=>'client',

                    'parent'=>$title[$text],
                    'text'=>$text,
                    'count'=>$counts[$text],
                    'user_id'=>$user_id,
                    'date'=>$today ,
                    'is_seen'=>0,
                    'url'=>$urls[$text]
                ]);
            }
            $notifications= DB::table('notifications')->where('user_id' , $user_id)->where('date' , $today)->get();
            $notifications_count= DB::table('notifications')->where('user_id' , $user_id)->where('date' , $today)->count();

        }
        else{
             foreach($notifications as $i=>$notification){
                if(!empty($notification_texts[$i])){
                    
                     if($notification->text==$notification_texts[$i]){
                        if($notification->count!=$counts[$notification_texts[$i]]){
                            // $count_diff= $new_added_clients-$notification->count ;
                            DB::table('notifications')->where('user_id' , $user_id)->where('date' , $today)->where('text' , $notification_texts[$i])->update([
                                'count'=>$counts[$notification_texts[$i]],
                                'is_seen'=>0

                            ]);
                          
                        }
                     }
                }
               
             }
             $notifications= DB::table('notifications')->where('user_id' , $user_id)->where('date' , $today)->get();
             $notifications_count= DB::table('notifications')->where('user_id' , $user_id)->where('date' , $today)->where('is_seen' , 0)->count();


        }


        $data = [$notifications, $notifications_count];
        return $data;


        //         $user_id= Auth::user()->email;
        //         $today= date('Y-m-d');

        //         $notifications= DB::table('notifications')->where('user_id' , $user_id)->where('date' , $today)->get();
        //         $notification_texts= ['New Client Added In This Week' , 'Clients Whose Agreement Is Going To Expire In 15 Days' , 'new plant added'];
        //         $fifteen_days_later= date('Y-m-d' , strtotime($today .'+15days'));
        //         $one_week_before= date('Y-m-d' , strtotime($today .'-1 week'));
        //         $new_added_clients= DB::table('client')->whereRaw("DATE_FORMAT(client.created_at,'%Y-%m-%d')>= '$one_week_before' and DATE_FORMAT(client.created_at,'%Y-%m-%d')<= '$today'")->where('status' , 1)->count();
        //         $expire_details= DB::table('client') ->whereRaw("DATE_FORMAT(client.agreement_end_date,'%Y-%m-%d')>= '$today' and DATE_FORMAT(client.agreement_end_date,'%Y-%m-%d')<= '$fifteen_days_later'")->where('status' , 1)->count();
        //         $counts= array(
        //             "New Client Added In This Week"=>$new_added_clients ,
        //             "Clients Whose Agreement Is Going To Expire In 15 Days"=>$expire_details,
        //             "new plant added"=>$expire_details

        //         );

        //           if(count($notifications)==0){
        //               DB::table('notifications')->update(
        //         ['date' => $today , 
        //               'is_seen'=>0
        //         ]
        //         );
        //           }
        //              foreach($notifications as $i=>$notification){
        //                  if($notification->text==$notification_texts[$i]){
        //                     if($notification->count!=$counts[$notification_texts[$i]]){
        //                         // $count_diff= $new_added_clients-$notification->count ;
        //                         // if($count_diff<0){
        //                         //     $count_diff= $notification->count - $new_added_clients;

        //                         // }
        //                         DB::table('notifications')->where('user_id' , $user_id)->where('date' , $today)->where('text' , $notification_texts[$i])->update([
        //                             'count'=>$counts[$notification_texts[$i]],


        //                         ]);

        //                     }
        //                  }

        //              }
        //              $notifications= DB::table('notifications')->where('user_id' , $user_id)->where('date' , $today)->get();
        //              $notifications_count= DB::table('notifications')->where('user_id' , $user_id)->where('date' , $today)->where('is_seen' , 0)->count();


        // $data=[$notifications ,$notifications_count];
        //         return $data ;









    }
    public function notificationManager($type)
    {

        $user_id = Auth::user()->id;
        $today = date('Y-m-d');
        if ($type == "agreement_expire") {
            DB::table('notifications')->where('user_id', $user_id)->where('date', $today)->where('text', "Clients Whose Agreement Is Going To Expire In 15 Days")->update([
                'is_seen' => 1,
                'seen_at' => date('Y-m-d H:i:s')
            ]);
            $today = date('Y-m-d');
            $fifteen_days_later = date('Y-m-d', strtotime($today . '+15days'));
            $clients = DB::table('client')->whereRaw("DATE_FORMAT(client.agreement_end_date,'%Y-%m-%d')>= '$today' and DATE_FORMAT(client.agreement_end_date,'%Y-%m-%d')<= '$fifteen_days_later'")->where('status', 1)->get();
            return view('Notifications.agreement_expire', compact('clients'));
        } 
        elseif ($type == "new_client") {
            $result = DB::table('notifications')->where('user_id', $user_id)->where('date', $today)->where('text', "New Client Added In This Week")->update([
                'is_seen' => 1,
                'seen_at' => date('Y-m-d H:i:s')
            ]);

            $today = date('Y-m-d');
            $one_week_before = date('Y-m-d', strtotime($today . '-1 week'));
            // dd($one_week_before);
            $clients = DB::table('client')->whereRaw("DATE_FORMAT(client.created_at,'%Y-%m-%d')>= '$one_week_before' and DATE_FORMAT(client.created_at,'%Y-%m-%d')<= '$today'")->where('status', 1)->get();
            return view('Notifications.new_client_added', compact('clients', 'one_week_before'));
        }
        elseif ($type == "client_added_to_new_route") {
            $result = DB::table('notifications')->where('user_id', $user_id)->where('date', $today)->where('text', "Client Added To New Route In This Week")->update([
                'is_seen' => 1,
                'seen_at' => date('Y-m-d H:i:s')
            ]);

            $today = date('Y-m-d');
            $one_week_before = date('Y-m-d', strtotime($today . '-1 week'));
            // dd($one_week_before);
            $clients = DB::table('client_routes')->whereRaw("DATE_FORMAT(client_routes.created_at,'%Y-%m-%d')>= '$one_week_before' and DATE_FORMAT(client_routes.created_at,'%Y-%m-%d')<= '$today'")->
            join('routes' , 'client_routes.route_id' ,'=' ,'routes.id')->select('client_routes.*' , 'routes.name as route_name')->where('client_routes.status' , 1)->get();
            // dd($clients);
            return view('Notifications.new_client_added_to_route', compact('clients', 'one_week_before'));
        }
        elseif ($type == "payment_recieved") {
            $result = DB::table('notifications')->where('user_id', $user_id)->where('date', $today)->where('text', "Payment Recieved In This Week")->update([
                'is_seen' => 1,
                'seen_at' => date('Y-m-d H:i:s')
            ]);

            $today = date('Y-m-d');
            $one_week_before = date('Y-m-d', strtotime($today . '-1 week'));
            // dd($one_week_before);
            $payments =DB::table('payment')->whereRaw("DATE_FORMAT(payment.created_at,'%Y-%m-%d')>= '$one_week_before' and DATE_FORMAT(payment.created_at,'%Y-%m-%d')<= '$today'")->join('client' , 'payment.client' , '=' , 'client.id')->select('payment.*' , 'client.business_name as client_name' , 'client.client_char_id as client_char_id' , 'client.id as client_id' )->where('payment.status' , 1)->get();
            // dd($payments);
            return view('Notifications.payment_recieved', compact('payments', 'one_week_before'));
        }
    }


    public function create()
    {
        // $user_id= Auth::user()->email;
        // $today= date('Y-m-d');
        // $notifications_count= DB::table('notifications')->where('user_id' , $user_id)->where('date' , $today)->where('is_seen' , 0)->count();
        // dd($notifications_count);
        $users =DB::table('users')
        ->join('employee_info' , 'employee_info.user_primary_id' , '=' , 'users.id')
        ->leftjoin('designation' , 'employee_info.designation_id' , '=' , 'designation.id')
        ->select(DB::raw("CONCAT_WS(' ',designation.name,users.name,employee_info.f_name,employee_info.l_name) as full_name"), 'users.*')
        ->get();
        // dd($UserData);

        return view('Notifications.notification_management', [
            'userdata' => $users,
        ]);
    }
    public function store(Request $request)
    {
        // dd($request);
        $all_approval = $request->approval;
        $approved_users = array_keys($all_approval);
        // dd($approved_users);
        foreach ($approved_users as $user) {
            DB::table('notifications')->insert([
                'parent' => $request->title,
                'text' => $request->description,
                'url' => $request->url,
                'user_id' => $user,
                'is_seen' => 0,



            ]);
        }

        return redirect()->back()->with('success', 'Notification and Access added successfully');
    }
}
