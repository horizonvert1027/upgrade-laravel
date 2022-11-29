<button onclick="scrollFunctionBottom()" id="hulk"><i class="ion-chevron-down"></i></button>
 <button id="topbutton"><i class="ion-chevron-up" aria-hidden="true"></i></button>

<script type="text/javascript">

var btntop = $('#topbutton');

$(window).scroll(function() {
  if ($(window).scrollTop() > 300) {
    btntop.addClass('show');
  } else {
    btntop.removeClass('show');
  }
});

btntop.on('click', function(e) {
  e.preventDefault();
  $('html, body').animate({scrollTop:0}, '300');
});



const $hulk = $("#hulk");

const toggleHulk = () => {
  $hulk.toggleClass("is-active", $(window).scrollTop() > 200);
};

$hulk.on("click", function() {
  $("html, body").animate({ scrollTop: $(document).height() }, "slow");
});

$(window).on("scroll", toggleHulk);

    </script><?php /**PATH /home/admin/web/oyebesmartest.com/public_html/resources/views/admin/topbottom.blade.php ENDPATH**/ ?>