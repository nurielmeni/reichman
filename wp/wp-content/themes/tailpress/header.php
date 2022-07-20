<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class('nls-hunter bg-mainbg text-gray-900 antialiased font-sans'); ?>>

	<?php do_action('reichman_site_before'); ?>

	<div id="page" class="min-h-screen flex flex-col">

		<?php do_action('reichman_header'); ?>

		<header>
			<div class="header-wrapper flex justify-center items-center bg-primary">
				<div class="mx-full container">
					<div class="md:flex md:justify-between md:items-center py-6 px-2">
						<div class="flex justify-between items-center text-white">

							<div>
								<?= get_header_ml_logo(); ?>
							</div>

							<h2 class="text-base md:text-lg lg:text-2xl font-bold mx-2 m-inline-ea">
								<?php echo get_bloginfo('description'); ?>
							</h2>

							<div class="flex md:hidden">
								<?php
								wp_nav_menu(
									array(
										'container_id'    => 'header-language-switcher',
										'container_class' => 'flex  md:hidden',
										'menu_class'      => 'flex text-white',
										'theme_location'  => 'language-switcher',
										'li_class'        => 'mx-4 text-white two-chars',
										'fallback_cb'     => false,
									)
								);
								?>
								<a href="#" aria-label="Toggle navigation" id="primary-menu-toggle">
									<svg viewBox="0 0 20 20" class="inline-block w-6 h-6" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
										<g stroke="none" stroke-width="1" fill="currentColor" fill-rule="evenodd">
											<g id="icon-shape">
												<path d="M0,3 L20,3 L20,5 L0,5 L0,3 Z M0,9 L20,9 L20,11 L0,11 L0,9 Z M0,15 L20,15 L20,17 L0,17 L0,15 Z" id="Combined-Shape"></path>
											</g>
										</g>
									</svg>
								</a>
							</div>

						</div>
						<?php
						wp_nav_menu(
							array(
								'container_id'    => 'primary-menu',
								'container_class' => 'hidden bg-gray-100 mt-4 p-4 md:mt-0 md:p-0 md:bg-transparent md:block',
								'menu_class'      => 'md:flex md:-mx-4 text-white',
								'theme_location'  => 'primary',
								'li_class'        => 'md:mx-4 md:text-white text-primary text-sm md:text-lg lg:text-xl',
								'fallback_cb'     => false,
							)
						);
						?>
						<div class="flex flex-col justify-center items-end">
							<?php
							wp_nav_menu(
								array(
									'container_id'    => 'header-language-switcher',
									'container_class' => 'hidden md:flex mb-1',
									'menu_class'      => 'md:flex md:-mx-4 text-white',
									'theme_location'  => 'language-switcher',
									'li_class'        => 'md:mx-4 text-white text-sm md:text-lg lg:text-xl',
									'fallback_cb'     => false,
								)
							);
							?>
							<button type="button" class="user-logout text-white mt-1 px-2 border text-sm md:text-lg lg:text-xl"><?= apply_filters('nym_auth_action_label', __('...', 'NlsHunetrFbf')) ?></button>
						</div>
					</div>
				</div>
			</div>
		</header>

		<div id="content" class="site-content flex-grow">



			<?php do_action('reichman_content_start'); ?>

			<main>