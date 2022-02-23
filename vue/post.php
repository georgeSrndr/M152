<body>
    <div id="postModal" tabindex="-1" role="dialog">
        <div id="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">�</button>
                    Update Status
                </div>
                <div class="modal-body">
                    <form action="#" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <textarea name="commentaire" id="commentaire" class="form-control input-lg" autofocus="" placeholder="Write something..."></textarea>
                        </div>
                </div>
                <div class="modal-footer">
                    <div>
                        <button class="btn btn-primary btn-sm" name="action" type="submit" value="publish">publish</button>
                        <input class="btn btn-primary btn-sm" name="action" type="submit" value="Boost Post">
                        <ul class="pull-left list-inline">
                            <li><i><input type="file" class="glyphicon glyphicon-picture" name="filesToUpload[]" accept="image/png, image/gif, image/jpeg" multiple></i></li>
                            <li><a href=""><i class="glyphicon glyphicon-user"></i></a></li>
                            <li><a href=""><i class="glyphicon glyphicon-map-marker"></i></a></li>
                            <li><a href=""><i class="glyphicon glyphicon-folder-open"></i></a></li>
                        </ul>
                        </form>
                    </div>
                </div>
                <?= $reponse ?>
            </div>
        </div>
    </div>
</body>