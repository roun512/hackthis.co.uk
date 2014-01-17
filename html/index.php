<?php
    define("PAGE_PUBLIC", true);
    define("LANDING_PAGE", true);

    require_once('init.php');

    // Set canonical link
    $app->page->canonical = "https://www.hackthis.co.uk";

    if (isset($_GET['api']) && isset($_GET['key'])) {
        header("Content-type: text/plain");
        
        // Make call to api
        try {
            $api = new api($app, $_GET['key']);
            $api->process();
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        die();
    }

    if ($app->user->loggedIn || !$app->user->loggedIn) {
        require_once("home.php");
    } else {
        define("_SIDEBAR", false);

        require_once('header.php');
?>
                <div class='row header'>
                    <img src="/files/images/logo_landing.png" alt="HackThis!! - The hackers playground">
                </div>
<?php
        if (isset($_GET['deleted'])) {
            $app->utils->message('Your account has been successfully deleted. Painful though parting be, I bow to you as I see you off to distant clouds. ', 'info');
        }
?>
                <div class='center row'>
                    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                    <!-- landing_header -->
                    <ins class="adsbygoogle"
                         style="display:inline-block;width:728px;height:90px"
                         data-ad-client="ca-pub-1120564121036240"
                         data-ad-slot="9555223615"></ins>
                    <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                </div>

                <div class='row landing_blurb'>
                    <h1>Want to learn about hacking and network security? Discover how hacks, dumps and defacements are performed and secure your website against hackers with HackThis!!</h1>
                </div>
                <div class='row landing'>
                    <div class='col span_15'>
                        <section class='row fluid features'>
                            <div class='clr'>
                                <div class='col span_5'>
                                    <div class='circle'><i class='icon-flag'></i></div>
                                </div>
                                <div class='col span_19'>
                                    <h2>Challenges</h2>
                                    <span class='blurb'>
                                        <strong class='white'>Test your skills with 40+ hacking levels, covering all aspects of security.</strong><br/>Each level is hand coded with help available at every stage.
                                    </span>
                                </div>
                            </div>
                            <div class='clr'>
                                <div class='col span_5'>
                                    <div class='circle'><i class='icon-domain2'></i></div>
                                </div>
                                <div class='col span_19'>
                                    <h2>Community</h2>
                                    <span class='blurb'>
                                        <strong class='white'>Join in the discussion with 150,000+ like-minded members.</strong><br/>
                                        Need a hint? Want to talk about the latest cracking software tool?
                                    </span>
                                </div>
                            </div>
                            <div class='clr'>
                                <div class='col span_5'>
                                    <div class='circle'><i class='icon-insertpictureleft'></i></div>
                                </div>
                                <div class='col span_19'>
                                    <h2>Articles</h2>
                                    <span class='blurb'>
                                        <strong class='white'>Learn from our online collection of articles.</strong><br/>
                                        Learn from our collection of articles covering all aspects of security and technology.
                                    </span>
                                </div>
                            </div>
                        </section>
                        <div class="center" style="border-top: 1px solid #141414; padding-top: 25px; margin-top: 25px;">
                            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                            <!-- landing page -->
                            <ins class="adsbygoogle"
                                 style="display:inline-block;width:336px;height:280px"
                                 data-ad-client="ca-pub-1120564121036240"
                                 data-ad-slot="7541400418"></ins>
                            <script>
                            (adsbygoogle = window.adsbygoogle || []).push({});
                            </script>
                        </div>
                    </div>

<?php
        $visible = true;
        if (isset($_COOKIE["member"]) && $_COOKIE["member"])
            $visible = false;
        if (isset($_GET['login']))
            $visible = false;
        if (isset($_GET['register']))
            $visible = true;
?>
                    <div class='col span_9 registration'>
<?php
        if (isset($_GET['request'])):
?>
                        <div class='row'>
                            <?php include('elements/widgets/request.php'); ?>
                        </div>
<?php
        endif;
?>
                        <div class='row'>
                            <h2>Login</h2>
                            <?php include('elements/widgets/login.php'); ?>
                        </div>
                        <div class='row'>
                            <h2>Register</h2>
                            <?php include('elements/widgets/register.php'); ?>
                        </div>
                    </div>
                </div>
<?php

    }
    require_once('footer.php');
?>