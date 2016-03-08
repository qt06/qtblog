<? include 'header.php'; ?>
    <!-- Page Header -->
    <!-- Set your background image for this header on the line below. -->
    <header class="intro-header" style="background-image: url('<?=$conf['appurl']?>qtblog/view/img/contact-bg.jpg')">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="page-heading">
                        <h1>发布新文章</h1>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container" role="main">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <form method="post" action="pm/create/" name="post_create" id="post_create_form">
                    <div class="row control-group">
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label for="title">标题</label>
                            <input type="text" class="form-control" placeholder="请在这里填写文章标题" id="title" name="title" required />
                            <p class="help-block text-danger"></p>
                        </div>
                    </div>
                    <div class="row control-group">
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label for="tags">标签</label>
                            <input type="text" class="form-control" placeholder="请在这里填写标签，用空格分割多个" id="tags" name="tags" required />
                            <p class="help-block text-danger"></p>
                        </div>
                    </div>
                    <div class="row control-group">
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label for="text">内容</label>
                            <textarea rows="5" class="form-control" placeholder="请在这里填写文章内容" id="text" name="text" required></textarea>
                            <p class="help-block text-danger"></p>
                        </div>
                    </div>
                    <br>
                    <div id="success"></div>
                    <div class="row">
                        <div class="form-group col-xs-12">
                            <button type="submit" class="btn btn-default">发布</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<? include 'footer.php'; ?>
