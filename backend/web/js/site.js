jQuery('.show-form-search').click(function () {
    if (open) {
        jQuery('.search-form').css('display', 'block');
    }
    else {
        jQuery('.search-form').css('display', 'none');
    }
    open = !open;
});

$('#translation-owner_table').on('change', function() {
    $('#translation-form').submit();
  
})
