 
// javascript code for autocomplete function
$(function() {
  // set up the autocomplete functionality on the input field with ID "searchProductsAdmin"
  $('#searchProductsAdmin').autocomplete({
    // function is called when the user types in the input field and triggers the autocomplete
    source: function(request, response) {
      // send an AJAX request to the server to retrieve product data that matches the user's input
      $.ajax({
        url: "<?php echo get_bloginfo('template_directory'); ?>/eshop/admin_product_autofill_search.php",
        dataType: 'json',
        data: {
          term: request.term
        },
        // function is called when the server returns the product data
        success: function(data) {
          // map the product data to an array of objects that have a "label" and "value" property
          response($.map(data, function(item) {
            return {
              label: item.Produktnamn,
              value: item.Produktnamn
            }
          }));
        }
      });
    },
    // the minimum number of characters the user must type to trigger the autocomplete
    minLength: 2
  });
});

// javascript code for AJAX live search function
// code block runs when the document is ready
$(document).ready(function(){
  // function is called when the user types in the search input field
  $("#searchProductsAdmin").keyup(function(){
    // Get the value of the search input field
    var queryProductSearch = $(this).val();

    // Check if the search input field is not empty
    if(queryProductSearch != ''){
      // Send an AJAX request to the server to search for products
      $.ajax({
        // URL of the PHP script that will handle the search request
        url:"<?php echo get_bloginfo('template_directory'); ?>/eshop/searchAdminProducts.php",
        // Use the POST method to send the search query to the server
        method:"POST",
        data:{queryProductSearch:queryProductSearch},
        // This function is called when the server responds with data
        success:function(data){      
          // Replace the contents of the result div with the search results
          $("#result").html(data);
          // Show the search result div
          $("#result").show();
          // Hide the default product div
          $('#default').hide();
        }
        });
        }
          // If the search input field is empty
          else {
          // Show the default product div
          $('#default').show();
          // Hide the search results div
          $("#result").hide();
    }
  });
});