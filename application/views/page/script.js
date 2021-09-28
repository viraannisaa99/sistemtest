$(function() {
    var oTable = $('#datatable').DataTable({
      "oLanguage": {
        "sSearch": "Filter Data"
      },
      "iDisplayLength": -1,
      "sPaginationType": "full_numbers",
  
    });
  
    $("#datepicker_from").datepicker({
      showOn: "button",
      buttonImage: "images/calendar.gif",
      buttonImageOnly: false,
      "onSelect": function(date) {
        minDateFilter = new Date(date).getTime();
        oTable.fnDraw();
      }
    }).keyup(function() {
      minDateFilter = new Date(this.value).getTime();
      oTable.fnDraw();
    });
  
    
  
  });
  
  // Date range filter
  minDateFilter = "";
  maxDateFilter = "";
  
  $.fn.dataTableExt.afnFiltering.push(
    function(oSettings, aData, iDataIndex) {
      if (typeof aData._date == 'undefined') {
        aData._date = new Date(aData[0]).getTime();
      }
  
      if (minDateFilter && !isNaN(minDateFilter)) {
        if (aData._date < minDateFilter) {
          return false;
        }
      }
  
      
  
      return true;
    }
  );