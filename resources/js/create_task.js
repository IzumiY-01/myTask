require('./bootstrap');
$(function(){
    console.log("Hello Javascript!!");
    
    //
    var nodelist = document.getElementsByName( "due_pattern" ) ;
    
    console.log(nodelist);
    
    $('[name="due_pattern"]:radio').change( function() {
        if($('[id=due_pattern01]').prop('checked')){
            
            $('.text').fadeOut();
            $('.text01').fadeIn();
            
        } else if ($('[id=due_pattern02]').prop('checked')) {
            
            $('.text').fadeOut();
            $('.text02').fadeIn();
            
        } else if ($('[id=due_pattern03]').prop('checked')) {
        
            $('.text').fadeOut();
            $('.text03').fadeIn();
        
        }else if ($('[id=due_pattern04]').prop('checked')) {
            
            $('.text').fadeOut();
            $('.text04').fadeIn();
            
        }
    });
    
    $('[name="start_pattern"]:radio').change( function() {
        if($('[id=start_pattern01]').prop('checked')){
            
            $('.text00').fadeOut();
            $('.text05').fadeIn();
            
        } else if ($('[id=start_pattern02]').prop('checked')) {
            
            $('.text00').fadeOut();
            $('.text06').fadeIn();
            
        } else if ($('[id=start_pattern03]').prop('checked')) {
        
            $('.text00').fadeOut();
            $('.text07').fadeIn();
        
        }
    });
   

});

