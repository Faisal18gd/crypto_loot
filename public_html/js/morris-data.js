$(function() {
  // Create a function that will handle AJAX requests
  function requestData(days, chart){
    $.ajax({
      type: "GET",
      url: window.location.origin+'/admin/chart', // This is the URL to the API
      data: { days: days }
    })
    .done(function( data ) {
      // When the response to the AJAX request comes back render the chart with new data
      chart.setData(JSON.parse(data));
    });
    //.fail(function() {
      // If there is no communication between the server, show an error
      //alert( "error occured" );
    //});
  }
  var chart = Morris.Bar({
    // ID of the element in which to draw the chart.
    element: 'morris-area-chart',
    // Set initial data (ideally you would provide an array of default data)
    data: [0,0],
    xkey: 'date',
    ykeys: ['value'],
    labels: ['Users'],
	hideHover: 'auto',
    resize: true
  });
  // Request initial data for the past 7 days:
  requestData(30, chart);
  $('ul.ranges a').click(function(e){
    e.preventDefault();
    // Get the number of days from the data attribute
    var el = $(this);
    days = el.attr('data-range');
    // Request the data and render the chart using our handy function
    requestData(days, chart);
    // Make things pretty to show which button/tab the user clicked
    el.parent().addClass('active');
    el.parent().siblings().removeClass('active');
  })
});