<?php
/**
 * Created by PhpStorm.
 * User: Nilesh Thadani
 * Date: 27-06-2016
 * Time: 09:09
 */

class transaction_model extends CI_Model{

    /**
     * transaction_model constructor.
     */
    public function __construct(){
        $this -> load -> database();

    }

    public function getDetails($details){
        extract($details);
        $query = $this->db->query("SELECT * FROM transaction_issue WHERE member_id='$qmemberId' AND status='0'");
        $count = $query->num_rows();
        if($count==0){
            return 0;
        }
        else{
            return $query->result();
        }
    }

    public function isDombivli($member){
        extract($member);
        $user = $this->db->query("SELECT address_city FROM member WHERE member_id='$memberid'");
        foreach ($user->result() as $row){
            $city = $row->address_city;
        }
        if(isset($city)){
            if(strtolower($city)=='dombivli'){
                return TRUE;
            }
            else{
                return FALSE;
            }
        }
        else{
            return FALSE;
        }

    }

    public function issueBook($details){
        extract($details);
        $memberId = $qmemberId;
        $bookId = $qbookId;
        $bookType = $qbookType;
        $date = date("F j, Y, g:i a");
        $query = "SELECT book_type FROM transaction_issue WHERE member_id='$memberId' AND status='0'";

        $data1 = "SELECT status FROM member";
        $viewdata = $this->db->query($data1);

        $result = $this->db->query($query);
        $edu = 0;
        $other = 0;
        $status = Null;

              $result = $this->db->query("SELECT * FROM member WHERE status='$status'");
              if ($status==1) {
                   return "SORRY, Book can not be issued due to in-active memebr status :( ";
               } 
                        
        elseif($result->num_rows()<2){
            //$result = $this->db->query("SELECT  FROM transaction_issue WHERE member_id='$memberId' AND status='0'");
            //ok to issue but condition to be checked for book type
            foreach ($result->result() as $row){
                if($row->book_type==0){
                    $edu++;
                }
                if($row->book_type==1 || $row->book_type==2){
                    $other++;
                }
            }
            $query = $this->db->query("SELECT * FROM transaction_issue WHERE book_id='$bookId' AND status='1' AND returned_on='$date'");
            $count = $query->num_rows();
            if($count>0){
                return "book-return-today";
            }
            switch ($bookType){
                case 0:
                    if($edu==1){
                        return "max-edu";
                    }
                    if($edu==0){
                        $query = $this->db->query("SELECT bk_id FROM book WHERE book_id='$bookId'");
                        if($query->num_rows()<1){
                            return "absent"; //book id does not exists
                        }
                        $user = $this->db->query("SELECT address_city, status FROM member WHERE member_id='$memberId'");
                        $row = $user->row();
                        if(isset($row)){
                            if($row->status==0){
                                return "inactive";
                            }
                            if(strtolower($row->address_city)=='dombivli'){
                                $return_date = date('d-m-Y', strtotime("+7 days"));
                            }
                            else{
                                $return_date = date('d-m-Y', strtotime("+14 days"));
                            }
                        }
                        else{
                            //no such member
                            return "no-user";
                        }
                        $query = $this->db->query("SELECT * FROM transaction_issue WHERE book_id='$bookId' AND status='0'");
                        $count = $query->num_rows();
                        if($count>0){
                            return "book-issued";
                        }

                        $query = "INSERT INTO transaction_issue(book_id, book_type, member_id, issue_date, return_date, returned_on, status) VALUES (?,?,?,?,?,?,?)";
                        $addTransaction = $this->db->query($query, array($bookId, $bookType, $memberId, $date, $return_date,'0','0'));
                        $transaction_id = $this->db->insert_id();
                        return "Book issued successfully and return date is ".$return_date."\n<strong>Transaction ID: ".$transaction_id."</strong>";
                    }
                    break;
                case 1:
                    $query = $this->db->query("SELECT id FROM magazine WHERE magazine_id='$bookId'");
                    //echo $this->db->last_query();
                    if($query->num_rows()<1){
                        return "absent"; //book id does not exists
                    }
                case 2:
                    if($other==1){
                        return "max-other";
                    }
                    if($edu==0){
                        if($bookType==2){
                            $query = $this->db->query("SELECT id FROM novel WHERE novel_id='$bookId'");
                      //      echo $this->db->last_query();
                            if($query->num_rows()<1){
                                return "absent"; //book id does not exists
                            }
                        }
                        $user = $this->db->query("SELECT address_city FROM member WHERE member_id='$memberId'");
                        //echo $this->db->last_query();
                        $row = $user->row();
                        if(isset($row)){
                            if(strtolower($row->address_city)=='dombivli'){
                                $return_date = date('d-m-Y', strtotime("+7 days"));
                            }
                            else{
                                $return_date = date('d-m-Y', strtotime("+14 days"));
                            }
                        }
                        $query = $this->db->query("SELECT * FROM transaction_issue WHERE book_id='$bookId' AND status='0'");
                        //echo $this->db->last_query();
                        $count = $query->num_rows();

                        if($count>0){
                            return "book-issued";
                        }
                        $query = "INSERT INTO transaction_issue(book_id, book_type, member_id, issue_date, return_date, returned_on, status) VALUES (?,?,?,?,?,?,?)";
                        $addTransaction = $this->db->query($query, array($bookId, $bookType, $memberId, $date, $return_date,'0','0'));
                        $transaction_id = $this->db->insert_id();
                        //echo $this->db->last_query()."Book issued successfully and return date is ".$return_date."<br><strong>Transaction ID: ".$transaction_id."</strong>";
                        return "Book issued successfully and return date is ".$return_date."<br><strong>Transaction ID: ".$transaction_id."</strong>";
                    }
                    break;
            }
        }
        else{
            return "max-all";
        }
    }

    public function justReturnBook($book_details){
        extract($book_details);
        $date = date("F j, Y, g:i a");
        $update_issue_table = "UPDATE transaction_issue SET status='1', returned_on='$date' WHERE book_id='$b_id' AND t_id='$t_id'";
        if($this->db->query($update_issue_table)){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    public function payFine($book_details){
        extract($book_details);
        $date = date("F j, Y, g:i a");
        $return_book = "UPDATE transaction_issue SET status='1', returned_on='$date' WHERE book_id='$b_id' AND t_id='$t_id'";
        if($this->db->query($return_book)){
            //echo $this->db->last_query();
            if($paid>0){
                if(($amt-$paid)>0){
                    $complete = 0;
                }
                else{
                    $complete = 1;
                }
                $fine_record = "INSERT INTO fine_record(member_id, amt_paid, date) VALUES (?,?,?)";
                $update_fine_record_entry = $this->db->query($fine_record, array($mem_id, $paid, $date));
                $fine_entry = "INSERT INTO member_fine(member_id, transaction_id, total_fine, paid_fine, updated_at, full_pay) VALUES(?,?,?,?,?,?)";
                $update_member_fine = $this->db->query($fine_entry, array($mem_id, $t_id, $amt, $paid, $date, $complete));
                return "success";
            }
        }
        else{
            return "error";
        }
    }
            // all from here is transaction history 
      public function transactionHistory(){

        $this->db->select('t_id')
                  ->from('transaction_issue')
                  ->order_by('t_id', 'desc');
        $sql = "SELECT t.t_id,t.member_id, t.book_id, t.book_type, t.issue_date, t.return_date ,t.returned_on FROM transaction_issue t";
        $query = $this->db->query($sql);
        if($query->num_rows()>0){
            return $query;
        }
        else{
            return "No records found , Thank You :)";
        }
    }
          
}

?>