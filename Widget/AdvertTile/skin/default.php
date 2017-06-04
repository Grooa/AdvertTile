<?php
ipAddCss('../assets/advertTile.css');
?>

<section class="classified-tile">
    <?php if (!empty($img)): ?>
        <div class="thumbnail">
            <img id="image" src="<?= ipFileUrl('file/repository/' . $img[0]); ?>"
                 alt="<?= isset($title) ? $title : '' ?>">
        </div>
    <?php endif; ?>

    <h4 id="profileName"
        class="name"
        style="<?= empty($img) ? 'margin-top: 1em' : '' ?>">

        <?php echo isset($title) && $title != '' ? $title : '[missing title]' ?>
    </h4>

    <?php if (isset($description) && !empty($description)): ?>
        <div class="description"
             style="<?= empty($img) ? 'margin-top: 1em' : '' ?>">
            <?= $description ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($price)): ?>
        <div class="price">
            <em>Price:</em>
            <strong><?= $price ?></strong>
        </div>
    <?php endif; ?>

    <div class="buttons" style="margin-top: <?= empty($price) ? 'auto' : '.2em' ?>" >
        <?php if (!empty($url) || !empty($apendix)): ?>
            <a class="button readmore"
               href="<?= !empty($apendix) ? ipFileUrl('file/repository/' . $apendix[0]) : $url ?>"
               target="_blank">Read more</a>
        <?php endif; ?>

        <?php if (isset($paypal) && !empty($paypal)): ?>
            <form class="paypal"
                  action="https://www.paypal.com/cgi-bin/webscr"
                  method="post"
                  target="_top">

                <input type="hidden" name="cmd" value="_s-xclick">
                <input type="hidden" name="hosted_button_id" value="<?= $paypal ?>">
                <button type="submit">
                    <svg version="1.1"
                         xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                         width="30"
                         height="30"
                         viewBox="0 0 512 512">

                        <path style="fill: #FFF;"
                              d="M282.132 200.172c9.431-5.827 14.695-13.568 17.091-25.078 4.393-20.869-2.714-26.983-4.618-29.87-12.216-18.668-50.401-18.166-81.398-17.992-0.226 0.778-0.451 1.566-0.686 2.365-6.277 21.361-15.442 52.685-23.388 79.954 24.115 3.399 68.465 5.786 92.999-9.38z"
                              fill="#000000"/>
                        <path style="fill: #FFF;"
                              d="M127.15 30.679l-109.24 367.882 144.558 1.721 29.286-92.139c0 0 190.3 29.563 220.027-100.291 55.010-240.087-284.631-177.173-284.631-177.173zM373.781 189.163c-6.37 30.515-23.829 55.286-50.442 71.68-53.76 33.034-130.109 23.101-155.167 18.616l-30.034 91.73-74.025-1.003 35.379-123.843 53.77-183.818 24.299-3.523c12.094-1.751 119.696-15.606 171.909 36.281 16.62 16.496 34.304 46.172 24.31 93.881z"
                              fill="#000000"/>
                        <path style="fill: #FFF;"
                              d="M437.392 143.022c4.915 34.581-0.491 46.285-2.243 51.845 12.943 17.52 22.938 44.185 14.909 82.759-6.38 30.515-23.849 55.296-50.462 71.67-53.75 33.045-130.13 23.122-155.187 18.637l-30.013 91.719-74.014-0.983c0 0 4.885-16.322 6.308-21.32h-37.745l-14.848 49.685 144.599 1.721 29.286-92.16c0 0 190.279 29.563 220.068-100.281 18.544-80.804-7.752-127.191-50.658-153.293z"
                              fill="#000000"/>
                    </svg>
                    Buy Now
                </button>
            </form>
        <?php endif; ?>
    </div>
</section>