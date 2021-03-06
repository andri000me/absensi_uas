<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$set = $this->db->get_where('sekolah', ['id'=>1])->row_array();
date_default_timezone_set('Asia/Jakarta');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Ujian Sekolah SMKN 1 BANGSRI</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="shorcut icon" href="<?php echo base_url().'assets/images/'.$set['LogoSekolah'];?>">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url().'assets/bootstrap/css/bootstrap.min.css'?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url().'assets/font-awesome/css/font-awesome.min.css'?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url().'assets/dist/css/AdminLTE.min.css'?>">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url().'assets/plugins/iCheck/square/blue.css'?>">
  <style type="text/css">
    .form-signin
{
    max-width: 330px;
    padding: 15px;
    margin: 0 auto;
}
.form-signin .form-signin-heading, .form-signin .checkbox
{
    margin-bottom: 10px;
}
.form-signin .checkbox
{
    font-weight: normal;
}
.form-signin .form-control
{
    position: relative;
    font-size: 16px;
    height: auto;
    padding: 10px;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}
.form-signin .form-control:focus
{
    z-index: 2;
}
.form-signin input[type="text"]
{
    margin-bottom: -1px;
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
}
.form-signin input[type="password"]
{
    margin-bottom: 10px;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
}
.account-wall
{
    margin-top: 20px;
    padding: 40px 0px 20px 0px;
    background-color: #f7f7f7;
    -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
    -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
}
.login-title
{
    color: #555;
    font-size: 18px;
    font-weight: 400;
    display: block;
}
.profile-img
{
    width: 96px;
    height: 96px;
    margin: 0 auto 10px;
    display: block;
    -moz-border-radius: 50%;
    -webkit-border-radius: 50%;
    border-radius: 50%;
}
.need-help
{
    margin-top: 10px;
}
.new-account
{
    display: block;
    margin-top: 10px;
}
  </style>

</head>
<body class="hold-transition login-page">
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title"></h1>
            <div class="account-wall">
                <img class="profile-img" src="<?php echo base_url().'assets/images/'.$set['LogoSekolah'];?>?sz=120"
                    alt=""><center style="font-weight: bold; font-size: 18px;">Biodata Identitas Anda<br/></center>
                <form class="form-signin" method="post" action="<?php echo base_url('siswa/proses');?>">
                  <label>NIS :</label>
                  <div class="form-group"> 
                    <?php echo $this->session->userdata('nis'); ?>
                  </div>
                  <label>Nama :</label>
                  <div class="form-group"> 
                    <?php echo $this->session->userdata('nama'); ?>
                  </div>
                  <label>Kelas :</label>
                  <div class="form-group"> 
                    <?php echo $this->session->userdata('kelas'); ?>
                  </div>
                  <label>Jurusan :</label>
                  <div class="form-group"> 
                    <?php echo $this->session->userdata('jurusan'); ?>
                  </div>
                  <label>Pilih Mapel Yang Aktif :</label>
                  <div class="form-group"> 
                            <?php 
                            $tgl = date("Y-m-d");
                            $tma = date("H:i:s");
                            $ting = $this->session->userdata('tingkatan');
                            $jur = $this->session->userdata('jurusan');
                            $aj = $this->db->query("select*from soal where tanggal_uji='$tgl' AND tingkatan='$ting' AND jurusan='all' AND waktu_awal <= '$tma' AND waktu_akhir >= '$tma'")->num_rows();
                            if (empty($aj)) {
                              $a = $this->db->query("select*from soal where tanggal_uji='$tgl' AND tingkatan='$ting' AND jurusan='$jur'")->result();
                             // echo "Ada Jurusan";
                            } else {
                              $a = $this->db->query("select*from soal where tanggal_uji='$tgl' AND tingkatan='$ting'")->result();
                              //echo "No Jurusan";
                            }
                            if (empty($a)) {
                              $sts = "disabled";
                            } else {
                              $sts = "";
                            }
                            foreach ($a as $df) {
                            if($tma >= $df->waktu_awal && $tma < $df->waktu_akhir) {
                                 echo '<input type="radio" name="KodeSoal" class="radioClass" value="'.$df->KodeSoal.'" required /> '.$df->NamaSoal;
                             }
                            } 
                            ?>
                   
                  </div>
                  <div class="form-group"> 
                    <input type="checkbox" name="checkbox" required="" value="Saya Mengerjakan Dengan Jujur"> Saya Mengerjakan Dengan Jujur
                  </div>
                <input type="hidden" name="IDSiswa" value="<?php echo $this->session->userdata('nis'); ?>">
                <input type="hidden" name="jurusan" value="<?php echo $this->session->userdata('jurusan'); ?>">
                <input type="hidden" name="kelas" value="<?php echo $this->session->userdata('kelas'); ?>">
                <button class="btn btn-lg btn-primary btn-block" type="submit" <?php echo $sts; ?>>
                    Lanjut Mengerjakan</button> <a href="<?php echo base_url('siswa'); ?>" class="btn btn-lg btn-danger btn-block">Refresh</a>
                </form>
            </div>
        </div>
    </div>
</div
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="<?php echo base_url().'assets/plugins/jQuery/jquery-2.2.3.min.js'?>"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url().'assets/bootstrap/js/bootstrap.min.js'?>"></script>
<!-- iCheck -->
<script src="<?php echo base_url().'assets/plugins/iCheck/icheck.min.js'?>"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
