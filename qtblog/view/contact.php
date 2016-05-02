<? include 'header.php'; ?>
    <!-- Page Header -->
    <!-- Set your background image for this header on the line below. -->
    <header class="intro-header" style="background-image: url('<?=$conf['appurl']?>qtblog/view/img/contact-bg.jpg')">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="page-heading">
                        <h1>联系我</h1>
                        <hr class="small">
                        <span class="subheading">您有什么问题吗？请联系我，我会尽力。</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container" role="main">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <p>请您填写下面的表格，我会尽可能在24小时内回复您。</p>
                <form method="post" action="/contact/send/" name="sentMessage" id="contactForm" novalidate>
                    <div class="row control-group">
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label for="name">姓名</label>
                            <input type="text" class="form-control" placeholder="您的姓名" id="name" name="name" required data-validation-required-message="请填写您的姓名。">
                            <p class="help-block text-danger"></p>
                        </div>
                    </div>
                    <div class="row control-group">
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label for="email">邮件地址</label>
                            <input type="email" class="form-control" placeholder="您的电子邮件地址" id="email" name="email" required data-validation-required-message="请填写您的电子邮件地址。">
                            <p class="help-block text-danger"></p>
                        </div>
                    </div>
                    <div class="row control-group">
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label for="phone">手机号码</label>
                            <input type="tel" class="form-control" placeholder="手机号码" id="phone" name="phone" required data-validation-required-message="请填写您的手机号码。">
                            <p class="help-block text-danger"></p>
                        </div>
                    </div>
                    <div class="row control-group">
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label for="message">您想说的话</label>
                            <textarea rows="5" class="form-control" placeholder="您想说的话……" id="message" name="message" required data-validation-required-message="请填写您想说的话。"></textarea>
                            <p class="help-block text-danger"></p>
                        </div>
                    </div>
                    <br>
                    <div id="success"></div>
                    <div class="row">
                        <div class="form-group col-xs-12">
                            <button type="submit" class="btn btn-default">发送</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<? include 'footer.php'; ?>
