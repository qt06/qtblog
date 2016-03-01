<? include 'header.php'; ?>
    <!-- Page Header -->
    <!-- Set your background image for this header on the line below. -->
    <header class="intro-header" style="background-image: url('img/post-bg.jpg')">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="post-heading">
                        <h1><?=$blog['title']?></h1>
                        <h2 class="subheading"></h2>
                        <span class="meta">发布于 <?=date("Y-m-d", $blog['created'])?></span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Post Content -->
    <article>
        <div class="container" role="main">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
<?=$blog['text']?>
                </div>
            </div>
        </div>
    </article>
<? include 'footer.php'; ?>