
<script type="text/javascript" src="assets/js/jquery.js"></script>
<script type="text/javascript" src="assets/js/bootstrap.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('[data-toggle=offcanvas]').click(function() {
			$(this).toggleClass('visible-xs text-center');
			$(this).find('i').toggleClass('glyphicon-chevron-right glyphicon-chevron-left');
			$('.row-offcanvas').toggleClass('active');
			$('#lg-menu').toggleClass('hidden-xs').toggleClass('visible-xs');
			$('#xs-menu').toggleClass('visible-xs').toggleClass('hidden-xs');
			$('#btnShow').toggle();
		});
	});
</script>
</body>

</html>