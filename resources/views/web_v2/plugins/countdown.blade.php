<script>
  $(function(){
    $('.countdown').startTimer({
      onComplete: function(){
      	location.reload();
      }
    });
  });
</script>