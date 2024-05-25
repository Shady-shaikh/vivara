<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\backend\Cmspages;
use App\Models\frontend\Contactus;
use PHPMailer\PHPMailer;
use App\Models\backend\CustomPageTitles;


class PagesController extends Controller
{
    public function index($cms_pages_id)
    {
        $page_content = Cmspages::Where('cms_slug',$cms_pages_id)->Where('show_hide',1)->first();
        // dd($page_content);
        if($page_content)
        {
            $cms_page_name = ($page_content->cms_pages_title)?$page_content->cms_pages_title:'';
            $custom_page_title = $page_content->cms_pages_title;
            $page_title = "";
            if(isset($custom_page_title->custom_page_title_name) && $custom_page_title->custom_page_title_name!="")
            {
                 
                $page_title = $custom_page_title->custom_page_title_name;
                $page_title = str_replace("{#pagename}",$cms_page_name,$page_title);
                $product_listing_title = $page_title;
            }
            else
            {
                $product_listing_title =  $cms_page_name;
            }
          return view('frontend.pages.index',compact('page_content','product_listing_title'));
        }
    }

    // public function faqs()
    // {
    //     $faqs = FAQs::Where('visibility',1)->orderBy('sort_order','asc')->get();
    //     if($faqs)
    //     {
    //       return view('frontend.pages.faqs',compact('faqs'));
    //     }
    // }
  
    // public function contactus(Request $request)
    // {
    //     $this->validate($request, [
    //       'name' => ['required',],
    //       'email' => ['required',],
    //     ]);
    //     // echo "string";exit;
    //     // dd($request->all());
    //     $constactus = new Contactus();
    //     $constactus->fill($request->all());
    //     if ($constactus->save())
    //     {
    //         try 
    //         {
    //             $email = "customercare@dadreeios.com";//$request->email;
    //             $mail = new PHPMailer\PHPMailer();
    //             $mail->IsSMTP();
                
    //             $mail->Host       = "localhost";
    //             $mail->SMTPSecure = "tls";
    //             $mail->SMTPDebug  = 0;
    //             $mail->SMTPAuth   = false;
    //             $mail->Mailer     ="smtp";
    //             $mail->Port       = 25;
    //             $mail->Username = "";
    //             $mail->Password = '';
            
    //             $mail->SMTPOptions = array(
    //                 'ssl' => array(
    //                     'verify_peer' => false,
    //                     'verify_peer_name' => false,
    //                     'allow_self_signed' => true
    //                 )
    //             );
            
    //             $mail->isHTML(true);
    //             $mail->SetFrom('customercare@dadreeios.com','Dadreeios');
    //             $mail->AddBCC("maheshm@parasightsolutions.com");
    //             $mail->AddAddress($email);
    //             $mail->Subject = "New Contact Us Enquiry";
    //             $mail->Body = '
    //             <html>
    //                 <head>
    //                     <style>
    //                         table, tr, th, td {border: 1px solid black;border-collapse: collapse;}
    //                         tr{text-align:left;}
    //                         td{padding: 10px;}
    //                         th{padding: 10px;}
    //                     </style>
    //                 </head>
    //                 <body>
    //                     <div>
    //                         <table>
    //                             <tbody>
    //                                 <tr>
    //                                     <th>Name</th>
    //                                     <td>'.$request->name.'</td>
    //                                 </tr>
    //                                 <tr>
    //                                     <th>Email</th>
    //                                     <td>'.$request->email.'</td>
    //                                 </tr>
    //                                 <tr>
    //                                     <th>Mobile Number</th>
    //                                     <td>'.$request->mobile_no.'</td>
    //                                 </tr>
    //                                 <tr>
    //                                     <th>Order Number</th>
    //                                     <td>'.$request->order_no.'</td>
    //                                 </tr>
    //                                 <tr>
    //                                     <th>Issue</th>
    //                                     <td>'.$request->issue.'</td>
    //                                 </tr>
    //                                 <tr>
    //                                     <th>Comment</th>
    //                                     <td>'.$request->comment.'</td>
    //                                 </tr>
            
    //                             </tbody>
    //                         </table>
    //                     </div>
    //                 </body>
    //             </html>
    //             ';
    //             $mail->Send();
                
    //         }
    //         catch (phpmailerException $e) 
    //         {
    //             echo $e->errorMessage();
    //         } 
    //         catch (Exception $e) 
    //         {
    //             echo $e->getMessage();
    //         }
    //         return back()->with('success','Contact us enquiry Added Successfully !');
    //         //   return redirect()->route('admin.c')->with('success', 'New Custom Page Title Added!');
    //     }
    //     else
    //     {
    //         return back()->with('error','Something went Wrong !');
    //         //   return redirect()->route('admin.c')->with('error', 'Something went wrong!');
    //     }
    // }
}
