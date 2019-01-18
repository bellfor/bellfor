$(function(){var widthScreen=window.innerWidth||document.documentElement.clientWidth||document.body.clientWidth;if(widthScreen<=990){$('.card').imagezoomsl({zoomrange:[6,6],magnifiersize:[350,350],innerzoom:true});}else{$('.card').imagezoomsl({zoomrange:[6,6],magnifiersize:[350,350]});}$('.toggle-mnu').click(function(){$(this).toggleClass('on');$(".top-menu").slideToggle();});$(function(){$('[data-toggle="tooltip"]').tooltip()})
$(".wrap_small_card").hover(function(){var curentPathImg=$(this).find("img").attr('data-large');popapImg(curentPathImg,$(this).find("img"));$('.card').attr('data-large',curentPathImg);$('.card').attr('src',curentPathImg);});function popapImg(curentPathImg,classImg){classImg.magnificPopup({items:[{src:curentPathImg},],gallery:{enabled:true},type:'image'});}$(".wrap_small_card").click(function(){var curentPathImg=$(this).find("img").attr('data-large');$('.card').attr('data-large',curentPathImg);$('.card').attr('src',curentPathImg);});});

// Bellfor Modal Cookie

// $(document).ready(function(){
//
//   // Animation with modal
//   $('#cookie').animate({top: '1px'}, 2000);
//
//   // Cookie
//    function getCookie(bellforCookie) {
//         let cookie_arr = document.cookie.split('; ');
//         let cookie_obj = {};
//
//         for (let i=0; i<cookie_arr.length; i++) {
//             let nv = cookie_arr[i].split('=');
//             cookie_obj[nv[0]] = nv[1];
//         }
//
//         return cookie_obj[bellforCookie];
//     }
//
//     let cookie_div = document.getElementById('cookie');
//
//     if ( getCookie('agree') == 'yes' ) {
//         cookie_div.style.display='none';
//     }
//
//     document.getElementById('agree')
//         .addEventListener('click', function() {
//
//             var date = new Date(new Date().getTime() + (86400 * 60 * 60 * 1000));
//             document.cookie = "agree=yes; path=/; expires=" + date.toGMTString();
//
//             $('#cookie').fadeOut(1000);
//         });
//
//   $('#notAgree').click(function(){
//     $('#cookie').fadeOut(1000);
//   });
//
// });



// Modal Video AutoPlay

$('.modal-video').on('hidden.bs.modal', function (e) {
    $('.modal-video iframe').attr('src', $('.modal-video iframe').attr('src'));
  });


autoPlayYouTubeModal();

  //FUNCTION TO GET AND AUTO PLAY YOUTUBE VIDEO FROM DATATAG
  function autoPlayYouTubeModal() {
      var trigger = $("body").find('[data-the-video]');
      trigger.click(function () {
          var theModal = $(this).data("target"),
              videoSRC = $(this).attr("data-the-video"),
              videoSRCauto = videoSRC + "&autoplay=1";
          $(theModal + ' iframe').attr('src', videoSRCauto);
          $(theModal + ' button.close').click(function () {
              $(theModal + ' iframe').attr('src', videoSRC);
          });
          $('.modal-video').click(function () {
              $(theModal + ' iframe').attr('src', videoSRC);
          });
      });
  }

$(window).on('load resize', function(){
  var $window = $(window);
  $('.modal-fill-vert .modal-body > *').height(function(){
      return $window.height()-60;
  });
}); 