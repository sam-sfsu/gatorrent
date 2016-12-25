/**
 * Update dropdown menu when user selects an option. 
 * And saves the key value into the hidden input 'search_option' to be sent to the search function. 
 */
$(document).ready(function(e){
    $('.search-panel .dropdown-menu').find('a').click(function(e) {
    	e.preventDefault();
                var key = $(this).data('value');
		var concept = $(this).text();  
		$('.search-panel span#search_concept').text(concept);
                document.getElementById('search_option').value = key.toLocaleString();
                
	});
});
