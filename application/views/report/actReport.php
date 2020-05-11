<script type="text/javascript">
  $(document).ready(function() {
    //alert("Masuk");
    $("#isproduct").hide();
    $("#isinstansi").hide();
  });

  $("#inlineRadio1").click(function() {
        $("#isproduct").show();
        $("#isinstansi").hide();
    });

    $("#inlineRadio2").click(function() {
        $("#isinstansi").show();
        $("#isproduct").hide();
    });

</script>