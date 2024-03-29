<?php include_once "../wp-load.php"; ?>
<!DOCTYPE html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <META name="robots" content="noindex, nofollow">
    <title>Old Posts - <?php echo get_bloginfo("name"); ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./styles.css?ver=1.0.4">
</head>
<body>
    <main class="container">
        <header class="page-header">
            <h1><?php echo get_bloginfo("name"); ?> - Old Posts</h1>
        </header>

        <nav>
            <ul class="nav nav-tabs">
                <?php
                $categories = get_categories(
                    "exclude=3,78,122,9,112,12,14,28,111,83,29,146,121"
                );

                foreach ($categories as $category) {
                    $class = "";

                    if ($category->cat_ID == $_GET["category"]) {
                        $class = 'class="active"';
                    }

                    echo "<li " .
                        $class .
                        '><a href="index.php?category=' .
                        $category->cat_ID .
                        '">';
                    print_r(
                        $category->name . " (" . $category->category_count . ")"
                    );

                    echo "</a></li>";
                }
                ?>
            </ul>
        </nav>

        <?php if (isset($_GET["category"]) && $_GET["category"] != "") {
            $category_name = get_cat_name($_GET["category"]);
            echo "<h2>Category: " . $category_name . "</h2>";
        ?>
        <section class="list">
            <?php
                global $post;
                $tmp_post = $post;

                $args = [
                    "numberposts" => 25,
                    "offset" => 0,
                    "category" => $_GET["category"],
                    "orderby" => "rand",
                    "order" => "DESC",
                    "post_type" => "post",
                    "post_status" => "publish",
                    "suppress_filters" => true,
                ];

                $myposts = get_posts($args);
                foreach ($myposts as $post):
                    setup_postdata($post); ?>
                        <article>
                            <header>
                                <h3>
                                    <a target="_blank" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                                </h3>
                                <span class="date"><?php the_date(); ?></span>
                            </header>

                            <?php if (has_post_thumbnail()) {
                                the_post_thumbnail();
                            } ?>
                        </article>
                    <?php
                endforeach; ?>
        </section>
        <?php    } ?>
    <footer>
        <a href="https://github.com/quicoto/old-wp-posts">GitHub</a>
    </footer>
    </main>
</body>
</html>
