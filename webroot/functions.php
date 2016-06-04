<script>
      function fetch_select(val)
    {
        $.ajax({
            type: 'post',
            url: '../ajax_search_functions.php',
            data: {
                tag:val
            },
            success: function (response) {
                document.getElementById('box').innerHTML=response;
            }
        });
    }
</script>


