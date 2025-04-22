// An array of highlighting dates ( 'mm-dd-yyyy' )
var highlight_dates = ['4-12-2020','4-15-2020','4-16-2020','4-17-2020', '5-12-2020','5-15-2020','5-16-2020','5-17-2020','6-12-2020','6-15-2020','6-16-2020','6-17-2020'];
 
 $(function() {
 // Initialize datepicker
 $('#DatePicker').datepicker({
   inline: true,
   altField: '#datepicker_field',
  beforeShowDay: function(date){
   var month = date.getMonth()+1;
   var year = date.getFullYear();
   var day = date.getDate();
 
   // Change format of date ( 'mm-dd-yyyy' )
   var newdate = month+"-"+day+'-'+year;

   // Set tooltip text when mouse over date
   var tooltip_text = "Available on " + newdate;

   // Check date in Array
   if(jQuery.inArray(newdate, highlight_dates) != -1){
    return [true, "highlight", tooltip_text ];
   }
   return [true];
  }
 });
 });

$('#datepicker_field').on('change', function() {
    $('#DatePicker').datepicker('setDate', $(this).val());
});