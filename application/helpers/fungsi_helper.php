<?php

    function rupiah($angka) {
        $hasil_rupiah = "Rp." . number_format($angka, 2, ',', '.');
        return $hasil_rupiah;
    }

    function changeFormat($rupiah) {
        $bilangan = substr(preg_replace("/[^0-9]/", "", $rupiah), 0, -2);
        return $bilangan;
    }

    function isLogin() {
        $ci =& get_instance();
        $user_session = $ci->session->userdata('userid');
        if($user_session) {
            redirect('web');
        }
    }

    function isNotLogin() {
        $ci =& get_instance();
        $user_session = $ci->session->userdata('userid');
        if(!$user_session) {
            redirect('auth');
        }
    }