	</div><!-- #content -->
		<footer>
			<div class="container">
				<div class="row">
					<div class="copywrite col-xs-12 ff-serif fs-18">
						&copy;&nbsp;<span><?php echo date('Y');?></span>
					</div>
				</div><!-- .row -->
			</div><!-- .container -->
		</footer>
	</div><!-- #page -->
</body>

<!-- SCRIPTS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="inc/typed/js/typed.js"></script>
<script src="inc/jquery-match-height/jquery.matchHeight.js" type="text/javascript"></script>

<!-- SECTION SCROLL -->
<script>
	$('.menu-item a').on('click', function(event){
		//event.preventDefault();
		var hash = this.hash;
		$('html, body').animate({
			scrollTop: $(hash).offset().top
			}, 600);
			$('.navbar-collapse').collapse('hide');
		return false;
	});
	$('.down').on('click', function(event){
		$('html, body').animate({
			scrollTop: $('#me').offset().top
			}, 600);
		return false;
	});
</script>

<!-- Match Height -->
<script>
	$(function() {
		$('.mock').matchHeight();
	});
</script>

<!-- NAV MENU COLLAPSE 
<script>
$(document).on('click','.navbar-collapse.in',function(e) {
    if( $(e.target).is('a') && $(e.target).attr('class') != 'dropdown-toggle' ) {
        $(this).collapse('hide');
    }
});
</script>

<!-- MOCK LINKS -->
<script>
	$('.mock:not(:last-of-type)').click(function(){
		link = $(this).find('a').attr('href');
		window.open(link, '_blank');
		return false;
	});
	$('.mock:last-of-type').click(function(){
		link = $(this).find('a').attr('href');
		window.open(link,'_self');
		return false;
	});
</script>

<!-- TYPED -->
<script>
	$(function(){
        $("#typed").typed({
            strings: [
            	"Hi.",
				"Hello.",
				"Bonjour.",
				"Hola.",
				"Hallo.",
				"Ciao.",
				"Namaste.",
				"Konnichiwa.",
				"Zdravstvuyte.",
				"Ni Hau.",
				"Përshëndetje.",
				"Hei.",
				"Halló.",
				"Ahoj.",
				"Aloha."
			],
            typeSpeed: 80,
            backDelay: 4000,
            loop: true
        });
    });
</script>

<!-- PROGRESS BAR -->
<script>
$(document).on('ready', function() {  
  var winHeight = $(window).height(), 
      docHeight = $(document).height(),
      progressBar = $('progress'),
      max, value;

  /* Set the max scrollable area */
  max = docHeight - winHeight;
  progressBar.attr('max', max);

  $(document).on('scroll', function(){
     value = $(window).scrollTop();
     progressBar.attr('value', value);
  });
});
</script>

</html>