                </article>
<?php include("elements/sidebar.php"); ?>
            </section>
        </div>
        <div id="page-footer">
            <footer class="container row">
                <div class='center'>
                    Current Version: <a href='/about/version'>5.4.4</a><br/>
                    Copyright © 2008 - <?=date('Y');?> <a href='//www.hackthis.co.uk'>hackthis.co.uk</a> || Icons: <a href='http://fortawesome.github.io/Font-Awesome/'>Font Awesome</a>
                </div>
                <br/>
                <span class='strong'>Disclaimer:</span><br/>
                The owner of this site does not accept responsibility for the actions of any users of this site.
                Users are solely responsible for any content that they place on this site This site does not encourage or condone any illegal activity,
                or attempts to hack into any network where they do not have authority to do so. 
            </footer>
        </div>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="/files/js/jquery-1.9.1.min.js"><\/script>')</script>
        <?= $minifier->load("js"); ?>

        <script>
            var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src='//www.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>
    </body>
</html>