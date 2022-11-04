<?php
// Breadcrumbs
// https://gist.github.com/Dimox/5654092

if ( ! function_exists( 'dimox_breadcrumbs' ) ) {
	function dimox_breadcrumbs( ) {
		global $post, $royalConfig;

		$text['home']     = ( ! empty( $royalConfig['home-page-title'] ) ? $royalConfig['home-page-title'] : esc_html__( 'Home', 'royal' ) );
		$text['category'] = '%s';
		$text['search']   = esc_html__( 'Search Results for Query &ndash; %s', 'royal' );
		$text['tag']      = esc_html__( 'Posts Tagged &ndash; %s', 'royal' );
		$text['author']   = esc_html__( 'Articles Posted by %s', 'royal' );
		$text['404']      = esc_html__( 'Error 404', 'royal' );
		$text['page']     = esc_html__( 'Page', 'royal' );

		$show_current   = 1;
		$show_on_home   = 0;
		$show_home_link = 1;
		$show_title     = 1;
		$delimiter      = '';
		$before         = '<span>';
		$after          = '</span>';

		$home_link    = home_url( '/' );
		$link_before  = '<span typeof="v:Breadcrumb">';
		$link_after   = '</span>';
		$link_attr    = ' rel="v:url" property="v:title"';
		$link         = $link_before . '<a' . $link_attr . ' href="%1$s">%2$s</a>' . $link_after;
		$frontpage_id = get_option( 'page_on_front' );

		if ( $post !== null ) {
			$parent_id = $parent_id_2 = $post->post_parent;
		} else {
			$parent_id = false;
		}

		if ( is_home( ) || is_front_page( ) ) {
			if ( $show_on_home == 1 ) echo '<span class="breadcrumbs_list"><a href="' . esc_url( $home_link ) . '">' . esc_html( $text['home'] ) . '</a></span>';
		} else {
			echo '<span class="breadcrumbs_list" xmlns:v="http://rdf.data-vocabulary.org/#">';

			if ( $show_home_link == 1 ) {
				echo wp_specialchars_decode( $link_before ) . '<a href="' . esc_url( $home_link ) . '"' . $link_attr . '>' . esc_html( $text['home'] ) . '</a>' . wp_specialchars_decode( $link_after );

				if ( $frontpage_id == 0 || $parent_id != $frontpage_id ) {
					echo wp_specialchars_decode( $delimiter );
				}
			}

			if ( is_category( ) ) {
				$this_cat = get_category( get_query_var( 'cat' ), false );

				if ( $this_cat->parent != 0 ) {
					$cats = get_category_parents( $this_cat->parent, true, $delimiter );

					if ( $show_current == 0 ) {
						$cats = preg_replace( "#^(.+)$delimiter$#", "$1", $cats );
					}

					$cats = str_replace( '<a', $link_before . '<a' . $link_attr, $cats );
					$cats = str_replace( '</a>', '</a>' . $link_after, $cats );

					if ( $show_title == 0 ) {
						$cats = preg_replace( '/ title="(.*?)"/', '', $cats );
					}

					echo wp_specialchars_decode( $cats );
				}

				if ( $show_current == 1 ) {
					echo wp_specialchars_decode( $before ) . sprintf( $text['category'], single_cat_title( '', false ) ) . wp_specialchars_decode( $after );
				}
			} elseif ( is_search( ) ) {
				echo wp_specialchars_decode( $before ) . sprintf( $text['search'], get_search_query( ) ) . wp_specialchars_decode( $after );
			} elseif ( is_day( ) ) {
				echo sprintf( $link, esc_url( get_year_link( get_the_time( 'Y' ) ) ), esc_html( get_the_time( 'Y' ) ) ) . $delimiter;
				echo sprintf( $link, esc_url( get_month_link( get_the_time( 'Y' ),get_the_time( 'm' ) ) ), esc_html( get_the_time( 'F' ) ) ) . $delimiter;
				echo wp_specialchars_decode( $before ) . get_the_time( 'd' ) . wp_specialchars_decode( $after );
			} elseif ( is_month( ) ) {
				echo sprintf( $link, esc_url( get_year_link( get_the_time( 'Y' ) ) ), esc_html( get_the_time( 'Y' ) ) ) . $delimiter;
				echo wp_specialchars_decode( $before ) . get_the_time( 'F' ) . wp_specialchars_decode( $after );
			} elseif ( is_year( ) ) {
				echo wp_specialchars_decode( $before ) . get_the_time( 'Y' ) . wp_specialchars_decode( $after );
			} elseif ( is_single( ) && ! is_attachment( ) ) {
				if ( get_post_type( ) != 'post' ) {
					$post_type = get_post_type_object( get_post_type( ) );
					$slug = $post_type->rewrite;

					printf( $link, esc_url( $home_link . $slug['slug'] . '/' ), esc_html( $post_type->labels->singular_name ) );

					if ( $show_current == 1 ) {
						echo wp_specialchars_decode( $delimiter ) . wp_specialchars_decode( $before ) . get_the_title( ) . wp_specialchars_decode( $after );
					}
				} else {
					$cat = get_the_category( );
					$cat = $cat[0];

					$cats = get_category_parents( $cat, true, $delimiter );

					if ( $show_current == 0 ) {
						$cats = preg_replace( "#^(.+)$delimiter$#", "$1", $cats );
					}

					$cats = str_replace( '<a', $link_before . '<a' . $link_attr, $cats );
					$cats = str_replace( '</a>', '</a>' . $link_after, $cats );

					if ( $show_title == 0 ) {
						$cats = preg_replace( '/ title="(.*?)"/', '', $cats );
					}

					echo wp_specialchars_decode( $cats );

					if ( $show_current == 1 ) {
						echo wp_specialchars_decode( $before ) . get_the_title( ) . wp_specialchars_decode( $after );
					}
				}

			} elseif ( ! is_single( ) && ! is_page( ) && get_post_type( ) != 'post' && ! is_404( ) ) {
				$post_type = get_post_type_object( get_post_type( ) );

				echo wp_specialchars_decode( $before ) . $post_type->labels->singular_name . wp_specialchars_decode( $after );
			} elseif ( is_attachment( ) ) {
				$parent = get_post( $parent_id );
				$cat = get_the_category( $parent->ID );
				$cat = $cat[0];

				if ( $cat ) {
					$cats = get_category_parents( $cat, true, $delimiter );
					$cats = str_replace( '<a', $link_before . '<a' . $link_attr, $cats );
					$cats = str_replace( '</a>', '</a>' . $link_after, $cats );

					if ( $show_title == 0 ) {
						$cats = preg_replace( '/ title="(.*?)"/', '', $cats );
					}

					echo wp_specialchars_decode( $cats );
				}

				printf( $link, esc_url( get_permalink( $parent ) ), esc_html( $parent->post_title ) );

				if ( $show_current == 1 ) {
					echo wp_specialchars_decode( $delimiter ) . wp_specialchars_decode( $before ) . get_the_title( ) . wp_specialchars_decode( $after );
				}
			} elseif ( is_page( ) && ! $parent_id ) {
				if ( $show_current == 1 ) {
					echo wp_specialchars_decode( $before ) . get_the_title( ) . wp_specialchars_decode( $after );
				}
			} elseif ( is_page( ) && $parent_id ) {
				if ( $parent_id != $frontpage_id ) {
					$breadcrumbs = array( );

					while ( $parent_id ) {
						$page = get_page( $parent_id );

						if ( $parent_id != $frontpage_id ) {
							$breadcrumbs[] = sprintf( $link, esc_url( get_permalink( $page->ID ) ), esc_html( get_the_title( $page->ID ) ) );
						}

						$parent_id = $page->post_parent;
					}

					$breadcrumbs = array_reverse( $breadcrumbs );

					for ( $i = 0; $i < count( $breadcrumbs ); $i++ ) {
						echo wp_specialchars_decode( $breadcrumbs[$i] );
						
						if ( $i != count( $breadcrumbs ) - 1 ) {
							echo wp_specialchars_decode( $delimiter );
						}
					}
				}

				if ( $show_current == 1 ) {
					if ( $show_home_link == 1 || ( $parent_id_2 != 0 && $parent_id_2 != $frontpage_id ) ) {
						echo wp_specialchars_decode( $delimiter );
					}

					echo wp_specialchars_decode( $before ) . get_the_title( ) . wp_specialchars_decode( $after );
				}

			} elseif ( is_tag( ) ) {
				echo wp_specialchars_decode( $before ) . sprintf( $text['tag'], single_tag_title( '', false ) ) . wp_specialchars_decode( $after );
			} elseif ( is_author( ) ) {
		 		global $author;

				$userdata = get_userdata( $author );

				echo wp_specialchars_decode( $before ) . sprintf( $text['author'], $userdata->display_name ) . wp_specialchars_decode( $after );
			} elseif ( is_404( ) ) {
				echo wp_specialchars_decode( $before ) . $text['404'] . wp_specialchars_decode( $after );
			} elseif ( has_post_format( ) && !is_singular( ) ) {
				echo get_post_format_string( get_post_format( ) );
			}

			if ( get_query_var( 'paged' ) ) {
				if ( is_category( ) || is_day( ) || is_month( ) || is_year( ) || is_search( ) || is_tag( ) || is_author( ) ) {
					echo ' (';
				}

				echo esc_html( $text['page'] ) . ' ' . get_query_var( 'paged' );

				if ( is_category( ) || is_day( ) || is_month( ) || is_year( ) || is_search( ) || is_tag( ) || is_author( ) ) {
					echo ')';
				}
			}

			echo '</span>';
		}
	}
}
