<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
  <div class="menu_section">
    <h3>General</h3>
    <ul class="nav side-menu">
      <?php $main_menu = $this->db->from('tbl_menu')->where('isactive', 'Y')->order_by('seqno, name ASC')->get();
      foreach ($main_menu->result() as $value) :
        $menu_id = $value->tbl_menu_id;
        $sub_menu = $this->db->from('tbl_submenu')->where('tbl_menu_id', $menu_id)->where('isactive', 'Y')->order_by('seqno, name ASC')->get();
        if ($sub_menu->num_rows() > 0) { ?>
          <li><a><i class="<?= $value->icon ?>"></i> <?= $value->name ?> <span class="fa fa-chevron-down"></span></a>
          <?php echo "<ul class='nav child_menu'>";
          foreach ($sub_menu->result() as $row) {
            echo "<li>" . anchor($row->url, ucfirst($row->name)) . "</li>";
          }
          echo "</ul></li>";
        } else {
          echo "<li>" . anchor($value->url, '<i class="' . $value->icon . '"></i>' . ucfirst($value->name)) . "</li>";
        }
      endforeach; ?>
    </ul>
  </div>
</div>