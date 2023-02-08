<?php
        defined('BASEPATH') OR exit('No direct script access allowed');

        class Register_model extends CI_Model {
                
        // Login User
    public function registerUser($username, $email, $password)
    {
        $active_code=md5(uniqid(rand(5, 15), true));
        $link = 'http://154.44.150.137/koena-new/register?key='.$active_code;
        
        $query = $this->db->query("SELECT * FROM user WHERE username = '".$username."' AND status = 1");
        $checkUser = $query->result();
        
        if (!empty($checkUser)) return 1;

        $query = $this->db->query("SELECT * FROM user WHERE email = '".$email."' AND status = 1");
        $checkEmail = $query->result();

        if (!empty($checkEmail)) return 2;

        $password = password_hash($password, PASSWORD_DEFAULT);
        
        $query = $this->db->query("INSERT INTO user (username, email, password, status, user_type_id, emailConfirmToken, isEmailConfirmed) VALUES ('".$username."', '".$email."', '".$password."',  0, 2,  '".$active_code."', 0)");
        
        $to = $email; //change to ur mail address
        $strSubject="Koena Tech | Email Verification";
        $message = 'Hi! '.$username.'
' ; 
        $message .= 'Thanks for signing up to the Koena Journal.
' ; 
        $message .= 'Click on the link to activate your account '.$link.'

Thanks' ;              

        $this->email->from('email@example.com', 'Identification');
        $this->email->to($to);
        $this->email->subject($strSubject);
        $this->email->message($message);
        if($this->email->send())
            return 3;
        else
            return 4;
    }
    public function resendVerificationEmail($params){   
        $active_code=md5(uniqid(rand(5, 15), true));
        $link = 'http://154.44.150.137/koena-new/register?key='.$active_code;
        $query = $this->db->query("SELECT * FROM user WHERE email = '".$params['emailid']."' AND status = 0");
        $checkEmail = $query->result();

        if (!$checkEmail){
           return 3;
        }else{
            $query = $this->db->query("UPDATE user SET `emailConfirmToken` = '".$active_code."', isEmailConfirmed=0 WHERE user_id =".$checkEmail[0]->user_id);
            //send email
            $to = $params['emailid']; //change to ur mail address
            $strSubject="Koena Tech | Email Verification";
            $message = 'Hi!
'; 
            $message .= 'Thanks for signing up to the Koena Journal.
'; 
            $message .= 'Click on the link to activate your account '.$link.'
' ;              

            $this->email->from('email@example.com', 'Identification');
            $this->email->to($to);
            $this->email->subject($strSubject);
            $this->email->message($message);
            if($this->email->send())
                return 1;
            else
                return 0;
        }
    }

    public function changeEmail($params){
        $active_code=md5(uniqid(rand(5, 15), true));
            $link = 'http://154.44.150.137/koena-new/register?key='.$active_code;
            $query = $this->db->query("SELECT * FROM user WHERE email = '".$params['emailid']."' AND status = 0");
            $checkEmail = $query->result();
            if (!$checkEmail){
                return 4;
            }else{
                //echo "UPDATE user SET `emailConfirmToken` = :emailConfirmToken, isEmailConfirmed=:isEmailConfirmed, email=:emailchangeid WHERE user_id = :user_id"
                $this->db->query("UPDATE user SET `emailConfirmToken` = '".$active_code."', isEmailConfirmed=0, email='".$params['emailchangeid']."' WHERE user_id = ".$checkEmail[0]->user_id);
                //send email
                $to = $params['emailchangeid']; //change to ur mail address
                $strSubject="Koena Tech | Email Verification";
                $message = 'Hi
' ; 
                $message .= 'Thanks for signing up to the Koena Journal.
' ; 
                $message .= 'Click on the link to activate your account '.$link.'
' ;              
                $this->email->from('email@example.com', 'Identification');
                $this->email->to($to);
                $this->email->subject($strSubject);
                $this->email->message($message);
                if($this->email->send())
                    return 5;
                else
                    return 6;
            }
    }
	
    public function completeRegistration($params){
        $email = $params['email'];
        $fname = $params['fname'];
        $lname = $params['lname'];
        $country = $params['country'];
        $emailConfirmToken = $params['key'];
        $gmt = $params['timezone'];
        $query = $this->db->query("SELECT * FROM user WHERE emailConfirmToken = '".$emailConfirmToken."' AND isEmailConfirmed = 0 AND status = 0");
        if (!$query->result()) return 0;
        $this->db->query("UPDATE user SET firstname = '".$fname."', lastname = '".$lname."', country = '".$country."', gmt = '".$gmt."', emailConfirmToken = '', isEmailConfirmed= 1, status=1 WHERE email = '".$email."' ");
        return 1;
    }
}