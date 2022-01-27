<div class="modal-footer">
				  <div>
				  <button class="btn btn-primary btn-sm" data-dismiss="modal" aria-hidden="true">Publish</button>
				  <button class="btn btn-primary btn-sm" data-dismiss="modal" aria-hidden="true">Boost Post</button>
					<ul class="pull-left list-inline"><li><a href=""><i class="glyphicon glyphicon-picture"></i></a></li><li><a href=""><i class="glyphicon glyphicon-user"></i></a></li><li><a href=""><i class="glyphicon glyphicon-map-marker"></i></a></li><li><a href=""><i class="glyphicon glyphicon-folder-open"></i></a></li></ul>
				  </div>	
			  </div>
		  </div>
		  </div>
		</div>
        
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