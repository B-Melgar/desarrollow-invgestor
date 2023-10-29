function ok() {
    $('#withCredit:checkbox').bind('change', function(e) {
      if ($(this).is(':checked')) {
        alert('Checked');
      }
      else {
        alert('Unchecked');
      }
    })
  };