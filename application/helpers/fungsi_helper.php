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

    function isSession() {
        $ci =& get_instance();
        $user_level = $ci->session->userdata('level');
        $uri_1 = $ci->uri->segment('1');
        $uri_2 = $ci->uri->segment('2');
        $sub = array("add", "edit", "actAdd", "actEdit");
        if ($user_level == 2) {
            $menu_1 = array(null, "web", "productin", "productout", "requestin", "rpt_budgetout", "product", "category", "type", "budget", "institute");
            if (in_array($uri_1, $menu_1) && in_array($uri_2, $sub)) {
                $params = array('userid', 'username', 'name', 'level');
                $ci->session->unset_userdata($params);
                redirect('auth');
            } else if (!in_array($uri_1, $menu_1) && in_array($uri_2, $sub)) {
                $params = array('userid', 'username', 'name', 'level');
                $ci->session->unset_userdata($params);
                redirect('auth');
            } else if (!in_array($uri_1, $menu_1)){
                $params = array('userid', 'username', 'name', 'level');
                $ci->session->unset_userdata($params);
                redirect('auth');
            }
        } else if ($user_level == 3) {
            $menu_2 = array(null, "web", "productin", "productout", "requestin", "rpt_budgetout");
            if (!in_array($uri_1, $menu_2) && in_array($uri_2, $sub)) {
                $params = array('userid', 'username', 'name', 'level');
                $ci->session->unset_userdata($params);
                redirect('auth');
            } else if (!in_array($uri_1, $menu_2)){
                $params = array('userid', 'username', 'name', 'level');
                $ci->session->unset_userdata($params);
                redirect('auth');
            }
        }
    }