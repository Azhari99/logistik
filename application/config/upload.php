<?php 
defined('BASEPATH') OR exit ('No direct script access allowed');

	$config = [
            'upload_path'        => './upload/nodin/',
            'allowed_types'      => 'pdf',
            'max_size'           => 5000,
            // 'file_name'          => 'item-'.date('ymd').'-'.substr(md5(rand()),0,10)
            'file_name'          => 'item' . '_' . date('ymd') . '_' . date('His') . '_' . substr(md5(rand()), 0, 10)
      ];
?>