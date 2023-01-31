<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
    @foreach ($products as $product)
        <url>
            <loc>{{ URL::to('product/'.$product->slug) }}</loc>
            <image:image>
			<image:loc><?php $product	= explode("#", $product->products_image); ?>{{ URL::to('public/images/'.$product[0]) }}</image:loc>
			</image:image>
           
            <changefreq>weekly</changefreq>
            <priority>0.6</priority>
        </url>
    @endforeach
</urlset>