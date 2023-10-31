<?php
/*
Plugin Name: Latest Comments Widget
Description: Display the latest comments across the site.
*/

class Latest_Comments_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'latest_comments_widget',
            'Latest Comments Widget',
            array( 'description' => 'Display the latest comments across the site.' )
        );
    }

    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] );
        $num_comments = isset( $instance['num_comments'] ) ? $instance['num_comments'] : 5;
		echo '<style>
            .latest-comments-widget ul {
                list-style: none;
                padding: 0;
            }

            .latest-comments-widget li {
                margin-bottom: 10px;
            }

            .latest-comments-widget a {
                text-decoration: none;
                font-weight: bold;
            }

            @media only screen and (max-width: 768px) {
                .latest-comments-widget li {
                    font-size: 14px;
                }
            }
        </style>';

        echo $args['before_widget'];
        // ... (Rest of the widget output code)
        echo $args['after_widget'];
    }

    // ... (Rest of the widget methods and functions)
}


        echo $args['before_widget'];
        if ( ! empty( $title ) ) {
            echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
        }

        $comments = get_comments( array(
            'number'      => $num_comments,
            'status'      => 'approve', // Only approved comments
            'post_status' => 'publish', // Only published posts
        ) );

        echo '<ul>';
        foreach ( $comments as $comment ) {
            $comment_excerpt = strlen( $comment->comment_content ) > 50 ? substr( $comment->comment_content, 0, 50 ) . '...' : $comment->comment_content;
            echo '<li><a href="' . esc_url( get_comment_link( $comment ) ) . '">' . esc_html( get_comment_author( $comment ) ) . '</a>: ' . esc_html( $comment_excerpt ) . '</li>';
        }
        echo '</ul>';

        echo $args['after_widget'];
    }

    public function form( $instance ) {
    $title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
    $num_comments = isset( $instance['num_comments'] ) ? absint( $instance['num_comments'] ) : 5;
    ?>
    <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id( 'num_comments' ); ?>">Number of comments to display:</label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'num_comments' ); ?>" name="<?php echo $this->get_field_name( 'num_comments' ); ?>" type="number" min="1" value="<?php echo $num_comments; ?>" />
    </p>
    <?php
}


    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
        $instance['num_comments'] = ( ! empty( $new_instance['num_comments'] ) ) ? absint( $new_instance['num_comments'] ) : 5;

        return $instance;
    }
}

function register_latest_comments_widget() {
    register_widget( 'Latest_Comments_Widget' );
}
add_action( 'widgets_init', 'register_latest_comments_widget' );
