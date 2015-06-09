<?php
/**
 * Created by PhpStorm.
 * User: rizamasta
 * Date: 6/6/15
 * Time: 2:06 PM
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

class Categories extends CI_Controller{
    public function __construct(){
        parent :: __construct();
        $this->load->model('Db_models');
    }
    public function index(){

        $result['message']= "Method Not Allowed, Contact Support";
        echo json_encode($result);
    }
    public function add(){
        $result['message']='';
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $id                 = substr(uniqid(),0,8);
            $result['message']  = 'success';
            $username           = $_POST['username'];
            $namaKategori       = $_POST['nama'];
            $time               = date('Y/m/d');

            if(!empty($username)){
                $sql    =    "INSERT INTO tbl_kategori VALUE ('$id','$namaKategori','$username','$time',1)";
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
            $result['method']=$_SERVER['REQUEST_METHOD'];
        }
        echo json_encode($result);
    }
    public function viewList(){
        $result['message']='';
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $username           = $_POST['username'];

            if(!empty($username)){
                $sql    =    "SELECT * From tbl_kategori WHERE username='$username' AND status='1'";
                $query  = $this->db->query($sql);

                if($query){
                    $result['message']  = "success";
                    $result['data']     = $query->result();
                }
                else{
                    $result['message']  = "Get List failed";
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
    public function delete(){
        $result['message']='';
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $id                 = $_POST['id_kategori'];
            $result['message']  = 'success';
            $username           = $_POST['username'];

            if(!empty($username)&&!empty($id)){
                $sql    =    "UPDATE tbl_kategori SET status=2 WHERE username='$username' AND id_kategori='$id'";
                $query  = $this->db->query($sql);

                if($query){
                    $result['message']  = "success";
                    $result['text']     = "Deleted Success";
                }
                else{
                    $result['message']  = "Deleted Failed!";
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
    public function update(){

    }
}