<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
  <div class="menu_section">
    <h3>General</h3>
    <ul class="nav side-menu">
      <?php
      $level = $this->session->userdata('level');
      $this->db->from('tbl_menu');
      $this->db->where('isactive', 'Y');
      
      if ($level == 2) {
        $this->db->where_in('tbl_menu_id', [1, 2, 3, 4, 5]);
      } else if ($level == 3)  {
        $this->db->where_in('tbl_menu_id', [1, 2, 3, 4]);
      }
      $this->db->order_by('seqno, name ASC');
      $main_menu = $this->db->get();
      foreach ($main_menu->result() as $value) :
        $menu_id = $value->tbl_menu_id;
        $this->db->from('tbl_submenu');
        $this->db->where('tbl_menu_id', $menu_id)
                ->where('isactive', 'Y');
        if ($level == 2) {
          $this->db->where_in('tbl_submenu_id', [1, 2, 3, 4, 7, 8, 9, 10, 11]);
        } else if ($level == 3) {
          $this->db->where_in('tbl_submenu_id', [9, 10, 11]);
        }
        $this->db->order_by('seqno, name ASC');
        $sub_menu = $this->db->get();
        if ($sub_menu->num_rows() > 0) { 
      ?>
          <li><a><i class="<?= $value->icon ?>"></i> <?= $value->name ?> <span class="fa fa-chevron-down"></span></a>
        <?php echo "<ul class='nav child_menu'>";
          foreach ($sub_menu->result() as $row) {
            echo "<li>" . anchor($row->url, ucfirst($row->name)) . "</li>";
          }
          echo "</ul></li>";
        } else {
          echo "<li>" . anchor($value->url, '<i class="' . $value->icon . '"></i>' . ucfirst($value->name)) . "</li>";
        }
      endforeach;
        ?>
    </ul>
  </div>
</div>