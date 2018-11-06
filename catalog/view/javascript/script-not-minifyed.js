$(function() {
	var widthScreen = window.innerWidth
    	|| document.documentElement.clientWidth
    	|| document.body.clientWidth;
	if(widthScreen<=990){
		$('.card').imagezoomsl({ 
			zoomrange: [6, 6],
			magnifiersize: [350, 350],
			innerzoom: true	
		});
	} else {
		$('.card').imagezoomsl({ 
			zoomrange: [6, 6],
			magnifiersize: [350, 350]
		});
	}

    $('.toggle-mnu').click(function() {
        $(this).toggleClass('on');
        $(".top-menu").slideToggle();
    });
    
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

$( ".wrap_small_card" ).hover(function() {
	var curentPathImg = $( this ).find( "img" ).attr( 'data-large');
	popapImg(curentPathImg,$( this ).find( "img" ));
	$('.card').attr( 'data-large',curentPathImg);
	$('.card').attr( 'src',curentPathImg);
});

function popapImg(curentPathImg,classImg){
	classImg.magnificPopup({
	    items: [
	      {
	        src: curentPathImg
	      },
	    ],
	    gallery: {
	      enabled: true
	    },
	    type: 'image' // this is default type
	});
}

$(".wrap_small_card").click(function() {
  	var curentPathImg = $( this ).find( "img" ).attr( 'data-large');
	$('.card').attr( 'data-large',curentPathImg);
	$('.card').attr( 'src',curentPathImg);
});
      
       
});