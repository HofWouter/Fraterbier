<?php
/*
Template Name: Waar te koop
*/
?>

<?php get_header(); ?>
<?php

for ($i = 1; $i <= 6; $i++) {
    $locatie = get_field('locatie' . $i);
    if ($locatie) {
        $locaties[] = $locatie;
    }
}

$current_lang = pll_current_language();
if ($current_lang == 'da') {
    $Verkooppunten = 'Forhandlere';
    $Afstand = 'Afstand';
} elseif ($current_lang == 'en') {
    $Verkooppunten = 'Retail locations';
    $Afstand = 'Distance';
} else {
    $Verkooppunten = 'Verkooppunten';
    $Afstand = 'Afstand';
}
?>

<main>
        <section class="waar-te-koop--accent section section--no-top-padding">
        <div>
            <?php
            if (has_post_thumbnail() ) {
                echo '<img class="article__image" src="' . esc_url( get_the_post_thumbnail_url() ) . '" alt="' . esc_attr( get_the_title() ) . '" />';
            } else {
                echo '<img class="article__image" src="' . get_template_directory_uri() . '/assets/images/voorbeeld_afbeelding.jpg" alt="Placeholder" />';
            }
            ?>
        </div>
            <div class="waar-te-koop__text-align">
            <div class="waar-te-koop__text">
            <div class="section__title post__title">
                <h1 class="title--secondary"><?php the_title(); ?></h1>
            </div>
            <div>
                    <?php
                    while (have_posts()) : the_post();
                        $tekst = get_the_content();
                        echo $tekst;
                    endwhile;
                    ?>
            </div>
            </div>
            <div class="icon--large spacing--water">
                <svg viewBox="0 0 48 21">
                            <path d="M1.78282 5.11696C4.84491 5.11696 6.39637 4.05263 7.87978 3.04288C9.29515 2.07407 10.6289 1.15984 13.3371 1.15984C16.0454 1.15984 17.3791 2.07407 18.7944 3.04288C20.2915 4.06627 21.8293 5.11696 24.8914 5.11696C27.9535 5.11696 29.505 4.05263 30.9884 3.04288C32.4037 2.07407 33.7238 1.15984 36.4457 1.15984C39.1676 1.15984 40.4877 2.07407 41.903 3.04288C43.4001 4.06627 44.9379 5.11696 48 5.11696V3.97076C45.2917 3.97076 43.958 3.05653 42.5427 2.08772C41.0456 1.06433 39.5078 0 36.4457 0C33.3836 0 31.8322 1.05068 30.3487 2.08772C28.9334 3.05653 27.6133 3.97076 24.8914 3.97076C22.1695 3.97076 20.8494 3.05653 19.4341 2.08772C17.9371 1.06433 16.3992 0 13.3371 0C10.275 0 8.72356 1.05068 7.24015 2.08772C5.82478 3.05653 4.49107 3.97076 1.78282 3.97076C1.10235 3.97076 0.517153 3.91618 0 3.82066V4.9805C0.530763 5.07602 1.12957 5.11696 1.78282 5.11696Z"/>
                            <path d="M1.78282 13.0586C4.84491 13.0586 6.39637 12.0079 7.87978 10.9845C9.29515 10.0157 10.6289 9.10149 13.3371 9.10149C16.0454 9.10149 17.3791 10.0157 18.7944 10.9845C20.2915 12.0079 21.8293 13.0586 24.8914 13.0586C27.9535 13.0586 29.505 12.0079 30.9884 10.9845C32.4037 10.0157 33.7238 9.10149 36.4457 9.10149C39.1676 9.10149 40.4877 10.0157 41.903 10.9845C43.4001 12.0079 44.9379 13.0586 48 13.0586V11.9124C45.2917 11.9124 43.958 10.9982 42.5427 10.0294C41.0456 9.00598 39.5078 7.94165 36.4457 7.94165C33.3836 7.94165 31.8322 8.99233 30.3487 10.0294C28.9334 10.9982 27.6133 11.9124 24.8914 11.9124C22.1695 11.9124 20.8494 10.9982 19.4341 10.0294C17.9371 9.00598 16.3992 7.94165 13.3371 7.94165C10.275 7.94165 8.72356 8.99233 7.24015 10.0294C5.82478 10.9982 4.49107 11.9124 1.78282 11.9124C1.10235 11.9124 0.517153 11.8578 0 11.7623V12.9222C0.530763 13.004 1.12957 13.0586 1.78282 13.0586Z"/>
                            <path d="M1.78282 21C4.84491 21 6.39637 19.9493 7.87978 18.9259C9.29515 17.9571 10.6289 17.0429 13.3371 17.0429C16.0454 17.0429 17.3791 17.9571 18.7944 18.9259C20.2915 19.9493 21.8293 21 24.8914 21C27.9535 21 29.505 19.9493 30.9884 18.9259C32.4037 17.9571 33.7238 17.0429 36.4457 17.0429C39.1676 17.0429 40.4877 17.9571 41.903 18.9259C43.4001 19.9493 44.9379 21 48 21V19.8538C45.2917 19.8538 43.958 18.9396 42.5427 17.9708C41.0456 16.9474 39.5078 15.8831 36.4457 15.8831C33.3836 15.8831 31.8322 16.9337 30.3487 17.9708C28.9334 18.9396 27.6133 19.8538 24.8914 19.8538C22.1695 19.8538 20.8494 18.9396 19.4341 17.9708C17.9371 16.9474 16.3992 15.8831 13.3371 15.8831C10.275 15.8831 8.72356 16.9337 7.24015 17.9708C5.82478 18.9396 4.49107 19.8538 1.78282 19.8538C1.10235 19.8538 0.517153 19.7992 0 19.7037V20.8636C0.530763 20.9454 1.12957 21 1.78282 21Z"/>
                </svg>
            </div>
            </div>
            <div class="waar-te-koop__text-align">
            <div style="width: 100%;">
            <div class="section__title">
                <h2 class="title--secondary"><?php echo $Verkooppunten; ?></h2>
            </div>
            <div class="waar-te-koop__text">
                <div id="map" class="kaart"></div>
                <div class="verkooppunt-container">
                    <div class="verkooppunt-wrapper">
                    <div class="verkooppunt-wrapper">
                        <div class="verkooppunt-samen">
                            <div class="verkooppunt-info">
                            <h5><?php echo $locaties[0]['name']; ?></h5>
                            <p><?php echo $locaties[0]['street_name'] . ' ' . $locaties[0]['street_number']; ?></p>
                            <p><?php echo $locaties[0]['city']; ?></p>
                            </div>
                            <div class="verkooppunt-afstand">
                                <h5 class="title--secondary"><?php echo $Afstand; ?></h5>
                                <h5 id="afstandLocatie0">0 km</h5>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="verkooppunt-wrapper">
                        <div class="verkooppunt-samen">
                            <div class="verkooppunt-info">
                            <h5><?php echo $locaties[1]['name']; ?></h5>
                            <p><?php echo $locaties[1]['street_name'] . ' ' . $locaties[1]['street_number']; ?></p>
                            <p><?php echo $locaties[1]['city']; ?></p>
                            </div>
                            <div class="verkooppunt-afstand">
                                <h5 class="title--secondary"><?php echo $Afstand; ?></h5>
                                <h5 id="afstandLocatie1">0 km</h5>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="verkooppunt-wrapper">
                        <div class="verkooppunt-samen">
                            <div class="verkooppunt-info">
                            <h5><?php echo $locaties[2]['name']; ?></h5>
                            <p><?php echo $locaties[2]['street_name'] . ' ' . $locaties[2]['street_number']; ?></p>
                            <p><?php echo $locaties[2]['city']; ?></p>
                            </div>
                            <div class="verkooppunt-afstand">
                                <h5 class="title--secondary"><?php echo $Afstand; ?></h5>
                                <h5 id="afstandLocatie2">0 km</h5>
                            </div>
                        </div>

                        <hr>
                    </div>
                    <input type="checkbox" id="show-more-check" class="toggle-input">          
                    <div class="extra-content">
                    <div class="verkooppunt-wrapper">
                        <div class="verkooppunt-samen">
                            <div class="verkooppunt-info">
                            <h5><?php echo $locaties[3]['name']; ?></h5>
                            <p><?php echo $locaties[3]['street_name'] . ' ' . $locaties[3]['street_number']; ?></p>
                            <p><?php echo $locaties[3]['city']; ?></p>
                            </div>
                            <div class="verkooppunt-afstand">
                                <h5 class="title--secondary"><?php echo $Afstand; ?></h5>
                                <h5 id="afstandLocatie3">0 km</h5>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="verkooppunt-wrapper">
                        <div class="verkooppunt-samen">
                            <div class="verkooppunt-info">
                                <h5><?php echo $locaties[4]['name']; ?></h5>
                                <p><?php echo $locaties[4]['street_name'] . ' ' . $locaties[4]['street_number']; ?></p>
                                <p><?php echo $locaties[4]['city']; ?></p>
                            </div>
                            <div class="verkooppunt-afstand">
                                <h5 class="title--secondary"><?php echo $Afstand; ?></h5>
                                <h5 id="afstandLocatie4">0 km</h5>
                            </div>
                        </div>

                        <hr>
                    </div>
                    <div class="verkooppunt-wrapper">
                        <div class="verkooppunt-samen">
                            <div class="verkooppunt-info">
                            <h5><?php echo $locaties[5]['name']; ?></h5>
                            <p><?php echo $locaties[5]['street_name'] . ' ' . $locaties[5]['street_number']; ?></p>
                            <p><?php echo $locaties[5]['city']; ?></p>
                            </div>
                            <div class="verkooppunt-afstand">
                                <h5 class="title--secondary"><?php echo $Afstand; ?></h5>
                                <h5 id="afstandLocatie5">0 km</h5>
                            </div>
                        </div>
                        <hr>
                    </div>   
                    </div>
                    </div>
                    <label for="show-more-check" class="btn btn--secondary show-more-btn">
                        <span class="text-more">Bekijk meer</span>
                        <span class="text-less">Bekijk minder</span>
                    </label>
                </div>
            </div>
            </div>
            <div class="icon--large spacing--water">
                <svg viewBox="0 0 48 21">
                            <path d="M1.78282 5.11696C4.84491 5.11696 6.39637 4.05263 7.87978 3.04288C9.29515 2.07407 10.6289 1.15984 13.3371 1.15984C16.0454 1.15984 17.3791 2.07407 18.7944 3.04288C20.2915 4.06627 21.8293 5.11696 24.8914 5.11696C27.9535 5.11696 29.505 4.05263 30.9884 3.04288C32.4037 2.07407 33.7238 1.15984 36.4457 1.15984C39.1676 1.15984 40.4877 2.07407 41.903 3.04288C43.4001 4.06627 44.9379 5.11696 48 5.11696V3.97076C45.2917 3.97076 43.958 3.05653 42.5427 2.08772C41.0456 1.06433 39.5078 0 36.4457 0C33.3836 0 31.8322 1.05068 30.3487 2.08772C28.9334 3.05653 27.6133 3.97076 24.8914 3.97076C22.1695 3.97076 20.8494 3.05653 19.4341 2.08772C17.9371 1.06433 16.3992 0 13.3371 0C10.275 0 8.72356 1.05068 7.24015 2.08772C5.82478 3.05653 4.49107 3.97076 1.78282 3.97076C1.10235 3.97076 0.517153 3.91618 0 3.82066V4.9805C0.530763 5.07602 1.12957 5.11696 1.78282 5.11696Z"/>
                            <path d="M1.78282 13.0586C4.84491 13.0586 6.39637 12.0079 7.87978 10.9845C9.29515 10.0157 10.6289 9.10149 13.3371 9.10149C16.0454 9.10149 17.3791 10.0157 18.7944 10.9845C20.2915 12.0079 21.8293 13.0586 24.8914 13.0586C27.9535 13.0586 29.505 12.0079 30.9884 10.9845C32.4037 10.0157 33.7238 9.10149 36.4457 9.10149C39.1676 9.10149 40.4877 10.0157 41.903 10.9845C43.4001 12.0079 44.9379 13.0586 48 13.0586V11.9124C45.2917 11.9124 43.958 10.9982 42.5427 10.0294C41.0456 9.00598 39.5078 7.94165 36.4457 7.94165C33.3836 7.94165 31.8322 8.99233 30.3487 10.0294C28.9334 10.9982 27.6133 11.9124 24.8914 11.9124C22.1695 11.9124 20.8494 10.9982 19.4341 10.0294C17.9371 9.00598 16.3992 7.94165 13.3371 7.94165C10.275 7.94165 8.72356 8.99233 7.24015 10.0294C5.82478 10.9982 4.49107 11.9124 1.78282 11.9124C1.10235 11.9124 0.517153 11.8578 0 11.7623V12.9222C0.530763 13.004 1.12957 13.0586 1.78282 13.0586Z"/>
                            <path d="M1.78282 21C4.84491 21 6.39637 19.9493 7.87978 18.9259C9.29515 17.9571 10.6289 17.0429 13.3371 17.0429C16.0454 17.0429 17.3791 17.9571 18.7944 18.9259C20.2915 19.9493 21.8293 21 24.8914 21C27.9535 21 29.505 19.9493 30.9884 18.9259C32.4037 17.9571 33.7238 17.0429 36.4457 17.0429C39.1676 17.0429 40.4877 17.9571 41.903 18.9259C43.4001 19.9493 44.9379 21 48 21V19.8538C45.2917 19.8538 43.958 18.9396 42.5427 17.9708C41.0456 16.9474 39.5078 15.8831 36.4457 15.8831C33.3836 15.8831 31.8322 16.9337 30.3487 17.9708C28.9334 18.9396 27.6133 19.8538 24.8914 19.8538C22.1695 19.8538 20.8494 18.9396 19.4341 17.9708C17.9371 16.9474 16.3992 15.8831 13.3371 15.8831C10.275 15.8831 8.72356 16.9337 7.24015 17.9708C5.82478 18.9396 4.49107 19.8538 1.78282 19.8538C1.10235 19.8538 0.517153 19.7992 0 19.7037V20.8636C0.530763 20.9454 1.12957 21 1.78282 21Z"/>
                </svg>
            </div>
            </div>
        </section>     
        <?php get_template_part('template-parts/layout/wapenveld', 'card'); ?>
</main>
<?php get_footer(); ?>