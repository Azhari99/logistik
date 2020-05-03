<?php

    function rupiah($angka) {
        $hasil_rupiah = "Rp." . number_format($angka, 2, ',', '.');
        return $hasil_rupiah;
    }

    function changeFormat($rupiah) {
        $bilangan = substr(preg_replace("/[^0-9]/", "", $rupiah), 0, -2);
        return $bilangan;
    }