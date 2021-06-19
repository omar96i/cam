$(document).ready(function() {


    $(document).on('click', '.dropdown-menu', function (e) {
      e.stopPropagation();
    });


	//////////////////////// Bootstrap tooltip
	if($('[data-toggle="tooltip"]').length > 0) {  // check if element exists
		$('[data-toggle="tooltip"]').tooltip()
	} 
    
    

}); 


