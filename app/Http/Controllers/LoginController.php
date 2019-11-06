<?php



namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer\PHPMailer;
use App\Models\RsgUser;


class LoginController extends Controller
{
    //
    public function __construct()
    {
    }

    public function signup(){
        return view('login.signup');
    }

    public function signupHandle(){

        if(!(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password_confirm']))){
            exit;
        }
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $password_confirm = trim($_POST['password_confirm']);
        $preg = '/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/';
        $msg = "";

        if($email==""){
            $msg = "Email cannot be blank.";
        }
        elseif(!preg_match($preg, $email)){
            $msg = "Email format is invalid.";
        }
        elseif($password == ""){
            $msg = "Password cannot be blank!";
        }
        elseif(strlen($password) < 8){
            $msg = "Password length must be at least 8!";
        }
        elseif($password_confirm == ""){
            $msg = "Password confirmation cannot be blank.";
        }
        elseif($password != $password_confirm){
            $msg = "The two passwords you entered do not match.";
        }
        else{
            $rsg_users = RsgUser::where('email', $email)->take(1)->get();
            if(count($rsg_users) > 0){
                $msg = "This email address has already been registered, please choose another one.";
            }
            else{
                $token = md5($email.$password);
                $rsg_user = new RsgUser;
                $rsg_user->email = $email;
                $rsg_user->password = md5($password);
                $rsg_user->token = $token;

                DB::beginTransaction();
                $data_insert_result = $rsg_user->save();

                if(isset($data_insert_result) && $data_insert_result){
                    $send_email_result = LoginController::send_email($email, $token);
                    if(isset($send_email_result) && $send_email_result){
                        DB::commit();
                        $msg = "successful";
                    }
                    else{
                        DB::rollback();
                        $msg = "Account has not been created successfully, please try again.";
                    }
                }
                else {
                    DB::rollback();
                }
            }
        }

        return json_encode(array('msg' => $msg));
    }

    public function activation(){
        if(isset($_REQUEST['email']) && isset($_REQUEST['verify'])){
            $email = $_REQUEST['email'];
            $verify = $_REQUEST['verify'];

            $rsg_users = RsgUser::where('email', $email)->where('token', $verify)->take(1)->get();
            if(count($rsg_users) > 0) {
                $rsg_user = $rsg_users[0];
                $rsg_user->status = 1;
                $rsg_user->save();
                echo "Your account has been created successfully.";
                # 4秒后页面跳转到主页
                header("Refresh:4; url=/signup");
            }
        }

    }

    public function signin(){
        return view('login.signin');
    }

    public function signinHandle(){
        if(!(isset($_POST['email']) && isset($_POST['password']))){
            exit;
        }
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        $msg = "";
        $preg = '/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/';

        if($email==""){
            $msg = "Email cannot be blank.";
        }
        elseif(!preg_match($preg, $email)){
            $msg = "Email format is invalid.";
        }
        elseif($password == "") {
            $msg = "Password cannot be blank!";
        }
        else{
            $rsg_users = RsgUser::where('email', $email)->where('password', md5($password))->take(1)->get();
            if(count($rsg_users) > 0){
                $rsg_user = $rsg_users[0];
                if($rsg_user->status == 0){
                    $msg = "Your account hasn't been activated. Please check your email to activate your account!";
                }
                else{
                    $msg = "successful";
                }
            }
            else{
                $msg = "Your email or password is incorrect!";
            }
        }

        return json_encode(array('msg' => $msg));
    }

    function send_email($to_email, $token)
    {
        $mail = new PHPMailer;

        $mail->CharSet = "UTF-8";
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = config('login.email_host');
        $mail->Port = config('login.email_port');
        $mail->SMTPAuth = config('login.email_smtpauth');
        $mail->Username = config('login.email_username');
        $mail->Password = config('login.email_password');
        $mail->SMTPSecure = config('login.email_smtpsecure');

        $mail->setFrom(config('login.email_username'), config('login.email_from_name'));
        $mail->addAddress($to_email);
        $mail->addReplyTo(config('login.email_username'), config('login.email_reply_to_name'));

        $mail->isHTML(true);

        $mail->Subject = 'Account activation';
        $mail->Body    = "Dear " . $to_email . "：<br/>Thank you for your registration.<br/>Please click the link below to activate your account.<br/><a href='" . url("/activation") . "?email=" . $to_email . "&verify=" . $token . "' target='_blank'>" . url("/activation") . "?email=" . $to_email . "&verify=" . $token . "</a>";

        if(!$mail->send()) {
            return false;

        }else{
            return true;
        }
    }


}
