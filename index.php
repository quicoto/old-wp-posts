<?php include_once("../wp-load.php"); ?>
<!DOCTYPE html>
<html class="no-js">
    <head>
        <meta charset="utf-8">
        <META name="robots" content="noindex, nofollow">
        <title>Old Posts - Quicoto Blog</title>
        <meta name="description" content="">
	    <meta name="viewport" content="width=device-width">
	    <link rel='stylesheet' href='css/bootstrap.min.css' type='text/css' media='all' />
   	    <link rel='stylesheet' href='css/bootstrap-responsive.min.css' type='text/css' media='all' />
        <style>
			.span4{
				width: 300px;
			}
			.well{
				height: 273px;
				text-align: center;
			}

			.container{
				width: 95%;
			}
			img{
				padding:10px 0px;
			}

			textarea{
				width: 100%;
			}
        </style>

    </head>
    <body>

     <div class="container">
      <div class="page-header">
        <h1>Quicoto Blog Old Posts</h1>
            <h2>Just pick a category</h2>
      </div>


	   <ul class="nav nav-tabs">
	      	<?php $categories = get_categories( 'exclude=3,78,122,9,112,12,14,28,111,83,,29,,146,121' );

				foreach	($categories as $category){

					$class = '';

					if($category->cat_ID == $_GET['category']) $class='class="active"';

					echo '<li '.$class.'><a href="index.php?category='.$category->cat_ID.'">';
						print_r($category->name);
					echo '</a></li>';
				}
			?>
	    </ul>

      <div class="row">
      	<?php if(isset($_GET['category']) && $_GET['category'] != ""){ ?>
				<?php
				global $post;
				$tmp_post = $post;

				$args = array(
			    'numberposts'     => 25,
			    'offset'          => 0,
			    'category'        => $_GET['category'],
			    'orderby'         => 'rand',
			    'order'           => 'DESC',
			    'post_type'       => 'post',
			    'post_status'     => 'publish',
			    'suppress_filters' => true );

				$myposts = get_posts( $args );
				foreach( $myposts as $post ) : setup_postdata($post); ?>
					<div class="span4">
						<div class="well">
							<h4><a target="_blank" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h4>
							<div class="date"><?php the_date(); ?></div>

							<?php

								   // get the attachments type image
							      $attachments = get_children( array(
							                'post_parent' => $post->ID,
							                'numberposts' => $repeat,
							                'post_type' => 'attachment',
							                'post_mime_type' => 'image')
							                );

							        $image = "";

							        // get the attachments
							        foreach ( $attachments as $att_id => $attachment ) {

							            // put the image in a array
							            $image = wp_get_attachment_image_src($att_id, 'thumbnail');

							            // I just want 1 image, so break
							            break;
							        }
										echo '<a target="_blank" href="'. $image[0] . '" title="' .  get_the_title() . '">';
										echo "<img src='". $image[0] ."' style='width:150px;' />";
										echo '</a>';

							?>
							<p>
								<textarea><?php the_title(); ?> <?php the_permalink(); ?></textarea>
							</p>
						</div>
					</div>
				<?php endforeach;

					curl_close($ch);
				?>
		<?php } ?>
      </div>

  </body>
</html>
