<?php include_once "../wp-load.php"; ?>
<!DOCTYPE html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <META name="robots" content="noindex, nofollow">
    <title>Old Posts - <?php echo get_bloginfo("name"); ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./styles.css?ver=1.0.2">
</head>
<body>
    <main class="container">
        <header class="page-header">
            <h1><?php echo get_bloginfo("name"); ?> - Old Posts</h1>
            <h2>Just pick a category</h2>
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
                    print_r($category->name . " (" . $category->category_count . ")");


                    echo "</a></li>";
                }
                ?>
            </ul>
        </nav>

        <section class="list">
            <?php if (isset($_GET["category"]) && $_GET["category"] != "") {
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
                            <?php
                            // get the attachments type image
                            $attachments = get_children([
                                "post_parent" => $post->ID,
                                "numberposts" => $repeat,
                                "post_type" => "attachment",
                                "post_mime_type" => "image",
                            ]);

                            $image = "";

                            // get the attachments
                            foreach ($attachments as $att_id => $attachment) {
                                // put the image in a array
                                $image = wp_get_attachment_image_src(
                                    $att_id,
                                    "thumbnail"
                                );

                                // I just want 1 image, so break
                                break;
                            }
                            echo '<a target="_blank" href="' .
                                $image[0] .
                                '" title="' .
                                get_the_title() .
                                '">';
                            echo "<img src='" .
                                $image[0] .
                                "' alt='" .
                                get_the_title() .
                                "' />";
                            echo "</a>";
                            ?>
                        </article>
                    <?php
            endforeach;
        } ?>
    </main>
</body>
</html>
