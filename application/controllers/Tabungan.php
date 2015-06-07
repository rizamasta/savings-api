<?php
/**
 * Created by PhpStorm.
 * User: rizamasta
 * Date: 6/1/15
 * Time: 9:02 PM
 */
if(!empty($_SERVER['HTTP_ORIGIN']))
{
    $http_origin = $_SERVER['HTTP_ORIGIN'];
}
else{
    $http_origin = '*';
}
header("Access-Control-Allow-Origin:$http_origin");
header("Access-Control-Allow-Credentials:true");
class Tabungan extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model('Db_models');
    }
    public function index(){
        $result['message']= "Method Not Allowed, Contact Support";
        echo json_encode($result);
    }
    public function add(){
        $result['message']='';
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $result['message']  = 'success';
            $username           = $_POST['username'];
            $jumlah             = $_POST['jumlah'];
            $time               = date('Y/m/d H:i:s');
            $type               = $_POST['type'];
            $kategori           = $_POST['kategori'];

            if(!empty($username)){
                $sql    =    "INSERT INTO tbl_savings VALUE (null,'$username','$jumlah','$kategori','$type','$time')";
                $query  = $this->db->query($sql);

                if($query){
                    $result['message']  = "success";
                    $result['text']     = "Save Success";
                }
                else{
                    $result['message']  = "Save Failed!";
                }
            }
            else{
                $result['message']  = "User Not found!";
            }
        }
        else{
            $result['message']= "Method Not Allowed!";
        }
        echo json_encode($result);
    }

    public function report(){
        $result['message']='';
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $result['message']  = 'success';
            $username           = $_POST['username'];

            if(!empty($username)){
                $sql                =   "SELECT jumlah,type_trx,DATE_FORMAT(time_trx,'%d-%m-%Y %H:%i') as tanggal,nama_kategori
                                          FROM tbl_savings,tbl_kategori
                                          WHERE tbl_kategori.id_kategori=tbl_savings.id_kategori AND
                                                tbl_savings.username= '$username' ORDER BY time_trx DESC ";
              //  $sql_deposit        =   "SELECT if(jumlah is NOT NULL ,sum(jumlah),0) as total_deposit FROM tbl_savings WHERE username= '$username' AND type_trx='deposit'";
              //  $sql_debt           =   "SELECT if(jumlah is NOT NULL ,sum(jumlah),0)  as total_debt FROM tbl_savings WHERE username= '$username' AND type_trx='debt'";
              //  $sql_pay_debt       =   "SELECT if(jumlah is NOT NULL ,sum(jumlah),0)  as total_pay_debt FROM tbl_savings WHERE username= '$username' AND type_trx='pay-debt'";

                $query              = $this->db->query($sql);
//                $query_deposit      = $this->db->query($sql_deposit);
//                $query_debt         = $this->db->query($sql_debt);
//                $query_pay_debt     = $this->db->query($sql_pay_debt);


                if($query){
                    $result['message']      = "success";
                    $result['data']         = $query->result();
//                    $result['deposit']      = $query_deposit->result();
//                    $result['debt']         = $query_debt->result();
//                    $result['pay_debt']     = $query_pay_debt->result();

                }
                else{
                    $result['message']  = "Save Failed!";
                }
            }
            else{
                $result['message']  = "User Not found!";
            }
        }
        else{
            $result['message']= "Method Not Allowed!";
        }
       echo json_encode($result);

    }
    public function mainSavings(){
        $result['message']='';
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $result['message']  = 'success';
            $username           = $_POST['username'];

            if(!empty($username)){
//                $sql                =   "SELECT jumlah,type_trx,DATE_FORMAT(time_trx,'%d-%m-%Y %H:%i') as tanggal,nama_kategori
//                                          FROM tbl_savings,tbl_kategori
//                                          WHERE tbl_kategori.id_kategori=tbl_savings.id_kategori AND
//                                                tbl_savings.username= '$username' ORDER BY time_trx DESC ";
                $sql_deposit        =   "SELECT if(jumlah is NOT NULL ,sum(jumlah),0) as total_deposit FROM tbl_savings
                                          WHERE username= '$username' AND type_trx='deposit' AND id_kategori='123Main'";
                $sql_debt           =   "SELECT if(jumlah is NOT NULL ,sum(jumlah),0)  as total_debt FROM tbl_savings
                                          WHERE username= '$username' AND type_trx='debt' AND id_kategori='123Main'";
                $sql_pay_debt       =   "SELECT if(jumlah is NOT NULL ,sum(jumlah),0)  as total_pay_debt FROM tbl_savings
                                          WHERE username= '$username' AND type_trx='pay-debt' AND id_kategori='123Main'";

//                $query              = $this->db->query($sql);
                $query_deposit      = $this->db->query($sql_deposit);
                $query_debt         = $this->db->query($sql_debt);
                $query_pay_debt     = $this->db->query($sql_pay_debt);


                if($query_deposit){
                    $result['message']      = "success";
//                    $result['data']         = $query->result();
                    $result['deposit']      = $query_deposit->result();
                    $result['debt']         = $query_debt->result();
                    $result['pay_debt']     = $query_pay_debt->result();

                }
                else{
                    $result['message']  = "Get data Failed!";
                }
            }
            else{
                $result['message']  = "User Not found!";
            }
        }
        else{
            $result['message']= "Method Not Allowed!";
        }
        echo json_encode($result);
    }
    public function totalSavings(){
        $result['message']='';
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $result['message']  = 'success';
            $username           = $_POST['username'];

            if(!empty($username)){
                $sql_kategori       =   "SELECT if(jumlah is NOT NULL ,sum(jumlah),0) as total_deposit,nama_kategori
                                          FROM tbl_savings,tbl_kategori
                                          WHERE tbl_savings.username= '$username' AND type_trx='deposit' AND
                                          tbl_savings.id_kategori=tbl_kategori.id_kategori AND tbl_kategori.status=1
                                          GROUP BY tbl_savings.id_kategori";


                $sql_deposit        =   "SELECT if(jumlah is NOT NULL ,sum(jumlah),0) as total_deposit FROM tbl_savings
                                          WHERE username= '$username' AND type_trx='deposit' AND id_kategori='123Main'";


                $sql_debt           =   "SELECT if(jumlah is NOT NULL ,sum(jumlah),0)  as total_debt FROM tbl_savings
                                          WHERE username= '$username' AND type_trx='debt' AND id_kategori='123Main'";


               $sql_pay_debt       =   "SELECT if(jumlah is NOT NULL ,sum(jumlah),0)  as total_pay_debt FROM tbl_savings
                                          WHERE username= '$username' AND type_trx='pay-debt' AND id_kategori='123Main'";

                $query              = $this->db->query($sql_kategori);
                $query_deposit      = $this->db->query($sql_deposit);
                $query_debt         = $this->db->query($sql_debt);
                $query_pay_debt     = $this->db->query($sql_pay_debt);


                if($query_deposit){
                    $result['message']      = "success";
                    $result['kategori']     = $query->result();
                    $result['deposit']      = $query_deposit->result();
                    $result['debt']         = $query_debt->result();
                    $result['pay_debt']     = $query_pay_debt->result();

                }
                else{
                    $result['message']  = "Get data Failed!";
                }
            }
            else{
                $result['message']  = "User Not found!";
            }
        }
        else{
            $result['message']= "Method Not Allowed!";
        }
        echo json_encode($result);
    }
}