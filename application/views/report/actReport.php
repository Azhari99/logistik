<script type="text/javascript">
  $(document).ready(function() {
    $("#listproduct").hide();
    $("#listinstitute").hide();
    $("#listcategory").hide();
    $("#listtype").hide();
  });

  $("#inlineRadio1").click(function() {
    $("#listproduct").show();
    $("#listinstitute").hide();
    $("#listcategory").hide();
    $("#listtype").hide();
  });

  $("#inlineRadio2").click(function() {
    $("#listproduct").hide();
    $("#listinstitute").show();
    $("#listcategory").hide();
    $("#listtype").hide();
  });

  $("#inlineRadio3").click(function() {
    $("#listproduct").hide();
    $("#listinstitute").hide();
    $("#listcategory").show();
    $("#listtype").hide();
  });

  $("#inlineRadio4").click(function() {
    $("#listproduct").hide();
    $("#listinstitute").hide();
    $("#listcategory").hide();
    $("#listtype").show();
  });
</script>