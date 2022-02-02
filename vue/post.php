<body>
    <div id="postModal" tabindex="-1" role="dialog">
        <div id="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">�</button>
                    Update Status
                </div>
                <div class="modal-body">
                    <form class="form center-block">
                        <div class="form-group">
                            <textarea id="message" class="form-control input-lg" autofocus="" placeholder="Write something..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div>
                        <form action="" method="POST">
                            <button class="btn btn-primary btn-sm" name="action" value="publish" data-dismiss="modal">Publish</button>
                            <button class="btn btn-primary btn-sm" name="action" value="boostPost" data-dismiss="modal">Boost Post</button>
                            <ul class="pull-left list-inline">
                                <li><a href=""><i><input type="file" class="glyphicon glyphicon-picture" accept="image/png, image/jpeg, image/jpg" multiple="multiple"></i></a></li>
                                <li><a href=""><i class="glyphicon glyphicon-user"></i></a></li>
                                <li><a href=""><i class="glyphicon glyphicon-map-marker"></i></a></li>
                                <li><a href=""><i class="glyphicon glyphicon-folder-open"></i></a></li>
                            </ul>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>