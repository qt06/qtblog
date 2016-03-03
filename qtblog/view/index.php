<? include 'header.php'; ?>
    <!-- Page Header -->
    <!-- Set your background image for this header on the line below. -->
    <header class="intro-header" style="background-image: url('<?=$conf['appurl']?>qtblog/view/img/home-bg.jpg')">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="site-heading">
                        <h1><?=$conf['appname']?></h1>
                        <hr class="small">
                        <span class="subheading"><?=$conf['description']?></span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container" role="main">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
<? foreach($bloglist as $blog) { ?>
                <div class="post-preview">
                    <a href="<?=$conf['appurl']?>post/<?=$blog['cid']?>/">
                        <h2 class="post-title">
<?=$blog['title']?>
                        </h2>
                    </a>
                    <p class="post-meta">时间： <?=date("Y-m-d", $blog['created'])?> 浏览：<?=$blog['views']?></p>
                </div>
                <hr>
<? } ?>

                <!-- Pager -->
<?=$pager?>
            </div>
        </div>
    </div>
<? include 'footer.php'; ?>