<?php
    $custom_css = array('articles.scss', 'highlight.css');
    $custom_js = array('articles.js', 'highlight.js');
    define("_SIDEBAR", false);
    define('PAGE_PUBLIC', true);

    require_once('init.php');

    $review = false;
    if (isset($_GET['slug'])) {
        $myArticle = false;
        // check if it is a category
        $category = $app->articles->getCategory($_GET['slug']);
        if ($category) {
            include('index.php');
            die();
        }

        $article = $app->articles->getArticle($_GET['slug']);
    } else if (isset($_GET['id'])) {
        $myArticle = true;
        $id = preg_replace('/[^0-9]*/','',$_GET['id']);
        if (!$id) {
            header('Location: /articles');
            die();
        }
        $article = $app->articles->getMyArticle($id);

        if ($article->user_id != $app->user->uid || $app->user->admin_site_priv)
            $review = true;
    }

    if ($article)
        $app->page->title = $app->parse($article->title, false);
    else
        $app->page->title = 'Articles';

    require_once('header.php');
?>
                    <section class="row">
<?php
    include('elements/sidebar_article.php');
?>    
                        <div class="col span_18 article-main">
<?php
    if (!isset($article) || !$article):
?>
                            <div class='msg msg-error'>
                                <i class='icon-error'></i>
                                Article not found
                            </div>
<?php
    else:

        if ($myArticle):
            if ($article->note):
?>
                            <div class='msg msg-error'>
                                <i class='icon-error'></i>
                                Article declined: <?=$app->parse($article->note, false);?>
                            </div>
<?php
            else:
?>            
                            <div class='msg msg-info'>
                                <i class='icon-info'></i>
                                This article is awaiting review
                            </div>
<?php
            endif;
        endif;

        $article->title = $app->parse($article->title, false);
        $article->body = $app->parse($article->body);
?>
                            <article class='bbcode body' itemscope itemtype="http://schema.org/Article">
                                <header class='title clearfix'>
<?php if ($myArticle): ?>
                                        <a href='/articles/me/submit.php?action=edit&id=<?=$id;?>' class='button icon right'><i class='icon-edit'></i></a>
<?php elseif ($app->user->admin_pub_priv): ?>
                                        <a href='/admin/articles.php?action=edit&slug=<?=$article->slug;?>' class='button icon right'><i class='icon-edit'></i></a>
<?php endif; ?>
<?php if ($review): ?>
                                        <a href='#' class='right button'><i class='icon-cross'></i> Decline</a>
                                        <a href='/admin/articles.php?accept=<?=$article->id;?>' class='right button'><i class='icon-tick'></i> Accept</a>
<?php endif; ?>
                                    <h1 itemprop="name"><?=$article->title;?></h1>
                                    <time itemprop='datePublished' pubdate datetime="<?=date('c', strtotime($article->submitted));?>"><?=$app->utils->timeSince($article->submitted);?></time>
<?php if (isset($article->updated) && $article->updated > 0): ?>
                                    &#183; updated <time itemprop='dateModified' datetime="<?=date('c', strtotime($article->updated));?>"><?=$app->utils->timeSince($article->updated);?></time>
<?php endif; ?>
<?php if (isset($article->cat_title)): ?>
                                    &#183; <a href='<?=$article->cat_slug;?>'><?=$article->cat_title;?></a>
<?php endif; ?>
<?php if (isset($article->username)): ?>
                                    &#183; <a rel='author' itemprop='author' href='/user/<?=$article->username;?>'><?=$article->username;?></a>
<?php endif; ?>

                                    <?php
                                        if (!$myArticle) {
                                            $share = new stdClass();
                                            $share->item = $article->id;
                                            $share->right = true;
                                            $share->comments = $article->comments;
                                            $share->title = $article->title;
                                            $share->link = "/articles/{$article->slug}";
                                            $share->favourites = $article->favourites;
                                            $share->favourited = $article->favourited;
                                            include("elements/share.php");
                                            echo '<meta itemprop="interactionCount" content="UserComments:'.$share->comments.'"/>';
                                        }
                                    ?>
                                </header>

<?php
    $matches = $app->articles->getTOC($article->body);
    if (count($matches[0])):
?>
                                <div class="right contents">
                                    <h2>Contents</h2>
                                    <ul>
<?php
    $i = 0;
    foreach($matches[2] as $match) {
        $c = '>';
        if ($matches[1][$i] == '2')
        $c = " class='sub'>- ";

        $slug = $app->utils->generateSlug($match);

        echo "<li{$c}<a href='#{$slug}'>{$match}</a></li>";
        $i++;
    }

    echo "<li><a href='#comments'>Comments</a></li>";
?>
                                    </ul>
                                </div>
<?php
    endif; 
    
    $article->body = $app->articles->setupTOC($article->body);
?>
                                <meta itemprop="wordCount" content="<?=str_word_count($article->body);?>"/>
                                <div itemprop='articleBody'>
<?php
    echo $article->body;
?>
                                </div>
                            </article>
<?php
        if (!$myArticle) {
            $comments = array("id"=>$article->id,"title"=>$article->title,"count"=>$article->comments);
            include('elements/comments.php');
        }
    endif;
?>
                        </div>
                    </section>

<?php
    if (isset($article->next) && $article->next):
?>
                    <a href='<?=$article->next->uri;?>' class='article-suggest'>
                        Next article<Br/>
                        <span><?=$article->next->title;?></span>
                    </a>
<?php
    endif;

    require_once('footer.php');
?>           