 <div class="event-summary">
                <a class="event-summary__date t-center" href="<?php echo get_permalink() ?>">
                  <span class="event-summary__month"><?php 
                  $eventDate = new DateTime(get_field('event_date'));
                  echo $eventDate->format('M'); 
                  ?></span>
                  <span class="event-summary__day"><?php 
                  echo $eventDate->format('d'); 
                  ?></span>
                </a>
                <div class="event-summary__content">
                  <h5 class="event-summary__title headline headline--tiny"><a href="<?php echo get_permalink() ?>"><?php the_title(); ?></a></h5>
                  <p><?php  if (has_excerpt()){
                    echo get_the_excerpt();  // Display the post's excerpt if it exists.
                  } else { echo wp_trim_words(get_the_content(), 13);
                  }
                  ?><a href="<?php echo get_permalink() ?>" class="nu gray">Learn more</a></p>
                </div>
          </div>